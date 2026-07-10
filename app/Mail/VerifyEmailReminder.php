<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class VerifyEmailReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        // Obtenemos la URL base limpia desde el archivo .env (ej. http://127.0.0.1:8000)
        $baseUrl = rtrim(config('app.url'), '/');

        $hash = sha1($user->getEmailForVerification());

        // Construimos la URL uniendo la base del .env con el prefijo de la API de forma directa
        $this->verificationUrl = "{$baseUrl}/api/email/verify/{$user->getKey()}/{$hash}";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Recordatorio: Verifica tu correo electrónico')
                    ->view('emails.verify-reminder');
    }
}