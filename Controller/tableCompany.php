<?php
require_once ('listar.php');

    $i = 0;
    $x = count($result1['result']);
    if($x == 0){
        
    }
    else
    do
    {
        echo '<tr>';
        echo '<td>' .$result1['result'][$i]['TITLE']. '</td>' ;
        echo '<td>' .$result1['result'][$i]['UF_CRM_1588503398']. '</td>' ;
        echo '<td>' .$result1['result'][$i]['UF_CRM_1588548671']. '</td>' ;
        echo '</tr>';
        $i++;
    }while( $i < $x);
?>
