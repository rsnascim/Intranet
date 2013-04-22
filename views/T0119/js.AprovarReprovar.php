<?php

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);
$obj       =   new models_T0119();
$user      =   $_SESSION['user'];

$arrLote    =   $_REQUEST['arrLote'];
$arrLoja    =   $_REQUEST['arrLoja'];
$arrTipo    =   $_REQUEST['arrTipo'];

// Acao = 2 Aprovar // 7 = Reprovar
$Acao      = $_REQUEST['Acao']; 

$DataHora=date("d/m/Y H:i:s");

$qtd        =   count($arrLote);

for($i=0;$i<$qtd;$i++)
{
    $arrStatus = array( "aprovacao_status_id" =>$Acao
                       ,"aprovacao_data"      =>$DataHora
                       ,"aprovacao_usuario"   =>$user
                      );

    $Tabela     = "davo_ccu_lote";

    $Delim     = "lote_numero=$arrLote[$i] AND store_key=$arrLoja[$i]";

    $Retorno   = $objEMP->altera($Tabela, $arrStatus, $Delim) ;

    if($Retorno)
    {
        $DigLoja   = $obj->calculaDigitoMod11($arrLoja[$i],1,100);
        $LojaCD    = $arrLoja[$i].$DigLoja; // loja Com Digito

        $arrStatus = array("T116_aprovacao_status_id" =>$Acao
                          ,"T116_aprovacao_data"      =>$DataHora
                          ,"T004_login"               =>$user
                          );

        $Tabela    = "T116_ccu_lote";
        $Delim     = "T116_lote=$arrLote[$i] AND T006_codigo=$LojaCD";

        $Retorno   = $obj->altera($Tabela, $arrStatus, $Delim) ;

    }

}
echo $Retorno;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
