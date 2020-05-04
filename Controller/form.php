<?php
require_once ('../Model/bitrixConn.php');

$defaults = array('first_name' => '', 'last_name' => '', 'phone' => '', 'email' => '');
$id_contact = 0;
$id_company = 0;
if (array_key_exists('saved', $_REQUEST)) {
    $defaults = $_REQUEST;
    BitrixConn:: writeToLog($_REQUEST, 'webform result');
    //BitrixConn::creatFields();

    $id_company = BitrixConn::NewCompany($_REQUEST['CNPJ']);
    if ($id_company == 0) {
            // Set url for webhook and operation ADD COMPANY
        $queryUrl = 'crm.company.add';
        // Set the data for the operation
        $queryData = http_build_query(array(
            'fields' => array(
            "TITLE" =>  $_REQUEST['nome_da_empresa'],
            "UF_CRM_1588503398" => $_REQUEST['CNPJ']
        ),
        'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));

        // Execution  and save a log
        $result = BitrixConn::ConnWH($queryData,$queryUrl,0);
        $result = json_decode($result, 1);
        BitrixConn:: writeToLog($result, 'ADD COMPANY');
        $company = $result['result'];
        $newcompany = true;

        if (array_key_exists('error', $result)) 
        echo '<meta http-equiv="refresh" content="1;url=../View/error.html">';
        //end of first operation add a company
    }
    else{
        // Set url for webhook and operation UP COMPANY
        $queryUrl = 'crm.company.update';
        // Set the data for the operation
        $queryData = http_build_query(array(
            'ID' => $id_company,
            'fields' => array(
            "TITLE" =>  $_REQUEST['nome_da_empresa'],
        ),
        'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));
    
        // Execution  and save a log
        $result = BitrixConn::ConnWH($queryData,$queryUrl,0);
        $result = json_decode($result, 1);
        BitrixConn:: writeToLog($result, 'UP COMPANY');
        $company = $id_company;
        $newcompany = false;

        if (array_key_exists('error', $result)) 
        echo '<meta http-equiv="refresh" content="0;url=../View/error.html">';
        
        //end of first operation up a company
    }

    $id_contact = BitrixConn::NewContact($_REQUEST['CPF']);

    if ($id_contact == 0){
        // Set url for webhook and operation ADD CONTACT
        $queryUrl = 'crm.contact.add';
        // Set the data for the operation
        $queryData = http_build_query(array(
        'fields' => array(
            "NAME" => $_REQUEST['first_name'], 
            "LAST_NAME" => $_REQUEST['last_name'], 
            "OPENED" =>"Y", 
            "UF_CRM_1588503377" => $_REQUEST['CPF'],
            "PHONE" => array(array("VALUE" => $_REQUEST['phone'], "VALUE_TYPE" => "WORK" )),
            "EMAIL" => array(array("VALUE" => $_REQUEST['email'], "VALUE_TYPE" => "WORK" ))
        ),
        'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));
    
        // Execution  and save a log
        $result = BitrixConn::ConnWH($queryData,$queryUrl,0);
        $result = json_decode($result, 1);
        BitrixConn:: writeToLog($result, 'ADD CONTACT');
        $contact = $result['result'];
        $newcontact = true;

        if (array_key_exists('error', $result)) 
        echo '<meta http-equiv="refresh" content="0;url=../View/error.html">';
        //end of second operation ADD CONTACT
    }
    else{
        // Set url for webhook and operation UP CONTACT
        $queryUrl = 'crm.contact.update';
        // Set the data for the operation
        $queryData = http_build_query(array(
            'ID' => $id_contact,
            'fields' => array(
            "NAME" => $_REQUEST['first_name'], 
            "LAST_NAME" => $_REQUEST['last_name'], 
            "OPENED" =>"Y", 
            "PHONE" => array(array("VALUE" => $_REQUEST['phone'], "VALUE_TYPE" => "WORK" )),
            "EMAIL" => array(array("VALUE" => $_REQUEST['email'], "VALUE_TYPE" => "WORK" ))
        ),
        'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));
    
        // Execution  and save a log
        $result = BitrixConn::ConnWH($queryData,$queryUrl,0);
        $result = json_decode($result, 1);
        BitrixConn:: writeToLog($result, 'UP CONTACT');
        $contact = $result['result'];
        $newcontact = false;

        if (array_key_exists('error', $result)) 
        echo '<meta http-equiv="refresh" content="0;url=../View/error.html">';
        //end of second operation UP CONTACT
    }

    if ($newcontact == true || $newcompany == true) {
        // Set url for webhook and operation ADD CONTACT TO COMPANY
        $queryUrl = 'crm.company.contact.add';
        // Set the data for the operation
        $queryData = http_build_query(array(
            'ID' => $company,
            'fields' => array(
                "CONTACT_ID" => $id_contact
            )
        ));

        // Execution  and save a log
        $result = BitrixConn::ConnWH($queryData,$queryUrl,0);
        $result = json_decode($result, 1);
        BitrixConn:: writeToLog($result, 'ADD CONTACT TO COMPANY');

        if (array_key_exists('error', $result)) 
        echo '<meta http-equiv="refresh" content="0;url=../View/error.html">';
        //end of second operation ADD CONTACT
    }

    echo '<meta http-equiv="refresh" content="0;url=../View/success.html">';     
}
?>
