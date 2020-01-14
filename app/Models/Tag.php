<?php

namespace Capello\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'course_id', 'user_id'];
}
