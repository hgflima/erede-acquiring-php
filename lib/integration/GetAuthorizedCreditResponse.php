<?php

namespace ERede\Acquiring\Integration;

class GetAuthorizedCreditResponse
{

    /**
     * @var Authorization $GetAuthorizedCreditResult
     * @access public
     */
    public $GetAuthorizedCreditResult = null;

    /**
     * @param Authorization $GetAuthorizedCreditResult
     * @access public
     */
    public function __construct($GetAuthorizedCreditResult)
    {
      $this->GetAuthorizedCreditResult = $GetAuthorizedCreditResult;
    }

}
