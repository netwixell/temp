<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonContact extends Model
{
    protected $table = 'person_contacts';
    const TYPE_FACEBOOK = 'FACEBOOK';
    const TYPE_INSTAGRAM = 'INSTAGRAM';
    const TYPE_ODNOKLASSNIKI = 'ODNOKLASSNIKI';
    const TYPE_TELEGRAM = 'TELEGRAM';
    const TYPE_TWITTER = 'TWITTER';
    const TYPE_VIBER = 'VIBER';
    const TYPE_VKONTAKTE = 'VKONTAKTE';
    const TYPE_WEBSITE = 'WEBSITE';
    const TYPE_YOUTUBE = 'YOUTUBE';

    public static $types = [
      self::TYPE_FACEBOOK,
      self::TYPE_INSTAGRAM,
      self::TYPE_ODNOKLASSNIKI,
      self::TYPE_TELEGRAM,
      self::TYPE_TWITTER,
      self::TYPE_VIBER,
      self::TYPE_VKONTAKTE,
      self::TYPE_WEBSITE,
      self::TYPE_YOUTUBE
    ];

    public function person(){
        return $this->belongsTo('App\Person','person_id');
    }
}
