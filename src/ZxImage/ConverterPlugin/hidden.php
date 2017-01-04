<?php
namespace ZxImage;
if (!class_exists('\ZxImage\ConverterPlugin_standard')) {
    include_once('standard.php');
}

class ConverterPlugin_hidden extends ConverterPlugin_standard
{
    protected function exportData($parsedData, $flashedImage = false)
    {
        $image = imagecreatetruecolor($this->width, $this->height);
        foreach ($parsedData['pixelsData'] as $y => &$row) {
            foreach ($row as $x => &$pixel) {
                $mapPositionX = (int)($x / $this->attributeWidth);
                $mapPositionY = (int)($y / $this->attributeHeight);

                if ($flashedImage && isset($parsedData['attributesData']['flashMap'][$mapPositionY][$mapPositionX])) {
                    if ($pixel === '1') {
                        $ZXcolor = $parsedData['attributesData']['paperMap'][$mapPositionY][$mapPositionX];
                    } else {
                        $ZXcolor = $parsedData['attributesData']['inkMap'][$mapPositionY][$mapPositionX];
                    }
                } else {
                    if ($parsedData['attributesData']['inkMap'][$mapPositionY][$mapPositionX] == $parsedData['attributesData']['paperMap'][$mapPositionY][$mapPositionX]) {
                        if ($pixel === '1') {
                            $ZXcolor = 'hidden';
                        } else {
                            $ZXcolor = $parsedData['attributesData']['paperMap'][$mapPositionY][$mapPositionX];
                        }
                    } else {
                        if ($pixel === '1') {
                            $ZXcolor = $parsedData['attributesData']['inkMap'][$mapPositionY][$mapPositionX];
                        } else {
                            $ZXcolor = $parsedData['attributesData']['paperMap'][$mapPositionY][$mapPositionX];
                        }
                    }
                }
                if ($ZXcolor == 'hidden') {
                    $color = 0xFF8000;
                } else {
                    $color = $this->colors[$ZXcolor];
                }
                imagesetpixel($image, $x, $y, $color);
            }
        }

        $resultImage = $this->drawBorder($image, $parsedData);
        $resultImage = $this->resizeImage($resultImage);
        $resultImage = $this->checkRotation($resultImage);
        return $resultImage;
    }
}
