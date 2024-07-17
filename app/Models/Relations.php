<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Relations extends Model
{
    use HasFactory;


    protected $fillable = ['task_id', 'user_id'];


    /**
     * Gets all users assigned to a single task
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskUsers(): HasMany
    {
        return $this->hasMany(Task::class, "task_id", "id");
    }

    /**
     * Get all tasks that are designated to a specific user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userTasks(): HasMany
    {
        return $this->hasMany(User::class, "user_id", "id");
    }

}
