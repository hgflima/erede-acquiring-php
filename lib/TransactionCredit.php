<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\Mapper\AuthorizeRequestMapper as AuthorizeRequestMapper;
use \ERede\Acquiring\Validator\TransactionCreditAuthorizeValidator as AuthorizeValidator;
use \ERede\Acquiring\TransactionStatus as s;
use ERede\Acquiring\Integration\KomerciWcf as Komerci;
use ERede\Acquiring\Integration\GetAuthorizedCredit;

class TransactionCredit {

  private $filiation, $password, $authorizeValidator, $authorizeRequestMapper, $authorizeResponseMapper, $integrator;

  public function __construct(array $parameters) {

    foreach($parameters as $key => $value)
      if(property_exists('\ERede\Acquiring\TransactionCredit', $key))
        $this->$key = $value;

  }

  public function authorize(array $parameters) {

    $response = new \stdClass;
    $response->status = s::SUCCESS;
    $response->errors = array();

    $validationResponse = $this->authorizeValidator->validate($parameters);

    if($validationResponse->status == s::VALIDATION_ERROR) {
      $response->status = $validationResponse->status;
      $response->errors = $validationResponse->errors;
      return $response;
    }

    $authorizeRequest = $this->authorizeRequestMapper->map($parameters);

    $authorizeResponse = $this->integrator->GetAuthorizedCredit(new GetAuthorizedCredit($authorizeRequest));
    $response->data    = $this->authorizeResponseMapper->map($authorizeResponse);

    if($response->data['return_code'] == null)
      $response->status = s::TRANSACTION_NOT_PROCESSED;

    return $response;

  }

}
