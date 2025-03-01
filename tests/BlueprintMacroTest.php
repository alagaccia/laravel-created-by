<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use JeffersonGoncalves\CreatedBy\CreatedByServiceProvider;

$fields = [
    ['createdBy', 'created_by'],
    ['updatedBy', 'updated_by'],
    ['deletedBy', 'deleted_by'],
    ['restoredBy', 'restored_by'],
];

it('can extend the blueprint for migrations', function ($functionName, $columnName) {
    app()->register(CreatedByServiceProvider::class);
    if (app()->version() >= '12.0') {
        $blueprint = new Blueprint(DB::connection(), 'users');
    } else {
        $blueprint = new Blueprint('users');
    }
    $blueprint->$functionName();
    expect($blueprint->getAddedColumns())->toHaveCount(1)
        ->and($blueprint->getAddedColumns()[0]->toArray())->toEqual([
            'type' => 'bigInteger',
            'name' => $columnName,
            'autoIncrement' => false,
            'unsigned' => true,
            'table' => $blueprint->getTable(),
            'referencesModelColumn' => 'id',
            'nullable' => true,
            'default' => null,
        ]);
})->with($fields);

it('can extend the blueprint for migrations - restoredAt', function () {
    app()->register(CreatedByServiceProvider::class);
    if (app()->version() >= '12.0') {
        $blueprint = new Blueprint(DB::connection(), 'users');
    } else {
        $blueprint = new Blueprint('users');
    }
    $blueprint->restoredAt();
    expect($blueprint->getAddedColumns())->toHaveCount(1)
        ->and($blueprint->getAddedColumns()[0]->toArray())->toEqual([
            'type' => 'timestamp',
            'name' => 'restored_at',
            'precision' => 0,
            'nullable' => true,
            'default' => null,
        ]);
});
