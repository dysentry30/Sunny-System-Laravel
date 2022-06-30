<?php

namespace App\Events;

use App\Models\NotificationsModel;
use App\Models\User;
use DateTime;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NotificationPasswordReset implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public User $from_user;
    public User $to_user;
    public string $message;
    public DateTime $timestamp;
    public string $id_notification;
    public bool $is_rejected;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    /**
     * Create a new event instance.
     * 
     * @param User $from_user
     * @param string $message
     * @param string $id_notification
     * @param User $to_user
     * 
     * @return void
     */
    public function __construct(User $from_user, string $message, string $id_notification = "", User $to_user, $is_rejected = true)
    {
        $this->from_user = $from_user;
        $this->to_user = $to_user;
        $this->message = $message;
        $this->timestamp = new DateTime("now");
        $this->id_notification = $id_notification;
        $this->is_rejected = $is_rejected;
        // dd($this);
        $this->dontBroadcastToCurrentUser();
        $is_notif_exist = new NotificationsModel();
        if(!$is_rejected && $from_user->check_administrator == 0) {   
            $is_notif_exist->token_reset_password = Str::random(30);
        } else {
            $is_notif_exist->is_rejected = $is_rejected; 
        }
        $is_notif_exist->id_notification = $this->id_notification;
        $is_notif_exist->from_id_user = $this->from_user->id;
        $is_notif_exist->message = $this->message;
        $is_notif_exist->to_user = $to_user->id;
        $is_notif_exist->save();

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notification.password.reset');
    }
}
