<?php

namespace Khanamiryan\QrCodeTests;

use PHPUnit_Framework_TestCase;
use Zxing\QrReader;

class QrReaderTest extends PHPUnit_Framework_TestCase
{

    public function testText1()
    {
        $image = __DIR__ . "/qrcodes/hello_world.png";

        $qrcode = new QrReader($image);
        $this->assertSame("Hello world!", $qrcode->text());
    }
}
