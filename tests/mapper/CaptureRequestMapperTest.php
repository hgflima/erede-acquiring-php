<?php

namespace ERede\Acquiring\Mapper;

class CaptureRequestMapperTest extends \ERede\Acquiring\TestCase {

  public function testInstallmentsMap() {

    $expected         = 10;

    $mapper           = new CaptureRequestMapper("123", "456");
    $data             = $this->getValidCaptureRequestData();

    $captureRequest = $mapper->map($data);
    $this->assertEquals($expected, $captureRequest->Parcelas);

  }

  public function testTIDMap() {

    $expected         = "123456";

    $mapper           = new CaptureRequestMapper("123", "456");
    $data             = $this->getValidCaptureRequestData();

    $captureRequest   = $mapper->map($data);
    $this->assertEquals($expected, $captureRequest->TID);

  }

  public function testMapAmount() {

    $expected         = 10.21;

    $mapper           = new CaptureRequestMapper("123", "456");
    $data             = $this->getValidCaptureRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Total);

  }

}
