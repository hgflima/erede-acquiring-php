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

  private function doAction(array $parameters, $validator, $requestMapper, $responseMapper, $methodToCall, $parameterClass) {

    $response = new \stdClass;
    $response->status = s::SUCCESS;
    $response->errors = array();

    $validationResponse = $validator->validate($parameters);

    if($validationResponse->status == s::VALIDATION_ERROR) {
      $response->status = $validationResponse->status;
      $response->errors = $validationResponse->errors;
      return $response;
    }

    $actionRequest      = $requestMapper->map($parameters);
    $actionResponse     = $this->integrator->$methodToCall(new $parameterClass($actionRequest));
    $response->data     = $responseMapper->map($actionResponse);

    if($response->data['return_code'] == null)
      $response->status = s::TRANSACTION_NOT_PROCESSED;

    return $response;

  }

  public function authorize(array $parameters) {
    return $this->doAction($parameters,
                      $this->authorizeValidator,
                      $this->authorizeRequestMapper,
                      $this->authorizeResponseMapper,
                      "GetAuthorizedCredit",
                      "\ERede\Acquiring\Integration\GetAuthorizedCredit");
  }

  public function capture(array $parameters) {
    return $this->doAction($parameters,
                      $this->captureValidator,
                      $this->captureRequestMapper,
                      $this->captureResponseMapper,
                      "ConfirmTxnTID",
                      "\ERede\Acquiring\Integration\ConfirmTxnTID");
  }

}
