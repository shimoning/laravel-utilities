<?php

namespace Shimoning\LaravelUtilities\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class MailLogger
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        if (!$event->data || !isset($event->data['message'])) {
          return;
        }

        $message = $event->data['message'];
        $toAddresses = collect($message->getTo())->keys();
        $fromAddresses = collect($message->getFrom())->keys();
        $subject = $message->getSubject();

        Log::channel(config('laravel-utilities.mail_logging_channel'))
            ->info("Mail sent to {$toAddresses} from {$fromAddresses}, subject: {$subject}");
    }
}
