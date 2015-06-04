<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\Mapper\AuthorizeRequestMapper as AuthorizeRequestMapper;
use \ERede\Acquiring\Validator\TransactionCreditAuthorizeValidator as AuthorizeValidator;
use \ERede\Acquiring\TransactionStatus as s;
use ERede\Acquiring\Integration\KomerciWcf as Komerci;
use ERede\Acquiring\Integration\GetAuthorizedCredit;

class TransactionCredit {

  private $filiation, $password, $authorizeValidator, $authorizeRequestMapper, $integrator;

  public function __construct(array $parameters) {

    foreach($parameters as $key => $value)
      if(property_exists('\ERede\Acquiring\TransactionCredit', $key))
        $this->$key = $value;

  }

  public function authorize(array $parameters) {

    $validationResponse = $this->authorizeValidator->validate($parameters);

    if($validationResponse->status == s::VALIDATION_ERROR)
      return false; # retornar um hash

    $authorizeRequest = $this->authorizeRequestMapper->map($parameters);

    $komerci = new Komerci(array(), "https://ecommerce.userede.com.br/Redecard.Adquirencia.Wcf/KomerciWcf.svc?wsdl");

    $ret = $komerci->GetAuthorizedCredit(new GetAuthorizedCredit($authorizeRequest));

  }

}
