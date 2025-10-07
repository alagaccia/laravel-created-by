<?php

namespace ALagaccia\CreatedBy;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\Str;

class CreatedByServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-created-by');
    }

    /**
     * Helper per definire una macro di colonna con chiave esterna.
     * @param string $columnName
     * @return \Closure
     */
    protected function foreignIdByMacro(string $columnName): \Closure
    {
        // Ottiene il modello utente configurato, usando User::class come fallback
        $userModel = config('auth.providers.users.model', User::class);

        return function () use ($userModel, $columnName) {
            /** @var Blueprint $this */
            $this->foreignIdFor($userModel, $columnName)
                ->nullable()
                ->constrained()
                ->default(null);
        };
    }

    /**
     * Helper per definire una macro per il drop di una colonna con chiave esterna.
     * @param string $columnName
     * @return \Closure
     */
    protected function dropForeignIdByMacro(string $columnName): \Closure
    {
        return function () use ($columnName) {
            /** @var Blueprint $this */
            $this->dropForeign([$columnName]);
            $this->dropColumn($columnName);
        };
    }

    /**
     * Helper per definire una macro per il drop di una colonna senza chiave esterna (come restored_at).
     * @param string $columnName
     * @return \Closure
     */
    protected function dropColumnMacro(string $columnName): \Closure
    {
        return function () use ($columnName) {
            /** @var Blueprint $this */
            $this->dropColumn($columnName);
        };
    }

    public function packageRegistered(): void
    {
        $userColumns = ['created_by', 'updated_by', 'deleted_by', 'restored_by'];

        // Definisce le singole macro di colonna (es. createdBy, dropCreatedBy)
        foreach ($userColumns as $column) {
            $macroName = Str::of($column)->camel()->ucfirst()->toString();

            // Aggiunge colonna X_by
            if (! Blueprint::hasMacro($macroName)) {
                Blueprint::macro($macroName, $this->foreignIdByMacro($column));
            }

            // Rimuove colonna X_by
            $dropMacroName = 'drop' . $macroName;
            if (! Blueprint::hasMacro($dropMacroName)) {
                Blueprint::macro($dropMacroName, $this->dropForeignIdByMacro($column));
            }
        }

        // Macro specifica per 'restored_at'
        if (! Blueprint::hasMacro('restoredAt')) {
            Blueprint::macro('restoredAt', function () {
                /** @var Blueprint $this */
                $this->timestamp('restored_at')->nullable()->default(null);
            });
        }
        if (! Blueprint::hasMacro('dropRestoredAt')) {
            Blueprint::macro('dropRestoredAt', $this->dropColumnMacro('restored_at'));
        }

        // Macro "customTimestamps" (che raggruppa le altre)
        if (! Blueprint::hasMacro('customTimestamps')) {
            Blueprint::macro('customTimestamps', function () use ($userColumns) {
                /** @var Blueprint $this */

                // Chiama le macro singole per le colonne X_by
                foreach ($userColumns as $column) {
                    $macroName = Str::of($column)->camel()->ucfirst()->toString();
                    $this->{$macroName}(); // Esegue la macro precedentemente definita, es. $this->createdBy()
                }

                // Chiama la macro per restored_at
                $this->restoredAt();
            });
        }
    }
}
