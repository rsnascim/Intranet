<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> dev-roberta
<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/04/2013 Roberta Schimidt    
<<<<<<< HEAD
 * Descrição: Incluir Executores RM
=======
 * Descrição: Altera status RM
>>>>>>> dev-roberta
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

$conn   = "";
$obj    = new models_T0117();



$codRM      =    $_REQUEST["codRM"];
$status     =    $_REQUEST["status"];
<<<<<<< HEAD


if($status == 3){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 3);
   $delim  =   "T113_codigo    =   ".$codRM;
    
  echo $obj->altera($tabela, $campos, $delim);
=======
$tituloRM   =   $_POST["titulo"];


if(($status == 3)||($status == 4)||($status == 5)||($status == 6)||($status == 7)){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => $status);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);
>>>>>>> dev-roberta

   
}

elseif($status  ==  2){
    
    foreach ($obj->retornaExecGeral($codRM) as $cpsExec => $vlrExec) {
        
<<<<<<< HEAD
        $obj->enviaEmailExec($vlrExec["Login"], $codRM, $vlrExec["Tipo"]);
    }
    
=======
        $obj->enviaEmailExec($vlrExec["Login"], $codRM, $vlrExec["Tipo"], $tituloRM);
        
    }
    
   $obj->enviaEmailGM($codRM, $tituloRM);
>>>>>>> dev-roberta
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 2);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);
   
   
    
}

?>
