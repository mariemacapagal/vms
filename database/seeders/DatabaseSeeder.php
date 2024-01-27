<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    //\App\Models\User::factory(30)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    // Define the number of random visitors you want to generate
    $numberOfVisitors = 10;
    for ($i = 0; $i < $numberOfVisitors; $i++) {
      DB::table('visitors')->insert([
        'visitor_name' => 'Visitor Name',
        'license_plate' => Str::random(8),
        'visit_purpose' => 'Visit Purpose',
        'visit_date' => Carbon::create('2024', '01', '28'),
        'visitor_qrcode' => Str::random(16),
        'registered_date' => Carbon::create('2024', '01', '26'),
      ]);
    }
  }
}
