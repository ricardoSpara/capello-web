<?php

namespace Capello\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Capello\User;

class Project extends Model
{
    protected $fillable = ['title', 'description', 'started_date', 'finished_date', 'image','private', 'status'];

    public function courses() {
        return $this->belongsToMany(Course::class, 'projects_courses');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'projects_tags');
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function getStartedDateAttribute($value) {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getFinishedDateAttribute($value){
        if($value != null)
            return Carbon::parse($value)->format('d/m/Y');
        else
            return 'Em andamento';
    }

    public function getStatusAttribute($value) {
        return $value == 0 ? 'Ativo' : 'Inativo';
    }

}
