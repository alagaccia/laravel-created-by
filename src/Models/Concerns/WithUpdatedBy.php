<?php

namespace JeffersonGoncalves\CreatedBy\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait WithUpdatedBy
{
    public static function bootWithUpdatedBy(): void
    {
        static::creating(static function ($model) {
            $model->updated_by = auth()->id();
        });
        static::updating(static function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', User::class));
    }
}
