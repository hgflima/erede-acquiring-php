<?php

namespace ERede\Acquiring\Validator;

use \Respect\Validation\Validator as v;
use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditFindValidator extends TransactionCreditValidator {

  public function __construct() {
    parent::__construct();
  }

  public function validate(array $parameters) {

    $fields               = array();

    $fields['tid']        = $this->validateField($parameters, "tid");
    $fields['reference']  = $this->validateField($parameters, "reference");

    if(!$fields['tid'] && !$fields['reference'])
      foreach($fields as $key => $value)
        if(!$fields[$key])
          $this->setValidationResponse(s::VALIDATION_ERROR, $key, "is required");

    return $this->validationResponse;

  }

  private function validateField($parameters, $fieldName) {

    if(v::key($fieldName)->validate($parameters))
      if(v::notEmpty()->validate($parameters[$fieldName]))
        return true;

    return false;

  }

}
