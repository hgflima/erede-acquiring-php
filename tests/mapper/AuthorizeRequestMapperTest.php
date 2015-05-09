<?php

namespace ERede\Acquiring\Mapper;

class AuthorizeRequestMapperTest extends \ERede\Acquiring\TestCase {

  public function testMapCreditCard() {

    $expected         = "4242424242424242";

    $mapper           = new AuthorizeRequestMapper();
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Nrcartao);

  }

  public function testMapExpMonth() {

    $expected         = "11";

    $mapper           = new AuthorizeRequestMapper();
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Mes);

  }

  public function testMapExpYear() {

    $expected         = "2015";

    $mapper           = new AuthorizeRequestMapper();
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Ano);

  }

  public function testMapCVV() {

    $expected         = "021";

    $mapper           = new AuthorizeRequestMapper();
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Cvc2);

  }

  public function testMapAmount() {

    $expected         = 10.21;

    $mapper           = new AuthorizeRequestMapper();
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Total);

  }

  public function testMapReference() {

    $expected         = "1234";

    $mapper           = new AuthorizeRequestMapper();
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->NumPedido);

  }

}
