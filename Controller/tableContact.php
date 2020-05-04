<?php
require_once ('listar.php');
    $i = 0;
    $x = count($result['result']);
    if($x == 0){
        
    }
    else
    do
    {
        echo '<tr>';
        echo '<td>' .$result['result'][$i]['NAME']. '</td>' ;
        echo '<td>' .$result['result'][$i]['LAST_NAME']. '</td>' ;
        echo '<td>' .$result['result'][$i]['UF_CRM_1588503377']. '</td>' ;
        echo '<td>' .$result['result'][$i]['PHONE'][0]['VALUE']. '</td>' ;
        echo '<td>' .$result['result'][$i]['EMAIL'][0]['VALUE']. '</td>' ;
        echo '</tr>';
        $i++;
    }while( $i < $x);
?>
