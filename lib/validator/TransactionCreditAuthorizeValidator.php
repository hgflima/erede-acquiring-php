<?php

namespace ERede\Acquiring\Validator;

use \Respect\Validation\Validator as v;
use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditAuthorizeValidator {

  private $validationResponse;

  public function __construct() {
    $this->validationResponse         = new \sTdClass;
    $this->validationResponse->status = 0;
    $this->validationResponse->errors = array();
  }

  public function validate(array $parameters) {
    $this->validateCreditCard($parameters);
    $this->validateCVV($parameters);
    $this->validateExpDate($parameters);
    $this->validateAmount($parameters);
    return $this->validationResponse;
  }

  private function validateCreditCard($parameters) {

    $fieldName = "credit_card";

    if(!$this->validateRequired($parameters, $fieldName))
      return false;

    if(!v::creditCard()->validate($parameters["credit_card"])) {
      $this->validationResponse->status = 1;
      $this->validationResponse->errors[$fieldName] = "is invalid";
      return false;
    }

    return true;

  }

  private function validateExpYear($parameters) {

    $fieldName = "exp_year";

    if(!$this->validateRequired($parameters, $fieldName))
      return false;

    if(!v::int()->validate($parameters[$fieldName])) {
      $this->validationResponse->status = s::VALIDATION_ERROR;
      $this->validationResponse->errors[$fieldName] = "is not a valid year";
      return false;
    }

    $now  = new \DateTime();
    $year = substr($parameters[$fieldName], -2);

    if(!v::int()->min($now->format("y"), true)->validate($year)) {
      $this->validationResponse->status = s::VALIDATION_ERROR;
      $this->validationResponse->errors[$fieldName] = "is invalid";
      return false;
    }

    return true;

  }

  private function validateExpMonth($parameters) {

    $fieldName = "exp_month";

    if(!$this->validateRequired($parameters, $fieldName))
      return false;

    if(!v::int()->between(1, 12)->validate($parameters[$fieldName])) {
      $this->validationResponse->status = s::VALIDATION_ERROR;
      $this->validationResponse->errors[$fieldName] = "is invalid";
      return false;
    }

    return true;

  }

  private function validateExpDate($parameters) {

    if($this->validateExpMonth($parameters) && $this->validateExpYear($parameters)) {

      $now = new \DateTime();
      $now = $now->format("y") . $now->format("m");

      $date = substr($parameters["exp_year"], -2) . $parameters["exp_month"];

      if($date >= $now) {
        return true;
      } else {
        $this->validationResponse->status = s::VALIDATION_ERROR;
        $this->validationResponse->errors["exp_date"] = "is invalid";
        return false;
      }

    }

    return false;

  }

  private function validateCVV($parameters) {

    $fieldName = "cvv";

    if(array_key_exists($fieldName, $parameters)) {

      if(!v::numeric()->validate($parameters[$fieldName]) || 
        !v::length(3,3,true)->validate($parameters[$fieldName])) {
          $this->validationResponse->status = s::VALIDATION_ERROR;
          $this->validationResponse->errors[$fieldName] = "is required";
          return false;
      }

    }

    return true;

  }

  private function validateAmount($parameters) {

    $fieldName = "amount";

    if(!$this->validateRequired($parameters, $fieldName))
      return false;

    if(!v::int()->min(50, true)->validate($parameters[$fieldName])) {
      $this->validationResponse->status = s::VALIDATION_ERROR;
      $this->validationResponse->errors[$fieldName] = "is invalid. Need to be higher than 50 cents";
      return false;
    }

    return true;

  }

  private function validateRequired($parameters, $fieldName) {

    if(!v::key($fieldName)->validate($parameters)) {
      $this->validationResponse->status = s::VALIDATION_ERROR;
      $this->validationResponse->errors[$fieldName] = "is required";
      return false;
    }

    return true;

  }

}
