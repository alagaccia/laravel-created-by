<?php

namespace JeffersonGoncalves\CreatedBy\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;
use JeffersonGoncalves\CreatedBy\Models\Scope\CreatedByScope;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait WithCreatedBy
{
    public static function bootWithCreatedBy(): void
    {
        static::addGlobalScope(new CreatedByScope);
        static::creating(static function ($model) {
            $model->created_by = auth()->id();
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', User::class));
    }
}
