<?php

namespace ERede\Acquiring\Validator;

use \Respect\Validation\Validator as v;
use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditValidator {

  protected $validationResponse;

  public function __construct() {
    $this->validationResponse         = new \sTdClass;
    $this->validationResponse->status = s::SUCCESS;
    $this->validationResponse->errors = array();
  }

  protected function validateAmount($parameters) {

    $fieldName = "amount";

    if(!v::numeric()->min(50, true)->validate($parameters[$fieldName])) {
      $this->validationResponse->status = s::VALIDATION_ERROR;
      $this->validationResponse->errors[$fieldName] = "is invalid. Need to be higher than 50 cents";
      return false;
    }

    return true;

  }

  protected function validateRequired($parameters, $fieldNames) {

    foreach($fieldNames as $fieldName) {

      if(!v::key($fieldName)->validate($parameters)) {
        $this->validationResponse->status = s::VALIDATION_ERROR;
        $this->validationResponse->errors[$fieldName] = "is required";
        return false;
      }

    }

    return true;

  }

  protected function assertIntBetween($fieldName, $start, $end, $parameter) {

    if(!v::numeric()->between($start, $end, true)->validate($parameter)) {
      $this->setValidationResponse(s::VALIDATION_ERROR, $fieldName, "is invalid");
      return false;
    }

    return true;

  }

  protected function setValidationResponse($status, $fieldName, $message) {
      $this->validationResponse->status = $status;
      $this->validationResponse->errors[$fieldName] = $message;
  }

}
