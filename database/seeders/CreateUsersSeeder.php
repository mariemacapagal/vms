<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(): void
  {
    $users = [
      [
        'name' => 'Marlon Gonzales',
        'username' => 'oic_marlon',
        'type' => 1,
        'password' => bcrypt('Pass123!'),
      ],
      [
        'name' => 'Jestoni Manalili',
        'username' => 'guard_jes',
        'type' => 0,
        'password' => bcrypt('Pass123!'),
      ],
    ];

    foreach ($users as $key => $user) {
      User::create($user);
    }
  }
}
