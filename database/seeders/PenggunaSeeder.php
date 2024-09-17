<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $pengguna = new \App\Models\User;
    $pengguna->username = "admin";
    $pengguna->name = "Administrator";
    $pengguna->email = "adminpa1@bsi.ac.id";
    $pengguna->roles = json_encode(["ADMIN"]);
    $pengguna->password = Hash::make("admin");
    $pengguna->phone = "081851851851";
    $pengguna->address = "Jl Raya Jatiwaringin No. 101";
    $pengguna->status = "ACTIVE";
    $pengguna->save();
    $this->command->info("User Admin berhasil diinsert");
  }
}
