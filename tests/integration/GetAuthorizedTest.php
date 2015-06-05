<?php

namespace ERede\Acquiring\Integration;

class GetAuthorizedCreditTest extends \ERede\Acquiring\TestCase {

  public function testConstructor() {

    $c = new GetAuthorizedCredit("123");
    $this->assertEquals("123", $c->request);

  }

}
