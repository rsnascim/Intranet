<<<<<<< HEAD
<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/04/2013 Roberta Schimidt    
 * Descrição: Altera status RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

$conn   = "";
$obj    = new models_T0117();



$codRM      =    $_REQUEST["codRM"];
$status     =    $_REQUEST["status"];
$tituloRM   =   $_POST["titulo"];


if(($status == 3)||($status == 4)||($status == 5)||($status == 6)||($status == 7)){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => $status);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);

   
}

elseif($status  ==  2){
    
    foreach ($obj->retornaExecGeral($codRM) as $cpsExec => $vlrExec) {
        
        $obj->enviaEmailExec($vlrExec["Login"], $codRM, $vlrExec["Tipo"]);
        
    }
    
   $obj->enviaEmailGM($codRM, $tituloRM);
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 2);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);
   
   
    
}

?>
