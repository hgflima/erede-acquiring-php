<?php

namespace ERede\Acquiring\Integration;

class ConfirmTxnTID
{

    /**
     * @var ConfirmTxnTID $request
     * @access public
     */
    public $request = null;

    /**
     * @param ConfirmTxnTID $request
     * @access public
     */
    public function __construct($request)
    {
      $this->request = $request;
    }

}
