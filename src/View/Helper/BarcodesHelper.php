<?php
namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Endroid\QrCode\QrCode;

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
        $options = array_merge([
            'padding' => 0,
            'size' => 300
        ], $options);
        $qrCode = new QrCode();
        $qrCode
            ->setText($content)
            ->setSize($options['size'])
            ->setPadding($options['padding'])
            ->setErrorCorrection('high')
            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0])
            ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 1])
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        return $this->_pngBase64($qrCode->get(), $options);

    }
}