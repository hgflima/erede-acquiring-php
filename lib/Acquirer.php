<?php

namespace ERede\Acquiring;

class Acquirer {

  private $filiation, $password;
  private $transactionTypeList;

  function __construct($filiation, $password) {
    $this->filiation  = $filiation;
    $this->password   = $password;
    $this->transactionTypeList = array(TransactionType::CREDIT => new TransactionCredit($filiation, $password));
  }

  function fetch($transactionType) {

    if(array_key_exists($transactionType, $this->transactionTypeList))
      return $this->transactionTypeList[$transactionType];

    throw new Error\WrongTransactionTypeException("invalid transaction type");

  }

}

