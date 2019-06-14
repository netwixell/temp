<?php

function thumbnail_url($image,$type)
{
        // We need to get extension type ( .jpeg , .png ...)
        $ext    = pathinfo($image, PATHINFO_EXTENSION);
        // We remove extension from file name so we can append thumbnail type
        $name   = rtrim($image, '.'. $ext);
        // We merge original name + type + extension
        return  $name . '-' . $type . '.' . $ext;
}

function getThumbnail($img_path, $width = null, $height = null, $type = "fit", $position = "center")
{
    return app('App\Http\Controllers\ImageController')->getImageThumbnail($img_path, $width, $height, $type, $position);
}

function getOptimizedImage($img_path)
{
  return app('App\Http\Controllers\ImageController')->getOptimizedImage($img_path);
}

function getResponsiveProps($path, ...$thumb_widths){
  return app('App\Http\Controllers\ImageController')->getResponsiveProps($path, ...$thumb_widths);
}

function srcset($path, ...$sizes){
  $srcset = [];

  foreach($sizes as $size){

    $srcset[] = getThumbnail($path, $size). " ".$size."w";

  }

  return implode(", ", $srcset);
}
