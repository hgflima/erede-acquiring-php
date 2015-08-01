<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\ConfirmTxnTIDResponse as Response;

class CaptureResponseMapper {

  private $fieldList;

  public function __construct() {

    $this->fieldList = array(
                        "CodRet"        => "return_code",
                        "Msgret"        => "message",
                        "NumPedido"     => "reference",
                        "NumAutor"      => "authorization_number",
                        "NumSqn"        => "nsu",
                        "Tid"           => "tid");

  }

  public function map(Response $captureResponse) {

    $response = array();

    foreach($this->fieldList as $key => $value)
      $response[$value] = $captureResponse->ConfirmTxnTIDResult->$key;

    return $response;

  }

}
