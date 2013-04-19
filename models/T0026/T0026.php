<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 12/01/2012 por Rodrigo Alfieri
 * Descrição: Arquivo contém todas as querys para o programa de Relatório de Despesas
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/

class models_T0026 extends models
{

    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        
        return $insere;
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
    
    public function altera($tabela,$campos,$delim,$alerta)
    {
       $conn = "";
       
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($alerta)
       {
            if($altera)
                $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
            else
                $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   
       }
       
       return $altera;
    }    
    
    public function retornaLojas($loja)
    {
        $sql    =   "   SELECT T06.T006_cnpj    LojaCnpj
                             , T06.T006_codigo  LojaCodigo
                             , T06.T006_nome    LojaNome
                          FROM T006_loja T06
                         WHERE T006_codigo  NOT IN  (0)";
        
        if(isset($loja))
            if($loja!="999")
                $sql   .=  "   AND T006_codigo  NOT IN  ($loja)";
            
        return $this->query($sql);
    }
    
    public function retornaKm($Origem, $Destino)
    {
        $sql    =   "SELECT T15.T015_km  Km
                       FROM T015_deslocamentos T15
                      WHERE T15.T006_codigo_origem   = $Origem
                        AND T15.T006_codigo_destino  = $Destino
                      UNION
                     SELECT T15.T015_km  Km
                       FROM T015_deslocamentos T15
                      WHERE T15.T006_codigo_origem   = $Destino
                        AND T15.T006_codigo_destino  = $Origem";
        
        return $this->query($sql);
    }
    
    public function retornaPrimeiroGrupoWkfUsuario($user)
    {
        $sql    =   "  SELECT T59.T059_codigo  GrupoWkfCodigo
                            , T59.T059_nome    GrupoWkfNome
                        FROM T004_T059 T0459
                        JOIN T059_grupo_workflow T59 ON T0459.T061_codigo = T59.T061_codigo 
                                                    AND T0459.T059_codigo = T59.T059_codigo
                        JOIN T061_processo T61 ON T59.T061_codigo = T61.T061_codigo
                        JOIN T060_workflow T60 ON T60.T061_codigo = T59.T061_codigo 
                                              AND T60.T059_codigo = T59.T059_codigo
                        WHERE T0459.T004_login = '$user'
                        AND T61.T061_codigo  = 2
                        AND T60.T060_ordem   = 1";
        
        $grpWkfUser =   $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        
        return $grpWkfUser[0];
    }
    
    public function retornaEtapaGrupo($grpWkfUser)
    {
        $sql = "SELECT T1.T060_codigo              EtapaCodigo
                     , T1.T060_proxima_etapa       ProxEtapaCodigo
                  FROM T060_workflow               T1
                 WHERE T1.T059_codigo              = $grpWkfUser";

        return $this->query($sql);
    }
    
