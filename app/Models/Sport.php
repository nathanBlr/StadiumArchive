<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sport extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'description'];
    public function stadiums():HasMany
    {
        return $this->hasMany(Stadium::class);
    }
}
