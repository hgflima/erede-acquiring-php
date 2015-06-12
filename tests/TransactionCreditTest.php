<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\TransactionStatus as s;
use \ERede\Acquiring\Mapper\AuthorizeResponseMapper;

class TransactionCreditTest extends TestCase {

  public function testValidationError() {

    $authorizeValidatorMock = $this->getAuthorizeValidatorMock(false);

    $parameters = array("filiation"           => "123",
                        "password"            => "456",
                        "authorizeValidator"  => $authorizeValidatorMock);

    $transactionCredit = new TransactionCredit($parameters);
    $response          = $transactionCredit->authorize($this->getValidAuthorizeRequestData());

    $expected_status = s::VALIDATION_ERROR;
    $expected_errors = 1;

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_errors, count($response->errors));

  }

  public function testAuthorizeRequestMapper() {

    $authorizeValidatorMock     = $this->getAuthorizeValidatorMock(true);
    $authorizeRequestMapperMock = $this->getAuthorizeRequestMapperMock();
    $integratorMock             = $this->getIntegratorGetAuthorizedCreditMock(true);

    $parameters = array("filiation"               => "123",
                        "password"                => "456",
                        "authorizeValidator"      => $authorizeValidatorMock,
                        "authorizeRequestMapper"  => $authorizeRequestMapperMock,
                        "authorizeResponseMapper" => new AuthorizeResponseMapper(),
                        "integrator"              => $integratorMock);

    $transactionCredit = new TransactionCredit($parameters);
    $response          = $transactionCredit->authorize($this->getValidAuthorizeRequestData());

    $expected_status      = s::SUCCESS;
    $expected_errors      = 0;
    $expected_return_code = "00";

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_errors, count($response->errors));
    $this->assertEquals($expected_return_code, $response->data['return_code']);

  }

  public function testAuthorizeRequestMapperServerValidationError() {

    $authorizeValidatorMock     = $this->getAuthorizeValidatorMock(true);
    $authorizeRequestMapperMock = $this->getAuthorizeRequestMapperMock();
    $integratorMock             = $this->getIntegratorGetAuthorizedCreditMock(false);

    $parameters = array("filiation"               => "123",
                        "password"                => "456",
                        "authorizeValidator"      => $authorizeValidatorMock,
                        "authorizeRequestMapper"  => $authorizeRequestMapperMock,
                        "authorizeResponseMapper" => new AuthorizeResponseMapper(),
                        "integrator"              => $integratorMock);

    $transactionCredit = new TransactionCredit($parameters);
    $response          = $transactionCredit->authorize($this->getValidAuthorizeRequestData());

    $expected_status      = s::TRANSACTION_NOT_PROCESSED;
    $expected_message     = "Número de pedido já existente para o estabelecimento.";

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_message, $response->data['message']);

  }

}
