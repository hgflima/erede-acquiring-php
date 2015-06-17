<?php

namespace ERede\Acquiring\Mapper;

class CancelRequestMapperTest extends \ERede\Acquiring\TestCase {

  public function testTIDMap() {

    $expected         = "123456";

    $mapper           = new CancelRequestMapper("123", "456");
    $data             = array("tid" => "123456");
    $request          = $mapper->map($data);

    $this->assertEquals($expected, $request->Tid);

  }

}
