<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\TransactionStatus as s;
use ERede\Acquiring\Integration\KomerciWcf as Komerci;
use ERede\Acquiring\Integration\GetAuthorizedCredit;
use ERede\Acquiring\Integration\ConfirmTxnTID;

class TransactionCredit {

  private $filiation, $password, $integrator;
  private $authorizeValidator, $authorizeRequestMapper, $authorizeResponseMapper;
  private $captureValidator, $captureRequestMapper, $captureResponseMapper;

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

    var_dump($authorizeRequest);

    $authorizeResponse = $this->integrator->GetAuthorizedCredit(new GetAuthorizedCredit($authorizeRequest));
    $response->data    = $this->authorizeResponseMapper->map($authorizeResponse);

    var_dump($authorizeResponse);

    if($response->data['return_code'] == null)
      $response->status = s::TRANSACTION_NOT_PROCESSED;

    return $response;

  }

  public function capture(array $parameters) {

    $response = new \stdClass;
    $response->status = s::SUCCESS;
    $response->errors = array();

    $validationResponse = $this->captureValidator->validate($parameters);

    if($validationResponse->status == s::VALIDATION_ERROR) {
      $response->status = $validationResponse->status;
      $response->errors = $validationResponse->errors;
      return $response;
    }

    $captureRequest   = $this->captureRequestMapper->map($parameters);
    var_dump($captureRequest);

    $captureResponse  = $this->integrator->ConfirmTxnTID(new ConfirmTxnTID($captureRequest));
    var_dump($captureResponse);

    $response->data   = $this->captureResponseMapper->map($captureResponse);

    if($response->data['return_code'] == null)
      $response->status = s::TRANSACTION_NOT_PROCESSED;

    return $response;

  }

}
