<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\TransactionStatus as s;
use \ERede\Acquiring\Mapper\AuthorizeResponseMapper;
use \ERede\Acquiring\Mapper\CaptureRequestMapper;
use \ERede\Acquiring\Mapper\CaptureResponseMapper;
use \ERede\Acquiring\Validator\TransactionCreditCaptureValidator as CaptureValidator;
use \ERede\Acquiring\Mapper\FindRequestMapper;
use \ERede\Acquiring\Mapper\FIndResponseMapper;
use \ERede\Acquiring\Validator\TransactionCreditFindValidator as FindValidator;


class TransactionCreditTest extends TestCase {

  public function testAuthorizeValidationError() {

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

  public function testAuthorizeSuccess() {

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

  public function testCaptureValidationError() {

    $field      = "installments";
    $validator  = new CaptureValidator();

    $parameters = array("filiation"         => "123",
                        "password"          => "456",
                        "captureValidator"  => $validator);

    $transactionCredit  = new TransactionCredit($parameters);

    $data               = $this->getValidCaptureRequestData();
    $data[$field]       = -1;

    $response           = $transactionCredit->capture($data);

    $expected_status    = s::VALIDATION_ERROR;
    $expected_errors    = 1;
    $expected_message   = "is invalid";

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_errors, count($response->errors));
    $this->assertEquals($expected_message, $response->errors[$field]);

  }

  public function testCaptureTransactionNotProcessed() {

    $integratorMock             = $this->getIntegratorConfirmTxnTIDMock(false);

    $parameters = array("filiation"               => "123",
                        "password"                => "456",
                        "captureValidator"        => new CaptureValidator(),
                        "captureRequestMapper"    => new CaptureRequestMapper("123", "456") ,
                        "captureResponseMapper"   => new CaptureResponseMapper(),
                        "integrator"              => $integratorMock);

    $transactionCredit = new TransactionCredit($parameters);
    $response          = $transactionCredit->capture($this->getValidCaptureRequestData());

    $expected_status      = s::TRANSACTION_NOT_PROCESSED;
    $expected_message     = "Dado Inválido. PARAMETRO OBRIGATORIO AUSENTE.";

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_message, $response->data['message']);

  }

  public function testCaptureSuccess() {

    $integratorMock             = $this->getIntegratorConfirmTxnTIDMock(true);

    $parameters = array("filiation"               => "123",
                        "password"                => "456",
                        "captureValidator"        => new CaptureValidator(),
                        "captureRequestMapper"    => new CaptureRequestMapper("123", "456") ,
                        "captureResponseMapper"   => new CaptureResponseMapper(),
                        "integrator"              => $integratorMock);

    $transactionCredit = new TransactionCredit($parameters);
    $response          = $transactionCredit->capture($this->getValidCaptureRequestData());

    $expected_status      = s::SUCCESS;
    $expected_errors      = 0;
    $expected_return_code = "00";

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_errors, count($response->errors));
    $this->assertEquals($expected_return_code, $response->data['return_code']);

  }

  public function testFindValidationError() {

    $field      = "tid";
    $validator  = new FindValidator();

    $parameters = array("filiation"         => "123",
                        "password"          => "456",
                        "findValidator"  => $validator);

    $transactionCredit  = new TransactionCredit($parameters);

    $data               = array();

    $response           = $transactionCredit->find($data);

    $expected_status    = s::VALIDATION_ERROR;
    $expected_errors    = 2;
    $expected_message   = "is required";

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_errors, count($response->errors));
    $this->assertEquals($expected_message, $response->errors[$field]);

  }

  public function testFindSuccess() {

    $integratorMock             = $this->getIntegratorQueryMock(true);

    $parameters = array("filiation"               => "123",
                        "password"                => "456",
                        "findValidator"        => new FindValidator(),
                        "findRequestMapper"    => new FindRequestMapper("123", "456") ,
                        "findResponseMapper"   => new FindResponseMapper(),
                        "integrator"              => $integratorMock);

    $transactionCredit = new TransactionCredit($parameters);
    $response          = $transactionCredit->find(array("tid" => "123"));

    $expected_status      = s::SUCCESS;
    $expected_errors      = 0;
    $expected_return_code = "00";

    $this->assertEquals($expected_status, $response->status);
    $this->assertEquals($expected_errors, count($response->errors));
    $this->assertEquals($expected_return_code, $response->data['return_code']);

  }

}
