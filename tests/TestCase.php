<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\TransactionStatus as s;
use \ERede\Acquiring\Integration\GetAuthorizedRequest;
use \ERede\Acquiring\Integration\GetAuthorizedCreditResponse;

class TestCase extends \PHPUnit_Framework_TestCase {

  protected function getAcquirer() {
    return new Acquirer("123", "456");
  }

  protected function getValidAuthorizeRequestData() {
    return array("credit_card" => "4242424242424242", "exp_month" => 11, "exp_year" => 2015, "cvv" => "021", "amount" => "1021", "reference" => "1234", "soft_descriptor" => "mystore", "installments" => 10, "capture" => false);
  }

  protected function getAuthorizeValidatorMock($success) {

    $authorizeValidatorMock = $this->getMockBuilder("stdClass")
                                    ->setMethods(array('validate'))
                                    ->getMock();

    $validationResponse = null;

    if($success)
      $validationResponse = $this->getValidationResponseSuccess();
    else
      $validationResponse = $this->getValidationResponseError();

    $authorizeValidatorMock->expects($this->once())
                            ->method("validate")
                            ->willReturn($validationResponse);

    return $authorizeValidatorMock;
  }

  protected function getValidationResponseSuccess() {
    $validationResponse         = new \sTdClass;
    $validationResponse->status = s::SUCCESS;
    $validationResponse->errors = array();
    return $validationResponse;
  }

  protected function getValidationResponseError() {
    $validationResponse         = new \sTdClass;
    $validationResponse->status = s::VALIDATION_ERROR;
    $validationResponse->errors = array();
    $validationResponse->errors["credit_card"] = "is invalid";
    return $validationResponse;
  }

  protected function getAuthorizeRequestMapperMock() {

    $authorizeRequestMapperMock = $this->getMockBuilder("stdClass")
                                      ->setMethods(array('map'))
                                      ->getMock();

    $authorizeRequestMapperMock->expects($this->once())
                                ->method("map")
                                ->willReturn(new GetAuthorizedRequest());

    return $authorizeRequestMapperMock;

  }

  protected function getIntegratorGetAuthorizedCreditMock() {

    $mock = $this->getMockBuilder("stdClass")
                  ->setMethods(array('GetAuthorizedCredit'))
                  ->getMock();

    $mock->expects($this->once())
                        ->method("GetAuthorizedCredit")
                        ->willReturn(new GetAuthorizedCreditResponse($this->getGetAuthorizedCreditResponseSuccess()));

    return $mock;

  }

  protected function getGetAuthorizedCreditResponseSuccess() {

    $result = new \stdClass;
    $result->Cet      = null;
    $result->CodRet   = "00";
    $result->Data     = "20150602";
    $result->Hora     = "09:34:21";
    $result->Juros    = null;
    $result->MsgAvs   = null;
    $result->Msgret   = "Sucesso";
    $result->NumAutor = "022579";
    $result->NumPedido = "123456";
    $result->NumSqn     = "25747";
    $result->RespAvs    = null;
    $result->Tid        = "134";
    $result->ValParcelas = null;
    $result->ValTotalJuros = null;

    return $result;

  }

}
