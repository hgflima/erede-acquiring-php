<?php

include("KomerciWcf.php");

$request = new QueryRequest();
$request->Filiacao            = "12341088";
$request->Senha               = "4913bb24a0284954be72c4258e229b86";
$request->Tid                 = "310";


$auth = new Query($request);

$k = new KomerciWcf(array("trace" => 1, "exception" => 0), "http://scommerce.userede.com.br/Redecard.Komerci.External.WcfKomerci/KomerciWcf.svc?wsdl");

try {

  $result = $k->Query($auth);
  echo "\nmsgret: " . $result->QueryResult->Msgret;

} catch(Exception $e) {}

echo "\nrequest: " . $k->__getLastRequest();
echo "\nresponse: " . $k->__getLastResponse();


?>
