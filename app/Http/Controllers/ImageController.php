<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

use ImageOptimizer;

class ImageController extends Controller
{

    public function getImageThumbnail($path, $width = null, $height = null, $type = "fit", $position = "center")
    {

        // $images_path = config('definitions.images_path');
        $images_path = 'storage';
        $path = ltrim($path, "/");

        //returns the original image if isn't passed width and height
        if (is_null($width) && is_null($height)) {
            return url("{$images_path}/" . $path);
        }
        elseif(is_null($width)){
            $width=$height;
            $possible_dir="{$images_path}/thumbs/" . "x{$height}/";
        }
        elseif(is_null($height)){
            $type = "widen";
            $height=$width;
            $possible_dir="{$images_path}/thumbs/" . "{$width}x/";
        }
        else{
            $possible_dir="{$images_path}/thumbs/" . "{$width}x{$height}/";
        }
        $possible_path=$possible_dir . $path;

        //if thumbnail exist returns it

        if (File::exists( public_path($possible_path) )) {
            return url($possible_path);
        }


        //If original image doesn't exists returns a default image which shows that original image doesn't exist.
        if (!File::exists(public_path("{$images_path}/" . $path))) {

            /*
             * 2 ways
             */

            //1. recursive call for the default image
            //return $this->getImageThumbnail("error/no-image.png", $width, $height, $type);

            //2. returns an image placeholder generated from placehold.it

            return "http://placehold.it/{$width}x{$height}";
        }

        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
        $contentType = mime_content_type("{$images_path}/" . $path);

        if (in_array($contentType, $allowedMimeTypes)) { //Checks if is an image

            $image = Image::make(public_path("{$images_path}/" . $path));

            switch ($type) {
                case "fit": {
                    $image->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    }, $position);
                    break;
                }
                case "resize": {
                    //stretched
                    $image->resize($width, $height);
                }
                case "background": {
                    $image->resize($width, $height, function ($constraint) {
                        //keeps aspect ratio and sets black background
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                case "resizeCanvas": {
                    $image->resizeCanvas($width, $height, 'center', false, 'rgba(0, 0, 0, 0)'); //gets the center part
                }
                case "widen": {
                    $image->widen($width, function ($constraint) {
                      $constraint->upsize();
                    });
                    break;
                }
            }

            //relative directory path starting from main directory of images
            $dir_path = (dirname($path) == '.') ? "" : dirname($path);

            //Create the directory if it doesn't exist
            if (!File::exists(public_path($possible_dir . $dir_path))) {
                File::makeDirectory(public_path($possible_dir . $dir_path), 0775, true);
            }

            //Save the thumbnail
            $public_path=public_path($possible_dir . $path);

            $image->interlace();
            $image->save($public_path);

            ImageOptimizer::optimize($public_path);

            // $optimizerChain = OptimizerChainFactory::create();

            // $optimizerChain->optimize($public_path);

            //return the url of the thumbnail
            return url($possible_dir . $path);
        } else {

            //return a placeholder image
            return "http://placehold.it/{$width}x{$height}";
        }
    }
    public function getOptimizedImage($path){
      $images_path = 'storage';
      $path = ltrim($path, "/");

      $possible_dir = "{$images_path}/optimized/";

      $possible_path = $possible_dir . $path;

      if (File::exists( public_path($possible_path) )) {
        return url($possible_path);
      }

      if (!File::exists(public_path("{$images_path}/" . $path))) {
        /*
         * 2 ways
         */

        //1. recursive call for the default image
        //return $this->getImageThumbnail("error/no-image.png", $width, $height, $type);

        //2. returns an image placeholder generated from placehold.it

        return "http://placehold.it/100x100";
      }

      //relative directory path starting from main directory of images
      $dir_path = (dirname($path) == '.') ? "" : dirname($path);

      //Create the directory if it doesn't exist
      if (!File::exists(public_path($possible_dir . $dir_path))) {
        File::makeDirectory(public_path($possible_dir . $dir_path), 0775, true);
      }

      $public_path = public_path($possible_path);

      ImageOptimizer::optimize("{$images_path}/" . $path,  $public_path);

      return url($possible_path);
    }

    public function getReducedHeight($reduced_width, $original_width, $original_height){
      return (int)($original_height * ($reduced_width / $original_width));
    }

    public function getImageSize($path){
      $images_path = 'storage';
      $path = ltrim($path, "/");

      $image_path = public_path("{$images_path}/" . $path);

      if (!File::exists($image_path)) {
        throw new Exception('Image not exists!');
      }

      $image = Image::make($image_path);

      return [$image->width(), $image->height()];
    }

    public function getResponsiveProps($path, ...$thumb_widths){

      list($image_width, $image_height) = $this->getImageSize($path);

      $srcset = [];
      $baseSrc = null;

      foreach($thumb_widths as $thumb_width){

        if($thumb_width <= $image_width){
          $thumb_height = $this->getReducedHeight($thumb_width, $image_width, $image_height);
          $src = $this->getImageThumbnail($path, $thumb_width, $thumb_height);
          $srcset[] = "{$src} {$thumb_width}w";

          if($baseSrc == null){
            $baseSrc = $src;
          }
        }
      }

      return [
        'src' => $baseSrc,
        'srcset' => implode(", ", $srcset)
      ];
    }
}
