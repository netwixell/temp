<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class Advertisement extends Model
{
  use Translatable;

  protected $translatable = ['title', 'caption', 'link_title'];

  protected $table = 'advertisement';

  protected $appends = ['src', 'srcset'];

  public static $srcset_widths = [300, 600, 900];

  public function getSrcAttribute(){
    $image = $this->image;

    return !empty($image) ? "/storage/{$image}" : "";
  }

  public function getSrcsetAttribute(){
    $image = $this->image;

    return !empty($image) ? srcset($image, ...self::$srcset_widths) : "";

  }

}
