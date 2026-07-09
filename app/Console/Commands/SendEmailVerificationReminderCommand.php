<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User; // <-- Importamos el modelo User para buscar en la BD
use Illuminate\Auth\Notifications\VerifyEmail; // <-- La notificación nativa de Laravel

class SendEmailVerificationReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de verificación de correo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $usersToVerify = User::whereNull('email_verified_at')->get();

        if ($usersToVerify->isEmpty()) {
            return 0;
        }

        foreach ($usersToVerify as $user) {
            $user->notify(new VerifyEmail);
        }

        return 0;
    }
}