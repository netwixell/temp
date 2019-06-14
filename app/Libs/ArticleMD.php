<?php

namespace App\Libs;

use Parsedown;

class ArticleMD extends Parsedown
{
  /**
     * The regex which matches an markdown image definition
     *
     * @var string
     */
    private $markdownImage = "~^!\[.*?\]\(.*?\)$~";

    private $appHost;

    function text($text){

      $this->appHost = parse_url(config('app.url'), PHP_URL_HOST);

      return parent::text($text);
    }

    protected function blockHeader($Line)
    {
      $header = parent::blockHeader($Line);

        if (!isset($header)){
            return null;
        }
        $header['element']['name'] = 'h2';

        $header['element']['attributes']['class'] = 'article__title article__title--h2';

        return $header;
    }

    protected function blockQuote($Line)
    {
      $quote = parent::blockQuote($Line);

        if (!isset($quote)){
            return null;
        }

        $quote['element']['attributes']['class'] = 'article__quote';

        return $quote;
    }

    protected function paragraph($Line)
    {

      if (1 === preg_match($this->markdownImage, $Line["text"]))
      {
        return $this->inlineImage($Line);
      }

      $paragraph = parent::paragraph($Line);

        if (!isset($paragraph)){
            return null;
        }

        $paragraph['element']['attributes']['class'] = 'article__text';

        return $paragraph;
    }

    protected function blockList($Line, array $CurrentBlock = null)
    {
      $blockList = parent::blockList($Line, $CurrentBlock);

        if (!isset($blockList)){
            return null;
        }

        $blockList['element']['attributes']['class'] = ($blockList['element']['name'] === 'ol') ? 'article__ordered-list' : 'article__unordered-list';

        return $blockList;
    }

    protected function inlineImage($excerpt)
    {
        $image = parent::inlineImage($excerpt);

        if ( ! isset($image))
        {
            return null;
        }

        $src = $image['element']['attributes']['src'];

        $image['element']['attributes']['data-src'] = $src;

        $partsSrc = parse_url($src);

        if($partsSrc['host'] === $this->appHost){

          $path = ltrim( $partsSrc['path'], "/storage/");

          $srcset = srcset($path, 600, 900, 1200, 1500, 1800);

          $image['element']['attributes']['data-srcset'] = $srcset;
          $image['element']['attributes']['data-src'] = getThumbnail($path, 600);

        } elseif( preg_match('/(youtube\.com|youtu\.be)/', $partsSrc['host']) ) {

          preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match);

          $video_id = $match[1];

          $image['element']['attributes']['data-src'] = 'https://www.youtube.com/embed/'. $video_id;

          $image['element']['attributes']['allowfullscreen'] = 'true';

          $image['element']['name'] = 'iframe';

          unset($image['element']['attributes']['alt']);

        }

        $image['element']['attributes']['class'] = 'article__img lazyload';
        $image['element']['attributes']['src'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

        unset($image['element']['attributes']['target']);
        unset($image['element']['attributes']['rel']);

        return $image;
    }

    protected function inlineLink($excerpt)
    {
        $link = parent::inlineLink($excerpt);

        if ( ! isset($link))
        {
            return null;
        }

        $link['element']['attributes']['target'] = '_blank';
        $link['element']['attributes']['rel'] = 'noopener';

        return $link;
    }

    protected function element(array $Element)
    {
      $markup = parent::element($Element);

      if($Element['name'] == 'img' || $Element['name'] == 'iframe')
      {
        $caption = '';

        if (isset($Element['attributes']['title']))
        {
          $caption = $Element['attributes']['title'];
        } elseif (isset($Element['attributes']['alt'])) {
          $caption = $Element['attributes']['alt'];
        }

        $markup = '<figure class="article__img-wrapper article__img-wrapper--'.($Element['name'] == 'iframe' ? 'video' : 'inner').' loading">' . $markup. ($Element['name'] == 'iframe' ? '</iframe>' : '');

        if ($caption != '')
        {
          $markup .= '<figcaption class="article__img-caption">' . $caption . '</figcaption>';
        }

        $markup .= '</figure>';
      }

      return $markup;
    }



}
