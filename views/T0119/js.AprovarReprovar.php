<?php

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);
$obj       =   new models_T0119();
$user      =   $_SESSION['user'];

$Lote      = $_REQUEST['Lote'];
$Loja      = $_REQUEST['Loja'];
// Acao = 2 Aprovar // 7 = Reprovar
$Acao      = $_REQUEST['Acao']; 

$DataHora=date("d/m/Y H:i:s");

$arrStatus = array( "aprovacao_status_id" =>$Acao
                   ,"aprovacao_data"      =>$DataHora
                   ,"aprovacao_usuario"   =>$user
                  );

$Tabela    = "davo_ccu_lote";
$Delim     = "lote_numero=$Lote AND store_key=$Loja";

$Retorno   = $objEMP->altera($Tabela, $arrStatus, $Delim) ;

if($Retorno)
{
    $DigLoja   = $obj->calculaDigitoMod11($Loja,1,100);
    $LojaCD    = $Loja.$DigLoja; // loja Com Digito
    
    $arrStatus = array("T116_aprovacao_status_id" =>$Acao
                      ,"T116_aprovacao_data"      =>$DataHora
                      ,"T004_login"               =>$user
                      );
    
    $Tabela    = "T116_ccu_lote";
    $Delim     = "T116_lote=$Lote AND T006_codigo=$LojaCD";
    
    $Retorno   = $obj->altera($Tabela, $arrStatus, $Delim) ;
    
}
  
echo $Retorno;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
