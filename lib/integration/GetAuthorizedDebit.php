<?php

namespace ERede\Acquiring\Integration;

class GetAuthorizedDebit
{

    /**
     * @var GetAuthorizedDebit $request
     * @access public
     */
    public $request = null;

    /**
     * @param GetAuthorizedDebit $request
     * @access public
     */
    public function __construct($request)
    {
      $this->request = $request;
    }

}
