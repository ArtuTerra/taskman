<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'completed', 'creator_id'];


    /**
     * Gets the user (creator) of the task
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function findCreator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of assignedUsers
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'relations', 'task_id', 'user_id');
    }

}
