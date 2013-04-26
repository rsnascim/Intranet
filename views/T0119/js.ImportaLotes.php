<?php

function conectaIntranet()
{
    try
    {
            ob_start();
            return $db = new PDO('mysql:host=10.2.1.41;dbname=Satelite', 'root', '');

    }catch (Exception $e) {
            $db->rollBack();
            echo "Failed: " . $e->getMessage();
    }
}

function conectaEmporium()
{
    try
    {
            ob_start();
            return $db = new PDO('mysql:host=10.2.1.10;dbname=emporium', 'root', 'emporium');

    }catch (Exception $e) {
            $db->rollBack();
            echo "Failed: " . $e->getMessage();
    }
}

function calculaDigitoMod11($NumDado, $NumDig, $LimMult)
{
    $Dado = $NumDado;
    for($n=1; $n<=$NumDig; $n++)
    {
        $Soma = 0;
        $Mult = 2;

        for($i=strlen($Dado) - 1; $i>=0; $i--)
        {
            $Soma += $Mult * intval(substr($Dado,$i,1));
            if(++$Mult > $LimMult) $Mult = 2;
        }

        $Dado .= strval(fmod(fmod(($Soma * 10), 11), 10));
    }
    return substr($Dado, strlen($Dado)-$NumDig);        
} 

function retornaLotesDisponiveis(){
    $sql = "   SELECT l.store_key , l.lote_numero , l.tipo_codigo , l.aprovacao_status_id
                 FROM davo_ccu_lote l
                WHERE l.aprovacao_status_id in ( 0 )
           ";

    $db =       conectaEmporium();
    
    return $db->query($sql);    
}

function retornaLotesCancelados(){
    $sql = "   SELECT l.store_key , l.lote_numero , l.tipo_codigo , l.aprovacao_status_id , l.aprovacao_data
                 FROM davo_ccu_lote l
                WHERE l.aprovacao_status_id in ( 6 , 8 )
           ";

    $db =       conectaEmporium();
    
    return $db->query($sql);      
}

function insereIntranet(){
  $dados =   retornaLotesDisponiveis();
  $db    =   conectaIntranet();
  $dbEMP =   conectaEmporium();

  foreach($dados as $campos => $valores)
  {  
      $DigLoja = calculaDigitoMod11($valores['store_key'],1,100);
      $LojaCD  = $valores['store_key'].$DigLoja; // loja Com Digito
      $Loja    = $valores['store_key'];
      $Lote    = $valores['lote_numero'];
      $Tipo    = $valores['tipo_codigo'];
      $Status  = $valores['aprovacao_status_id'];
      
      // Verifica se é status = 0 e muda para 1
      if($Status==0)
        $Status=1;  
      
      $insere = $db->exec("INSERT INTO T116_ccu_lote (T006_codigo              , T116_lote  
                                                    , T116_aprovacao_status_id ,T117_codigo)
                                              VALUES ($LojaCD      , $Lote  
                                                    , $Status , $Tipo ) ");
      
     
      if($insere)
      {
            $atualiza = $dbEMP->exec("UPDATE davo_ccu_lote l
                                         SET l.aprovacao_status_id = $Status
                                       WHERE l.store_key           = $Loja
                                         AND l.lote_numero         = $Lote
                                     ");        
      }else{
        $atualiza = $dbEMP->exec("UPDATE davo_ccu_lote l
                           SET l.aprovacao_status_id = 9
                         WHERE l.store_key           = $Loja
                           AND l.lote_numero         = $Lote
                       ");        

      }
                
  }
}

function atualizaCanceladosIntranet(){
  $dadosC =   retornaLotesCancelados();
  $db    =   conectaIntranet();
  
  foreach($dadosC as $camposC => $valoresC)
  {     
      $DigLoja = calculaDigitoMod11($valoresC['store_key'],1,100);
      $LojaCD  = $valoresC['store_key'].$DigLoja; // loja Com Digito
     
      $Lote    = $valoresC['lote_numero'];
      $Tipo    = $valoresC['tipo_codigo'];
      $Status  = $valoresC['aprovacao_status_id'];
      $Data    = $valoresC['aprovacao_data'];
      
      $insere = $db->exec("INSERT INTO T116_ccu_lote (T006_codigo              , T116_lote  
                                                    , T116_aprovacao_status_id , T116_aprovacao_data
                                                    , T117_codigo)
                                              VALUES ($LojaCD      , $Lote  
                                                    , $Status , '$Data' 
                                                    , $Tipo ) ");
      
      if(!$insere)
      {
        // registro ja existe na Intranet, atualiza status para cancelado
        $atualiza = $db->exec("UPDATE T116_ccu_lote l
                                  SET l.T116_aprovacao_status_id = $Status
                                    , l.T116_aprovacao_data      = '$Data'
                                WHERE l.T006_codigo              = $LojaCD
                                  AND l.T116_lote                = $Lote
                                  AND l.T116_aprovacao_status_id = 1 /* somente em aprovacao */
                              ");        
      }
                
  }
  
}
echo 'Inicio Execucao';
echo '<BR>';
insereIntranet();
atualizaCanceladosIntranet();
echo 'Fim Execucao';
echo '<BR>';

// 

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
