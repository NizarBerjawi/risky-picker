<?php

namespace App\Notifications;

use App\Models\CoffeeRun;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class VolunteerRequested extends Notification implements ShouldQueue
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
     * @param \App\Models\CoffeeRun  $run
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
            ->content("{$tag}{$notifiable->full_name} has requested a volunteer to take this run!")
            ->attachment(function($attachment) {
                $attachment->content("You can volunteer for this run here:" . route('dashboard.index'));
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
