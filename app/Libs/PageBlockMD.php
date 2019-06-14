<?php

namespace App\Libs;

use App\PageBlock;

use Parsedown;

class PageBlockMD extends Parsedown
{
    private $pageBlock;

    private $markdownEmphasis = "~^\*.*?\*$~";
    private $markdownStrong = "~^__.*?__$~";

    function __construct(PageBlock $pageBlock){
      $this->pageBlock = $pageBlock;
    }

    protected function blockHeader($Line)
    {
      $header = parent::blockHeader($Line);

        if (!isset($header)){
          return null;
        }

        $header['element']['name'] = 'h4';
        $header['element']['attributes']['class'] = 'rules__title rules__title--h4';

        return $header;
    }

    protected function paragraph($Line)
    {

      if ( ($this->pageBlock->type == PageBlock::TYPE_LEVEL_2 || $this->pageBlock->type == PageBlock::TYPE_LEFT_COLUMN || $this->pageBlock->type == PageBlock::TYPE_LEVEL_3  ) && 1 === preg_match($this->markdownEmphasis, $Line["text"]))
      {
        return $this->inlineEmphasis($Line);
      }
      elseif ( $this->pageBlock->type == PageBlock::TYPE_RIGHT_COLUMN && 1 === preg_match($this->markdownStrong, $Line["text"]))
      {
        return $this->inlineEmphasis($Line);
      }

      $paragraph = parent::paragraph($Line);

        if (!isset($paragraph)){
            return null;
        }

        if($this->pageBlock->type == PageBlock::TYPE_CAPTION){
          $paragraph['element']['attributes']['class'] = 'rules__item rules__item--margin';
        }
        else{
          $paragraph['element']['attributes']['class'] = 'rules__item';
        }

        return $paragraph;
    }

    protected function blockList($Line, array $CurrentBlock = null)
    {
      $blockList = parent::blockList($Line, $CurrentBlock);

        if (!isset($blockList)){
            return null;
        }

        if( $this->pageBlock->type == PageBlock::TYPE_RIGHT_COLUMN){
          if($blockList['element']['name'] === 'ol'){
            $blockList['element']['name'] = 'ul';
            $blockList['element']['attributes']['class'] = 'rules__list';
          }
          else{
            $blockList['element']['attributes']['class'] = 'rules__list rules__list--grey';
          }
        } else {
          $blockList['element']['attributes']['class'] = 'rules__list';
        }

        $blockList['li']['attributes'] = [];

        $blockList['li']['attributes']['class'] =  $blockList['element']['name'] === 'ol' ? 'rules__item-wrapper rules__item-wrapper--order' : 'rules__item-wrapper';

        return $blockList;
    }

    protected function blockListContinue($Line, array $Block)
    {
      $blockListContinue = parent::blockListContinue($Line, $Block);

      if ( ! isset($Block['interrupted'])){

        $blockListContinue['li']['attributes'] = [];

        $blockListContinue['li']['attributes']['class'] =  $Block['element']['name'] === 'ol' ? 'rules__item-wrapper rules__item-wrapper--order' : 'rules__item-wrapper';

      }

      return $blockListContinue;
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

      if($Element['name'] == 'em'){

        if($this->pageBlock->type == PageBlock::TYPE_LEVEL_2 || $this->pageBlock->type == PageBlock::TYPE_LEVEL_3){

          $markup = '<aside class="rules__atention-wrapper"><p class="rules__atention">'.$Element['text'].'</p></aside>';

        } elseif($this->pageBlock->type == PageBlock::TYPE_LEFT_COLUMN){

          $markup = '<p class="rules__item rules__item--italic">'.$Element['text'].'</p>';

        }

      } elseif($Element['name'] == 'strong'){

        if($this->pageBlock->type == PageBlock::TYPE_RIGHT_COLUMN){

          $markup = '<p class="rules__item rules__item--title rules__item--grey"><b class="rules__title rules__title--b">'.$Element['text'].'</b></p>';

        }
        else{
          $markup = '<b class="rules__title rules__title--b">'.$Element['text'].'</b>';
        }

      }

      return $markup;
    }



}
