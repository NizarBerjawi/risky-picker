<?php

namespace Picker\CoffeeRun\Notifications;

use Picker\CoffeeRun;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class UserVolunteered extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The coffee run that a volunteer was requested for
     *
     * @var CoffeeRun $run
     */
    protected $run;

    /**
     * Instantiate the Notification
     *
     * @param CoffeeRun $run
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
        return (new SlackMessage)
                    ->from('Risky Picker')
                    ->content("{$notifiable->full_name} has volunteered to take this run! Thank you!")
                    ->attachment(function($attachment) {
                        $attachment->content("You can find today's orders here:" . $this->run->signed_url);
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
