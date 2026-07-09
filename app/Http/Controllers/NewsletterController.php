<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan; 
use App\Console\Commands\SendEmailVerificationReminderCommand; 
class NewsletterController extends Controller
{
    public function send()
    {
        try {
            Artisan::call('email:send-reminders');

            return response()->json([
                'data' => 'Todo ok'
            ]);
            
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'linea' => $e->getLine()
            ], 500);
        }
    }
}

