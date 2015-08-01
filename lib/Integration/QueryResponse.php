<?php

namespace ERede\Acquiring\Integration;

class QueryResponse {

  public $QueryResult = null;

  public function __construct($data) {
    $this->QueryResult = $data;
  }

}
