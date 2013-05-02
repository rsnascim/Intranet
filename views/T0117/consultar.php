<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 20/03/2013 Roberta Schimidt    
 * Descrição: Nova RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/
//Instancia Classe
$obj = new models_T0117();
$codRM = $_REQUEST["codRM"];
$user   =   $_SESSION["user"];

//$codRM  =    '4';

if (!empty($_POST)) {

    $tabela = "T113_requisicao_mudanca";

    $titulo             = $_POST['T113_titulo'];
    $solicitante        = $_SESSION['user'];
    $data               = date("d/m/Y h:i:s");
    $descricao          = $_POST['T113_descricao'];
    $dt_inicio          = $_POST['T113_dt_hr_inicio'] . " " . $_POST['hr_ini'] . ":00";
    $dt_fim             = $_POST['T113_dt_hr_fim'] . " " . $_POST['hr_fim'] . ":00";
    $motivo             = $_POST['T113_motivo'];
    $impacto            = $_POST['T113_impacto'];
    $tempo_previsto     = $_POST['T113_tempo_previsto'];
    $responsavel        = $_POST["T004_responsavel"];
    $obs_contingencia   = $_POST['T113_obs_contingencia'];
    $tempo_total        = $_POST['T113_tempo_total'];
    $janela_disp        = $_POST['T113_janela_disponivel'];
    $status             = 1;                                                  //Status 1 = Aberta
    $hora_total         =   $_POST["T113_hora_total"];
    $hora_disponivel    =   $_POST["T113_hora_disponivel"];
    $hora_prevista      =   $_POST["T113_hora_prevista"];


    $campos = array(
        "T004_solicitante"              => $solicitante
        , "T113_data"                   => $data
        , "T113_titulo"                 => $titulo
        , "T113_descricao"              => $descricao
        , "T113_dt_hr_inicio"           => $dt_inicio
        , "T113_dt_hr_fim"              => $dt_fim
        , "T113_motivo"                 => $motivo
        , "T113_impacto"                => $impacto
        , "T113_tempo_previsto"         => $tempo_previsto
        , "T113_obs_contingencia"       => $obs_contingencia
        , "T004_responsavel"            => $responsavel
        , "T113_status"                 => $status
        , "T113_tempo_total"            => $tempo_total
        , "T113_janela_disponivel"      => $janela_disp
        ,  "T113_hora_total"            => $hora_total
        ,  "T113_hora_prevista"         => $hora_prevista
        ,  "T113_hora_disponivel"       => $hora_disponivel    
    );

    $delim = "T113_codigo  = " . $codRM;

    $altera = $obj->altera($tabela, $campos, $delim);


    if ($altera)
        header('location:?router=T0117/home');
}

$retornaDados = $obj->retornaRM($titulo, $descricao, $solicitante, $codRM);



