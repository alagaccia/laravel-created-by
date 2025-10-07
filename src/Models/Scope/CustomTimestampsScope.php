<?php

namespace Alagaccia\CreatedBy\Models\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CustomTimestampsScope implements Scope
{
    public function apply(Builder $builder, Model $model) {}

    public function extend(Builder $builder): void
    {
        $builder->macro('createdBy', function (Builder $builder, $value) {
            return $builder->where('created_by', $value);
        });
        $builder->macro('withCreatedBy', function (Builder $builder) {
            return $builder->with('createdBy');
        });

        $builder->macro('updatedBy', function (Builder $builder, $value) {
            return $builder->where('updated_by', $value);
        });
        $builder->macro('withUpdatedBy', function (Builder $builder) {
            return $builder->with('updatedBy');
        });

        $builder->macro('deletedBy', function (Builder $builder, $value) {
            return $builder->where('deleted_by', $value);
        });
        $builder->macro('withDeletedBy', function (Builder $builder) {
            return $builder->with('deletedBy');
        });

        $builder->macro('restoredBy', function (Builder $builder, $value) {
            return $builder->where('restored_by', $value);
        });
        $builder->macro('withRestoredBy', function (Builder $builder) {
            return $builder->with('restoredBy');
        });
    }
}
