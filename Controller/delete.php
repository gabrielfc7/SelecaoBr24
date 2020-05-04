<?php
require_once ('../Model/bitrixConn.php');

$defaults = array('CNPJ' => '', 'CPF' => '');
$id_contact = 0;
$id_company = 0;
if (array_key_exists('saved', $_REQUEST)) {
    $defaults = $_REQUEST;
    BitrixConn:: writeToLog($_REQUEST, 'webform result');
    if ($_REQUEST['CNPJ'] != '') {
        $id_company = BitrixConn::NewCompany($_REQUEST['CNPJ']);

        if ($id_company == 0) {

            echo '<meta http-equiv="refresh" content="0;url=../View/error.html">';
        }
        else{
            // Set url for webhook and operation UP COMPANY
            $queryUrl = 'crm.company.delete';
            // Set the data for the operation
            $queryData = http_build_query(array(
                'ID' => $id_company
            ));
        
            // Execution  and save a log
            $result = BitrixConn::ConnWH($queryData,$queryUrl,0);
            $result = json_decode($result, 1);
            BitrixConn:: writeToLog($result, 'DELETED COMPANY');
            $company = $id_company;
        
            if (array_key_exists('error', $result)) 
            echo '<meta http-equiv="refresh" content="0;url=../View/error.html">';
            
            //end of first operation DELETE a company
        }
    }
    
    if ($_REQUEST['CPF'] != '') {
        $id_contact = BitrixConn::NewContact($_REQUEST['CPF']);

        if ($id_contact == 0){

            echo '<meta http-equiv="refresh" content="0;url=../View/error.html">';

        }
        else{
            // Set url for webhook and operation DELETE CONTACT
            $queryUrl = 'crm.contact.delete';
            // Set the data for the operation
            $queryData = http_build_query(array(
                'ID' => $id_contact
            ));
        
            // Execution  and save a log
            $result = BitrixConn::ConnWH($queryData,$queryUrl,0);
            $result = json_decode($result, 1);
            BitrixConn:: writeToLog($result, 'DELETED CONTACT');
            $contact = $result['result'];
            $newcontact = false;

            if (array_key_exists('error', $result)) 
            echo '<meta http-equiv="refresh" content="0;url=../View/error.html">';
            //end of second operation DELETE CONTACT
        }
    }

    echo '<meta http-equiv="refresh" content="0;url=../View/success.html">';     
}
?>