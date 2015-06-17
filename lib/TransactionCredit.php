<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\TransactionStatus as s;
use ERede\Acquiring\Integration\KomerciWcf as Komerci;
use ERede\Acquiring\Integration\GetAuthorizedCredit;
use ERede\Acquiring\Integration\ConfirmTxnTID;
use ERede\Acquiring\Integration\Query;
use ERede\Acquiring\Integration\VoidTransactionTID;

class TransactionCredit {

  private $filiation, $password, $integrator;
  private $authorizeValidator, $authorizeRequestMapper, $authorizeResponseMapper;
  private $captureValidator, $captureRequestMapper, $captureResponseMapper;
  private $findValidator, $findRequestMapper, $findResponseMapper;
  private $cancelValidator, $cancelRequestMapper, $cancelResponseMapper;

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

  public function find(array $parameters) {
    return $this->doAction($parameters,
                      $this->findValidator,
                      $this->findRequestMapper,
                      $this->findResponseMapper,
                      "Query",
                      "\ERede\Acquiring\Integration\Query");
  }

  public function cancel(array $parameters) {
    return $this->doAction($parameters,
                      $this->cancelValidator,
                      $this->cancelRequestMapper,
                      $this->cancelResponseMapper,
                      "VoidTransactionTID",
                      "\ERede\Acquiring\Integration\VoidTransactionTID");
  }

}
