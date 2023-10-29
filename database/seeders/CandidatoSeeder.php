<?php

namespace Database\Seeders;

use App\Models\Candidato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatoSeeder extends Seeder
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
        'name' => 'Mi candidato',
        'source' => 'Fotocasa',
        'owner' => 2,
        'created_by' => 1,
      ],
      [
        'name' => 'Candidato 2',
        'source' => 'Remoto',
        'owner' => 1,
        'created_by' => 1,
      ],
      [
        'name' => 'Candidato 3',
        'source' => 'Fotocasa',
        'owner' => 1,
        'created_by' => 1,
      ],
      [
        'name' => 'Candidato 4',
        'source' => 'Remoto',
        'owner' => 2,
        'created_by' => 1,
      ]
    ];

    foreach ($data as $candidato) {
      Candidato::create($candidato);
    }
  }
}
