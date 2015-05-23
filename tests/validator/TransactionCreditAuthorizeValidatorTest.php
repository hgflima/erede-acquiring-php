<?php

namespace ERede\Acquiring\Validator;

use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditAuthorizeValidatorTest extends \ERede\Acquiring\TestCase {

  public function testValidateRightCreditCard() {

    $validator          = new TransactionCreditAuthorizeValidator();
    $validationResponse = $validator->validate($this->getValidAuthorizeRequestData());
    $this->assertEquals(s::SUCCESS, $validationResponse->status);

  }
  public function testValidateRightCreditCardExpYear2Digits() {

    $validator          = new TransactionCreditAuthorizeValidator();
    $data               = $this->getValidAuthorizeRequestData();

    $now                = new \DateTime();
    $data["exp_year"]   = $now->format("y");

    $validationResponse = $validator->validate($data);
    $this->assertEquals(s::SUCCESS, $validationResponse->status);

  }

  public function testValidateCreditCardRequired() {

    $validator          = new TransactionCreditAuthorizeValidator();
    $validationResponse = $validator->validate(array("xxx" => "yyy"));
    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateWrongCreditCard() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["credit_card"]  = "4212123456789867";
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateWrongExpMonth() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["exp_month"]    = 13;
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateRightExpMonth() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::SUCCESS, $validationResponse->status);

  }

  public function testValidateWrongExpYearRequired() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    unset($data["exp_year"]);
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateWrongExpYearNotAInteger() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["exp_year"]     = "lala";
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateWrongExpYearInvalid() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["exp_year"]     = 2011;
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateWrongExpYearInvalid2Digits() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["exp_year"]     = 11;
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateWrongExpDate() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["exp_month"]    = "04";
    $data["exp_year"]     = "2015";
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateWrongCVV4Digits() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["cvv"]          = "1015";
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }


  public function testValidateWrongCVV2Digits() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["cvv"]          = "15";
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateWrongCVVInvalidDigits() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["cvv"]          = "a15";
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateAmountRequired() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    unset($data["amount"]);

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateAmountLowerThanExpected() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["amount"]       = 49;

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateAmountInvalid() {

    $validator            = new TransactionCreditAuthorizeValidator();

    $data                 = $this->getValidAuthorizeRequestData();
    $data["amount"]       = 49.3;

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

}