foreach ($retornaDados as $cpsRM => $vlrRM) {
    
   $statusRM    =   $vlrRM["StatusRM"];
    
    ?>

    <!-- Divs com a barra de ferramentas -->
    <div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
        <div class="push_9 conteudo_16">
            <ul class="lista-horizontal">
                <li><a href="?router=T0117/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
            </ul>
            <div class="push_7 grid_5">
                <label class="label">Requisição de Mudança - <?php echo $vlrRM["CodigoRM"]; ?> </label>
            </div>
            <?php 
            $p = 0;
           foreach($obj->retornaPerfil($user, 59) as $cp59 => $vlr59){
               $p++;
           } 
            if (($statusRM >= 3) && ($p >= 1)) {?>
            <div class="push_7 grid_3">
                Status: <select name="T113_status" id="statusRM">
                    <option value="<?php echo $statusRM?>"><?php $obj->nomeStatus($statusRM);?></option>    
                    <option value="4">Suspensa</option>
                    <option value="5">Reprovada</option>
                    <option value="6">Aprovada</option>
                    <option value="7">Concluída</option>
                </select>
            </div>
            <?php }?>
        </div>
    </div>

    <div class="conteudo_16">
        
        <div class="clear10"></div>

            <div class="push_7 grid_6">
                <label class="label" style="color: blue;">Período Previsto para Requisição de Mudança</label>
            </div>

            <div class="clear"></div>

            <div class="grid_7">
                <label class="label">Título *</label>
                <input type="text" name="T113_titulo"     class="validate[required] form-input-text-table" value="<?php echo $vlrRM["TituloRM"]; ?>"    readonly   />            
            </div>

            <div style="position: absolute; top: 217px; left: 590px;">
                <label class="label">Data Inícial*</label>
                <input style="width: 65px"type="text"  value="<?php echo $vlrRM["DataInicioRM"]; ?>"  readonly/>            
                <input style="width: 65px"type="hidden" name="dataHoje"  id="dataHoje" value="<?php echo date("d/m/Y"); ?>" readonly/>            
            </div>

            <div style="position: absolute; top: 217px; left: 665px;">
                <label class="label">Hora*</label>
                <input style="width: 65px"type="text"  value="<?php echo $vlrRM["HoraInicioRM"]; ?>"  readonly/>      
            </div>

            <div style="position: absolute; top: 217px; left: 750px;">
                <label class="label">Data Final*</label>
                <input style="width: 65px" value="<?php echo $vlrRM["DataFimRM"]; ?>"  readonly />            
            </div>

            <div style="position: absolute; top: 217px; left: 825px;">
                <label class="label">Hora*</label>
                <input style="width: 65px" value="<?php echo $vlrRM["HoraFimRM"]; ?>"  readonly />   
            </div>

            <div style="position: absolute; top: 217px; left: 900px;">
                <label class="label">Responsável da Requisição de Mudança*</label>
                <input style="width: 268px" type="text"
                       value   ="<?php echo $vlrRM["Responsavel"]; ?>"
                       readonly />
            </div>

            <div class="clear"></div>

            <div class="grid_6">
                <label class="label">Descrição * </label>
                <textarea name="T113_descricao"   placeholder="Falta o Texto!"          class="validate[required] textarea-table" cols="122" rows="4" readonly><?php echo $vlrRM["DescricaoRM"]; ?></textarea>            
            </div>        
            <br><br>
            <div class="clear"></div>

            <div style="margin-top: 15px; position: absolute; top: 350px; left: 177px;">
                <label class="label">Qual a necessidade de mudança? *</label>
                <textarea style="width: 485px" name="T113_motivo"      placeholder="Falta o Texto!"       class="validate[required] textarea-table" cols="50" rows="4" readonly><?php echo $vlrRM["MotivoRM"]; ?></textarea>            
            </div>

            <div style=" margin-top: 15px; position: absolute; top: 350px; left: 680px;">
                <label class="label">Qual o impacto para o negocio se não houver a mudança? *</label>
                <textarea style="width: 485px" name="T113_impacto"     placeholder="Falta o Texto!"        class="validate[required] textarea-table" cols="47" rows="4" readonly ><?php echo $vlrRM["ImpactoRM"]; ?></textarea>            
            </div>
            
            <div style=" margin-top: 15px; position: absolute; top: 450px; left: 177px;">
                <label class="label">Qual impacto durante a ocorrência? (Para o negócio)*</label>
                <textarea style="width: 1000px" name="T113_impacto_ocorrencia"     placeholder="Falta o Texto!"        class="validate[required] textarea-table" cols="47" rows="4" readonly ><?php echo $vlrRM["ImpactoOcorrencia"]; ?></textarea>            
            </div>  

            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="grid_16">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Contingência</a></li>
                        <li><a href="#tabs-2">Executores Internos</a></li>
                        <li><a href="#tabs-3">Executores Externos</a></li>
                     <?php 
                        $CM =   $obj->retornaComite($user);
                        $cmt = 0;
                        foreach ($CM as $cpPerCM => $vlPerCM) {
                            $cmt++;
                        }
                     if ($statusRM == 3) {?>   <li><a href="#tabs-4">Comitê</a></li><?php }?>
                         <li><a href="#tabs-5">Após Mudança</a></li>
                    </ul>
                    <div id="tabs-1">
                        <span class="form-input">
                            <div class="conteudo_16">                            
                                <div style="position: absolute; top: 60px; left: 7px;">
                                    <label class="label">Tempo:</label>
                                </div> 
                                <div style="position: absolute; top: 40px; left: 50px;">
                                    <label class="label">Contingência</label>
                                    <input style="width: 60px;" type="text" name="T113_tempo_previsto" placeholder="" id='tempoPrev' readonly value ="<?php echo $vlrRM["TempoPrevisto"] ?>"
                                           onmouseover ='show_tooltip_alert("", "Tempo previsto para voltar para cenário anterior em minutos.", true);
                        tooltip.pnotify_display();'
                                           onmousemove ='tooltip.css({"top": event.clientY + 12, "left": event.clientX + 12});' 
                                           onmouseout  ='tooltip.pnotify_remove();'
                                           />
                                </div>
                                
                                <div style="position: absolute; top: 63px; left: 120px;">
                                    <input style="width: 60px;" type="text" name="T113_hora_prevista"  placeholder="" value ="<?php echo $vlrRM["HoraPrevista"]?>" id='horaPrev'
                                           readonly
                                           />
                                </div>

                                <div style="position: absolute; top: 40px; left: 210px;">
                                    <label class="label">Disponível</label>
                                    <input style="width: 60px"type="text" name="T113_janela_disponivel" placeholder="" value="<?php echo $vlrRM["JanelaDisp"]; ?>" id='tempoDisp' 
                                           readonly/>
                                </div>
                                
                                <div style="position: absolute; top: 63px; left: 280px;">
                                    <input style="width: 60px"type="text" name="T113_hora_disponivel" placeholder="" value="<?php echo $vlrRM["HoraDisponivel"]; ?>" id='horaDisp' readonly
                                           readonly/>
                                </div>

                                <div style="position: absolute; top: 40px; left: 370px;">
                                    <label class="label">Total</label>
                                    <input style="width: 60px" type="text" value="<?php echo $vlrRM['TempoTotal'];?>"  name="T113_tempo_total" placeholder="" id="tempoTotal"  readonly/>
                                </div> 
                                
                                <div style="position: absolute; top: 63px; left: 440px;">
                                    <input style="width: 60px" type="text" name="T113_hora_total" placeholder="" id="horasTotal" readonly value="<?php echo $vlrRM["HoraTotal"]; ?>" 
                                           />
                                </div> 
                                <br><br><br><br><br>

                                <div class="clear"></div>
                           
  <div class="clear"></div>
    <?php $retExeCont = $obj->retornaExecutoresCont($codRM); ?>
                                <div class="grid_7">
                                    <label class="label">Executores</label>
                                    <select name="ExeCont[]" multiple >
                                <?php foreach ($retExeCont as $cpsExeCont => $vlrExCont) { ?>
                                            <option value="<?php echo $vlrExCont["Login"]; ?>"> <?php echo $vlrExCont["Nome"]; ?> </option>
    <?php } ?>
                                    </select>
                                    *Clique em cima do Executor para exclui-lo da lista.
                                </div>                               

                                <div style="position: absolute; top: 30px; left: 515px;">
                                    <label class="label">Observação Contingência</label>
                                    <textarea style="height: 120px" name="T113_obs_contingencia"    placeholder="Observação da contingência"         class="textarea-table" cols="150" rows="5" ><?php echo $vlrRM["ObsContingencia"]; ?></textarea>            
                                </div>                            

                            </div>
                        </span>
                    </div>
                    <div id="tabs-2">
                     
    <?php $retExeIntRM = $obj->retornaExecutoresRM($codRM); ?>
                        <div style="top: 84px; left: 275px">
                            <label class="label">Executores Internos</label>
                            <select style="width: 450px" name="T004_login[]" multiple readonly >
                        <?php foreach ($retExeIntRM as $cpsExIn => $vlrExInt) { ?>
                                    <option value="<?php echo $vlrExInt["Login"] ?>"><?php echo $vlrExInt["Nome"]; ?></option>
    <?php } ?>    
                            </select>
                            *Clique em cima do Executor para exclui-lo da lista.
                        </div>

                    </div>
                    <div id="tabs-3">
                        
                        <?php $retExecExternoRM = $obj->retornaExecExternoRM($codRM); ?>
            <div style=" top: 55px; left: 0px">
                <label class="label">Executores Externos</label>
                <select style="width: 625px;" name="ExeExt[]" multiple readonly>
            <?php foreach ($retExecExternoRM as $cpsExtRm => $vlrExtRM) { ?>
                        <option value="<?php echo $vlrExtRM['Codigo'] ?>">
        <?php echo $vlrExtRM['Nome'] . "|" . $vlrExtRM['Telefone'] . "|" . $vlrExtRM['Email'] . "|" . $vlrExtRM['Notificado'] ?>
                        </option>
                    <?php } ?>    
                </select>
                *Clique em cima do Executor para exclui-lo da lista.
            </div> 

                    </div>
                    <?php 
                 if($statusRM == 3){?>
                    <div id="tabs-4">
                    <?php if(($cmt   !=  0) && ($statusRM == 3)){
                        $retUser = $obj->retornaDadosUser($user);
                        foreach ($retUser as $cpsUser => $vlruser) {
                            $nomeUser   =   $vlruser["Nome"];
                        }
                        ?>
                        <div >
                            <label class="label">Comitê</label>
                            <input name='T004_nome' type='text' id='txtComite' value='<?php echo $nomeUser." - ".$user;?>' style='width: 300px;' readonly/>  
                                   
                        </div>
                        <div style="position: absolute; top: 44px; left: 350px">
                                <label class="label">Aprovado</label>
                                <div id="radioC">
                                    <input type="radio" id="radio3" name="T113_aprovado" value="S"                    class="validate[required]" /><label for="radio3">Sim</label>
                                    <input type="radio" id="radio4" name="T113_aprovado" value="N" checked="checked"  class="validate[required]" /><label for="radio4">Não</label>
                                </div>            
                            </div>
                        <div style="position: absolute; top: 44px; left: 450px;">
                                <label class="label">Parecer</label>
                                <textarea style="width: 250px" name="T113_justificativa" id='txtJustComite'    placeholder="Falta o Texto!"        class="validate[required] textarea-table" cols="47" rows="4" ></textarea>            
                        </div>
                        <div style="position: absolute; top: 44px; left: 790px">      
                                <label class="label">Adicionar</label>
                                <input type="button" value="+" id="btnAddComite"/>
                        </div>   <br><br><br>
                        <div style="position: static; top: 500px; left: auto; ">
                            <label class="label">Membros do Comitê</label>
                            <?php $retComiteRM = $obj->retornaComiteRM($codRM);?>
                            <select style="width: 950px" name="T004_login[]" multiple id="cmbComite" >
                        <?php foreach ($retComiteRM as $cpsComt => $vlrComt) { ?>
                                    <option value="<?php echo $vlrComt["Login"] ?>"><?php echo $vlrComt["Nome"]." | ".$vlrComt["Voto"]." | ".$vlrComt["Parecer"]; ?></option>
    <?php } ?>    
                            </select><br>
                            *Clique em cima do Executor para exclui-lo da lista.
                     </div> <?php } else {?>
                            <div >
                            <label class="label">Comitê</label>
                           
                        <div style="position: static; top: 500px; left: auto; ">
                            <label class="label">Membros do Comitê</label>
                            <?php $retComiteRM = $obj->retornaComiteRM($codRM);?>
                            <select style="width: 950px" name="T004_login[]" multiple readonly >
                        <?php foreach ($retComiteRM as $cpsComt => $vlrComt) { ?>
                                    <option value="<?php echo $vlrComt["Login"] ?>"><?php echo $vlrComt["Nome"]." | ".$vlrComt["Voto"]." | ".$vlrComt["Parecer"]; ?></option>
    <?php } ?>    
                            </select><br>
                            
                        </div>
                     </div> <?php } ?>
                 </div>    <?php }?>  
                    <div id="tabs-5">
                        <div style="margin-left: 15px;">
                            <label class="label">Data Real de Inicio</label>
                            <input type="text" name="T113_data_real_inicio" id="dataRealInicio" value="" style="width: 65px;"/>
                        </div>
                        <div style="position: absolute; top: 33px; left:130px;">
                            <label class="label">Hora Real Inicio*</label>
                                <select id="hr_ini" name="hr_ini" class="validate[required]">
                                    <?php if (!empty($vlrRM["HoraInicioRM"])) { ?>
                                                        <option><?php echo $vlrRM["HoraInicioRM"]; ?></option>
                                    <?php } ?>
                                    <?php $obj->comboHora(); ?>
                                </select>       
                        </div>
                        <div style="position: absolute; top: 33px; left:250px;">
                            <label class="label">Data Real Final</label>
                            <input type="text" name="T113_data_real_inicio" id="dataRealFinal" value="" style="width: 65px;"/>
                        </div>
                        <div style="position: absolute; top: 33px; left:350px;">
                            <label class="label">Hora Real Final*</label>
                                <select id="hr_ini" name="hr_ini" class="validate[required]">
                                    <?php if (!empty($vlrRM["HoraInicioRM"])) { ?>
                                                        <option><?php echo $vlrRM["HoraInicioRM"]; ?></option>
                                    <?php } ?>
                                    <?php $obj->comboHora(); ?>
                                </select>       
                        </div>
                        <div style="position: relative; top: -45px; left: 500px;">
                                    <label class="label">Problemas Relacionados</label>
                                    <textarea style="height: 120px; width: 477px;" name="T113_prob_relacionados"    placeholder="Problemas Relacionados"         class="textarea-table" cols="150" rows="5" ><?php echo $vlrRM["ObsContingencia"]; ?></textarea>            
                                </div>   
                    </div>
                       

            </div>   


           
            <div class="clear"></div>
            <input type="hidden" value="<?php echo $codRM; ?>" id="codRM">


    

            <div class="clear10"></div>

            <!--        <div class="grid_2">
                        <label class="label">Prioridade *</label>
                        <input type="text" name=""          />            
                    </div>-->

            <div class="clear"></div>

         


<?php } ?>

