<?php

namespace ERede\Acquiring\Mapper;

class AuthorizeRequestMapperTest extends \ERede\Acquiring\TestCase {

  public function testMapCreditCard() {

    $expected         = "4242424242424242";

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Nrcartao);

  }

  public function testMapExpMonth() {

    $expected         = "11";

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Mes);

  }

  public function testMapExpYear() {

    $expected         = "2020";

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Ano);

  }

  public function testMapCVV() {

    $expected         = "021";

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Cvc2);

  }

  public function testMapNullCVV() {

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    unset($data["cvv"]);

    $authorizeRequest = $mapper->map($data);
    $this->assertNull($authorizeRequest->Cvc2);

  }

  public function testMapAmount() {

    $expected         = 10.21;

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Total);

  }

  public function testMapReference() {

    $expected         = "1234";

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->NumPedido);

  }

  public function testMapNullReference() {

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    unset($data["reference"]);

    $authorizeRequest = $mapper->map($data);
    $this->assertNull($authorizeRequest->NumPedido);

  }

  public function testMapSoftDescriptor() {

    $expected         = "mystore";

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->IdentificacaoFatura);

  }

  public function testMapNullSoftDescriptor() {

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    unset($data["soft_descriptor"]);

    $authorizeRequest = $mapper->map($data);
    $this->assertNull($authorizeRequest->IdentificacaoFatura);

  }

  public function testMapFiliation() {

    $expected         = "123";

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Filiacao);

  }

  public function testMapPassword() {

    $expected         = "456";

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Senha);

  }

  public function testInstallments() {

    $expected         = 10;

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $authorizeRequest = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Parcelas);

  }

  public function testParcelasNull() {

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    $data["installments"] = 1;

    $authorizeRequest = $mapper->map($data);
    $this->assertNull($authorizeRequest->Parcelas);

  }

  public function testInstallmentsNull() {

    $mapper           = new AuthorizeRequestMapper("123", "456");
    $data             = $this->getValidAuthorizeRequestData();

    unset($data["installments"]);

    $authorizeRequest = $mapper->map($data);
    $this->assertNull($authorizeRequest->Parcelas);

  }

  public function testMapTransacaoAutomaticCaptureAvista() {

    $expected             = "04";

    $mapper               = new AuthorizeRequestMapper("123", "456");
    $data                 = $this->getValidAuthorizeRequestData();

    $data["installments"] = 1;
    $data["capture"]      = true;

    $authorizeRequest     = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Transacao);

  }

  public function testMapTransacaoAutomaticCaptureParcelado() {

    $expected             = "08";

    $mapper               = new AuthorizeRequestMapper("123", "456");
    $data                 = $this->getValidAuthorizeRequestData();

    $data["installments"] = 2;
    $data["capture"]      = true;

    $authorizeRequest     = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Transacao);

  }

  public function testMapTransacaoJustAuthorizeAVista() {

    $expected             = "73";

    $mapper               = new AuthorizeRequestMapper("123", "456");
    $data                 = $this->getValidAuthorizeRequestData();

    $data["installments"] = 1;
    $data["capture"]      = false;

    $authorizeRequest     = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Transacao);

  }

  public function testMapTransacaoJustAuthorizeParcelado() {

    $expected             = "73";

    $mapper               = new AuthorizeRequestMapper("123", "456");
    $data                 = $this->getValidAuthorizeRequestData();

    $data["installments"] = 2;
    $data["capture"]      = false;

    $authorizeRequest     = $mapper->map($data);
    $this->assertEquals($expected, $authorizeRequest->Transacao);

  }

}
