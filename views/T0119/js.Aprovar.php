<?php

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);

$Lote      = $_REQUEST['Lote'];
$Loja      = $_REQUEST['Loja'];

$arrStatus = array("aprovacao_status_id"=>2);
$Tabela    = "davo_ccu_lote";
$Delim     = "lote_numero=$Lote AND store_key=$Loja";

echo $Retorno   = $objEMP->altera($Tabela, $arrStatus, $Delim) ;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
