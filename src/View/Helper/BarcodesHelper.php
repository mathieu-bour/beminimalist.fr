<?php
namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;
use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\Output\QRImageOptions;
use chillerlan\QRCode\QRCode;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodesHelper extends HtmlHelper
{

    protected function _pngBase64($data, $options)
    {
        return $this->image('data:image/png;base64,' . base64_encode($data), $options);
    }

    public function barcode($content, $options = [])
    {
        $options = array_merge([
            'height' => 30
        ], $options);

        $generator = new BarcodeGeneratorPNG();
        return $this->_pngBase64($generator->getBarcode($content, $generator::TYPE_CODE_128, 1, $options['height']), $options);
    }

    public function qrcode($content, $options = [])
    {
        // QRCode options
        $outputOptions = new QRImageOptions;
        $outputOptions->marginSize = 0;
        $outputOptions->pixelSize = 10;
        $outputInterface = new QRImage($outputOptions);

        $qrcode = new QRCode($content, $outputInterface);

        return $this->image($qrcode->output(), $options);

    }
}