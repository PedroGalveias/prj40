<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //membro direcao
        $this->registerPolicies();
        //so o utilizador por editar os seus dados

        Gate::define('edit-perfil', function ($userlogado, $user) {

        });

        Gate::define('direcao', function ($user) {
            return $user->direcao == '1';
        });










    }
}
