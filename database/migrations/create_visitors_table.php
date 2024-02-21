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
      $table->string('visitor_name', 60);
      $table->string('license_plate', 8);
      $table->string('visit_purpose', 30);
      $table->string('resident_name', 60);
      $table->date('visit_date');
      $table->string('visitor_qrcode', 35)->nullable();
      $table->string('registered_date');
      $table->timestamps();
    });

    Schema::create('deleted_visitors', function (Blueprint $table) {
      $table->id();
      $table->integer('visitor_id');
      $table->string('visitor_name', 60);
      $table->string('license_plate', 8);
      //$table->string('visit_purpose', 30);
      //$table->string('resident_name', 60);
      //$table->date('visit_date');
      $table->string('visitor_qrcode', 35);
      $table->string('registered_date');
      $table->timestamps();
    });

    Schema::create('visitor_histories', function (Blueprint $table) {
      $table->id();
      $table->integer('visitor_id');
      $table->string('visitor_name', 60);
      $table->string('license_plate', 8);
      $table->string('visit_purpose', 30);
      $table->string('resident_name', 60);
      $table->date('visit_date');
      $table->string('visitor_qrcode', 35);
      $table->string('registered_date');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visitors');
    Schema::dropIfExists('deleted_visitors');
    Schema::dropIfExists('visitors_history');
  }
};