<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em:                
// * Descrição: 
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/

class models_T0119 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {        
        $insere = $this->exec($this->insere($tabela, $campos));
        
//       if($insere)
//            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
//       else
//            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
//       
       return $insere;
    }      
       
    public function altera($tabela,$campos,$delim)
    {              
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
      // echo $altera;
       return $altera;
    }  
    
    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
        
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!');
       
       return $exclui;
    }  
    
    public function ConsultaLotesLoja($filtroLoja, $filtroDtInicio, $filtroDtFim, $filtroStatusConsumo, $filtroStatusIntegracao, $filtroStatusAprovacao, $filtroRegistros)
    {   
        
        
        
        $sql="  SELECT l.store_key , l.lote_numero , l.start_time 
                     , l.pos_number , l.ticket_number
                     , l.amount , l.quantity_rows 
                     , t.tipo_codigo 
                     , sc.status_consumo_id     , sc.status_consumo_descricao     , l.consumo_data , l.consumo_agent_key
                     , si.status_integracao_id  , si.status_integracao_descricao  , l.integracao_data
                     , sa.status_aprovacao_id   , sa.status_aprovacao_descricao   , l.aprovacao_data , l.aprovacao_agent_key , l.aprovacao_usuario
                     , a.id , u.alternate_id, UPPER(a.name) name
                  FROM davo_ccu_lote l
                  INNER JOIN davo_ccu_tipo t                 ON (     t.tipo_codigo           = l.tipo_codigo          )
                  INNER JOIN davo_ccu_status_consumo    sc   ON (     sc.status_consumo_id    = l.consumo_status_id    )
                  INNER JOIN davo_ccu_status_integracao si   ON (     si.status_integracao_id = l.integracao_status_id )
                  INNER JOIN davo_ccu_status_aprovacao  sa   ON (     sa.status_aprovacao_id  = l.aprovacao_status_id  )                  
                  LEFT JOIN `user` u                         ON (     l.agent_key = u.agent_key )
                  LEFT JOIN agent a                          ON (     u.agent_key = a.agent_key )
                 WHERE 1    =   1";
                 
                 if(!empty($filtroLoja))
                    $sql   .=  " AND l.store_key                = $filtroLoja";
                 
                 if(!empty($filtroDtInicio)){
                     $filtroDtInicio=$this->formataData($filtroDtInicio);
                     $sql   .=  " AND l.start_time            >= '$filtroDtInicio 00:00:00'";
                 }
                    
                 
                 if(!empty($filtroDtFim)){
                     $filtroDtFim=$this->formataData($filtroDtFim); 
                     $sql   .=  " AND l.start_time            <= '$filtroDtFim 23:59:59'";
                 }

                 
                 if((!empty($filtroStatusConsumo))&&($filtroStatusConsumo<>"999"))
                    $sql   .=  " AND sc.status_consumo_id       = $filtroStatusConsumo";
                 
                 if((!empty($filtroStatusIntegracao))&&($filtroStatusIntegracao<>"999"))
                    $sql   .=  " AND si.status_integracao_id    = $filtroStatusIntegracao";
                 
                 if((!empty($filtroStatusAprovacao))&&($filtroStatusAprovacao<>"999"))
                    $sql   .=  " AND sa.status_aprovacao_id     = $filtroStatusAprovacao";
                 
                  $sql  .=  " ORDER BY l.start_time ";
                  
                  if(!empty($filtroRegistros))
                    $sql  .=  " LIMIT $filtroRegistros";

        return $this->query($sql) ; // ->fetchAll(PDO::FETCH....);
    }
    
    public function ConsultaLoteIntranet($Loja,$Lote,$CondSQL)
    {
        $sql=" SELECT 1
                 FROM T116_ccu_lote t
                WHERE t.T006_codigo   =  $Loja".$this->calculaDigitoMod11($Loja,1,100)
                ." AND t.T116_lote    =  $Lote
                   AND $CondSQL 
               LIMIT 1
             ";   
        
        $Retorno=$this->query($sql)->fetchAll(PDO::FETCH_COLUMN) ;
        return $Retorno[0];
        
    }
    
    public function ConsultaLote($Loja,$Lote)
    {
        $sql=" SELECT *
                 FROM davo_ccu_lote l
                WHERE l.store_key   = $Loja
                  AND l.lote_numero = $Lote
             ";   
        
        return $this->query($sql) ; // ->fetchAll(PDO::FETCH....);
        
    }
    
    public function ConsultaLotesDestino($Loja,$Lote)
    {
        $sql="    SELECT ld.*
                    FROM davo_ccu_lote l
                    JOIN davo_ccu_tipo t ON (      t.tipo_codigo = l.tipo_codigo 
                                              AND  t.consumivel = 1
                                            )
                    JOIN davo_ccu_lote_consumo c ON (     c.lote_numero_origem = l.lote_numero 
                                                      AND c.store_key_origem   = l.store_key                        
                                                    ) 
                    JOIN davo_ccu_lote ld ON (     ld.lote_numero = c.lote_numero_destino 
                                               AND ld.store_key   = c.store_key_destino                                  
                                             )  
                   WHERE l.lote_numero  = $Lote
                     AND l.store_key    = $Loja 
             ";   
        
        return $this->query($sql) ; // ->fetchAll(PDO::FETCH....);
        
    }
    
    public function ConsultaDetalhesLoteLoja($Loja,$Lote)
    {
        $sql="  SELECT d.sequence , d.plu_id , d.desc_plu , d.quantity , d.unit_price , d.amount
                  FROM davo_ccu_lote_detalhe d
                 where d.store_key   = $Loja
                   and d.lote_numero = $Lote
              ";
        
        return $this->query($sql) ; // ->fetchAll(PDO::FETCH....);
    }
    
    public function ConsultaDetalhesLoteLojaProducao($Loja,$Lote)
    {
        $sql="  CALL spDVCCU_ExtratoProducaoLoteLoja ( $Loja , $Lote ) ";

        return $this->query($sql) ; // ->fetchAll(PDO::FETCH....);
    }

    public function RetornaStringTipo ($Tipo)
    {
        // funcao recursiva para retornar a String Completa do Tipo de Movimentacao
        
        $sql="
                SELECT t.tipo_codigo , t.descricao , IFNULL(t.tipo_codigo_pai,0) tipo_codigo_pai
                  FROM davo_ccu_tipo t
                 WHERE t.tipo_codigo = $Tipo
             ";        
        
        $Retorno=$this->query($sql) ; #->fetchAll(PDO::FETCH_COLUMN,2);
        #return $this->query($sql);
        # echo $sql;
       
        foreach($Retorno as $campos=>$valores)
        {
            $valores['tipo_codigo'] ;
            $TipoPai=$valores['tipo_codigo_pai'] ;
            
            if ($TipoPai)
              $String=$this->RetornaStringTipo($TipoPai).' > '.$valores['descricao'];
            else
              $String=$valores['descricao'];
            
        }
        
        return $String ; 
        # RetornaStringTipo(5);
        
    }
    
    public function retornaLojasSelectBox()
    {
        $sql = "   SELECT T06.T006_codigo LojaCodigo
                        , T06.T006_nome   LojaNome
                     FROM T006_loja T06
                     JOIN T065_segmento_filiais T65 ON T06.T065_codigo = T65.T065_codigo
                    WHERE T65.T065_codigo  = 1";
        
        return $this->query($sql);
    }
    
    public function retornaStatusIntegracao()
    {
        $sql    =   "  SELECT si.status_integracao_id               Codigo
                            , si.status_integracao_descricao        Descricao
                         FROM davo_ccu_status_integracao si";
        
        return $this->query($sql);          
    }
    
    public function retornaStatusConsumo()
    {
        $sql    =   "  SELECT sc.status_consumo_id              Codigo
                            , sc.status_consumo_descricao       Descricao
                         FROM davo_ccu_status_consumo sc";
        
        return $this->query($sql);        
    }
    
    public function retornaStatusAprovacao()
    {
        $sql    =   "  SELECT sa.status_aprovacao_id            Codigo
                            , sa.status_aprovacao_descricao     Descricao
                         FROM davo_ccu_status_aprovacao sa
                        WHERE sa.status_aprovacao_id   >  0
                        ";
        
        return $this->query($sql);
    }
    
    public function retornaDadosOperador($Operador)
    {
        $sql    =   "  SELECT CONCAT(a.id ,' - ', u.alternate_id,' - ', UPPER(a.name))
                        FROM `user` u
                        LEFT JOIN agent a ON (u.agent_key = a.agent_key) 
                       WHERE u.agent_key =  $Operador   
                        ";

        $Retorno=$this->query($sql)->fetchAll(PDO::FETCH_COLUMN) ;
        return $Retorno[0];        
    }
    
    public function retornaDadosUsuario($Login)
    {
        $sql    =   " select T004.T004_nome
                        from T004_usuario T004
                       where T004.T004_login =  '$Login'
                        ";

        $Retorno=$this->query($sql)->fetchAll(PDO::FETCH_COLUMN) ;
        return $Retorno[0];        
    }
    
    public function retornaTiposFilhos($Tipo)
    {   
        $sql =   "SELECT t.T117_codigo , t.T117_descricao , t.T117_codigo_pai
                    FROM T117_ccu_tipo t
                   WHERE t.T117_codigo_pai  = $Tipo
                  ";        
        
        $Retorno=$this->query($sql)->fetchAll() ; 
        
        foreach($Retorno as $campos=>$valores)
        {
            $Grupos.=','.($valores['T117_codigo']).$this->retornaTiposFilhos($valores['T117_codigo']);
        }
        
        return $Grupos;
    }
            
    
    public function retornaGruposAprovacaoUsuario($Usuario)
    {
        // retorna as lojas distintas que o usuario visualiza
        $sql =   "SELECT DISTINCT 
                         g.T006_codigo
                    FROM T004_T059 u INNER JOIN T117_T059 g ON (g.T059_codigo = u.T059_codigo)
                   WHERE u.T061_codigo = 5 
                     AND u.T004_login = '$Usuario'
                  ";
        
        $RetornoLojas=$this->query($sql) ; #->fetchAll(PDO::FETCH_COLUMN,2);
        
        $i=0;
        foreach($RetornoLojas as $campos=>$valores)
        {
            $Loja=$valores['T006_codigo'] ;
            
            // retorna os grupos distintos que o usuario visualiza para a loja
            $sql =   "SELECT DISTINCT 
                             g.T006_codigo , g.T117_codigo
                        FROM T004_T059 u INNER JOIN T117_T059 g ON (g.T059_codigo = u.T059_codigo)
                       WHERE u.T061_codigo = 5 
                         AND u.T004_login   = '$Usuario'
                         AND g.T006_codigo  =  $Loja
                      ";            
            
            $RetornoGrupos=$this->query($sql) ;
            
            
            foreach($RetornoGrupos as $campos=>$valores)
            {
                
                $LojasGrupos['Loja'][$i]=$Loja;
                $LojasGrupos['Tipo'][$i]=$valores['T117_codigo'].$this->retornaTiposFilhos($valores['T117_codigo']);
                $i++;
                
                
                
            }
            
            
        }    
        return $LojasGrupos;
    }
            
    
}
 ?>
