<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdminNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $admin_id; // Add user identifier

    public function __construct($message, $admin_id)
    {
        $this->message = $message;
        $this->admin_id = $admin_id; // Assign user identifier
    }

    public function broadcastOn()
    {
        // Return a private channel for the specific user
        return new PrivateChannel('admin.' . $this->admin_id);
    }

    public function broadcastAs()
    {
        return 'admin-notification-event';
    }
}