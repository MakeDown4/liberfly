<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Testa a obtenção de todos os usuários.
     *
     * @return void
     */
    public function testGetUsers()
    {
        $user = User::factory()->create();

        // Gera o token JWT
        $token = JWTAuth::fromUser($user);

        // Chama a rota protegida, incluindo o token no cabeçalho Authorization
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->get('/api/users');

        $response->assertStatus(200);
    }

    /**
     * Testa a criação de um usuário.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ];

        $token = JWTAuth::fromUser(User::factory()->create());

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->post('/api/users', $userData);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Usuário criado com sucesso']);
    }

    /**
     * Testa update do usuário.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $updatedUserData = [
            'name' => $this->faker->name,
            'password' => bcrypt('newpassword'),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->put('/api/users/' . $user->id, $updatedUserData);

        // Remover o campo "password" dos dados esperados pro assert do json
        $expectedData = $updatedUserData;
        unset($expectedData['password']);

        $response->assertStatus(200);
        $response->assertJsonFragment($expectedData);
    }

    /**
     * Testa a exclusão de um usuário.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->delete('/api/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Usuário excluído com sucesso']);
    }
}