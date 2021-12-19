<?php


namespace Tests\Helpers;


trait AddAuthHelper
{
    protected function makeHeader(string $bearerToken): array
    {
        return ['accept' => 'application/json', 'Authorization' => "Bearer ${bearerToken}"];
    }


    public function defaultUser(): array
    {
        return [
            'email'    => "test@test.com",
            'password' => 'Qwerty123@',
        ];
    }

    /**
     * @throws \Throwable
     */
    private function userLogin(): string
    {
        $loginResponse = $this->postJson('/api/auth/login', $this->defaultUser());
        $loginResponse->assertOk();

        return $loginResponse->decodeResponseJson()['access_token'];
    }

}

