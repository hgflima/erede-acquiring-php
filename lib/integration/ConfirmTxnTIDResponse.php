<?php

namespace ERede\Acquiring\Integration;

class ConfirmTxnTIDResponse {

    public $ConfirmTxnTIDResult = null;

    public function __construct($data) {
      $this->ConfirmTxnTIDResult = $data;
    }

}
