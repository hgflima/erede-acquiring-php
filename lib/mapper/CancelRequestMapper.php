<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\VoidTransactionTIDRequest as CancelRequest;

class CancelRequestMapper {

  private $filiation, $password;

  public function __construct($filiation, $password) {

    $this->filiation  = $filiation;
    $this->password   = $password;

  }

  public function map($data) {

    $cancelRequest = new CancelRequest();

    $cancelRequest->Tid       = $data['tid'];
    $cancelRequest->Filiacao  = $this->filiation;
    $cancelRequest->Senha     = $this->password;

    return $cancelRequest;

  }

}
