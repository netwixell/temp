<?php

namespace App\Http\Controllers;


use App\Order;

use App\Role;
use Notification;
use App\Notifications\NewOrder;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


use App\Events\NewOrderEvent;
// use TCG\Voyager\Models\Role;


class OrderController extends Controller
{
  public function notification(){

    // return substr(chunk_split("K402",4,"-"),0,-1);
    // return order_number_by_id(5);


    // $order= \App\Order::find(1);
    $callback= \App\Callback::find(1);

    // Mail::to( $order->email )
    //       ->send(new \App\Mail\NewOrder($order));

    $role=Role::where('name','manager')->first();
    $users=$role->my_users()->get();


    return Notification::send($users, new \App\Notifications\NewCallback($callback));

    return Mail::to( $order->email )
          ->send(new \App\Mail\NewOrder($order));


    // return Notification::send($role->users, new NewOrder($order));

  }

  public function buying(){
    return view('web-site.order-buying');
  }
  public function installment(){
    return view('web-site.order-installment');
  }
  // Заполнение формы после выбора билета
  public function ordering(Request $request, $payment_type){

    $request->validate([
        'ticket_id' => 'required'
    ]);
    $order=[];
    $ticket_id=$request->input('ticket_id');
    $selected_groups=$request->input('options_group',[]);
    $selected_options=$request->input('options',[]);

    $lang = app()->getLocale();

    $ticket=\App\Ticket::with(['options'=>function($query) use ($lang){
        $query->withPivot('group')->withTranslation($lang)->orderBy('type','desc')->orderBy('option_id','asc');
    },'cards' => function($query) use ($lang){
      $query->withTranslation($lang);
    }])->withTranslation($lang)->findOrFail($ticket_id);

    $card=$ticket->cards->first();

    $total_cost=$ticket->price;

    $groups = [];

    $order_options_ids=[];
    $order_options=[];
    foreach($ticket->options as $option){
      $group=$option->pivot->group;
      if(isset($group)){
        $groups[$group][]=$option;
      }
      else{
        if(in_array($option->id, $selected_options)){
          $total_cost+=$option->price;
          $order_options_ids[]=$option->id;
          $order_options[]=$option;
        }
      }
    }

    foreach($groups as $group => $group_options){
      $default_option=$group_options[0];

      if(array_key_exists($group, $selected_groups)){
        $selected_option_id=$selected_groups[$group];

        $order_option=$default_option;
        foreach($group_options as $option){
          if($option->id == $selected_option_id){
            $order_option=$option;
            break;
          }
        }
        $total_cost+=$order_option->price;
        $order_options_ids[]=$order_option->id;
        $order_options[]=$order_option;
      }
      else{
        $total_cost+=$default_option->price;
        $order_options_ids[]=$default_option->id;
        $order_options[]=$default_option;
      }
    }

    if(isset($card)){
      $order['card_id']=$card->id;
    }

    $order['ticket_id']=$ticket_id;
    $order['options_ids']=$order_options_ids;
    $order['total_cost']=$total_cost;

    if($payment_type=='installment'){

      $installment_id=$request->input('installment_id');

      $installment=\App\Installment::findOrFail($installment_id);

      $order['installment_id']=$installment_id;
      $order['payment_type']='installments';

      $installment_plan = installment_plan(
        now(),
        $installment->expires_at,
        $total_cost,
        $installment->commission,
        $installment->first_payment
      );


      session(['order' => $order]);

      return view('web-site.order-'.$payment_type, compact(
        'ticket',
        'order_options',
        'total_cost',
        'card',
        'installment',
        'installment_plan'
      ));
    }
    else{
      $order['payment_type']='cash';

      session(['order' => $order]);

      return view('web-site.order-'.$payment_type, compact('ticket','order_options','total_cost','card'));

    }

  }

  public function checkout(Request $request){
    $sessionOrder = session('order');

    $request->validate([
        'name' => 'required|max:255',
        'phone' => 'required|min:9|max:13|phone:AUTO,UA',
        'email' => 'required|email',
        'city' => 'required|max:255',
        'promocode.seller' => 'nullable|max:60',
        'promocode.code' => 'nullable|max:2',
        'comment' => 'nullable|max:65535',
    ]);

    if(!isset($sessionOrder)){
      return abort(401);
    }

    $input_seller=$request->input('promocode.seller');

    $last_order = Order::select('id')->orderBy('id', 'desc')->first();

    if(isset($last_order)){
      $last_id = $last_order->id;
    }
    else{
      $last_id = 0;
    }

    $order_id = $last_id + 1;
    $order=new Order();
    $order->id=$order_id;
    $order->number = order_number_by_id($order_id);
    $order->ticket_id=$sessionOrder['ticket_id'];
    $order->total_price=$sessionOrder['total_cost'];
    $order->payment_type=$sessionOrder['payment_type'];
    if($sessionOrder['payment_type']=='installments'){
      $order->installment_id=$sessionOrder['installment_id'];
    }
    $order->name=$request->name;
    $order->email=$request->email;
    $order->phone=$request->phone;
    $order->city=$request->city;
    $order->lang=app()->getLocale();

    $order->card_id=$sessionOrder['card_id'];

    if(isset($input_seller)){
      $seller=\App\Seller::where('code','=',$input_seller)->first();
      if(isset($seller->id)){
        $order->seller_id=$seller->id;
        $req_code=$request->input('promocode.code','00');
        $code= empty($req_code) ? '00' : $req_code;
        $order->promocode=$input_seller.'-'.$code;
      }
    }

    $order->comment=$request->comment;
    $order->save();

    $ticket=\App\Ticket::find($sessionOrder['ticket_id']);

    if(isset($ticket)){
      $bill = new \App\Bill();
      $bill->price=$ticket->price;
      $bill->order_id=$order->id;
      $ticket->bill()->save($bill);
    }

    if(isset($sessionOrder['options_ids'])){

      $options = \App\Option::findMany($sessionOrder['options_ids']);

      foreach($options as $option){

        $bill = new \App\Bill();

        $bill->price = $option->price;
        $bill->order_id = $order->id;

        $option->bill()->save($bill);
      }
    }

    $request->session()->forget('order');

    Mail::to( $order->email )->send(new \App\Mail\NewOrder($order));


    event(new NewOrderEvent($order));

    if ($request->ajax()) {
      return response()->json([
          'message'    =>  trans('messages.success'),
          'alert-type' => 'success',
          'type' => 'ajax'
      ]);
    }

    return back()->with('success', trans('messages.success'));
  }

  public function create(Request $request){
      $request->validate([
        'name'=>'required|string',
        'email'=>'required|email',
      ]);

      $order=new Order();
      $order->name=$request->name;
      $order->email=$request->email;
      $order->save();


      // $user->notify(new NewOrder($order));
      Notification::send($users, new NewOrder($order));

      Mail::to( $order->email )
          ->send(new \App\Mail\NewOrder($order));

    }
}
