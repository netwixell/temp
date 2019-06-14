<?php

namespace App\Libs;

use App\PageBlock;

use Parsedown;

class BlockDTVoteMD extends Parsedown
{
    private $pageBlock;

    function __construct(PageBlock $pageBlock){
      $this->pageBlock = $pageBlock;
    }



    protected function paragraph($Line)
    {

      $paragraph = parent::paragraph($Line);

        if (!isset($paragraph)){
            return null;
        }

        $paragraph['element']['attributes']['class'] = 'vote__description';

        return $paragraph;
    }

}
