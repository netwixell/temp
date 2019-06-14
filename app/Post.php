<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Libs\ArticleMD;
use App\Libs\PlainTextParsedownExt;

use TCG\Voyager\Traits\Translatable;

class Post extends Model
{
  use Translatable {
    prepareTranslations as protected traitPrepareTranslations;
  }

   protected $table = 'posts';

   protected $translatable = ['title', 'slug', 'seo_title', 'body', 'content', 'excerpt','meta_description', 'meta_keywords'];

   protected $guarded = [];

   const STATUS_PUBLISHED = 'PUBLISHED';
   const STATUS_DRAFT = 'DRAFT';
   const STATUS_PENDING = 'PENDING';

   public static $statuses = [

    self::STATUS_PUBLISHED,
    self::STATUS_DRAFT,
    self::STATUS_PENDING,

  ];

  public function save(array $options = [])
  {
      // If no author has been assigned, assign the current user's id as the author of the post
      if (!$this->author_id && Auth::user()) {
          $this->author_id = Auth::user()->id;
      }

      // Parse MD to HTML
      if($this->body){

        $this->excerpt = $this->MDtoExcerpt($this->body);

        $this->content = $this->MDtoHTML($this->body);

      }

      parent::save();
  }

  public function MDtoExcerpt($md){

    $Parsedown = new PlainTextParsedownExt();

    $Parsedown->setSafeMode(true);

    return str_replace(["\r\n", "\r", "\n"], "<br/><br/>", str_limit( $Parsedown->text($md) , 300));
  }

  public function MDtoHTML($md){

    $articleMD = new ArticleMD();

    $articleMD->setSafeMode(true);

    return $articleMD->text($md);
  }

  public static function reactionsCount($post_id){
    return static::join('post_reactions','post_reactions.post_id','=', 'posts.id')
      ->selectRaw('post_reactions.type,count(post_reactions.id) as count')
      ->where('post_reactions.post_id', $post_id)
      ->where('is_active', 1)
      ->groupBy('post_reactions.type');

  }

  public static function findBySlug($slug = ''){
    return static::where('slug', $slug);
  }

  public function scopePublished($query)
  {
      return $query->where('status', '=', static::STATUS_PUBLISHED);
  }

  public function reactions(){
    return $this->hasMany('App\PostReaction','post_id');
  }


  public function prepareTranslations(&$request){

    $mdTrans = null;

    $translations = [];

    // Translatable Fields
    $transFields = $this->getTranslatableAttributes();

    foreach ($transFields as $field) {

      if($field == 'excerpt' || $field == 'content') continue;

      $trans = json_decode($request->input($field.'_i18n'), true);

      if($field == 'body'){
        $mdTrans = $trans;
      }

      // Set the default local value
      $request->merge([$field => $trans[config('voyager.multilingual.default', 'en')]]);

      $translations[$field] = $this->setAttributeTranslations(
          $field,
          $trans
      );

      // Remove field hidden input
      unset($request[$field.'_i18n']);

    }

    if(isset($mdTrans)){

      $contentTrans = [];
      $excerptTrans = [];

      foreach($mdTrans as $lang => $md){
        $contentTrans[$lang] = $this->MDtoHTML($md);
        $excerptTrans[$lang] = $this->MDtoExcerpt($md);
      }

      // Set the default local value
      $request->merge(['excerpt' => $trans[config('voyager.multilingual.default', 'en')]]);

      $translations['excerpt'] = $this->setAttributeTranslations(
          'excerpt',
          $excerptTrans
      );

      // Set the default local value
      $request->merge(['content' => $trans[config('voyager.multilingual.default', 'en')]]);

      $translations['content'] = $this->setAttributeTranslations(
          'content',
          $contentTrans
      );

    }

    // Remove language selector input
    unset($request['i18n_selector']);

    return $translations;

    // return $this->traitPrepareTranslations($request);
  }


}
