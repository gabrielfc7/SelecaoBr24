<?php
class BitrixConn
{
    /**
     * Write data to log file.
     *
     * @param mixed $data
     * @param string $title
     *
     * @return bool
     */
    public function writeToLog($data, $title = '') {
        $log = "\n------------------------\n";
        $log .= date("Y.m.d G:i:s") . "\n";
        $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
        $log .= print_r($data, 1);
        $log .= "\n------------------------\n";
        file_put_contents(getcwd() . '/hook.log', $log, FILE_APPEND);
        return true;
    }

    public function ConnWH($queryData, $queryUrl, $ssl_verify) {
        
        $queryUrl1 = 'https://b24-gdmg97.bitrix24.com.br/rest/1/2qiotwgwavymgnat/'.$queryUrl;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => $ssl_verify,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl1,
        CURLOPT_POSTFIELDS => $queryData,
        ));


        $result = curl_exec($curl);
        curl_close($curl);

        return $result;

   }
   
   public function NewCompany($cnpj){
    
    $queryUrl = 'crm.company.list';
    $queryData = http_build_query(array(

            'filter' => [ "UF_CRM_1588503398" => $cnpj ],
            'select' => [ "UF_CRM_1588548671" ]
        ));
    $result = BitrixConn::ConnWH($queryData, $queryUrl, 0) ;
    $result = json_decode($result, 1);
    BitrixConn::writeToLog($result, 'LIST COMPANY AND CHECK IF EXISTS');

    if ($result['result']==NULL) {
        return 0;
    }
    else
        return $result['result'][0]['ID'];
   }

   public function NewContact($cpf){
    
    $queryUrl = 'crm.contact.list';
    $queryData = http_build_query(array(

            'filter' => [ "UF_CRM_1588503377" => $cpf ],
            'select' => [ "ID" ]
        ));
    $result = BitrixConn::ConnWH($queryData, $queryUrl, 0) ;
    $result = json_decode($result, 1);
    BitrixConn::writeToLog($result, 'LIST CONTACT AND CHECK IF EXISTS');
    
    if ($result['result']==NULL) {
        return 0;
    }
    else{
        return $result['result'][0]['ID'];
    }
       
   }

   public function NewDeal($idDeal){
    
        $queryUrl = 'crm.deal.list';
        $queryData = http_build_query(array(

                'filter' => [ "ID" => $idDeal ],
                'select' => [ "COMPANY_ID",  "OPPORTUNITY"]
            ));
        $result = BitrixConn::ConnWH($queryData, $queryUrl, 0) ;
        $result = json_decode($result, 1);
        BitrixConn::writeToLog($result, 'GET DEAL DATA');
        
        $id_company = $result['result'][0]['COMPANY_ID'];
        $newAmount = $result['result'][0]['OPPORTUNITY'];
        $queryUrl = 'crm.company.list';
        $queryData = http_build_query(array(
    
                'filter' => [ "ID" => $id_company ],
                'select' => [ "UF_CRM_1588548671", "ID" ]
            ));
        $result = BitrixConn::ConnWH($queryData, $queryUrl, 0) ;
        $result = json_decode($result, 1);
        BitrixConn::writeToLog($result, 'FIND COMPANY AMOUNT');

        $amount = $result['result'][0]['UF_CRM_1588548671'] + $newAmount;
        $company_amount_id = $result1['result'][0]['ID'];
        $queryUrl = 'crm.company.update';
        // Set the data for the operation
        $queryData = http_build_query(array(
            'ID' => $id_company,
            'fields' => array(
            "UF_CRM_1588548671" => $amount,
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


   //USAR APENAS UMA VEZ 
    /* 
    public function creatFields(){

        $queryUrl = 'crm.contact.userfield.add';
        $queryData = http_build_query(array(
            'fields' => array(
                "FIELD_NAME" => "CPF",
                "EDIT_FORM_LABEL" => "CPF",
                "LIST_COLUMN_LABEL" => "CPF",
                "USER_TYPE_ID" => "string",
                "XML_ID" => "CPF"
            )));
        $result = BitrixConn::ConnWH($queryData, $queryUrl, 0) ;
        $result = json_decode($result, 1);
        BitrixConn::writeToLog($result, 'CREAT FIELD');
    }
*/
}
?>