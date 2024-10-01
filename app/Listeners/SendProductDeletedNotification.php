<?php

namespace App\Listeners;

use App\Events\ProductDeleted;
use App\Notifications\ProductDeletedNotification;

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
        $event->product->user->notify(new ProductDeletedNotification($event->product));
    }
}
