<?php

namespace ERede\Acquiring\Integration;

class VoidTransactionTIDResponse
{

    /**
     * @var Confirmation $VoidTransactionTIDResult
     * @access public
     */
    public $VoidTransactionTIDResult = null;

    /**
     * @param Confirmation $VoidTransactionTIDResult
     * @access public
     */
    public function __construct($VoidTransactionTIDResult)
    {
      $this->VoidTransactionTIDResult = $VoidTransactionTIDResult;
    }

}
