<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use JeffersonGoncalves\CreatedBy\CreatedByServiceProvider;

$fields = [
    ['createdBy', 'created_by'],
    ['updatedBy', 'updated_by'],
    ['deletedBy', 'deleted_by'],
];

it('can extend the blueprint for migrations', function ($functionName, $columnName) {
    app()->register(CreatedByServiceProvider::class);
    $blueprint = new Blueprint(DB::connection(), 'users');
    $blueprint->$functionName();
    expect($blueprint->getAddedColumns())->toHaveCount(1)
        ->and($blueprint->getAddedColumns()[0]->toArray())->toEqual([
            'type' => 'bigInteger',
            'name' => $columnName,
            'autoIncrement' => false,
            'unsigned' => true,
            "table" => $blueprint->getTable(),
            "referencesModelColumn" => "id",
            'nullable' => true,
            'default' => null,
        ]);
})->with($fields);
