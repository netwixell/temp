<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\OnlineVote;

class NewOnlineVoteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vote;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OnlineVote $vote)
    {
        $this->vote = $vote;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
      return new Channel('poll-'.$this->vote->poll_id);
        // return new PrivateChannel('channel-name');
    }
    public function broadcastAs()
    {
        return 'poll.new-vote';
    }
    public function broadcastWith()
    {
        return [
            'team_id' => $this->vote->team_id,
            'poll_id' => $this->vote->poll_id,
            'message' => 'New Vote'
        ];
    }
}
