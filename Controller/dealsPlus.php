<?php
require_once ('../Model/bitrixConn.php');
print_r($_REQUEST);
BitrixConn:: writeToLog($_REQUEST, 'incoming');

$result = $_REQUEST;
BitrixConn::NewDeal($result['data']['FIELDS']['ID']);

?>