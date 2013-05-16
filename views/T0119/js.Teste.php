<?php

//Instancia Classe
$conn      =   "emporium";
$obj       =   new models_T0119();
$user      =   $_SESSION['user'];


 $LojasGrupos=$obj->retornaGruposAprovacaoUsuario($user);
 
 // print_r($LojasGrupos);
 
 $l=count($LojasGrupos['Loja']);

 $CondSQL=" ( ";
 for($i=0;$i<$l;$i++){
     
     // verifica se nao é o primeiro registro
     if($i)
        // adiciona "OR" na condicao
        $CondSQL.=" OR " ;
     
     
     // monta condicao do SQL
     $CondSQL.="( T006_codigo=".$LojasGrupos['Loja'][$i]." " ;
     $CondSQL.=" AND ";
     $CondSQL.=" T117_codigo in (".$LojasGrupos['Tipo'][$i]." ) ) " ;
    
    
 }
 $CondSQL.=" ) ";
 
 echo $CondSQL ; 

     
// echo $RetornoDetalhes = $obj->retornaTiposFilhos(4);

# echo $RetornoDetalhes;
#$RetornoDetalhes = $objEMP->ConsultaDetalhesLoteLoja(3,2532);

?>


  
