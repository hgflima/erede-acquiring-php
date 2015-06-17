<?php

namespace ERede\Acquiring;

use \ERede\Acquiring\Acquirer;
use \ERede\Acquiring\TransactionType;

class AcquirerTest extends TestCase {

  public function testFetchTransactionCredit() {

    $acquirer = $this->getAcquirer();
    $transaction = $acquirer->fetch(TransactionType::CREDIT);
    $this->assertInstanceOf('\ERede\Acquiring\TransactionCredit', $transaction);

  }

  public function testFetchWrongTransaction() {

    $acquirer = $this->getAcquirer();

    try {
      $transaction = $acquirer->fetch(8);
    } catch(Error\WrongTransactionTypeException $e) {
      $this->assertInstanceOf('\ERede\Acquiring\Error\WrongTransactionTypeException', $e);
    }

  }

  public function testFetchWrongTransactionMessage() {

    $acquirer = $this->getAcquirer();

    try {
      $transaction = $acquirer->fetch(8);
    } catch(Error\WrongTransactionTypeException $e) {
      $this->assertEquals("invalid transaction type", $e->getMessage());
    }

  }

}
