<<<<<<< HEAD
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
        $login      =  $_POST["login"];  
 
        $tabela     =   "T004_T113";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login'"; 
        $delim  .=   "AND T004_T113_tipo    =   2";        


$obj->excluir($tabela, $delim); 

        } elseif($_REQUEST["cod"]   ==  1){
            
        $codRM      =  $_REQUEST["codRM"];  
        $login      =  $_REQUEST["login"];
            
        $tabela     =   "T004_T113";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login' "; 
        $delim  .=   "AND T004_T113_tipo    =   1" ;
    
       $obj->excluir($tabela, $delim);
       
       } elseif($_REQUEST["cod"]    ==  3){
           
           
            $tabela     =   "T119_executores_externos";
            $codRM      =  $_REQUEST["codRM"];  
            $codExecExt  =   $_REQUEST["codExecExt"];
           
        $delim  =  "T113_codigo  =   $codRM";
        $delim  .=  "AND T119_codigo    =   $codExecExt";
       
          $obj->excluir($tabela, $delim);
           
       } elseif ($_REQUEST["cod"]   ==  4) {
       
        $codRM      =  $_REQUEST["codRM"];  
        $login      =  $_REQUEST["login"];
            
        $tabela     =   "T113_T118";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login' "; 
       
        $obj->excluir($tabela, $delim);
           
           
}
?>
=======
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
        $login      =  $_POST["login"];  
 
        $tabela     =   "T004_T113";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login'"; 
        $delim  .=   "AND T004_T113_tipo    =   2";        


$obj->excluir($tabela, $delim); 

        } elseif($_REQUEST["cod"]   ==  1){
            
        $codRM      =  $_REQUEST["codRM"];  
        $login      =  $_REQUEST["login"];
            
        $tabela     =   "T004_T113";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login' "; 
        $delim  .=   "AND T004_T113_tipo    =   1" ;
    
       $obj->excluir($tabela, $delim);
       
       } elseif($_REQUEST["cod"]    ==  3){
           
           
            $tabela     =   "T119_executores_externos";
            $codRM      =  $_REQUEST["codRM"];  
            $codExecExt  =   $_REQUEST["codExecExt"];
           
        $delim  =  "T113_codigo  =   $codRM";
        $delim  .=  "AND T119_codigo    =   $codExecExt";
       
          $obj->excluir($tabela, $delim);
           
       } elseif ($_REQUEST["cod"]   ==  4) {
       
        $codRM      =  $_REQUEST["codRM"];  
        $login      =  $_REQUEST["login"];
            
        $tabela     =   "T113_T118";
        
        $delim   =   "T113_codigo       =    $codRM ";
        $delim  .=   "AND T004_login        =   '$login' "; 
       
        $obj->excluir($tabela, $delim);
           
           
}
?>
>>>>>>> cbc7580f5913f6eeed94f050bbec978bfb0696ff
