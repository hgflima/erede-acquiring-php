<?php

namespace ERede\Acquiring\Validator;

use \Respect\Validation\Validator as v;
use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditCaptureValidator extends TransactionCreditValidator {

  public function __construct() {
    parent::__construct();
  }

  public function validate(array $parameters) {

    if($this->validateRequired($parameters, array("installments", "tid", "amount"))) {

      $this->validateAmount($parameters);
      $this->validateInstallments($parameters);

    }

    return $this->validationResponse;

  }

  private function validateInstallments($parameters) {
    $fieldName = "installments";
    return $this->assertIntBetween($fieldName, 1, 12, $parameters[$fieldName]);
  }

}
