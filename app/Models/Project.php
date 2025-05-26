<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Project extends Model implements ContractsAuditable
{
    use Auditable;
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function task(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }
}
