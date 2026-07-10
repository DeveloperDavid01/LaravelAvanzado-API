<!DOCTYPE html>
<html>
<head>
    <title>Verifica tu cuenta</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>¡Hola, {{ $user->name }}!</h2>
    <p>Este es un recordatorio automático para que verifiques tu cuenta en nuestra API.</p>
    <p>Por favor, haz clic en el siguiente enlace o cópialo en tu cliente de pruebas (Postman) para validar tu correo electrónico:</p>
    
    <p style="margin: 20px 0;">
        <a href="{{ $verificationUrl }}" style="background-color: #2d3748; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Verificar mi cuenta
        </a>
    </p>

    <p>Si tienes problemas con el botón, usa esta URL completa:</p>
    <p style="word-break: break-all; color: #3869d4;">{{ $verificationUrl }}</p>
    
    <p>Saludos,<br>Platzi API Team</p>
</body>
</html>