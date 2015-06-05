<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\TransactionStatus as s;
use \ERede\Acquiring\Integration\GetAuthorizedRequest;

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

}
