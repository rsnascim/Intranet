<?php

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);
$obj       =   new models_T0119();

$Lote      = $_REQUEST['Lote'];
$Loja      = $_REQUEST['Loja'];

$Lote=234;
$Loja=2;
  
$DataHora=date("d/m/Y H:i:s");

$arrStatus = array("aprovacao_status_id"=>2,"aprovacao_data"=>$DataHora);
$Tabela    = "davo_ccu_lote";
$Delim     = "lote_numero=$Lote AND store_key=$Loja";

$Retorno   = $objEMP->altera($Tabela, $arrStatus, $Delim) ;

if($Retorno)
{
    $DigLoja   = $obj->calculaDigitoMod11($Loja,1,100);
    $LojaCD    = $Loja.$DigLoja; // loja Com Digito
    $arrStatus = array("T116_status_aprovacao"=>2);
    $Tabela    = "T116_ccu_lote";
    $Delim     = "T116_lote=$Lote AND T006_codigo=$LojaCD";
}
  
#echo 

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
