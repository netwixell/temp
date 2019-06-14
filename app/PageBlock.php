<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Libs\BlockDTRuleMD;
use App\Libs\BlockDTVoteMD;

use TCG\Voyager\Traits\Translatable;

class PageBlock extends Model
{
  use Translatable {
    prepareTranslations as protected traitPrepareTranslations;
  }

  protected $translatable = ['title', 'md', 'html'];
  protected $table='page_blocks';

  public $additional_attributes = ['name'];

  const TYPE_LEVEL_1 = 'LEVEL_1';
  const TYPE_LEVEL_2 = 'LEVEL_2';
  const TYPE_LEVEL_3 = 'LEVEL_3';
  const TYPE_LEFT_COLUMN = 'LEFT_COLUMN';
  const TYPE_RIGHT_COLUMN = 'RIGHT_COLUMN';
  const TYPE_CAPTION = 'CAPTION';

   public static $types = [

    self::TYPE_LEVEL_1,
    self::TYPE_LEVEL_2,
    self::TYPE_LEVEL_3,
    self::TYPE_LEFT_COLUMN,
    self::TYPE_RIGHT_COLUMN,
    self::TYPE_CAPTION,

  ];

  public function save(array $options = [])
  {
      // Parse MD to HTML
      if($this->md){

        $slug = $this->page->slug;

        $this->html = $this->MDtoHTML($this->md);
      }

      parent::save();
  }

  public function children(){
    return $this->hasMany('App\PageBlock','parent_id');
  }

  public function parent(){
    return $this->belongsTo('App\PageBlock', 'parent_id')->whereNotIn('type', [$this::TYPE_LEFT_COLUMN, $this::TYPE_RIGHT_COLUMN]);
  }

  public function page(){
    return $this->belongsTo('App\Page', 'page_id');
  }

  public function getNameAttribute(){

    if($this->type == $this::TYPE_LEVEL_3){
      if(!empty($this->parent->title)){
        return $this->parent->title.': '.$this->title;
      }
    }
    elseif($this->type == $this::TYPE_LEFT_COLUMN){
      return $this->title.' (Левый столбец)';
    }
    elseif($this->type == $this::TYPE_RIGHT_COLUMN){
      return $this->title.' (Правый столбец)';
    }


    return $this->title;
  }

  public function MDtoHTML($md){
    $slug = $this->page->slug;

    $html = '';

    if($slug == 'dream-team.rules'){

      $blockDTRuleMD = new BlockDTRuleMD($this);

      $blockDTRuleMD->setSafeMode(true);

      $html = $blockDTRuleMD->text($md);

    } elseif($slug == 'dream-team.vote') {

      $blockDTVoteMD = new BlockDTVoteMD($this);

      $blockDTVoteMD->setSafeMode(true);

      $html = $blockDTVoteMD->text($md);

    }

    return $html;
  }

  public function prepareTranslations(&$request){

    $mdTrans = null;

    $translations = [];

    // Translatable Fields
    $transFields = $this->getTranslatableAttributes();

    foreach ($transFields as $field) {

      if($field == 'html') continue;

      $trans = json_decode($request->input($field.'_i18n'), true);

      if($field == 'md'){
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

      $htmlTrans = [];
      $slug = $this->page->slug;

      foreach($mdTrans as $lang => $md){
        $htmlTrans[$lang] = $this->MDtoHTML($md);
      }

      // Set the default local value
      $request->merge(['html' => $trans[config('voyager.multilingual.default', 'en')]]);

      $translations['html'] = $this->setAttributeTranslations(
          'html',
          $htmlTrans
      );

    }

    // Remove language selector input
    unset($request['i18n_selector']);

    return $translations;

    // return $this->traitPrepareTranslations($request);
  }

}
