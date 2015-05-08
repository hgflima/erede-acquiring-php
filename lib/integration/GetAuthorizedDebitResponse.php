<?php

namespace ERede\Acquiring\Integration;

class GetAuthorizedDebitResponse
{

    /**
     * @var Authorization $GetAuthorizedDebitResult
     * @access public
     */
    public $GetAuthorizedDebitResult = null;

    /**
     * @param Authorization $GetAuthorizedDebitResult
     * @access public
     */
    public function __construct($GetAuthorizedDebitResult)
    {
      $this->GetAuthorizedDebitResult = $GetAuthorizedDebitResult;
    }

}
