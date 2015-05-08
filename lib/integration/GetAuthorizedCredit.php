<?php

namespace ERede\Acquiring\Integration;

class GetAuthorizedCredit
{

    /**
     * @var GetAuthorizedCredit $request
     * @access public
     */
    public $request = null;

    /**
     * @param GetAuthorizedCredit $request
     * @access public
     */
    public function __construct($request)
    {
      $this->request = $request;
    }

}
