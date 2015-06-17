<?php

namespace ERede\Acquiring\Validator;

use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditCancelValidatorTest extends \ERede\Acquiring\TestCase {

  public function testTIDEmpty() {

    $validator            = new TransactionCreditCancelValidator();
    $validationResponse   = $validator->validate(array());

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);
    $this->assertEquals("is required", $validationResponse->errors['tid']);

  }

  

}
