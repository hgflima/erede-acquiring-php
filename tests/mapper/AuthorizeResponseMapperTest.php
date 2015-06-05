<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\GetAuthorizedCreditResponse as Response;

class AuthorizeResponseMapperTest extends \ERede\Acquiring\TestCase {

  public function testMap() {

    $expected_return_code = "00";
    $expected_message     = "Sucesso";

    $response = new Response($this->getGetAuthorizedCreditResponseSuccess());

    $mapper   = new AuthorizeResponseMapper();
    $returned = $mapper->map($response);

    $this->assertEquals($expected_return_code, $returned['return_code']);
    $this->assertEquals($expected_message, $returned['message']);
    $this->assertNull($returned['cet']);

  }

}
