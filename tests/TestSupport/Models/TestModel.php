<?php

namespace Alagaccia\CreatedBy\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Alagaccia\CreatedBy\Models\Concerns\WithCreatedBy;
use Alagaccia\CreatedBy\Models\Concerns\WithDeletedBy;
use Alagaccia\CreatedBy\Models\Concerns\WithRestoredAt;
use Alagaccia\CreatedBy\Models\Concerns\WithRestoredBy;
use Alagaccia\CreatedBy\Models\Concerns\WithUpdatedBy;

class TestModel extends Model
{
    public $fillable = [
        'name',
        'secret',
    ];

    public $hidden = [
        'secret',
    ];

    public $table = 'test_models';

    use HasFactory;
    use SoftDeletes;
    use WithCreatedBy;
    use WithDeletedBy;
    use WithRestoredAt;
    use WithRestoredBy;
    use WithUpdatedBy;
}
