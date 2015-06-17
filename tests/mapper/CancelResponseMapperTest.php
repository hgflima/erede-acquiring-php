<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\VoidTransactionTIDResponse as Response;

class CancelResponseMapperTest extends \ERede\Acquiring\TestCase {

  public function testMap() {

    $expected_return_code = "00";
    $expected_message     = "Sucesso";

    $response = new Response($this->getCancelResponseSuccess());

    $mapper   = new CancelResponseMapper();
    $returned = $mapper->map($response);

    $this->assertEquals($expected_return_code, $returned['return_code']);
    $this->assertEquals($expected_message, $returned['message']);

  }

}
