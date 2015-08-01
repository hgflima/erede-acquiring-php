<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\GetAuthorizedRequest as AuthorizeRequest;

class AuthorizeRequestMapper {

  private $filiation, $password, $fieldList;

  public function __construct($filiation, $password) {

    $this->filiation  = $filiation;
    $this->password   = $password;

    $this->fieldList = array("credit_card"  => "Nrcartao",
                        "exp_month"         => "Mes",
                        "exp_year"          => "Ano",
                        "cvv"               => "Cvc2",
                        "reference"         => "NumPedido",
                        "soft_descriptor"   => "IdentificacaoFatura");
  }

  public function map($data) {

    $authorizeRequest = new AuthorizeRequest();

    foreach($this->fieldList as $key => $value)
      if(isset($data[$key]))
        $authorizeRequest->$value = $data[$key];

    $authorizeRequest->Total    = ((float)$data['amount']) / 100;
    $authorizeRequest->Filiacao = $this->filiation;
    $authorizeRequest->Senha    = $this->password;

    if(isset($data['installments']))
      if($data['installments'] > 1)
        $authorizeRequest->Parcelas = $data['installments'];

    $authorizeRequest->Transacao = $this->getTransactionType($data);

    return $authorizeRequest;

  }

  /*
   *  Authorize + Automatic capture
   *  At sight  => 04
   *  Installments with interest rate => 08
   *  Installments without interest rate => XX
   *
   * Just Authorize => 73
   */
  private function getTransactionType($data) {

    $authorizeType = "08"; # padrao

    if($data['capture'] === true) {

      if($data['installments'] > 1)
        $authorizeType = "08";
      else
        $authorizeType = "04";

    } else {
        $authorizeType = "73";
    }

    return $authorizeType;

  }

}
