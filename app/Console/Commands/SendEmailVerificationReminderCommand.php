<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User; 
use App\Mail\VerifyEmailReminder;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationReminderCommand extends Command
{
    protected $signature = 'email:send-reminders';
    protected $description = 'Envía recordatorios de verificación de correo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $usersToVerify = User::whereNull('email_verified_at')->get();

        if ($usersToVerify->isEmpty()) {
            $this->info('No hay usuarios pendientes por verificar.');
            return 0;
        }

        $this->info("Se encontraron {$usersToVerify->count()} usuarios sin verificar. Enviando correos...");

        foreach ($usersToVerify as $user) {
            Mail::to($user->email)->send(new VerifyEmailReminder($user));
            $this->line("-> Recordatorio enviado con éxito a: {$user->email}");
        }

        $this->info('¡Todos los correos han sido procesados!');
        return 0;
    }
}