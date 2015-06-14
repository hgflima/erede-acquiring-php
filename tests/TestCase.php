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

  protected function getValidCaptureRequestData() {
    return array("amount" => "1021", "installments" => 10, "tid" => "123456", "authorization_number" => "001122", "date" => "20150614");
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

  protected function getIntegratorGetAuthorizedCreditMock($success) {

    $mock = $this->getMockBuilder("stdClass")
                  ->setMethods(array('GetAuthorizedCredit'))
                  ->getMock();

    $getAuthorizedCreditResponse = $this->getGetAuthorizedCreditResponseNotApproved();

    if($success)
      $getAuthorizedCreditResponse = $this->getGetAuthorizedCreditResponseSuccess();

    $mock->expects($this->once())
                        ->method("GetAuthorizedCredit")
                        ->willReturn(new GetAuthorizedCreditResponse($getAuthorizedCreditResponse));

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

  protected function getConfirmTxnTIDResponseSuccess() {

    $result = new \stdClass;
    $result->CodRet   = "00";
    $result->Data     = "20150602";
    $result->Hora     = "09:34:21";
    $result->Msgret   = "Sucesso";
    $result->NumAutor = "022579";
    $result->NumPedido = "123456";
    $result->NumSqn     = "25747";
    $result->Tid        = "134";

    return $result;

  }

  protected function getGetAuthorizedCreditResponseNotApproved() {

    $result = new \stdClass;
    $result->Cet            = null;
    $result->CodRet         = null;
    $result->Data           = null;
    $result->Hora           = null;
    $result->Juros          = null;
    $result->MsgAvs         = null;
    $result->Msgret         = "Número de pedido já existente para o estabelecimento.";
    $result->NumAutor       = null;
    $result->NumPedido      = null;
    $result->NumSqn         = null;
    $result->RespAvs        = null;
    $result->Tid            = null;
    $result->ValParcelas    = null;
    $result->ValTotalJuros  = null;

    return $result;

  }

}
