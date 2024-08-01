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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'completed' => 'boolean',
        ];
    }



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
