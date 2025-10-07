<?php

namespace Alagaccia\CreatedBy\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;
use Alagaccia\CreatedBy\Models\Scope\CustomTimestampsScope;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait WithCustomTimestamps
{
    public static function bootWithCustomTimestamps(): void
    {
        static::addGlobalScope(new CustomTimestampsScope);

        static::creating(static function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(static function ($model) {
            $model->updated_by = auth()->id();
        });

        static::deleting(static function ($model) {
            $model->deleted_by = auth()->id();
        });

        static::restoring(static function ($model) {
            $model->restored_by = auth()->id();
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', User::class));
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', User::class));
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', User::class));
    }

    public function restoredBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', User::class));
    }
}
