<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * GET /api/users
     * Muestra todos los usuarios
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * GET /api/users/{id}
     * Muestra un usuario específico
     */
    // public function show($id)
    // {
    //     $user = User::find($id);

    //     if (!$user) {
    //         return response()->json(['message' => 'Usuario no encontrado'], 404);
    //     }

    //     return response()->json($user, 200);
    // }

    /**
     * POST /api/users
     * Crea un nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token'    => \Str::random(10),
        ]);

        return response()->json($user, 201);
    }

    /**
     * PUT /api/users/{id}
     * Actualiza un usuario
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->update([
            'name'     => $request->name ?? $user->name,
            'email'    => $request->email ?? $user->email,
            'password' => $request->filled('password')
            ? Hash::make($request->password)
            : $user->password,
        ]);

        return response()->json($user, 200);
    }

    /**
     * DELETE /api/users/{id}
     * Elimina un usuario
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }

    public function login(Request $request)
    {
        $email    = $request->query('email');
        $password = $request->query('password');

        if (!$email || !$password) {
            return response()->json(['message' => 'Debe proporcionar email y password'], 400);
        }

        $user = User::where('email', $email)->first();

        if (!$user || !\Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        return response()->json([
            'message' => 'Login exitoso',
            'user'    => $user,
        ], 200);
    }
}
