<?php
require_once ('../Model/bitrixConn.php');
print_r($_REQUEST);
BitrixConn:: writeToLog($_REQUEST, 'incoming');

$result = $_REQUEST;

$queryUrl = 'crm.deal.get';
$queryData = http_build_query(array(
        'ID' => $result['data']['FIELDS']['ID']
    ));

    $deal = BitrixConn::ConnWH($queryData, $queryUrl, 0) ;
    $deal = json_decode($deal, 1);
    BitrixConn::writeToLog($deal, 'GET DEAL DATA');

if($deal['result']['STAGE_ID'] == 'WON')
    BitrixConn::NewDeal($result['data']['FIELDS']['ID']);
?>