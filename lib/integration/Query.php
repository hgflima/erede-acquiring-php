<?php

namespace ERede\Acquiring\Integration;

class Query {

  public $request = null;

  public function __construct($data) {
    $this->request = $data;
  }

}
