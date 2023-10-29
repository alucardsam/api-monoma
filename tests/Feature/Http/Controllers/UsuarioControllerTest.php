<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UsuarioController
 */
class UsuarioControllerTest extends TestCase
{
	/**
	 * @test
	 */
	public function login_behaves_as_expected()
	{
		#$this->withoutExceptionHandling();
		$response = $this->json('POST', route('api.auth.login'), ['username' => 'tester', 'password' => 'PASSWORD']);
		$response->assertStatus(200)->assertJsonStructure([
			'meta' => [
				'success', 'errors'
			],
			'data' => [
				'token', 'minutes_to_expire'
			]
		]);
	}
}
