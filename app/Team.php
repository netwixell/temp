<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TCG\Voyager\Traits\Translatable;

class Team extends Model
{
    use Translatable;

    protected $table='teams';
    protected $translatable = ['name','city','country'];

    protected $fillable = ['name','contact_name','email','phone','city'];

    protected $hidden = ['contact_name','phone','email','notice', 'country', 'city', 'photos', 'created_at', 'updated_at', 'event_id', 'judgeVotes'];

    protected $appends = ['location', 'caption', 'responsive'];

    public static $gallery_widths = [720, 1080, 2160, 4320];
    public static $card_widths = [300, 600, 900];

    const STATUS_NEW = 'NEW';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_PAID = 'PAID';
    const STATUS_EXPELLED = 'EXPELLED';
    const STATUS_CANCELED = 'CANCELED';

    public static $statuses = [self::STATUS_NEW, self::STATUS_ACCEPTED, self::STATUS_PAID, self::STATUS_EXPELLED, self::STATUS_CANCELED];

    public static $included_statuses = [self::STATUS_ACCEPTED, self::STATUS_PAID];

    public static $registered_statuses = [self::STATUS_ACCEPTED, self::STATUS_PAID, self::STATUS_EXPELLED];

    const BADGE_GRAND_PRIX = 'GRAND_PRIX';
    const BADGE_PEOPLES_CHOICE = 'PEOPLES_CHOICE';
    const BADGE_BEST_HAIRSTYLE = 'BEST_HAIRSTYLE';
    const BADGE_BEST_MAKEUP = 'BEST_MAKEUP';
    const BADGE_BEST_MANICURE = 'BEST_MANICURE';

    const BADGE_FINALIST = 'FINALIST';

    public static $badges = [self::BADGE_GRAND_PRIX, self::BADGE_BEST_HAIRSTYLE, self::BADGE_BEST_MANICURE, self::BADGE_BEST_MAKEUP, self::BADGE_PEOPLES_CHOICE, self::BADGE_FINALIST];

    public static function boot(){
      parent::boot();

      self::updating(function($model){

        $original_status = $model->getOriginal('status');

        if($model->status != $original_status){
          $model->unreadUsers()->detach();
        }

      });

      self::deleting(function($model){
        $model->unreadUsers()->detach();
      });
    }

    public function save(array $options = [])
    {
      $this->responsive = null;

      if($this->photos){

        $result = [];
        $photos = $this->photoArray;
        $gallery_widths = self::$gallery_widths;
        $card_widths = self::$card_widths;

        if(is_array($photos) && isset($photos[0])){

          $result[] = getResponsiveProps($photos[0], ...$card_widths);

            foreach($photos as $n => $photo){
              $item = getResponsiveProps($photo, ...$gallery_widths);

              $result[] = $item;
            }

          $this->responsive = json_encode($result);

        }

      }

      parent::save();
    }


    public function getLocationAttribute(){

      if(!empty($this->country)){
        return $this->getTranslatedAttribute('city').', '.$this->getTranslatedAttribute('country');
      }

      return $this->getTranslatedAttribute('city');
    }

    public function getCaptionAttribute(){
      return "«{$this->getTranslatedAttribute('name')}» — {$this->location}";
    }
    public function getBadgeCaptionAttribute(){
      if(!isset($this->badge)) return null;

      return __('teams.'.$this->badge);
    }
    public function getOnlineVotesCaptionAttribute(){
      $votesCount = $this->votesCount;
      if(!isset($votesCount)) return null;

      return __('votes.online_votes_caption').' '.number_format($votesCount, 0, '', ' ').' '.declOfNum($votesCount, explode("," , __('votes.votes')));
    }
    public function getJudgeVotesCaptionAttribute(){
      $sum = $this->judgeVotesSum;

      if(!isset($sum)) return null;

      return __('votes.judge_votes_caption').' '.number_format($sum, 0, '', ' ').' '.declOfNum($sum, explode("," , __('votes.points')));
    }
    public function getVoteResultsUrlAttribute(){
      $slug = $this->slug;

      if(!isset($slug)) return null;

      return url("/dream-team/vote/results/{$slug}");
    }


    public function getPhotoArrayAttribute(){
       return json_decode($this->photos);
    }

    public function getResponsiveAttribute(){
      return json_decode($this->getOriginal('responsive'));
    }

    public function getJudgeVotesSumAttribute(){
      if(!isset($this->judgeVotes)) return null;

      return $this->judgeVotes->sum('score');
    }

    public function event(){
        return $this->belongsTo('App\Event','event_id');
    }

    public static function findBySlug($slug=''){
      return static::where('slug', $slug)->paid();
    }

    public function scopePaid($query){
      return $query->where('status', static::STATUS_PAID);
    }
    public function scopeIncluded($query){
      return $query->whereIn('status',self::$included_statuses);
    }
    public function scopeRegistered($query){
      return $query->whereIn('status',self::$registered_statuses);
    }

    public function unreadUsers(){
      return $this->morphToMany('App\User', 'userable');
    }

    public function onlineVotes(){
      return $this->hasMany('App\OnlineVote','team_id');
    }
    public function audienceVotes(){
      return $this->hasMany('App\AudienceVote','team_id');
    }
    public function judgeVotes(){
      return $this->hasMany('App\JudgeVote','team_id');
    }
    public function judgeVotesSum(){
      return $this->hasMany('App\JudgeVote','team_id');
    }

    protected $casts = [
      'only_best_teams' => 'boolean',
    ];

}
