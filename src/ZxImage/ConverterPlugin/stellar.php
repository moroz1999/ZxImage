<?php

namespace ZxImage;

if (!class_exists('\ZxImage\ConverterPlugin_gigascreen')) {
    include_once('gigascreen.php');
}

class ConverterPlugin_stellar extends ConverterPlugin_gigascreen
{
    protected $fileSize = 3072;
    protected $atrWidth = 64;
    protected $atrHeight = 48;
    protected $attributeHeight = 4;

    protected function loadBits()
    {
        $texture = array();
        $attributesArray = array(array(), array());
        if ($this->makeHandle()) {
            while (($bin = $this->read8BitString()) && ($bin2 = $this->read8BitString()) && ($bin3 = $this->read8BitString()) && ($bin4 = $this->read8BitString())) {
                $attributesArray[0][] = $bin;
                $attributesArray[0][] = $bin2;
                $attributesArray[1][] = $bin3;
                $attributesArray[1][] = $bin4;
            }
            $pixelsArray = $this->generatePixelsArray($texture);
            $resultBits = array(
                $resultBits = array(
                    'pixelsArray'     => $pixelsArray,
                    'attributesArray' => $attributesArray[0],
                ),
                array(
                    'pixelsArray'     => $pixelsArray,
                    'attributesArray' => $attributesArray[1],
                ),
            );
            return $resultBits;
        }
        return false;
    }

    protected function generatePixelsArray()
    {
        $pixelsArray = array();
        for ($x = 0; $x < $this->width * $this->height / 8; $x++) {
            $pixelsArray[] = '00001111';

        }
        return $pixelsArray;
    }
}
