<?php

namespace ERede\Acquiring\Integration;

class KomerciWcf extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     * @access private
     */
    private static $classmap = array(
      'GetAuthorizedCredit' => '\ERede\Acquiring\Integration\GetAuthorizedCredit',
      'Authorization' => '\ERede\Acquiring\Integration\Authorization',
      'ExcecaoAmigavel' => '\ERede\Acquiring\Integration\ExcecaoAmigavel',
      'GetAuthorizedDebit' => '\ERede\Acquiring\Integration\GetAuthorizedDebit',
      'VoidTransactionTID' => '\ERede\Acquiring\Integration\VoidTransactionTID',
      'Confirmation' => '\ERede\Acquiring\Integration\Confirmation',
      'ConfirmTxnTID' => '\ERede\Acquiring\Integration\ConfirmTxnTID',
      'QueryRequest' => '\ERede\Acquiring\Integration\QueryRequest',
      'QueryResponse' => '\ERede\Acquiring\Integration\QueryResponse',
      'HeaderClass' => '\ERede\Acquiring\Integration\HeaderClass',
      'RegistroClass' => '\ERede\Acquiring\Integration\RegistroClass',
      'AvsQueryClass' => '\ERede\Acquiring\Integration\AvsQueryClass',
      'ThreeDClass' => '\ERede\Acquiring\Integration\ThreeDClass',
      'GetAuthorizedCreditResponse' => '\ERede\Acquiring\Integration\GetAuthorizedCreditResponse',
      'GetAuthorizedDebitResponse' => '\ERede\Acquiring\Integration\GetAuthorizedDebitResponse',
      'VoidTransactionTIDResponse' => '\ERede\Acquiring\Integration\VoidTransactionTIDResponse',
      'ConfirmTxnTIDResponse' => '\ERede\Acquiring\Integration\ConfirmTxnTIDResponse',
      'Query' => '\ERede\Acquiring\Integration\Query');

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     * @access public
     */
    public function __construct(array $options = array(), $wsdl = 'Komerci.wsdl.xml')
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      
      parent::__construct($wsdl, $options);
    }

    /**
     * @param GetAuthorizedCredit $parameters
     * @access public
     * @return GetAuthorizedCreditResponse
     */
    public function GetAuthorizedCredit(GetAuthorizedCredit $parameters)
    {
      return $this->__soapCall('GetAuthorizedCredit', array($parameters));
    }

    /**
     * @param GetAuthorizedDebit $parameters
     * @access public
     * @return GetAuthorizedDebitResponse
     */
    public function GetAuthorizedDebit(GetAuthorizedDebit $parameters)
    {
      return $this->__soapCall('GetAuthorizedDebit', array($parameters));
    }

    /**
     * @param VoidTransactionTID $parameters
     * @access public
     * @return VoidTransactionTIDResponse
     */
    public function VoidTransactionTID(VoidTransactionTID $parameters)
    {
      return $this->__soapCall('VoidTransactionTID', array($parameters));
    }

    /**
     * @param ConfirmTxnTID $parameters
     * @access public
     * @return ConfirmTxnTIDResponse
     */
    public function ConfirmTxnTID(ConfirmTxnTID $parameters)
    {
      return $this->__soapCall('ConfirmTxnTID', array($parameters));
    }

    /**
     * @param Query $parameters
     * @access public
     * @return QueryResponse
     */
    public function Query(Query $parameters)
    {
      return $this->__soapCall('Query', array($parameters));
    }

}
