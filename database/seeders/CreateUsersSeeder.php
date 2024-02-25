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
        'name' => 'Angelo Cometa',
        'username' => 'admin_coms',
        'type' => 1,
        'password' => bcrypt('Pass123!'),
      ],
      [
        'name' => 'Ed Marie Macapagal',
        'username' => 'admin_marie',
        'type' => 1,
        'password' => bcrypt('Pass123!'),
      ],
      [
        'name' => 'Hanneka Puri',
        'username' => 'user_nika',
        'type' => 0,
        'password' => bcrypt('Pass123!'),
      ],
      [
        'name' => 'Kim De Leon',
        'username' => 'user_kim',
        'type' => 0,
        'password' => bcrypt('Pass123!'),
      ],
    ];

    foreach ($users as $key => $user) {
      User::create($user);
    }
  }
}
