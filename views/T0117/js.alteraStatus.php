<<<<<<< HEAD
<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/04/2013 Roberta Schimidt    
 * Descrição: Incluir Executores RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

$conn   = "";
$obj    = new models_T0117();



$codRM      =    $_REQUEST["codRM"];
$status     =    $_REQUEST["status"];


if($status == 3){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 3);
   $delim  =   "T113_codigo    =   ".$codRM;
    
  //echo $obj->altera($tabela, $campos, $delim);

   
}

elseif($status  ==  2){
    
    foreach ($obj->retornaExecGeral($codRM) as $cpsExec => $vlrExec) {
        
        $obj->enviaEmailExec($vlrExec["Login"], $codRM, $vlrExec["Tipo"]);
    }
    
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 2);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);
   
   
    
}

?>
=======
<?php

/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 03/04/2013 Roberta Schimidt    
 * Descrição: Incluir Executores RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

$conn   = "";
$obj    = new models_T0117();



$codRM      =    $_REQUEST["codRM"];
$status     =    $_REQUEST["status"];


if($status == 3){
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 3);
   $delim  =   "T113_codigo    =   ".$codRM;
    
  echo $obj->altera($tabela, $campos, $delim);

   
}

elseif($status  ==  2){
    
    foreach ($obj->retornaExecGeral($codRM) as $cpsExec => $vlrExec) {
        
        $obj->enviaEmailExec($vlrExec["Login"], $codRM, $vlrExec["Tipo"]);
    }
    
    
   $tabela =   "T113_requisicao_mudanca";
   $campos =   array("T113_status" => 2);
   $delim  =   "T113_codigo    =   ".$codRM;
    
   $obj->altera($tabela, $campos, $delim);
   
   
    
}

?>
<<<<<<< HEAD
=======
>>>>>>> d90d2b73efaeacbcde147b9fe7e80abb8699a8e7
>>>>>>> f648e5c32fca1655877a666bab49a8d3bbd0cfe0
