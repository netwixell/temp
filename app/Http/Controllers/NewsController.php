<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\PostReaction;

use Illuminate\Validation\Rule;
use Validator;

class NewsController extends Controller
{
  public function news(Request $request){

    $page = \App\Page::findBySlug('news')->withTranslation()
      ->firstOrFail();

    if($page->show_adv){
      $advertisement = \App\Advertisement::inRandomOrder()->withTranslation()->first();
    }

    $skip = $request->query('skip',0);
    $limit = 5;

    $items = Post::published()->withTranslation()->latest()->skip($skip)->take($limit)->get();

    if ($request->ajax()) {

      $HTMLitems = [];

      $result = [
        'message'    =>  trans('messages.success'),
        'alert-type' => 'success',
        'type' => 'ajax'
       ];

      foreach($items as $item){
        $HTMLitems[] = view('web-site.news-item.news-item',['item' => $item])->render();
      }

      if(count($items) < $limit){
        $result['HTMLtail'] = view('web-site.news-tail.news-tail')->render();
      }

      $result['HTMLitems'] = $HTMLitems;

      return response()->json($result);
     }

     $firstItem = $items->first();

     if(isset($firstItem) ){

      $ogImage = ( !empty($firstItem->image) ) ? url('/storage/'.$firstItem->image) : (!empty($page->image) ? url('/storage/'. $page->image) : null);

      $metaDescription = $firstItem->title;

     } else {
      $ogImage = (!empty($page->image) ? url('/storage/'. $page->image) : null);

      $metaDescription = $page->meta_description;

     }


    return view('web-site.news',compact('page', 'ogImage', 'metaDescription', 'limit', 'items', 'advertisement'));
  }

  public function article(Request $request, $slug){

    $item = Post::findBySlug($slug)
    ->withTranslation()
    ->withCount(['reactions' => function($query){
      return $query->active();
    }])
    ->firstOrFail();

    $sPostReactions = $request->session()->get('postReactions', []);

    if($request->ajax()){

      if($request->exists('reaction')){

        // Validate reaction
        $val = $this->validateReaction($request->all());

        if ($val->fails()) {
           return response()->json(['success' => false, 'errors' => $val->messages()]);
        }

        $typeReaction = $request->query('reaction');

        if( count($sPostReactions) > 0){

          $userReaction = PostReaction::whereIn('id', $sPostReactions)
            ->where('post_id', $item->id)
            ->where('type', $typeReaction)
            ->first();

        }

        if(isset($userReaction)){

          $userReaction->is_active = !$userReaction->is_active;

        } else {

          $userReaction = new PostReaction();
          $userReaction->post_id = $item->id;
          $userReaction->type = $typeReaction;
          $userReaction->is_active = 1;

        }

        $userReaction->save();

        if(!in_array($userReaction->id, $sPostReactions)){

          $sPostReactions[] = $userReaction->id;
          $request->session()->put('postReactions', $sPostReactions);

        }

        $total = $item->reactions_count + ($userReaction->is_active ? 1 : -1);

        return response()->json([
          'success'   =>  true,
          'type' => 'ajax',
          'isActive' => $userReaction->is_active,
          'total' => $total,
          'totalText' => declOfNum($total, explode("," , __('post_reactions.reactions')))
       ]);

      }

      return abort(404);

    }

    $item->increment('views');

    $content = $item->getTranslatedAttribute('content');

    $reactionsCount = Post::reactionsCount($item->id)->get()->pluck('count', 'type');

    if(count($sPostReactions) > 0){

      $userReactions = PostReaction::where('post_id', $item->id)
                      ->whereIn('id', $sPostReactions)
                      ->active()
                      ->get()
                      ->pluck('type')
                      ->toArray();

    } else {
      $userReactions = [];
    }

    $reactionTypes = PostReaction::$types;

    return view('web-site.article', compact('item', 'content', 'reactionTypes', 'reactionsCount', 'userReactions'));
  }

  public function validateReaction($request){

      return Validator::make($request, [
        'reaction' => ['required',Rule::in(\App\PostReaction::$types)]
      ]);
  }
}
