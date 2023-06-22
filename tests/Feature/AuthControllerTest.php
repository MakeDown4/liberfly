<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o login de um usuário válido.
     *
     * @return void
     */
    public function testLoginWithValidCredentials()
    {
        // Cria um usuário de teste
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Envia uma solicitação POST para o endpoint de login
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Verifica se a resposta tem o status 200 (login bem-sucedido)
        $response->assertStatus(200);

        // Verifica se a resposta contém um token
        $response->assertJsonStructure([
            'token',
        ]);
    }

    /**
     * Testa o login com credenciais inválidas.
     *
     * @return void
     */
    public function testLoginWithInvalidCredentials()
    {
        // Envia uma solicitação POST para o endpoint de login com credenciais inválidas
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);

        // Verifica se a resposta tem o status 400 (credenciais inválidas)
        $response->assertStatus(400);

        // Verifica se a resposta contém a mensagem de erro correta
        $response->assertJson([
            'error' => 'invalid_credentials',
        ]);
    }
}

