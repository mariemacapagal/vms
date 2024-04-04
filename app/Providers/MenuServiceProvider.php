<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */

  public function boot(): void
  {
    $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
    $verticalMenuData = json_decode($verticalMenuJson);

    $userVerticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu-user.json'));
    $userVerticalMenuData = json_decode($userVerticalMenuJson);

    // Share the admin menu data with all views
    \View::share('menuData', [$verticalMenuData]);

    // Share the user menu data with all views
    \View::share('userMenu', [$userVerticalMenuData]);
  }
}
