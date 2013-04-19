<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 13/03/2013 Roberta Schimidt    
 * Descrição: Incluir Executores RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/
$conn   = "";
$obj    = new models_T0117();


if ($_REQUEST['cod'] == 2) {
    
 $codRM      =  $_REQUEST["codRM"];  
 $login      =  $_REQUEST["login"];  
 
 $tabela     =   "T004_T113";
 
 $funcRM =0;
 foreach ($obj->retornaFuncionariosRM($login) as $cps => $val) {
     $funcRM++;
 } 

if($funcRM == 0){
    
    $tabelaFuncRM   =    "T004_T009";
    $camposFuncRM   =    array("T004_Login"     =>  $login
                              ,"T009_codigo"    =>  57     );
    
    $obj->inserir($tabelaFuncRM, $camposFuncRM);
    
}
        
        $user       =   $login;
        
        $campos =   array(
                            "T113_codigo"           =>  $codRM
                         ,  "T004_login"            =>  $login
                         ,  "T004_T113_tipo"        =>  2               //Tipo 1 = Responsaveis RM
                         );

$obj->inserir($tabela, $campos); 

        } elseif($_REQUEST["cod"]   ==  1){
            
        $codRM      =  $_REQUEST["codRM"];  
        $login      =  $_REQUEST["login"];
        
         $funcRM =0;
        foreach ($obj->retornaFuncionariosRM($login) as $cps => $val) {
            $funcRM++;
        } 

       if($funcRM == 0){

           $tabelaFuncRM   =    "T004_T009";
           $camposFuncRM   =    array("T004_Login"     =>  $login
                                     ,"T009_codigo"    =>  57     );

           $obj->inserir($tabelaFuncRM, $camposFuncRM);

       }
            
        $tabela     =   "T004_T113";
        
        $user       =   $login;
        
        $campos =   array(
                            "T113_codigo"           =>  $codRM
                         ,  "T004_login"            =>  $login
                         ,  "T004_T113_tipo"        =>  1               //Tipo 1 = Responsaveis RM
                         );
        
  
       $obj->inserir($tabela, $campos);
       
       } elseif($_REQUEST["cod"]    ==  3){
           
            $tabela     =   "T119_executores_externos";
            $codRM      =  $_REQUEST["codRM"];  
            $nome       =  $_REQUEST["nome"];
            $tel        =  $_REQUEST["tel"];
            $notif      =  $_REQUEST["notif"];
            $email      =  $_REQUEST["email"]; 
            
        
        $campos =   array(
                            "T113_codigo"      =>  $codRM
                         ,  "T119_nome"        =>  $nome
                         ,  "T119_email"       =>  $email
                         ,  "T119_telefone"    =>  $tel
                         ,  "T119_notificado"  =>  $notif
                         );
        
       
          $obj->inserir($tabela, $campos);
           
       } elseif ($_REQUEST["cod"]   ==  4) {
       
           $tabela  =   "T113_T118";
           $codRM   =  $_REQUEST["codRM"];
           $login   =  $_REQUEST["login"];
           $parecer =  $_REQUEST["parecer"];
           $aprovar =  $_REQUEST["aprovar"];         
           $user       =   $login;
  
        $campos =   array(
                            "T113_codigo"               =>  $codRM
                         ,  "T004_login"                =>  $login
                         ,  "T113_T118_voto"            =>  $aprovar
                         ,  "T113_T118_parecer"         => $parecer   
                         ,  "T113_T118_data"            => date("Y-m-d")
                         );
        
  
       $obj->inserir($tabela, $campos);
       
       }
       

?>
