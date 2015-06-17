<?php

namespace ERede\Acquiring\Validator;

use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditCaptureValidatorTest extends \ERede\Acquiring\TestCase {

  public function testValidateTIDRequired() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    unset($data["tid"]);
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);
    $this->assertEquals("is required", $validationResponse->errors["tid"]);

  }

  public function testValidateInstallmentsRequired() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    unset($data["installments"]);
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);
    $this->assertEquals("is required", $validationResponse->errors["installments"]);

  }

  public function testValidateAmountRequired() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    unset($data["amount"]);
    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateSuccess() {

    $validator          = new TransactionCreditCaptureValidator();
    $validationResponse = $validator->validate($this->getValidCaptureRequestData());
    $this->assertEquals(s::SUCCESS, $validationResponse->status);

  }

  public function testValidateAmountLowerThanExpected() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    $data["amount"]       = 49;

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateAmountInvalid() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    $data["amount"]       = 49.3;

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);

  }

  public function testValidateAmount() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    $data["amount"]       = 50;

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::SUCCESS, $validationResponse->status);

  }

  public function testValidateWrongInstallments() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    $data["installments"]       = "ABC";

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);
    $this->assertEquals("is invalid", $validationResponse->errors["installments"]);

  }

  public function testValidateWrongInstallmentsGreaterThan() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    $data["installments"]       = 13;

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);
    $this->assertEquals("is invalid", $validationResponse->errors["installments"]);

  }

  public function testValidateWrongInstallmentsLowerThan() {

    $validator            = new TransactionCreditCaptureValidator();

    $data                 = $this->getValidCaptureRequestData();
    $data["installments"]       = 0;

    $validationResponse   = $validator->validate($data);

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);
    $this->assertEquals("is invalid", $validationResponse->errors["installments"]);

  }

}
