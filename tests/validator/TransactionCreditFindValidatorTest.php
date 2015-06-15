<?php

namespace ERede\Acquiring\Validator;

use \ERede\Acquiring\TransactionStatus as s;

class TransactionCreditFindValidatorTest extends \ERede\Acquiring\TestCase {

  public function testAllEmpty() {

    $validator            = new TransactionCreditFIndValidator();
    $validationResponse   = $validator->validate(array());

    $this->assertEquals(s::VALIDATION_ERROR, $validationResponse->status);
    $this->assertEquals("is required", $validationResponse->errors["tid"]);
    $this->assertEquals("is required", $validationResponse->errors["reference"]);

  }

  public function testTIDEmpty() {

    $validator            = new TransactionCreditFIndValidator();
    $validationResponse   = $validator->validate(array("reference" => "123456"));

    $this->assertEquals(s::SUCCESS, $validationResponse->status);

  }

  public function testReferenceEmpty() {

    $validator            = new TransactionCreditFIndValidator();
    $validationResponse   = $validator->validate(array("tid" => "205"));

    $this->assertEquals(s::SUCCESS, $validationResponse->status);

  }

}
