<?php
require_once ('listar.php');
    $i = 0;
    $x = $result['result'] ?? 0;
    if($x == 0){
        
    }
    else{
        $x = count($result['result']);
        for ($i=0; $i < $x; $i++) { 
            echo '<tr>';
            echo '<td>' .$result['result'][$i]['NAME']. '</td>' ;
            echo '<td>' .$result['result'][$i]['LAST_NAME']. '</td>' ;
            echo '<td>' .$result['result'][$i]['UF_CRM_1588503377']. '</td>' ;
            echo '<td>' .$result['result'][$i]['PHONE'][0]['VALUE']. '</td>' ;
            echo '<td>' .$result['result'][$i]['EMAIL'][0]['VALUE']. '</td>' ;
            echo '</tr>';
        }

    }
?>
