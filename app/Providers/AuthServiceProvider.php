<?php

namespace App\Providers;

//use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('admin-access', function($user) {
            return $user->role == '0A';
        });

        $gate->define('direksi-access', function($user) {
            return $user->role == 'DA';
        });

        $gate->define('staff-access', function($user) {
            return $user->role == 'SA';
        });

        $gate->define('agen-access', function($user) {
            return $user->role == 'AA';
        });
    }
}
