<?php

namespace ERede\Acquiring\Integration;

class VoidTransactionTID {

  public $request = null;

  public function __construct($data) {
    $this->request = $data;
  }

}
