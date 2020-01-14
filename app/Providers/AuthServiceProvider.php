<?php

namespace Capello\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Capello\User;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Capello\Model' => 'Capello\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function(User $user) {
            return $user->access_level == 5;
        });

        Gate::define('isUser', function(User $user) {
            return $user->access_level == 0;
        });

        Gate::define('isStudent', function(User $user) {
            return $user->access_level == 3;
        });
        
        Gate::define('isTeacher', function(User $user) {
            return $user->access_level == 4;
        });

        Gate::define('isStudentHigher', function(User $user) {
            return $user->access_level >= 3;
        });

        Gate::define('isTeacherHigher', function(User $user) {
            return $user->access_level >= 4;
        });

    }
}
