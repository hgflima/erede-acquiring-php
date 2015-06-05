<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\GetAuthorizedCreditResponse as Response;

class AuthorizeResponseMapper {

  private $fieldList;

  public function __construct() {

    $this->fieldList = array("Cet"      => "cet",
                        "CodRet"        => "return_code",
                        "Juros"         => "interest_rate",
                        "MsgAvs"        => "avs_message",
                        "RespAvs"       => "avs_response",
                        "Msgret"        => "message",
                        "NumAutor"      => "authorization_number",
                        "NumPedido"     => "reference",
                        "NumSqn"        => "nsu",
                        "Tid"           => "tid",
                        "ValParcelas"   => "installments_amount",
                        "ValTotalJuros" => "total_interest_rate");

  }

  public function map(Response $authorizeResponse) {

    $response = array();

    foreach($this->fieldList as $key => $value)
        $response[$value] = $authorizeResponse->GetAuthorizedCreditResult->$key;

    return $response;

  }

}
