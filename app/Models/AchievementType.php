<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementType extends Model
{
    protected $fillable = ['name', 'category', 'points', 'description'];
}
