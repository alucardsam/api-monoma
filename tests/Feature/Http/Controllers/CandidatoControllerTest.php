<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Candidato;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CandidatoController
 */
class CandidatoControllerTest extends TestCase
{

  /**
   * @test
   */
  public function index_behaves_as_expected()
  {
    #$this->withoutExceptionHandling();
    $tokenResponse = $this->json('POST', route('api.auth.login'), ['username' => 'tester', 'password' => 'PASSWORD']);
    $dataToken = $tokenResponse->getData();
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $dataToken->data->token,
    ])->json('GET', route('api.leads.index'));
    $response->assertStatus(200)->assertJsonStructure([
      'meta' => [
        'success', 'errors'
      ],
      'data' => [
        '*' => [
          'id', 'name', 'source', 'owner', 'created_at', 'created_by'
        ]
      ]
    ]);
  }


  /**
   * @test
   */
  public function show_behaves_as_expected()
  {
    #$this->withoutExceptionHandling();
    $tokenResponse = $this->json('POST', route('api.auth.login'), ['username' => 'tester', 'password' => 'PASSWORD']);
    $dataToken = $tokenResponse->getData();
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $dataToken->data->token,
    ])->json('GET', route('api.lead.show', 1));
    $response->assertStatus(200)->assertJsonStructure([
      'meta' => [
        'success', 'errors'
      ],
      'data' => [
        'id', 'name', 'source', 'owner', 'created_at', 'created_by'
      ]
    ]);
  }

  /**
   * @test
   */
  public function create_behaves_as_expected()
  {
    #$this->withoutExceptionHandling();
    $tokenResponse = $this->json('POST', route('api.auth.login'), ['username' => 'tester', 'password' => 'PASSWORD']);
    $dataToken = $tokenResponse->getData();
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $dataToken->data->token,
    ])->json('POST', route('api.lead.create'), ['name' => 'Candidato 4', 'source' => 'Remoto', 'owner' => 1]);
    $response->assertStatus(201)->assertJsonStructure([
      'meta' => [
        'success', 'errors'
      ],
      'data' => [
        'id', 'name', 'source', 'owner', 'created_at', 'created_by'
      ]
    ]);
  }
}
