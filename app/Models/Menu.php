<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    protected $fillable = [
        'name',
        'parent_id',
        'depth'

    ];

     /**
     * Get the child menu items for the current menu item.
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    /**
     * Get the parent menu item, if any, for the current menu item.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
