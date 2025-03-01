<?php

namespace JeffersonGoncalves\CreatedBy\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JeffersonGoncalves\CreatedBy\Models\Concerns\WithCreatedBy;
use JeffersonGoncalves\CreatedBy\Models\Concerns\WithDeletedBy;
use JeffersonGoncalves\CreatedBy\Models\Concerns\WithUpdatedBy;

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
    use WithUpdatedBy;
}
