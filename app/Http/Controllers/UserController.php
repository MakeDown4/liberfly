<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API de Usuários",
 *     description="Esta API permite gerenciar usuários através de autenticação e operações CRUD (criar, ler, atualizar, excluir) de usuários. Para utilizar a API, siga o passo a passo abaixo:

Passo 1: Realize a autenticação
- Chame a rota `/api/login` com as credenciais do usuário para obter o token de acesso.

Passo 2: Autorize a API
- No canto superior direito da documentação, clique no botão `Authorize`.
- Insira o token de acesso obtido no passo anterior no campo `Value` (formato: `Bearer <token>`).
- Clique em `Authorize` para aplicar a autorização.

Passo 3: Gerencie os usuários
- Agora você está autorizado a chamar qualquer rota de usuários disponível na API.

Observação: Lembre-se de incluir o token de acesso obtido no cabeçalho de autorização (`Authorization: Bearer <token>`) em cada requisição às rotas protegidas."
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth"
 * )
 */
class UserController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="getUsers",
     *      tags={"Users"},
     *      summary="Obter todos os usuários",
     *      description="Recupera uma lista de todos os usuários",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Operação bem-sucedida"
     *      )
     * )
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

/**
 * @OA\Post(
 *      path="/api/users",
 *      operationId="createUser",
 *      tags={"Users"},
 *      summary="Criar um novo usuário",
 *      description="Cria um novo usuário",
 *      security={{"bearerAuth": {}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="name",
 *                  type="string",
 *                  example="Test user",
 *                  description="Nome do usuário"
 *              ),
 *              @OA\Property(
 *                  property="email",
 *                  type="string",
 *                  format="email",
 *                  example="test@example.com",
 *                  description="E-mail do usuário"
 *              ),
 *              @OA\Property(
 *                  property="password",
 *                  type="string",
 *                  example="password",
 *                  description="Senha do usuário"
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Usuário criado com sucesso"
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Requisição inválida"
 *      )
 * )
 */
public function store(Request $request)
{
    $email = $request->input('email');

    // Verificar se o email já existe na base de dados
    if (User::where('email', $email)->exists()) {
        return response()->json(['error' => 'Email já existe'], 409);
    }

    // Validação dos campos
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Criar o usuário
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $email,
        'password' => bcrypt($request->input('password')),
    ]);

    return response()->json(['message' => 'Usuário criado com sucesso'], 201);
}

    /**
     * @OA\Get(
     *      path="/api/users/{id}",
     *      operationId="getUserById",
     *      tags={"Users"},
     *      summary="Obter um usuário pelo ID",
     *      description="Recupera um usuário pelo ID",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="ID do usuário",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação bem-sucedida"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado"
     *      )
     * )
     */
    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
    }

/**
 * @OA\Put(
 *      path="/api/users/{id}",
 *      operationId="updateUser",
 *      tags={"Users"},
 *      summary="Atualizar um usuário",
 *      description="Atualiza um usuário",
 *      security={{"bearerAuth": {}}},
 *      @OA\Parameter(
 *          name="id",
 *          description="ID do usuário",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property(property="name", type="string", example="Novo nome do usuário"),
 *              @OA\Property(property="password", type="string", example="novasenha")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Usuário atualizado com sucesso"
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Requisição inválida"
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Usuário não encontrado"
 *      ),
 *      @OA\Response(
 *          response=409,
 *          description="Conflito - Email já existe"
 *      )
 * )
 */
public function update(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $user->name = $request->input('name');
    $user->password = bcrypt($request->input('password'));
    $user->save();

    return response()->json($user, 200);
}

    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Excluir um usuário",
     *      description="Exclui um usuário",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="ID do usuário",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Usuário excluído com sucesso"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado"
     *      )
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso'], 200);
    }
}