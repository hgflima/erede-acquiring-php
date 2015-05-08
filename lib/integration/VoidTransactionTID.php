<?php

namespace ERede\Acquiring\Integration;

class VoidTransactionTID
{

    /**
     * @var VoidTransactionTID $request
     * @access public
     */
    public $request = null;

    /**
     * @param VoidTransactionTID $request
     * @access public
     */
    public function __construct($request)
    {
      $this->request = $request;
    }

}
