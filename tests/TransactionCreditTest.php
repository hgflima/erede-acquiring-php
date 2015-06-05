<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\TransactionStatus as s;

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
    $integratorMock             = $this->getIntegratorGetAuthorizedCreditMock();

    $parameters = array("filiation"               => "123",
                        "password"                => "456",
                        "authorizeValidator"      => $authorizeValidatorMock,
                        "authorizeRequestMapper"  => $authorizeRequestMapperMock,
                        "integrator"              => $integratorMock);

    $transactionCredit = new TransactionCredit($parameters);
    $response          = $transactionCredit->authorize($this->getValidAuthorizeRequestData());

    $expected_status = s::SUCCESS;
    $expected_errors = 0;

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_errors, count($response->errors));

  }

}
