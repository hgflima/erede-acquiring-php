<?php

namespace ERede\Acquiring\Integration;

class Query
{

    /**
     * @var QueryRequest $request
     * @access public
     */
    public $request = null;

    /**
     * @param QueryRequest $request
     * @access public
     */
    public function __construct($request)
    {
      $this->request = $request;
    }

}
