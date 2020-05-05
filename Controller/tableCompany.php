<?php
require_once ('listar.php');

    $y = $result['result'] ?? 0;
    if($y == 0){
        
    }
    else{
        $y =  $result['total'];
        for ($i=0; $i < $y; $i++){
     
            echo '<tr>';
            echo '<td>' .$result1['result'][$i]['TITLE']. '</td>' ;
            echo '<td>' .$result1['result'][$i]['UF_CRM_1588503398']. '</td>' ;
            echo '<td>' .$result1['result'][$i]['UF_CRM_1588548671']. '</td>' ;
            echo '</tr>';
    }
}
?>
