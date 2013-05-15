<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 10/04/2013 Roberta Schimidt    
 * Descrição: Enviar E-mail Comitê
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/
$obj = new models_T0117();

$membrosComite  =   $obj->retornaComite();

foreach ($membrosComite as $cpsCom => $valCom) {
    
$codRM  = $_POST["codRM"];
$tituloRM   =   $_POST["titulo"];
$nome   = utf8_encode($valCom["Nome"]);

        $to         = $valCom["Email"]; 
        $from       = "web@davo.com.br"; 
        $subject    = "Aviso de RM ao Comite";
        
        $html   =   $nome.'<br>';
        $html   .=   'Há disponível uma Requisição de Mundança para aprovação.';
        $html   .=   'Requisição Nº '. $codRM.' - '.$tituloRM;
    
        $headers  = "From: $from\r\n"; 
        $headers .= "Content-type: text/html\r\n"; 
        $headers .= "Cc: web@davo.com.br";
    
       
        
        mail($to, $subject, $html, $headers); 


}

echo $nome;






?>
