<?php

namespace ERede\Acquiring;

use ERede\Acquiring\Mapper\AuthorizeRequestMapper;
use ERede\Acquiring\Validator\TransactionCreditAuthorizeValidator;

class Acquirer {

  private $filiation, $password;
  private $transactionTypeList;

  function __construct($filiation, $password) {

    $this->filiation  = $filiation;
    $this->password   = $password;

    $parameters = array("filiation"               => $filiation,
                        "password"                => $password,
                        "authorizeValidator"      => new TransactionCreditAuthorizeValidator(),
                        "authorizeRequestMapper"  => new AuthorizeRequestMapper($filiation, $password));

    $this->transactionTypeList = array(TransactionType::CREDIT => new TransactionCredit($parameters));

  }

  function fetch($transactionType) {

    if(array_key_exists($transactionType, $this->transactionTypeList))
      return $this->transactionTypeList[$transactionType];

    throw new Error\WrongTransactionTypeException("invalid transaction type");

  }

}

