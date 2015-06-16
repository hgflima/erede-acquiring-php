<?php

namespace ERede\Acquiring;

use ERede\Acquiring\Mapper\AuthorizeRequestMapper;
use ERede\Acquiring\Mapper\AuthorizeResponseMapper;
use ERede\Acquiring\Validator\TransactionCreditAuthorizeValidator;
use ERede\Acquiring\Mapper\CaptureRequestMapper;
use ERede\Acquiring\Mapper\CaptureResponseMapper;
use ERede\Acquiring\Validator\TransactionCreditCaptureValidator;

use ERede\Acquiring\Integration\KomerciWcf as Komerci;

class Acquirer {

  private $filiation, $password, $transactionTypeList;

  function __construct($filiation, $password, $environment = 'production') {

    $environments = array("production"  => "https://ecommerce.userede.com.br/Redecard.Adquirencia.Wcf/KomerciWcf.svc?wsdl",
                          "homolog"     => "https://ecommerce.userede.com.br/Redecard.Adquirencia.Wcf/KomerciWcf.svc?wsdl");

    $env = $environments['production'];

    if(array_key_exists($environment, $environments))
      $env = $environments[$environment];

    $this->filiation  = $filiation;
    $this->password   = $password;

    $parameters = array("filiation"               => $filiation,
                        "password"                => $password,
                        "authorizeValidator"      => new TransactionCreditAuthorizeValidator(),
                        "authorizeRequestMapper"  => new AuthorizeRequestMapper($filiation, $password),
                        "authorizeResponseMapper" => new AuthorizeResponseMapper(),
                        "captureValidator"        => new TransactionCreditCaptureValidator(),
                        "captureRequestMapper"    => new CaptureRequestMapper($filiation, $password),
                        "captureResponseMapper"   => new CaptureResponseMapper(),
                        "findValidator"           => new TransactionCreditFindValidator(),
                        "findRequestMapper"       => new FindRequestMapper($filiation, $password),
                        "findResponseMapper"      => new FindResponseMapper(),
                        "integrator"              => new Komerci(array(), $env));

    $this->transactionTypeList = array(TransactionType::CREDIT => new TransactionCredit($parameters));

  }

  function fetch($transactionType) {

    if(array_key_exists($transactionType, $this->transactionTypeList))
      return $this->transactionTypeList[$transactionType];

    throw new Error\WrongTransactionTypeException("invalid transaction type");

  }

}

