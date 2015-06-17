<?php

namespace ERede\Acquiring\Integration;

class VoidTransactionTIDResponse {

  public $VoidTransactionTIDResult = null;

  public function __construct($data) {
    $this->VoidTransactionTIDResult = $data;
  }

}
