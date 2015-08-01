<?php

namespace ERede\Acquiring\Integration;

class GetAuthorizedCreditResponse {

  public $GetAuthorizedCreditResult = null;

  public function __construct($data) {
    $this->GetAuthorizedCreditResult = $data;
  }

}
