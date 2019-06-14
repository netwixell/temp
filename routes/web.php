<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Mail;

Route::get('/','PageController@main')->name('main');
Route::get('/throwback','PageController@throwback')->name('throwback');
Route::get('/schedule','PageController@schedule')->name('schedule');
Route::get('/recreation','PageController@recreation')->name('recreation');
Route::get('/privacy','PageController@privacy')->name('privacy');

Route::get('/dream-team','PageController@dreamTeam')->name('dream-team');
Route::get('/dream-team/rules','PageController@dtRules')->name('dream-team.rules');
Route::get('/dream-team/sponsors', 'PageController@dtSponsors')->name('dream-team.sponsors');
Route::get('/dream-team/judges', 'PageController@dtJudges')->name('dream-team.judges');

Route::get('/dream-team/vote', 'VoteController@pageVote')->name('dream-team.vote');
Route::get('/dream-team/vote/teams', 'VoteController@teams')->name('dream-team.vote-teams');
Route::get('/dream-team/vote/results/{teamSlug}', 'VoteController@pageVoteResults')->name('dream-team.vote-results');

Route::get('/news','NewsController@news')->name('news');
Route::get('/news/{slug}','NewsController@article')->name('article');


Route::get('language/{lang}', 'PageController@language')->name('langroute');

Route::get('/partners', 'PageController@partners')->name('partners');


Route::post('/dream-team/vote', 'VoteController@giveVote')->name('dream-team.give-vote');
Route::post('/dream-team','PageController@dtRegistration')->name('dtRegistration');
Route::get('{payment_type}', function(){
  return redirect('/');
})->where('payment_type', '(buying|installment)');
Route::post('{payment_type}', 'OrderController@ordering')->where('payment_type', '(buying|installment)');
Route::post('checkout', 'OrderController@checkout')->name('checkout');
Route::post('callback', 'PageController@callback')->name('callback');


// Route::get('vote-broadcast', function(){
//   broadcast(new \App\Events\NewOnlineVoteEvent);
// });

// develpment routes

// Route::get('note', 'OrderController@notification');


// Route::get('/pdf-ticket', function () {
//     $lang = request()->query('lang', 'ru');

//     $order = \App\Order::inRandomOrder()->first();
//     $order->lang = $lang;

//     // $order -> options()->accommodation()->first()

//     // PDF::setOptions(['dpi' => 1, 'defaultFont' => 'dejavu sans condensed']);
//     // $data=[];
//     // $pdf = PDF::loadView('pdf.ticket', ['order'=>$order])->setPaper('a5', 'landscape');
//     // return $pdf->stream('download.pdf');
//     // return $pdf->download('order.pdf');



//     // PDF::loadHTML($html)->setPaper('a4')->setOrientation('portret')->setOption('margin-bottom', 0)->save('myfile.pdf');


//     app()->setlocale($lang);

//     $order->load(['ticket'=>function($query) use ($lang){
//       $query->withTranslation($lang);
//     }, 'card', 'bill_options'=>function($query) use ($lang){
//       $query->accommodation()->withTranslation($lang);
//     }]);

//     $ticket = $order->ticket;

//     $ticket->load('event');

//     $event = $ticket->event;

//     $card = $order->card;

//     $accommodation = isset( $order->bill_options[0]) ? $order->bill_options[0]->getTranslatedAttribute('name') : '—';

//     $pdf = PDF::loadView('pdf.ticket', compact('order','ticket','event','card','accommodation'))
//       ->setPaper('a4')
//       ->setOption('allow', [ public_path('/static/img/pdf/molfar.png') ]);
//       // ->setOrientation('portret')
//       // ->setOption('margin-left', 0)
//       // ->setOption('margin-right', 0)

//       return $pdf->stream();

// // return $pdf->download('ticket.pdf');


// });

// Route::get('mail/{type}',function($type){

//   if($type == 'dt'){
//     $team = \App\Team::inRandomOrder()->first();

//     return new App\Mail\NewTeam($team, request()->query('lang', 'ru'));
//   }

//   $order=App\Order::where('payment_type', $type)->inRandomOrder()->first();
//   $order->lang = request()->query('lang', 'ru');
//   // $order=App\Order::findOrFail(12);

//   Mail::to( $order->email )->send(new \App\Mail\NewOrder($order));

//   return new App\Mail\NewOrder($order);
// })->where('type', '(cash|installments|dt)');


Route::group(['prefix' => 'home'], function () {
  App::setLocale('ru');
  Voyager::routes();
});
