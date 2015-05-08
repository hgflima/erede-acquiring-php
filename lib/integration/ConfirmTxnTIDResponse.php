<?php

namespace ERede\Acquiring\Integration;

class ConfirmTxnTIDResponse
{

    /**
     * @var Authorization $ConfirmTxnTIDResult
     * @access public
     */
    public $ConfirmTxnTIDResult = null;

    /**
     * @param Authorization $ConfirmTxnTIDResult
     * @access public
     */
    public function __construct($ConfirmTxnTIDResult)
    {
      $this->ConfirmTxnTIDResult = $ConfirmTxnTIDResult;
    }

}
