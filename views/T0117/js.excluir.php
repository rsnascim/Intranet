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

$tabela1    =   "T004_T113";
$delim1     =   "T113_codigo = ".$_GET["codRM"];

$obj->excluir($tabela1, $delim1);


$tabela2    =    "T119_executores_externos";

$delim2     =    "T113_codigo   =   ". $_GET["codRM"];


$obj->excluir($tabela2, $delim2);


$tabela3    =    "T113_T118";
$delim3     =   "T113_codigo    =   ".$_GET["codRM"];

$obj->excluir($tabela3, $delim3);

$tabela = "T113_requisicao_mudanca";
$delim = "T113_codigo = ".$_GET["codRM"];


$obj->excluir($tabela, $delim);



?>
