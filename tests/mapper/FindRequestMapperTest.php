<?php

namespace ERede\Acquiring\Mapper;

class FindRequestMapperTest extends \ERede\Acquiring\TestCase {

  public function testTIDMap() {

    $expected         = "123456";

    $mapper           = new FindRequestMapper("123", "456");
    $data             = array("tid" => "123456");

    $request   = $mapper->map($data);
    $this->assertEquals($expected, $request->Tid);

  }

  public function testReferenceMap() {

    $expected         = "123456";

    $mapper           = new FindRequestMapper("123", "456");
    $data             = array("reference" => "123456");

    $request   = $mapper->map($data);
    $this->assertEquals($expected, $request->NumPedido);

  }

}
