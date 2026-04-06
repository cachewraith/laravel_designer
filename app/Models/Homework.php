<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homeworks';

    protected $fillable = [
        'title',
        'description',
        'teacher_id',
        'due_date',
        'max_score',
        'is_active',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_active' => 'boolean',
        'max_score' => 'integer',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isOverdue()
    {
        return $this->due_date && now()->gt($this->due_date);
    }
}
