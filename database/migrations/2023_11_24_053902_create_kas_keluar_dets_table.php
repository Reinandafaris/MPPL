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
    Schema::create('kas_keluar_det', function (Blueprint $table) {
      $table->unsignedBigInteger('idkk');
      $table->unsignedBigInteger('idakun');
      $table->double('nilcr');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kas_keluar_det');
  }
};
