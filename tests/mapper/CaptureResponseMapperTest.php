<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\ConfirmTxnTIDResponse as Response;

class CaptureResponseMapperTest extends \ERede\Acquiring\TestCase {

  public function testMap() {

    $expected_return_code = "00";
    $expected_message     = "Sucesso";

    $response = new Response($this->getConfirmTxnTIDResponseSuccess());

    $mapper   = new CaptureResponseMapper();
    $returned = $mapper->map($response);

    $this->assertEquals($expected_return_code, $returned['return_code']);
    $this->assertEquals($expected_message, $returned['message']);

  }

}
