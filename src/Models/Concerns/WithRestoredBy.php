<?php

namespace Alagaccia\CreatedBy\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;
use Alagaccia\CreatedBy\Models\Scope\RestoredByScope;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\SoftDeletes
 */
trait WithRestoredBy
{
    public static function bootWithRestoredBy(): void
    {
        static::addGlobalScope(new RestoredByScope);
        static::restoring(static function ($model) {
            $model->restored_by = auth()->id();
        });
    }

    public function restoredBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', User::class));
    }
}
