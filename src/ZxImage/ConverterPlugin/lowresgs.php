<?php
namespace ZxImage;
if (!class_exists('\ZxImage\ConverterPlugin_gigascreen')) {
    include_once('gigascreen.php');
}

class ConverterPlugin_lowresgs extends ConverterPlugin_gigascreen
{
    protected $fileSize = 1628;
    protected function loadBits()
    {
        $texture = array();
        $attributesArray = array(array(), array());
        if ($this->makeHandle()) {
            $length = 0;
            while ($bin = $this->read8BitString()) {
                if ($length >= 84 && $length < 92) {
                    $texture[] = $bin;
                } elseif ($length >= 92 && $length < 92 + 768) {
                    $attributesArray[0][] = $bin;
                } elseif ($length >= 92 + 768) {
                    $attributesArray[1][] = $bin;
                }
                $length++;
            }
            $pixelsArray = $this->generatePixelsArray($texture);
            $resultBits = array(
                $resultBits = array(
                    'pixelsArray' => $pixelsArray,
                    'attributesArray' => $attributesArray[0],
                ),
                array(
                    'pixelsArray' => $pixelsArray,
                    'attributesArray' => $attributesArray[1],
                ),
            );
            return $resultBits;
        }
        return false;
    }

    protected function generatePixelsArray($texture)
    {
        $pixelsArray = array();
        for ($third = 0; $third < 3; $third++) {
            $row = 0;
            for ($y = 0; $y < 8; $y++) {
                for ($x = 0; $x < 32 * 8; $x++) {
                    $pixelsArray[] = $texture[$row];
                }
                $row++;
            }
        }
        return $pixelsArray;
    }
}
