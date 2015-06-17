<?php

namespace ERede\Acquiring\Validator;

use \Respect\Validation\Validator as v;
use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditCancelValidator extends TransactionCreditValidator {

  public function __construct() {
    parent::__construct();
  }

  public function validate(array $parameters) {

    $field = "tid";

    if(!$this->validateField($parameters, $field))
      $this->setValidationResponse(s::VALIDATION_ERROR, $field, "is required");

    return $this->validationResponse;

  }

  private function validateField($parameters, $fieldName) {

    if(v::key($fieldName)->validate($parameters))
      if(v::notEmpty()->validate($parameters[$fieldName]))
        return true;

    return false;

  }

}
