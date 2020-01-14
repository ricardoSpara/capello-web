<?php

namespace Capello;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Capello\Notifications\ResetPassword;
use Carbon\Carbon;

use Capello\Models\Project;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'image', 'access_level', 'status', 'course_id', 'ra', 'degree', 'cpf', 'birth', 'gender', 'phone', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getBirthAttribute($value) {
        if($value) 
            return Carbon::parse($value)->format('d/m/Y');
        return "";
    }
}
