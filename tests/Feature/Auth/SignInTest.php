<?php


namespace Tests\Feature\Auth;


use Tests\Helpers\AddAuthHelper;
use Tests\TestCase;

class SignInTest extends TestCase
{

    use AddAuthHelper;

    public function test_sign_in_success()
    {
        $response = $this->postJson('/api/auth/login', $this->defaultUser());
        $response->assertOk();

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'user' => [
                'id',
                'name',
                'surname',
                'patronymic',
                'phone',
                'email',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function test_sign_in_unauthorized_error()
    {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'test@test.com',
            'password' => 'userErrorPass'
        ]);
        $response->assertStatus(401);
    }

    public function test_sign_in_empty_error()
    {
        $response = $this->postJson('/api/auth/login', []);
        $response->assertStatus(422);
    }

}
