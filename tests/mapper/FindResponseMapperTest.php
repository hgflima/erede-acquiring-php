<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\QueryResponse as Response;

class FindResponseMapperTest extends \ERede\Acquiring\TestCase {

  public function testMap() {

    $expected_return_code = "00";
    $expected_date        = "20150614";

    $response = new Response($this->getQueryResponseSuccess());

    $mapper   = new FindResponseMapper();
    $returned = $mapper->map($response);

    $this->assertEquals($expected_return_code, $returned['return_code']);
    $this->assertEquals($expected_date, $returned['date']);

  }

}
