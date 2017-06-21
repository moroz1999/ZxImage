<?php

include_once('../src/ZxImage/Converter.php');

$converter = new \ZxImage\Converter();
$converter->setType('standard');
$converter->setPath('example.scr'); //
$converter->setBorder(5); //cyan
$converter->setSize(2); //2 for 320*240 (256*192 with border)


$folderForCache = 'tmp';
//ensure that there is a folder for converted images cache
if (!is_dir($folderForCache)) {
    mkdir($folderForCache);
}
//set cache path
$converter->setCachePath($folderForCache);
//enable file cache
$converter->setCacheEnabled(true);


//convert and return image data
if ($binary = $converter->getBinary()) {
    //after conversion we can ask for a mime type of last operation and send it to browser
    $imageType = $converter->getResultMime();
    header('Content-Type: ' . $imageType);

    //send image contents to browser
    echo $binary;
}