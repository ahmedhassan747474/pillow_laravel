<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Session::put('back_locale','ar');
        Gate::define('can_view', function ($user) {


                return $user->isAdmin
                            ? Response::allow()
                            : Response::deny('You must be a super administrator.');

        });

        Gate::define('can_create', function ($user) {


            return $user->isAdmin
                        ? Response::allow()
                        : Response::deny('You must be a super administrator.');

    });

        Blade::directive('canCreate', function () {
			return "<?php if ( Auth::guard('admin')->user()->permissions->can_create ) : ?>";
        });

        Blade::directive('canEdit', function () {
			return "<?php if ( Auth::guard('admin')->user()->permissions->can_edit ) : ?>";
        });

        Blade::directive('canShow', function () {
			return "<?php if ( Auth::guard('admin')->user()->permissions->can_show ) : ?>";
        });

        Blade::directive('canDelete', function () {
			return "<?php if ( Auth::guard('admin')->user()->permissions->can_delete ) : ?>";
        });

        Blade::directive('endCan', function () {
			return "<?php endif; ?>";
        });

    }
}
