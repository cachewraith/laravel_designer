<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'position',
        'order',
        'is_active',
        'parent_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeHeader($query)
    {
        return $query->where('position', 'header')->whereNull('parent_id');
    }

    public function scopeFooter($query)
    {
        return $query->where('position', 'footer')->whereNull('parent_id');
    }
}
