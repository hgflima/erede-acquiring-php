<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\QueryResponse as Response;

class FindResponseMapper {

  private $fieldList;

  public function __construct() {

    $this->fieldList = array(
                        "COD_RET"             => "return_code",
                        "HORA"                => "time",
                        "DATA"                => "date",
                        "DATA_CANC"           => "cancel_date",
                        "DATA_CON_PRE_AUT"    => "authorization_date", #confirmar
                        "DATA_EXP_PRE_AUT"    => "authorization_expiration_date",
#                        "FILIACAO_DSTR"       => "return_code", # WTF?
                        "IDENTIFICACAOFATURA" => "soft_descriptor",
                        "MOEDA"               => "currency",
                        "MSG_RET"             => "message",
                        "NOM_PORTADOR"        => "card_holder_name",
                        "NR_CARTAO"           => "credit_card_number",
                        "NUMAUTOR"            => "authorization_number",
                        "NUMPEDIDO"           => "reference",
                        "NUMSQN"              => "nsu",
                        "PARCELAS"            => "installments",
                        "STATUS"              => "status",
                        "TAXA_EMBARQUE"       => "departure_tax",
                        "TID"                 => "tid",
                        "TOTAL"               => "amount",
                        "TRANSACAO"           => "transaction");

  }

  public function map(Response $findResponse) {

    $response = array();

    foreach($this->fieldList as $key => $value)
      if(property_exists($findResponse->QueryResult->REGISTRO, $key))
        $response[$value] = $findResponse->QueryResult->REGISTRO->$key;

    return $response;

  }

}
