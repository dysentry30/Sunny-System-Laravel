<?php

namespace App\Events;

use App\Models\NotificationsModel;
use App\Models\UnitKerja;
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

class LockForeacastEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public User $from_user;
    public User $to_user;
    public array $next_user;
    public string $message;
    public string $id_notification;
    public bool $is_approved;
    public bool $is_rejected;
    public DateTime $timestamp;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $from_user, User $to_user, $message, $next_user, $is_approved, $is_rejected)
    {
        $this->id_notification = Str::uuid();
        $this->message = $message;
        $this->to_user = $to_user;
        $this->from_user = $from_user;
        $this->next_user = $next_user;
        $this->timestamp = new DateTime("now");
        // $next_user = User::find($next_user);
        // if(!empty($next_user)) {
        //     $this->next_user = $next_user;
        // }
        $this->is_approved = $is_approved;
        $this->is_rejected = $is_rejected;

        $new_notif = new NotificationsModel();
        $new_notif->id_notification = $this->id_notification;
        $new_notif->from_id_user = $this->from_user->id;
        $new_notif->to_user = $this->to_user->id;
        $new_notif->message = $this->message;
        $new_notif->next_user = join(",", $this->next_user);
        $new_notif->is_approved = $is_approved ?? false;
        $new_notif->is_rejected = $is_rejected ?? false;
        $new_notif->save();
        // $this->dontBroadcastToCurrentUser();
    } 

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('lock.foreacast.event');
    }
}
