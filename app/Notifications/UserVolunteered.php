<?php

namespace App\Notifications;

use App\Models\CoffeeRun;
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
     * @param  \App\Models\CoffeeRun  $run
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
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        $tag = config('app.env') === 'production' ? '<!channel> ' : '';

        return (new SlackMessage)
                    ->from('Risky Picker')
                    ->content("{$tag}{$notifiable->full_name} has volunteered to take this run! Thank you!")
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
