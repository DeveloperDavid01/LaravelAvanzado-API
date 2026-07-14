<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\API\UserTokenController;
use App\Http\Controllers\NewsletterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Ruta pública para obtener el Tokenevent
Route::post('/sanctum/token', UserTokenController::class);

// Agrupamos todas las rutas que requieren autenticación con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // Endpoint por defecto para conocer el usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Recursos protegidos
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    
    // Ruta para destruir el token (Logout)
    Route::post('/sanctum/logout', [UserTokenController::class, 'destroy']);

    // Envío del newsletter / recordatorio
    Route::post('/newsletter', [NewsletterController::class, 'send']);

    // =========================================================
    // RUTAS DE VERIFICACIÓN DE EMAIL ADAPTADAS PARA LA API
    // =========================================================

    // 1. Aviso de verificación
    Route::get('/email/verify', static function () {
        return response()->json([
            'message' => 'Debes verificar tu correo electrónico para continuar.'
        ], 403);
    })->name('verification.notice');

    // 2. Reenviar correo de verificación manual
    Route::post('/email/verification-notification', static function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json([
            'message' => '¡Enlace de verificación enviado a tu correo!'
        ]);
    })->middleware('throttle:6,1')->name('verification.send');

    // 3. Procesar el clic del enlace (Dentro del grupo para asegurar $request->user())
    Route::get('/email/verify/{id}/{hash}', static function (Request $request, $id, $hash) {
        
        // 1. Validar que el token de Sanctum le pertenezca al usuario de la URL
        if ((string) $request->user()->getKey() !== (string) $id) {
            return response()->json(['message' => 'El token no coincide con el usuario solicitado.'], 403);
        }

        // 2. Validar que el hash corresponda al email del usuario
        if (! hash_equals((string) $hash, sha1($request->user()->getEmailForVerification()))) {
            return response()->json(['message' => 'El enlace de verificación es inválido.'], 403);
        }

        // 3. Si ya estaba verificado, avisar de inmediato
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Este correo ya ha sido verificado anteriormente.']);
        }

        // 4. Marcar como verificado y disparar el evento nativo de Laravel
        if ($request->user()->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user()));
        }

        return response()->json([
            'message' => '¡Correo verificado con éxito!'
        ]);
    })->name('verification.verify');

});