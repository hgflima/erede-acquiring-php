<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\VoidTransactionTIDResponse as Response;

class CancelResponseMapper {

  private $fieldList;

  public function __construct() {

    $this->fieldList = array(
                        "CodRet"              => "return_code",
                        "MsgRet"              => "message",
                        "Tid"                 => "tid");

  }

  public function map(Response $cancelResponse) {

    $response = array();

    foreach($this->fieldList as $key => $value)
      if(property_exists($cancelResponse->VoidTransactionTIDResult, $key))
        $response[$value] = $cancelResponse->VoidTransactionTIDResult->$key;

    return $response;

  }

}
