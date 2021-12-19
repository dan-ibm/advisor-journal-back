<?php


namespace Tests\Feature\Auth;


use Tests\Helpers\AddAuthHelper;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use AddAuthHelper;

    public function test_sign_up_success()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test',
            'surname' => 'Testov',
            'phone' => '81112223344',
            'email' => 'user@test3.com',
            'password' => '12345678Qw'
        ]);
        $response->assertCreated();

        $response->assertJsonStructure([
            'message',
            'user' => [
                'name',
                'surname',
                'phone',
                'email',
                'created_at',
                'updated_at',
                'id'
            ]
        ]);
    }

    public function test_sign_up_failed()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test',
            'surname' => 'Testov',
            'phone' => '81112223344',
            'email' => 'test@test.com',
            'password' => '12345678Qw'
        ]);
        $response->assertStatus(400);
    }

}
