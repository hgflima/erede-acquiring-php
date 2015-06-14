<?php

namespace ERede\Acquiring\Validator;

use \Respect\Validation\Validator as v;
use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditCaptureValidator extends TransactionCreditValidator {

  public function __construct() {
    parent::__construct();
  }

  public function validate(array $parameters) {

    if($this->validateRequired($parameters, array("installments", "tid", "amount", "authorization_number", "date"))) {

      $this->validateAmount($parameters);
      $this->validateInstallments($parameters);
      $this->validateDate($parameters);

    }

    return $this->validationResponse;

  }

  private function validateInstallments($parameters) {
    $fieldName = "installments";
    return $this->assertIntBetween($fieldName, 1, 12, $parameters[$fieldName]);
  }

  private function validateDate($parameters) {

    $fieldName = "date";

    if(!v::date('Ymd')->validate($parameters[$fieldName])) {
      $this->validationResponse->status = s::VALIDATION_ERROR;
      $this->validationResponse->errors[$fieldName] = "is invalid";
      return false;
    }

    return true;

  }

}
