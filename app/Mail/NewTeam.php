<?php

namespace App\Mail;

use App\Team;
use App\Ticket;
use App\Page;

use Illuminate\Support\Facades\App;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTeam extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $team;
    public $lang;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Team $team, $lang='ru')
    {
        $this->team = $team;
        $this->lang = $lang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $team = $this->team;

      $lang = $this->lang;

      App::setLocale($lang);

      $ticket = Ticket::findBySlug('dream-team')->with(['cards'=>function($query) use ($lang){
        $query->withTranslation($lang);
      }])->firstOrFail();

      $card = $ticket->cards[0];

      $page = Page::findBySlug('dream-team')
        ->has('event')
        ->has('poll')
        ->with(['event','poll'=>function($query){

          $query->with(['children'=>function($query){
            $query->judge()->orderBy('begin_at');
          }]);

        }])
        ->firstOrFail();

      $poll = $page->poll->children->first();

      $event = $page->event;

      return $this->subject(__('emails.new-team_subject'))
        ->view('client-email.new-team.new-team', compact('team', 'ticket', 'event', 'card', 'poll'));
    }
}
