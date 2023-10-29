<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      [
        'username' => 'tester',
        'password' => Hash::make('PASSWORD'),
        'last_login' => date('Y-m-d H:i:s'),
        'is_active' => true,
        'role' => 'manager',
      ],
      [
        'username' => 'prueba',
        'password' => Hash::make('12345678'),
        'last_login' => date('Y-m-d H:i:s'),
        'is_active' => true,
        'role' => 'agent',
      ]
    ];

    foreach ($data as $usuario) {
      Usuario::create($usuario)->assignRole($usuario['role']);
    }
  }
}
