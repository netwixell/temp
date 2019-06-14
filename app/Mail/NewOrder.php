<?php

namespace App\Mail;

use App\Order;
use App\Page;

use Illuminate\Support\Facades\App;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use \PDF;

class NewOrder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $order=$this->order;

      $lang = $order->lang;

      App::setLocale($lang);

      $payment_type = strtolower( $order->payment_type );

      $order->load(['ticket'=>function($query) use ($lang){
        $query->withTranslation($lang);
      }, 'card'=>function($query) use ($lang){
        $query->withTranslation($lang);
      }, 'bill_options'=>function($query) use ($lang){
        $query->accommodation()->withTranslation($lang);
      }]);

      $ticket = $order->ticket;

      $ticket->load('event');

      $event = $ticket->event;

      $card = $order->card;

      $accommodation = isset( $order->bill_options[0]) ? $order->bill_options[0]->getTranslatedAttribute('name') : '—';

      // PDF::setOptions(['dpi' => 96/*150*/,'defaultPaperSize'=>'a5', 'defaultFont' => 'dejavu sans condensed']);
      // $pdf = PDF::loadView('pdf.order', ['order'=>$order])->setPaper('a5', 'landscape');

      $pdf = PDF::loadView('pdf.ticket', compact('order','ticket','event','card','accommodation'))
      ->setPaper('a4')
      ->setOption('allow', [ public_path('/pdf/img/layout/molfar.png') ]);


      return $this->subject(__('emails.new-order_subject'))
        // ->replyTo('inbox@molfarforum.com', 'Molfar')
        ->view('client-email.new-order-'.$payment_type.'.new-order-'.$payment_type ,compact('order','ticket','event','card','accommodation') )
        ->attachData($pdf->output(), 'Molfar-Forum-Ticket_'.$order->number.'.pdf', ['mime' => 'application/pdf']);
    }
}
