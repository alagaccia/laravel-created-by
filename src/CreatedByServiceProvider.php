<?php

namespace AndreaLagaccia\CreatedBy;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CreatedByServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-created-by');
    }

    public function packageRegistered(): void
    {
        // Add new columns with foreign keys
        if (! Blueprint::hasMacro('createdBy')) {
            Blueprint::macro('createdBy', function () {
                $this->foreignIdFor(config('auth.providers.users.model', User::class), 'created_by')
                    ->nullable()
                    ->constrained()
                    ->default(null);
            });
        }
        if (! Blueprint::hasMacro('updatedBy')) {
            Blueprint::macro('updatedBy', function () {
                $this->foreignIdFor(config('auth.providers.users.model', User::class), 'updated_by')
                    ->nullable()
                    ->constrained()
                    ->default(null);
            });
        }
        if (! Blueprint::hasMacro('deletedBy')) {
            Blueprint::macro('deletedBy', function () {
                $this->foreignIdFor(config('auth.providers.users.model', User::class), 'deleted_by')
                    ->nullable()
                    ->constrained()
                    ->default(null);
            });
        }
        if (! Blueprint::hasMacro('restoredBy')) {
            Blueprint::macro('restoredBy', function () {
                $this->foreignIdFor(config('auth.providers.users.model', User::class), 'restored_by')
                    ->nullable()
                    ->constrained()
                    ->default(null);
            });
        }
        if (! Blueprint::hasMacro('restoredAt')) {
            Blueprint::macro('restoredAt', function () {
                $this->timestamp('restored_at')->nullable()->default(null);
            });
        }

        // Drop columns and their foreign key constraints
        if (! Blueprint::hasMacro('dropCreatedBy')) {
            Blueprint::macro('dropCreatedBy', function () {
                $this->dropForeign(['created_by']);
                $this->dropColumn('created_by');
            });
        }
        if (! Blueprint::hasMacro('dropUpdatedBy')) {
            Blueprint::macro('dropUpdatedBy', function () {
                $this->dropForeign(['updated_by']);
                $this->dropColumn('updated_by');
            });
        }
        if (! Blueprint::hasMacro('dropDeletedBy')) {
            Blueprint::macro('dropDeletedBy', function () {
                $this->dropForeign(['deleted_by']);
                $this->dropColumn('deleted_by');
            });
        }
        if (! Blueprint::hasMacro('dropRestoredBy')) {
            Blueprint::macro('dropRestoredBy', function () {
                $this->dropForeign(['restored_by']);
                $this->dropColumn('restored_by');
            });
        }
        if (! Blueprint::hasMacro('dropRestoredAt')) {
            Blueprint::macro('dropRestoredAt', function () {
                $this->dropColumn('restored_at');
            });
        }
    }
}