    public function retornaProximaEtapa($CodigoEtapa)
    {
        return $this->query("  SELECT T60.T060_codigo           EtapaCodigo
                                    , T60.T060_proxima_etapa    ProxCodigoEtapa
                                 FROM T060_workflow             T60
                                WHERE T60.T060_codigo           = $CodigoEtapa");
    }    
    
    public function inserirFluxo($CodigoDespesa, $CodigoEtapa, $Ordem)
    {   $tabela = "T016_T060";
        $user   = $_SESSION['user'];
        if(!is_null($CodigoEtapa))
        {
            $Etapas = $this->retornaProximaEtapa($CodigoEtapa);

            foreach($Etapas as $campos=>$valores)
            {
                $dados = array (  "T060_codigo"      => $valores['EtapaCodigo']
                                , "T016_codigo"      => $CodigoDespesa
                                , "T016_T060_ordem"  => $Ordem
                                , "T016_T060_status" => 0
                                , "T004_login"       => $user
                                );
                $this->inserir($tabela, $dados);
                $this->inserirFluxo($CodigoDespesa, $valores['ProxCodigoEtapa'], $Ordem+1);
            }
        }
        return true;
    }
    
    public function retornaDespesasPendentesAprovacao($user, $FiltroQuery, $FiltroRegistros)
    {
        $sql    =   "SELECT DISTINCT  T16.T016_codigo                                   AS DespesaCodigo
                                    , T16.T004_login                                    AS Login
                                    , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    AS DespesaData
                                    , T60.T060_codigo                                   AS CodigoEtapa
                                    , T16.T016_vl_total_geral                           AS DespesaValor
                                    , T60.T059_codigo                                   AS CodigoGrupo
                                FROM  T016_T060 T1660
                                JOIN ( 
                                        SELECT T016_codigo despesa, min(T016_T060_ordem) ordem
                                        FROM T016_T060 T
                                        WHERE T016_T060_dt_aprovacao IS NULL
                                        AND T016_T060_status       = '0'
                                    GROUP BY T016_codigo
                                    ) SE1 ON (     SE1.despesa = T1660.T016_codigo
                                                AND SE1.ordem   = T1660.T016_T060_ordem
                                                )
                                JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                JOIN T016_despesa T16    ON ( T16.T016_codigo  =  T1660.T016_codigo )
                               WHERE T1660.T060_codigo  = T60.T060_codigo 
                                 AND T16.T016_status in ('0','1')";
        
        $sql    .=  $FiltroQuery;
        
        $sql    .=  $FiltroRegistros;    
        
        return $this->query($sql);
    }
    
    public function retornaDespesasDigitadas($user, $FiltroQuery, $FiltroRegistros)
    {
        $sql    =   " SELECT DISTINCT T16.T016_codigo                                   AS DespesaCodigo
                                    , T16.T004_login                                    AS Login
                                    , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    AS DespesaData
                                    , T16.T016_vl_total_geral                           AS DespesaValor
                                 FROM T016_despesa T16
                                WHERE T16.T016_status = '0' -- despesas novas e nao aprovadas
                                  AND T16.T004_login = '$user' ";
        
        $sql    .=  $FiltroQuery;
        
        $sql    .=  $FiltroRegistros;                
        
        return $this->query($sql);
    }
    
    public function retornaDespesasAnteriores($user, $FiltroQuery, $FiltroRegistros)
    {
        $sql    =   " SELECT DISTINCT T16.T016_codigo                                   AS DespesaCodigo
                                    , T16.T004_login                                    AS Login
                                    , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    AS DespesaData
                                    , T16.T016_vl_total_geral                           AS DespesaValor
                                    FROM (  SELECT T1660.T016_codigo DESPESA , max(T1660.T016_T060_ordem) ordem
                                            FROM T016_T060 T1660
                                            JOIN ( -- retorna as despesas que ja foram aprovadas
                                                    SELECT T016_codigo despesa, max(T016_T060_ordem) ordem
                                                    FROM T016_T060 T
                                                    WHERE T016_T060_ordem        IS NOT NULL
                                                    AND T016_T060_dt_aprovacao IS NULL -- nao aprovadas
                                                    GROUP BY  T016_codigo
                                                    ) SE1 ON ( SE1.despesa  = T1660.T016_codigo )
                                                -- retorna grupos do usuario
                                            JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                                -- retorna etapas dos grupos
                                            JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                            WHERE T1660.T060_codigo  = T60.T060_codigo
                                            AND T1660.T016_T060_dt_aprovacao IS NULL -- em que o usuario logado nao aprovou
                                            GROUP BY T1660.T016_codigo
                                          ) SE2
                                    JOIN T016_T060 T1660_2 ON (     T1660_2.T016_codigo     = SE2.DESPESA
                                                                AND T1660_2.T016_T060_ordem < SE2.ordem -- etapas anteriores ao usuario logado
                                                            )
                                    -- detalhes da AP
                                    JOIN T016_despesa T16    ON ( T16.T016_codigo  =  T1660_2.T016_codigo )
                                     AND T16.T016_status   in ( '0','1' ) -- novas ou ja aprovadas
                                     AND T1660_2.T016_T060_dt_aprovacao IS NULL  /*somente nao aprovadas*/";
        
        $sql    .=  $FiltroQuery;
        
        $sql    .=  $FiltroRegistros;
        
        return $this->query($sql);
    }
    
    public function retornaDespesasPosteriores($user, $FiltroQuery, $FiltroRegistros)
    {
        $sql    =   " SELECT DISTINCT T16.T016_codigo                                   AS DespesaCodigo
                                    , T16.T004_login                                    AS Login
                                    , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    AS DespesaData
                                    , T16.T016_vl_total_geral                           AS DespesaValor
                                    FROM (  SELECT T1660.T016_codigo DESPESA , max(T1660.T016_T060_ordem) ordem
                                            FROM T016_T060 T1660
                                            JOIN ( -- retorna as Despesas que ja foram aprovadas
                                                    SELECT T016_codigo despesa, max(T016_T060_ordem) ordem
                                                    FROM T016_T060 T
                                                    WHERE T016_T060_ordem        IS NOT NULL
                                                    GROUP BY  T016_codigo
                                                    ) SE1 ON ( SE1.despesa  = T1660.T016_codigo )
                                                -- retorna grupos do usuario
                                            JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                                -- retorna etapas dos grupos
                                            JOIN T060_workflow T60    ON ( T60.T059_codigo  =  T0459.T059_codigo )
                                            WHERE T1660.T060_codigo  = T60.T060_codigo
                                            AND T1660.T016_T060_dt_aprovacao IS NOT NULL -- em que o usuario JA aprovou
                                            GROUP BY T1660.T016_codigo
                                        ) SE2
                                    JOIN T016_T060 T1660_2 ON (     T1660_2.T016_codigo     = SE2.DESPESA
                                                                AND T1660_2.T016_T060_ordem > SE2.ordem
                                                            )
                                    -- detalhes da despesa
                                    JOIN T016_despesa T16    ON ( T16.T016_codigo  =  T1660_2.T016_codigo )
                                   WHERE T16.T016_status   = '1'";
        
        $sql    .=  $FiltroQuery;
        
        $sql    .=  $FiltroRegistros;
        
        return $this->query($sql);
    }
    
    public function retornaDespesasFinalizadas($user, $FiltroQuery, $FiltroRegistros)
    {
        $sql    =   " SELECT DISTINCT T16.T016_codigo                                   AS DespesaCodigo
                                    , T16.T004_login                                    AS Login
                                    , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    AS DespesaData
                                    , T16.T016_vl_total_geral                           AS DespesaValor
                                    FROM T016_despesa T16
                                    -- retorna etapas das Despesas
                                    JOIN T016_T060 T1660      ON ( T1660.T016_codigo = T16.T016_codigo )
                                    -- retorna grupos do usuario
                                    JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                    -- retorna etapas dos grupos do usuario
                                    JOIN T060_workflow T60    ON (      T60.T059_codigo    =  T0459.T059_codigo
                                                                    AND T1660.T060_codigo  =  T60.T060_codigo
                                                                )
                                WHERE T16.T016_status = 9";
        
        $sql    .=  $FiltroQuery;
        
        $sql    .=  $FiltroRegistros;
        
        return $this->query($sql);
    }
    
    public function retornaDespesasCanceladas($user, $FiltroQuery, $FiltroRegistros)
    {
        $sql    =   " SELECT DISTINCT T16.T016_codigo                                   AS DespesaCodigo
                                    , T16.T004_login                                    AS Login
                                    , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    AS DespesaData
                                    , T16.T016_vl_total_geral                           AS DespesaValor        
                                    FROM T016_despesa T16
                                    -- retorna etapas das Despesas
                                    JOIN T016_T060 T1660      ON ( T1660.T016_codigo = T16.T016_codigo )
                                    -- retorna grupos do usuario
                                    JOIN T004_T059 T0459      ON ( T0459.T004_login = '$user' )
                                    -- retorna etapas dos grupos do usuario
                                    JOIN T060_workflow T60    ON (    T60.T059_codigo    =  T0459.T059_codigo
                                                                AND T1660.T060_codigo  =  T60.T060_codigo
                                                                )
                                WHERE T16.T016_status = 4";
        
        $sql    .=  $FiltroQuery;
        
        $sql    .=  $FiltroRegistros;
        
        return $this->query($sql);
    }
    
    public function retornaArquivos($DespesaCodigo)
    {
        $sql    =   "   SELECT T56.T056_codigo  CategoriaCodigo
                             , T56.T056_nome    CategoriaNome
                             , T56.T056_desc    CategoriaDescricao
                             , T55.T055_codigo  ArquivoCodigo         
                             , T55.T055_nome    ArquivoNome         
                             , T57.T057_nome    ExtensaoNome
                          FROM T016_T055 T1655
                          JOIN T016_despesa T16 ON T1655.T016_codigo = T16.T016_codigo
                          JOIN T055_arquivos T55 ON T1655.T055_codigo = T55.T055_codigo
                          JOIN T056_categoria_arquivo T56 ON T55.T056_codigo = T56.T056_codigo
                          JOIN T057_extensao T57 ON T55.T057_codigo = T57.T057_codigo
                         WHERE T16.T016_codigo  = $DespesaCodigo";

        return $this->query($sql);
    }

    public function retornaDespesa($DespesaCodigo)
    {
        $sql    =   "  SELECT T16.T016_codigo                                   DespesaCodigo
                            , T16.T016_cpf                                      CpfUsuario
                            , T04.T004_nome                                     UsuarioNome
                            , T04.T004_matricula                                UsuarioMatricula
                            , T16.T004_login                                    DespesaLogin
                            , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y')    DespesaData
                            , date_format(T16.T016_dt_inicio,'%d/%m/%Y')        DespesaDtInicio
                            , date_format(T16.T016_dt_final,'%d/%m/%Y')         DespesaDtFim
                            , T16.T016_vl_total_km                              DespesaTotalKm
                            , T16.T016_vl_total_diversos                        DespesaTotalDiversos
                            , T16.T016_vl_total_geral                           DespesaValor
                        FROM T016_despesa T16
                        JOIN T004_usuario T04 ON T16.T004_login = T04.T004_login
                        WHERE T16.T016_codigo  = $DespesaCodigo";
        
        return $this->query($sql);
    }

    public function retornaDespesaDetalhe($DespesaCodigo)
    {
        $sql    =   "  SELECT date_format(T1516.T015_T016_saida,'%d/%m/%Y %H:%i')   DespesaSaida
                            , date_format(T1516.T015_T016_chegada,'%d/%m/%Y %H:%i') DespesaChegada                            
                            , T1516.T015_T016_desc                                  DespesaDescricao
                            , T1516.T006_codigo_origem                              DespesaOrigem
                            , T06A.T006_nome                                        OrigemNome
                            , T1516.T015_T016_origem                                DespesaDescOrigem
                            , T1516.T015_T016_destino                               DespesaDescDestino
                            , T1516.T006_codigo_destino                             DespesaDestino
                            , T06B.T006_nome                                        DestinoNome                            
                            , T1516.T015_T016_km                                    DespesaKm
                         FROM T015_T016 T1516
                         JOIN T006_loja T06A ON T1516.T006_codigo_origem = T06A.T006_codigo
                         JOIN T006_loja T06B ON T1516.T006_codigo_destino = T06B.T006_codigo
                        WHERE T1516.T016_codigo  = $DespesaCodigo";
        
        return $this->query($sql);
    }

    public function retornaDespesasDiversas($DespesaCodigo)
    {
        $sql    =   "  SELECT T17.T014_codigo                       ContaCodigo
                            , T14.T014_nome                         ContaNome 
                            , date_format(T17.T017_data,'%d/%m/%Y') DespesaData
                            , T17.T017_desc                         DespesaDescricao
                            , T17.T017_valor                        DespesaValor
                        FROM T017_despesa_detalhe T17
                        JOIN T014_conta T14 ON T17.T014_codigo = T14.T014_codigo
                        WHERE T17.T016_codigo  = $DespesaCodigo";
        
        return $this->query($sql);
    }
    
    public function retornaUltimaEtapaDespesa($DespesaCodigo)
    {
        $sql    =   " SELECT T060_codigo UltimaEtapa -- retorna última etapa da AP
                        FROM
                            (
                                SELECT T016_T060.T016_codigo cod ,  max(T016_T060_ordem) ordem -- retorna ultima ordem da AP
                                FROM T016_T060
                                WHERE T016_codigo = $DespesaCodigo
                                GROUP BY T016_T060.T016_codigo
                            ) SE1
                        JOIN T016_T060  ON (     T016_codigo     = SE1.cod
                                             AND T016_T060_ordem = SE1.ordem)";

        return $this->query($sql);
    }
    
    public function retornaExtensao($Extensao)
    {
        $sql    =   "  SELECT T57.T057_codigo  ExtensaoCodigo
                            , T57.T057_desc    ExtensaoDescricao
                            , T57.T057_nome    ExtensaoNome
                        FROM T057_extensao T57
                        WHERE T57.T057_nome  = '$Extensao'";
        
        return $this->query($sql);
    }
    
    public function retornaUltimaAprovacao($DespesaCodigo)
    {
        $sql    =   "  SELECT '000'                                          GrupoCodigo
                            , 'Despesa digitada e não aprovada'              GrupoNome
                            , date_format(T16.T016_dt_elaboracao,'%d/%m/%Y') DtAprovacao
                            , time(T16.T016_dt_elaboracao)                   TimeAprovacao
                            , T16.T004_login                                 Login
                            FROM T016_despesa T16
                            WHERE T16.T016_codigo  = $DespesaCodigo
                            AND T16.T016_status    = '0'
                        UNION
                        SELECT T59.T059_codigo GrupoCodigo
                            , T59.T059_nome   GrupoNome
                            , date_format(T1660.T016_T060_dt_aprovacao,'%d/%m/%Y') dtAprovacao
                            , time(T1660.T016_T060_dt_aprovacao)                   TimeAprovacao
                            , T1660.T004_login                                     Login
                            FROM T016_T060 T1660
                        JOIN  (  SELECT T060_codigo etapa, max(T016_T060_ordem) ordem
                                    FROM T016_T060 T
                                    WHERE T016_T060_dt_aprovacao IS NOT NULL
                                    AND T016_T060_status       IN ('1') 
                                    AND T016_codigo            = $DespesaCodigo
                                GROUP BY T.T016_codigo
                                ) SE1 ON ( SE1.etapa  = T1660.T060_codigo )
                            JOIN T060_workflow  T60         ON  ( T60.T060_codigo  = T1660.T060_codigo )
                            JOIN T059_grupo_workflow    T59 ON  ( T59.T059_codigo  = T60.T059_codigo   )
                            JOIN T016_despesa           T16 ON  ( T16.T016_codigo  = $DespesaCodigo    )
                        WHERE T1660.T016_codigo  = $DespesaCodigo
                            AND T16.T016_status    IN ('1','4','9')";
        
        return $this->query($sql);
    }
    
    //Cria combo para Reembolso de Despesa, de 30 em 30 minutos
    public function comboHora()
    {
        $html   =   "<option value=''>Hora</option>";
        for($h=0;$h<=23;$h++)
        {
            for($m=0;$m<=1;$m++)
            {
                $hora   =   $this->preencheZero("E", 2, $h);
                if($m == 0)
                    $min    =   "00";
                else
                    $min    =   "30";
                
                $horario    =   $hora.":".$min;
                $html .= "<option value='$horario'>$horario</option>";
            }
            
        }
        
        return $html;
        
    }
    
    public function retornaContas()
    {
        $sql    =   "  SELECT T14.T014_agenda_RMS  ContaAgendaRMS
                            , T14.T014_codigo      ContaCodigo
                            , T14.T014_CRF_RMS     ContaCRF
                            , T14.T014_nome        ContaNome
                        FROM T014_conta T14";
        
        return $this->query($sql);
    }
    
    public function verificaCpf($cpf)
    {
        $connORA  =   $this->consulta;
        
        $sql = "  SELECT A.TIP_RAZAO_SOCIAL NOME
                    FROM RMS.AA2CTIPO A
                   WHERE A.TIP_LOJ_CLI  =   'F'
                     AND A.TIP_NATUREZA =   'FS'
                     AND A.TIP_CGC_CPF  = '$cpf'";        
        
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
    }
    
    public function retornaParametroKm()
    {
        $sql    =   " SELECT SE.ValorParametro 
                        FROM (
                                SELECT MAX(T89.T089_dt_inicio)  DataInicio  
                                     , T089_valor               ValorParametro
                                  FROM T089_parametro_detalhe T89
                                 WHERE T003_codigo = 7
                              )SE";
        
        $parametro  =   $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        
        return $parametro[0];
    }   
    
    public function retornaArrayPeriodo($codigoDespesa)
    {
        $sql    =   "  SELECT MIN(date_format(T01516.T015_T016_saida,'%d/%m/%Y'))  DataInicial
                            , MAX(date_format(T01516.T015_T016_saida,'%d/%m/%Y'))  DataFinal
                         FROM T015_T016 T01516
                        WHERE T016_codigo  = $codigoDespesa";
        
        $dadoPeriodo    =   $this->query($sql);        
        foreach($dadoPeriodo as $campos => $valores)
        {
            $arrPeriodo =   array(    
                                      "DataInicial" =>  $valores['DataInicial']
                                    , "DataFinal"   =>  $valores['DataFinal']
                                 );
        }
        
        return $arrPeriodo;
    }
    
    public function retornaDadosConta($crf)
    {        
        $sql    =   " SELECT T14.T014_codigo      CodigoConta
                        FROM T014_conta T14       
                       WHERE T014_CRF_RMS = $crf";        
        
        return $this->query($sql);

    }
    
    public function retornaUltimaEtapaAprovadaDespesa($codigoDespesa)
    {
        $sql =   "   SELECT max(T1660.T060_codigo)   ProxEtapa
                       FROM T016_T060 T1660
                      WHERE T1660.T016_codigo  = $codigoDespesa   
                        AND T1660.T016_T060_status = 0";

        return $this->query($sql);
    }  
        
}
?>

<?php
/* -------- Controle de versões - T0026.php --------------
 * 1.0.0 - 01/02/2012 - Rodrigo Alfieri --> Liberada versao inicial
 *                                
 */
?>