<?php

namespace App\Listeners;

use App\Events\ProductDeleted;
use App\Notifications\ProductDeletedNotification;
use Illuminate\Support\Facades\Log;

class SendProductDeletedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductDeleted $event): void
    {
        Log::channel('adminlog')->info('Product with name \''.$event->product->name.'\' has been deleted by '.$event->user->name.'.');

        $event->product->user->notify(new ProductDeletedNotification($event->product));
    }
}
