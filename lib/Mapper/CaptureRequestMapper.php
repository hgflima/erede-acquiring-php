<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\ConfirmTxnTIDRequest as CaptureRequest;

class CaptureRequestMapper {

  private $filiation, $password, $fieldList;

  public function __construct($filiation, $password) {

    $this->filiation  = $filiation;
    $this->password   = $password;

    $this->fieldList = array("tid"                    => "Tid",
                              "installments"          => "Parcelas");

  }

  public function map($data) {

    $captureRequest = new CaptureRequest();

    foreach($this->fieldList as $key => $value)
      if(isset($data[$key]))
        $captureRequest->$value = $data[$key];

    if(isset($data['amount']))
      $captureRequest->Total    = ((float)$data['amount']) / 100;

    $captureRequest->Filiacao = $this->filiation;
    $captureRequest->Senha    = $this->password;

    return $captureRequest;

  }

}
