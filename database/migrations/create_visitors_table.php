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
      $table->string('visitor_name', 50);
      $table->string('license_plate', 8);
      $table->string('visit_purpose', 50);
      $table->date('visit_date');
      $table->string('visitor_qrcode')->nullable();
      $table->datetime('registered_date', 22);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visitors');
  }
};
