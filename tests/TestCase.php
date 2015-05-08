<?php

namespace ERede\Acquiring;

class TestCase extends \PHPUnit_Framework_TestCase {

  protected function getAcquirer() {
    return new Acquirer("123", "456");
  }

  protected function getValidAuthorizeRequestData() {
    return array("credit_card" => "42424242424242", "exp_month" => 11, "exp_year" => 2015, "cvv" => "021");
  }

}
