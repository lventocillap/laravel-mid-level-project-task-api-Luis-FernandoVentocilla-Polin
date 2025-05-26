<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Task extends Model implements ContractsAuditable
{
    use Auditable;
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'project_id'
    ];

    public function projects(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
