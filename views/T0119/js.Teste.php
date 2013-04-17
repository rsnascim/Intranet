<?php

//Instancia Classe
$conn      =   "emporium";
$obj       =   new models_T0119();
$user      =   $_SESSION['user'];


 ECHO $RetornoDetalhes = $obj->retornaGruposAprovacaoUsuario($user);
// echo $RetornoDetalhes = $obj->retornaTiposFilhos(4);

# echo $RetornoDetalhes;
#$RetornoDetalhes = $objEMP->ConsultaDetalhesLoteLoja(3,2532);

?>


  
