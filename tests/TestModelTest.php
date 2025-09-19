<?php

use Alagaccia\CreatedBy\Tests\TestSupport\Models\TestModel;

test('check method is called', function (string $method) {
    expect(method_exists(new TestModel, $method))->toBeTrue();
})->with([
    'createdBy',
    'deletedBy',
    'updatedBy',
    'restoredBy',
]);
