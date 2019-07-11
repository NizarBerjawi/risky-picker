<?php

namespace Picker\User\Notifications;

use Picker\CoffeeRun;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Support\Facades\URL;

class UserPicked extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The coffee run that the user was picked for
     *
     * @var CoffeeRun $run
     */
    protected $run;

    /**
     * Instantiate the Notification
     */
    public function __construct(CoffeeRun $run)
    {
        $this->run = $run;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $tag = config('app.env') === 'production' ? '<!channel> ' : '';

        return (new SlackMessage)
                    ->from('Risky Picker')
                    ->content("{$tag}{$notifiable->full_name} You have been picked!")
                    ->attachment(function($attachment) {
                        $attachment->content("You can find today's orders here:" . route('index', $this->run));
                    });
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
