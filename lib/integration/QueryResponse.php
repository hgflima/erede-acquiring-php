<?php

namespace ERede\Acquiring\Integration;

class QueryResponse
{

    /**
     * @var QueryResponse $QueryResult
     * @access public
     */
    public $QueryResult = null;

    /**
     * @param QueryResponse $QueryResult
     * @access public
     */
    public function __construct($QueryResult)
    {
      $this->QueryResult = $QueryResult;
    }

}
