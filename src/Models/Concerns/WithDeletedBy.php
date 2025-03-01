<?php

namespace JeffersonGoncalves\CreatedBy\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait WithDeletedBy
{
    public static function bootWithDeletedBy(): void
    {
        static::deleting(static function ($model) {
            $model->deleted_by = auth()->id();
        });
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', User::class));
    }
}
