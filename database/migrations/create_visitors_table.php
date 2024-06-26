<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('visitors', function (Blueprint $table) {
      $table->id();
      $table->string('visitor_first_name', 40);
      $table->string('visitor_last_name', 40);
      $table->string('license_plate', 13);
      $table->string('visit_purpose', 30)->nullable();
      $table->string('resident_name', 80)->nullable();
      $table->date('from_visit_date')->nullable();
      $table->date('to_visit_date')->nullable();
      $table->string('visitor_qrcode', 36);
      $table->string('valid_id');
      $table->date('registered_date');
      $table->string('user');
      $table->timestamps();
    });

    Schema::create('blocked_visitors', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('visitor_id');
      $table->string('visitor_first_name', 40);
      $table->string('visitor_last_name', 40);
      $table->string('license_plate', 13);
      $table->string('valid_id');
      $table->date('registered_date');
      $table->date('blocked_date');
      $table->string('remarks');
      $table->string('user');
      $table->timestamps();
    });

    Schema::create('blocked_lists', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('visitor_id');
      $table->string('visitor_first_name', 40);
      $table->string('visitor_last_name', 40);
      $table->string('license_plate', 13);
      $table->string('valid_id');
      $table->date('registered_date');
      $table->date('blocked_date');
      $table->string('remarks');
      $table->string('user');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visitors');
    Schema::dropIfExists('blocked_visitors');
    Schema::dropIfExists('blocked_lists');
  }
};