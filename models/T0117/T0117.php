<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 13/02/2013 por Rodrigo Alfieri                               
// * Descrição: Requisição de Mudança (RM)
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/

class models_T0117 extends models
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
       return $altera;
    }  
    
    public function retornaDadosUsuario($user)
    {
        $sql    =   "  SELECT T04.T004_nome     NomeUsuario
                            , T04.T004_email    EmailUsuario
                         FROM T004_usuario T04
                        WHERE T04.T004_login = '$user'";
       // echo $sql;
        return $this->query($sql);
    }
    
    public function retornaRM($titulo, $descricao, $solicitante, $codRM, $user)
    {        
        
        $sql    =   "  SELECT   T113.T113_codigo CodigoRM,
                                T113.T004_solicitante SolicitanteLogin,
                                T04B.T004_nome SolicitanteNome,
                                DATE_FORMAT(T113.T113_data, '%d/%m/%Y') DataRM,
                                DATE_FORMAT(T113_dt_hr_inicio, '%H:%i') HoraInicioRM,
                                DATE_FORMAT(T113_dt_hr_fim, '%H:%i') HoraFimRM,
                                DATE_FORMAT(T113_dt_hr_fim, '%d/%m/%Y') DataFimRM,
                                DATE_FORMAT(T113_dt_hr_inicio, '%d/%m/%Y') DataInicioRM,
                                T113.T004_responsavel ResponsavelLogin,
                                T04.T004_nome ResponsavelNome,
                                T113.T113_titulo TituloRM,
                                T113.T113_descricao DescricaoRM,
                                T113.T113_dt_hr_inicio DtHrInicioRM,
                                T113.T113_dt_hr_fim DtHrFimRM,
                                T113.T113_motivo MotivoRM,
                                T113.T113_impacto ImpactoRM,
                                T113.T113_status StatusRM,
                                T113.T113_tempo_previsto TempoPrevisto,
                                T113.T113_obs_contingencia ObsContingencia,
                                T113.T004_responsavel Responsavel,
                                T113_tempo_total TempoTotal,
                                T113.T113_janela_disponivel JanelaDisp,
                                T113.T113_hora_prevista HoraPrevista,
                                T113.T113_hora_disponivel HoraDisponivel,
                                T113.T113_hora_total HoraTotal,
                                T113_impacto_ocorrencia ImpactoOcorrencia,
                                T113_problemas_relacionados ProblemasRelacionados,
                                DATE_FORMAT(T113.T113_data_hr_real_inicial, '%d/%m/%Y') DataInicioReal,
                                DATE_FORMAT(T113.T113_data_hr_real_final, '%d/%m/%Y') DataFinalReal,
                                DATE_FORMAT(T113.T113_data_hr_real_inicial, '%H:%i') HoraInicioReal,
                                DATE_FORMAT(T113.T113_data_hr_real_final, '%H:%i') HoraFinalReal
                           FROM T113_requisicao_mudanca T113
                                JOIN T004_usuario T04
                                   ON T04.T004_login = T113.T004_responsavel
                                JOIN T004_usuario T04B
                                   ON T04B.T004_login = T113.T004_solicitante
                          WHERE (   T113.T004_solicitante = '$user'
                                 OR T113.T004_responsavel = '$user'
                                 OR EXISTS
                                       (SELECT T004_login
                                          FROM T118_comite_rm t118
                                         WHERE t118.T004_login = '$user')
                                 OR EXISTS
                                       (SELECT *
                                          FROM T004_T113 T04113
                                         WHERE     T04113.T113_codigo = T113.T113_codigo
                                               AND T04113.T004_login = '$user')
                                 OR EXISTS
                                       (SELECT *
                                          FROM T004_T009 T0409
                                         WHERE T0409.T004_login = '$user' AND T009_codigo = '59'));
                        ";
        
        if(!empty($titulo))
            $sql    .=  " AND T113.T113_titulo       LIKE   '%$titulo%'";
        if(!empty($descricao))
            $sql    .=  " AND T113.T113_descricao    LIKE   '%$descricao%'";
        if(!empty($solicitante))
            $sql    .=  " AND T113.T004_solicitante     =   '$solicitante'";
        if(!empty($codRM))
            $sql    .=  " AND T113.T113_codigo          =   '$codRM'";

        //echo $sql;
        
        return $this->query($sql);
    }
    
    public function retornaExecutoresCont($codRm) {
        
        $sql    =   "  SELECT T04.T004_login       Login
                            , T004_nome            Nome
                            , T04113.T113_codigo   Codigo
                         FROM    T004_usuario T04
                              JOIN
                                 T004_T113 T04113
                              ON T04.T004_login = T04113.T004_login
                      WHERE T04113.T004_T113_tipo = 2
                        AND T04113.T113_codigo    = $codRm";
        
        //echo $sql;
        return $this->query($sql);
                
        
    }
    
        public function retornaExecutoresRM($codRm) {
        
        $sql    =   "SELECT T04.T004_login       Login
                            , T004_nome            Nome
                            , T04113.T113_codigo   Codigo
                         FROM    T004_usuario T04
                              JOIN
                                 T004_T113 T04113
                              ON T04.T004_login = T04113.T004_login
                      WHERE T04113.T004_T113_tipo = 1
                        AND T04113.T113_codigo    = $codRm";
        
        //echo $sql;
        return $this->query($sql);
                
        
    }
    
      public function retornaExecExternoRM($codRm) {
        
        $sql    =   "SELECT T119.T119_codigo       Codigo,
                            T119.T119_nome         Nome,
                            T119.T119_email        Email,
                            T119.T119_telefone     Telefone,
                            T119.T119_notificado   Notificado
                       FROM T119_executores_externos T119
                      WHERE T119.T113_codigo    = $codRm";
        
        //echo $sql;
        return $this->query($sql);
                
        
    }
    
    public function retornaComiteRM($codRm){
        
           $sql    =   "SELECT  T04.T004_nome               Nome,
                                T113118.T113_T118_parecer   Parecer,
                                T113118.T113_T118_voto      Voto,
                                T113118.T004_login          Login
                           FROM    T113_T118 T113118
                                JOIN
                                   T004_usuario T04
                                ON T113118.T004_login = T04.T004_login
                          WHERE T113118.T113_codigo = ".$codRm;

           return $this->query($sql);
        
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
    
    public function retornaPerfil($user, $perfil) {
        
        $sql = "SELECT T004_login   Login
                  FROM T004_T009    T0409
                 WHERE T009_codigo  = $perfil
                   AND T004_login   = '$user'";
        
        return $this->query($sql);
        
    }
    
    public function nomeStatus($status) {
        
        switch ($status) {
            case 1:
                echo    "Aberta";
                break;
            case 2:
               echo     "Elaborada";
                break;
            case 3:
                echo    "Revisada";
                break;
            case 4:
                echo    "Suspensa";
                break;
            case 5:
                echo    "Reprovada";
                break;
            case 6:
                echo    "Aprovada";
                break;
            case 7:
                echo    "Concluída";
                break;
        }
        
    }
    
    public function mostraBotao($perfil, $user, $status, $codRM) {
        
        if (($perfil == 57 ) && ($user == $_SESSION["user"]) && ($status == 1)){
            echo " 
                    <input type='hidden' value='".$codRM."' id='codRM'>
                  <li class='ui-state-default ui-corner-all' title='Concluir'>
                                        <a href='#' class='ui-icon ui-icon-check concluir'></a> 
                   </li>
                    <li class='ui-state-default ui-corner-all' title='Excluir'>
                                       <a href='#' onclick='excluirLinha(".$codRM.")' class='ui-icon ui-icon-closethick excluir'></a> 
                    </li>
                    <li class='ui-state-default ui-corner-all' title='Alterar'>
                                        <a href='?router=T0117/alterar&codRM=".$codRM."' class='ui-icon ui-icon-pencil alterar'></a> 
                    </li>
                    <li class='ui-state-default ui-corner-all' title='Anexar'>
                                        <a href='javascript:upload(".$codRM.")' class='ui-icon ui-icon-pin-s Anexar'></a> 
                    </li>";
                    
        } elseif(($perfil == 59)&& ($status == 2)){
            
              echo " 
                    <input type='hidden' value='".$codRM."' id='codRM'>
                    <li class='ui-state-default ui-corner-all' title='Revisar'>
                                        <a href='#' class='ui-icon ui-icon-check revisar'></a> 
                   </li>
                    <li class='ui-state-default ui-corner-all' title='Excluir'>
                                       <a href='#' onclick='excluirLinha(".$codRM.")' class='ui-icon ui-icon-closethick' excluir></a> 
                    </li>
                    <li class='ui-state-default ui-corner-all' title='Alterar'>
                                        <a href='?router=T0117/alterar&codRM=".$codRM."' class='ui-icon ui-icon-pencil'></a> 
                    </li>";
            
        } elseif(($perfil == 59 ) && ($status == 3)) {
        echo "      <li class='ui-state-default ui-corner-all' title='Alterar'>
                                        <a href='?router=T0117/alterar&codRM=".$codRM."' class='ui-icon ui-icon-pencil alterar'></a> 
                    </li>";
        }
        
    }
    
    public function retornaDadosUser($user) {
        
        $sql    =   " SELECT T004_nome  Nome
                        FROM T004_usuario
                       WHERE T004_login = '$user' ";
       
        return $this->query($sql);
        
    }
    
    
    public function retornaComite($user) {
        $sql    =   "SELECT T04.T004_nome Nome, T04.T004_email Email
                       FROM    T118_comite_rm T118
                            JOIN
                               T004_usuario T04
                            ON T118.T004_login = T04.T004_login
                            WHERE 1 = 1";
        if($user != ""){
            $sql .= " AND T04.T004_login    =   '$user' ";
        }
    
       
        return $this->query($sql);
    }
    
    public function retornaFuncionariosRM($user) {
            $sql    =   "SELECT T004_login Login
                            FROM T004_T009
                            WHERE T004_login = '$user' AND T009_codigo = 57";
            
            return $this->query($sql);
        
    }
    
    public function enviaEmailExec($user, $codRM, $tipo){
        
        $sql = "SELECT T004_email Email
                      ,T004_nome  Nome
                  FROM T004_usuario
                 WHERE T004_login  = '$user'";
        
        $emailUser  =   $this->query($sql);
        
        if($tipo    ==  1){
            $rmTipo =   "da RM.";
        } elseif($tipo == 2){
            $rmTipo =   "de Contingência.";
        }
        
        foreach ($emailUser as $cpsEmail => $valEmail) {
          
        $to         = $valEmail["Email"]; 
        $from       = "web@davo.com.br"; 
        $subject    = "[Intranet] - Aviso de RM aos Executores";
        
        $html   =   $valEmail["Nome"].'<br>';
        $html   .=   'Há uma Requisição de Mundança onde você foi incluído como executor '.$rmTipo.'<br>';
        $html   .=   'Requisição Nº '. $codRM;
    
        $headers  = "From: $from\r\n"; 
        $headers .= "Content-type: text/html\r\n"; 
        $headers .= "Cc: web@davo.com.br";
    
       
        
        mail($to, $subject, $html, $headers); 
            
        }
        
    }
    
    public function retornaExecGeral($codRM) {
              
        
        $sql    =   "  SELECT T04.T004_login            Login
                            , T004_nome                 Nome
                            , T04113.T113_codigo        Codigo
                            , T04113.T004_T113_tipo     Tipo
                         FROM    T004_usuario T04
                              JOIN
                                 T004_T113 T04113
                              ON T04.T004_login = T04113.T004_login
                      WHERE T04113.T113_codigo    = $codRM";
        
        echo $sql;
        return $this->query($sql);
        
    }
    
     public function selecionaExtensao($extensao)
    {
       return $this->query("SELECT T1.T057_codigo   COD
                                  , T1.T057_nome    NOM
                                  , T1.T057_desc    DES
                               FROM T057_extensao   T1
                              WHERE T1.T057_nome = '$extensao'");
    }
    
        public function selecionaTipoArquivo()
    {
        return $this->query("SELECT DISTINCT T.T056_codigo   AS COD
                                  , T.T056_nome              AS NOM
                               FROM T056_categoria_arquivo   AS T
                               JOIN T055_arquivos T2 ON ( T2.T056_codigo = T.T056_codigo)
                              WHERE T2.T061_codigo IS NOT NULL
                                AND T.T056_codigo <> 19");
    }
    
     public function selecionaArquivos($rm)
    {
         
         $sql  =            "SELECT T5.T056_nome                    NOM
                                  , T5.T056_codigo                  CAT
                                  , T3.T055_codigo                  ARQ
                                  , T5.T056_desc                    DES
                                  , T4.T057_nome                    EXT
                               FROM T113_T055                       T1
                                  , T113_requisicao_mudanca         T2
                                  , T055_arquivos                   T3
                                  , T057_extensao                   T4
                                  , T056_categoria_arquivo          T5
                              WHERE T1.T113_codigo =   T2.T113_codigo
                                AND T1.T055_codigo =   T3.T055_codigo
                                AND T3.T056_codigo =   T5.T056_codigo
                                AND T3.T057_codigo =   T4.T057_codigo
                                AND T1.T113_codigo =   $rm";
         
       //  echo $sql;
        return $this->query($sql);
   }

     
}
 ?>
