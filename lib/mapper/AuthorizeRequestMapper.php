<?php

namespace ERede\Acquiring\Mapper;

use \ERede\Acquiring\Integration\GetAuthorizedRequest as AuthorizeRequest;

class AuthorizeRequestMapper {

    public function map($data) {

      $authorizeRequest = new AuthorizeRequest();

      $authorizeRequest->Nrcartao   = $data['credit_card'];
      $authorizeRequest->Mes        = $data['exp_month'];
      $authorizeRequest->Ano        = $data['exp_year'];
      $authorizeRequest->Cvc2       = $data['cvv'];
      $authorizeRequest->Total      = ((float)$data['amount']) / 100;
      $authorizeRequest->NumPedido  = $data['reference'];

      return $authorizeRequest;

    }

}
