<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'completed', 'creator_id'];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'completed' => 'boolean',
            'description' => 'string',
        ];
    }

    public function setDescriptionAttribute($value): void
    {
        $this->attributes['description'] = $value ?? '';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'relations', 'task_id', 'user_id');
    }
}
