<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 12/03/2013 por Roberta Schimidt                               
// * Descrição: Areas de Negocio - Deletar
// * Entrada:   
// * Origens:   
//           
//**************************************************************************

$conn   =   "";
$obj    =   new models_T0117();    



$tabela = "T113_requisicao_mudanca";
$delim = "T113_codigo = ".$_GET["codRM"];


$deletarTab = $obj->excluir($tabela, $delim);


?>
