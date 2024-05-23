<?php

namespace App\Models;

use App\StatusEnum;
use App\TaskPriorityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'status',
        'priority',
        'due_date',
        'assigned_user_id',
        'created_by',
        'updated_by',
        'project_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'assigned_user_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'image_path' => 'string',
        'status' => StatusEnum::class,
        'priority' => TaskPriorityEnum::class,
        'created_by' => 'datetime',
        'updated_by' => 'datetime',
        'project_id' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


}
