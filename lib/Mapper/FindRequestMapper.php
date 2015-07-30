<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\QueryRequest as FindRequest;

class FindRequestMapper {

  private $filiation, $password, $fieldList;

  public function __construct($filiation, $password) {

    $this->filiation  = $filiation;
    $this->password   = $password;

    $this->fieldList = array("tid"        => "Tid",
                              "reference" => "NumPedido");

  }

  public function map($data) {

    $findRequest = new FindRequest();

    foreach($this->fieldList as $key => $value)
      if(isset($data[$key]))
        $findRequest->$value = $data[$key];

    $findRequest->Filiacao = $this->filiation;
    $findRequest->Senha    = $this->password;

    return $findRequest;

  }

}
