<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User; 
use App\Notifications\NewsletterNotification; 

class SendNewsletterCommand extends Command 
{
    
    protected $signature = 'send:newsletter {emails?*}';

    protected $description = 'Envía un correo electrónico de newsletter a los usuarios verificados';

    public function handle()
    {
        $emails = $this->argument('emails');

        $builder = User::query()->whereNotNull('email_verified_at');

        if (!empty($emails)) {
            $builder->whereIn('email', $emails);
        }

        $count = $builder->count();
        
        if ($count > 0) {   
            $this->output->progressStart($count);

            $builder->each(function (User $user) {
                $user->notify(new NewsletterNotification());
                $this->output->progressAdvance();
            });

            $this->output->progressFinish();
            $this->info("Se enviaron {$count} correos correctamente.");
            
        }  

        $this->warn('No se envió ningún correo (ningún usuario coincidió o no están verificados).');
    }
}
