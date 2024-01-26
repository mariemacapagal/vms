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
        'password' => bcrypt('12345678'),
      ],
      [
        'name' => 'Ed Marie Macapagal',
        'username' => 'admin_marie',
        'type' => 1,
        'password' => bcrypt('12345678'),
      ],
      [
        'name' => 'Hanneka Puri',
        'username' => 'user_nika',
        'type' => 0,
        'password' => bcrypt('12345678'),
      ],
      [
        'name' => 'Kim De Leon',
        'username' => 'user_kim',
        'type' => 0,
        'password' => bcrypt('12345678'),
      ],
    ];

    foreach ($users as $key => $user) {
      User::create($user);
    }
  }
}
