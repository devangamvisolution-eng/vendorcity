<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {

            $edit_perm = [];

            if (Auth::check()) {
                $userId = Auth::id();
                $get_user_data = Helper::get_user_data($userId);

                if ($get_user_data && $get_user_data->role_id) {
                    $roleIds = explode(',', $get_user_data->role_id);

                    foreach ($roleIds as $roleId) {
                        $roleId = trim($roleId);

                        $get_permission_data = Helper::get_permission_data($roleId);

                        if (
                            is_object($get_permission_data) &&
                            property_exists($get_permission_data, 'editperm') &&
                            $get_permission_data->editperm != ''
                        ) {
                            $perms = explode(',', $get_permission_data->editperm);
                            $edit_perm = array_merge($edit_perm, $perms);
                        }
                    }

                    $edit_perm = array_values(array_unique($edit_perm));
                }
            }

            $view->with('edit_perm', $edit_perm);
        });
    }
}
