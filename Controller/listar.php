<?php

require_once ('../Model/bitrixConn.php'); 
$queryUrl = 'crm.contact.list';
$queryData = http_build_query(array(
           
   'select' => [ "ID", "NAME", "LAST_NAME", "UF_CRM_1588503377", "PHONE", "EMAIL"]
));
$result = BitrixConn::ConnWH($queryData, $queryUrl, 0) ;
$result = json_decode($result, 1);
BitrixConn::writeToLog($result, 'LIST CONTACS');
          
$queryUrl = 'crm.company.list';
$queryData = http_build_query(array(
          
'select' => [ "ID","TITLE", "UF_CRM_1588503398",'UF_CRM_1588548671']
));
$result1 = BitrixConn::ConnWH($queryData, $queryUrl, 0) ;
$result1 = json_decode($result1, 1);
BitrixConn::writeToLog($result1, 'LIST COMPANIES');

echo '<meta http-equiv="refresh" content="2;url=../View/listarMIX.php">';
?>