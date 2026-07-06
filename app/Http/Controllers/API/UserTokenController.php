<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        // Emitir el token usando Sanctum
        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }

    public function destroy(Request $request)
    {
        // Revocar el token actual con el que se está autenticando
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Token revocado con éxito']);
    }
}