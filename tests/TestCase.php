<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\TransactionStatus as s;
use \ERede\Acquiring\Integration\GetAuthorizedRequest;
use \ERede\Acquiring\Integration\GetAuthorizedCreditResponse;
use \ERede\Acquiring\Integration\ConfirmTxnTID;
use \ERede\Acquiring\Integration\ConfirmTxnTIDResponse;
use \ERede\Acquiring\Integration\QueryResponse;

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

  protected function getIntegratorConfirmTxnTIDMock($success) {

    $mock = $this->getMockBuilder("stdClass")
                  ->setMethods(array('ConfirmTxnTID'))
                  ->getMock();

    $response = $this->getConfirmTxnTIDResponseError();

    if($success)
      $response = $this->getConfirmTxnTIDResponseSuccess();

    $mock->expects($this->once())
                        ->method("ConfirmTxnTID")
                        ->willReturn(new ConfirmTxnTIDResponse($response));

    return $mock;

  }

  protected function getIntegratorQueryMock($success) {

    $mock = $this->getMockBuilder("stdClass")
                  ->setMethods(array('Query'))
                  ->getMock();

    $response = $this->getQueryResponseError();

    if($success)
      $response = $this->getQueryResponseSuccess();

    $mock->expects($this->once())
                        ->method("Query")
                        ->willReturn(new QueryResponse($response));

    return $mock;

  }

  protected function getQueryResponseSuccess() {

    $result = new \stdClass;

    $result->REGISTRO = new \stdClass;
    $result->REGISTRO->COD_RET              = "00";
    $result->REGISTRO->DATA                 = "20150614";
    $result->REGISTRO->DATA_CANC            = "";
    $result->REGISTRO->DATA_CON_PRE_AUT     = "20150614";
    $result->REGISTRO->DATA_EXP_PRE_AUT     = "20150714";
    $result->REGISTRO->FILIACAO_DSTR        = "0";
    $result->REGISTRO->HORA                 = "13:39:41";
    $result->REGISTRO->IDENTIFICACAOFATURA  = "LOJADRI-mystore";
    $result->REGISTRO->MOEDA                = "Real";
    $result->REGISTRO->MSG_RET              = "Sucesso";
    $result->REGISTRO->NOM_PORTADOR         = "";
    $result->REGISTRO->NR_CARTAO            = "544570XXXXXX9838";
    $result->REGISTRO->NUMAUTOR             = "035985";
    $result->REGISTRO->NUMPEDIDO            = "capture4";
    $result->REGISTRO->NUMSQN               = "249939093";
    $result->REGISTRO->ORIGEM               = "0";
    $result->REGISTRO->PARCELAS             = "00";
    $result->REGISTRO->STATUS               = "1";
    $result->REGISTRO->TAXA_EMBARQUE        = "0.00";
    $result->REGISTRO->TID                  = "206";
    $result->REGISTRO->TOTAL                = "1.11";
    $result->REGISTRO->TRANSACAO            = "69";

    return $result;

  }

  protected function getQueryResponseError() {

    $result = new \stdClass;

    $result->REGISTRO = new \stdClass;
    $result->REGISTRO->COD_RET              = "99";
    $result->REGISTRO->DATA                 = "";
    $result->REGISTRO->DATA_CANC            = "";
    $result->REGISTRO->DATA_CON_PRE_AUT     = "";
    $result->REGISTRO->DATA_EXP_PRE_AUT     = "";
    $result->REGISTRO->FILIACAO_DSTR        = "";
    $result->REGISTRO->HORA                 = "";
    $result->REGISTRO->IDENTIFICACAOFATURA  = "";
    $result->REGISTRO->MOEDA                = "";
    $result->REGISTRO->MSG_RET              = "Transação não encontrada";
    $result->REGISTRO->NOM_PORTADOR         = "";
    $result->REGISTRO->NR_CARTAO            = "";
    $result->REGISTRO->NUMAUTOR             = "";
    $result->REGISTRO->NUMPEDIDO            = "";
    $result->REGISTRO->NUMSQN               = "";
    $result->REGISTRO->ORIGEM               = "";
    $result->REGISTRO->PARCELAS             = "";
    $result->REGISTRO->STATUS               = "";
    $result->REGISTRO->TAXA_EMBARQUE        = "";
    $result->REGISTRO->TID                  = "";
    $result->REGISTRO->TOTAL                = "";
    $result->REGISTRO->TRANSACAO            = "";

    return $result;

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
    $result->Msgret   = "Sucesso";
    $result->NumAutor = "022579";
    $result->NumPedido = "123456";
    $result->NumSqn     = "25747";
    $result->Tid        = "134";

    return $result;

  }

  protected function getConfirmTxnTIDResponseError() {

    $result = new \stdClass;
    $result->CodRet   = NULL;
    $result->Data     = NULL;
    $result->Msgret   = "Dado Inválido. PARAMETRO OBRIGATORIO AUSENTE.";
    $result->NumAutor = NULL;
    $result->NumPedido = NULL;
    $result->NumSqn     = NULL;
    $result->Tid        = NULL;

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
