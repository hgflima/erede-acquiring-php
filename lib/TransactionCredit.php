<?php

namespace ERede\Acquiring;

class TransactionCredit {

  private $filiation, $password;

  public function __construct($filiation, $password) {
    $this->filiation = $filiation;
    $this->password  = $password;
  }

  public function authorize(array $parameters) {

  }

}

?>
