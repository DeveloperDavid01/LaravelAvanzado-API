<?php

namespace App\Listeners;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailModelRatedNotification
{

    public function __construct(string $qualiferName, string $product)
    {
        //
    }
    
    public function handle($event)
    {
        $rateable = $event->getRateable();

        if ($rateable instanceof Product){
            $notification = new ModelRatedNotification(
                $event->getQualifier()->name,
                $rateable->name,
                $event->getScore()

            );

            $rateable->createdBy->notify($notification);
        }
    }
}
