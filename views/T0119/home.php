<?php
// teste ORAAS141
//Instancia Classe
$conn       =   "emporium";
$objEMP     =   new models_T0119($conn);
$obj        =   new models_T0119();

if(!empty($_POST))
{   
    
    $filtroLoja             =   $_REQUEST['FiltroLoja']             ;
    $filtroDtInicio         =   $_REQUEST['FiltroDataInicio']       ;
    $filtroDtFim            =   $_REQUEST['FiltroDataFim']          ;
    $filtroStatusConsumo    =   $_REQUEST['FiltroStatusConsumo']    ;
    $filtroStatusIntegracao =   $_REQUEST['FiltroStatusIntegracao'] ;
    $filtroStatusAprovacao  =   $_REQUEST['FiltroStatusAprovacao']  ;
    $filtroRegistros        =   $_REQUEST['FiltroRegistros']        ;

    if(empty($_REQUEST['FiltroStatusAprovacao']))
        $filtroStatusAprovacao = "1";            
    
    if(empty($_REQUEST['FiltroDataInicio']))
        $dataI  =   date("d/m/Y", strtotime("-5 day"));
    else
        $dataI  =   $_REQUEST['FiltroDataInicio'];    
    
    if(empty($_REQUEST['FiltroDataFim']))
        $dataF  =   date("d/m/Y");
    else
        $dataF  =   $_REQUEST['FiltroDataFim'];      
    
    
    $RetornoLotes   =   $objEMP->ConsultaLotesLoja($filtroLoja, $dataI, $dataF, $filtroStatusConsumo, $filtroStatusIntegracao, $filtroStatusAprovacao, $filtroRegistros);
    
  
}

$SelectBoxLoja              =   $obj->retornaLojasSelectBox();
$SelectStatusIntegracao     =   $objEMP->retornaStatusIntegracao();
$SelectStatusConsumo        =   $objEMP->retornaStatusConsumo();
$SelectStatusAprovacao      =   $objEMP->retornaStatusAprovacao();

 // armazena grupos/lojas que o usuario possui acesso
 $LojasGrupos=$obj->retornaGruposAprovacaoUsuario($user);
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
   // verifica se há algum grupo de aprovacao
  if(!$i)      
    $CondSQL.=" 1 > 1";
  
 $CondSQL.=" ) ";
 
 
?>
<div id="dialog-aprovar" style="display:none;">
    
</div>
<div id="dialog-detalhes" style="display:none;">
    
</div>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
    </ul>
</div>

<!-- Divs com filtros oculta -->
<div class="conteudo_16  div-filtro">
    
    <form action="" method="post" class="div-filtro-visivel validaFormulario">
        <!--<input type="hidden" name="router" value="T0119/home" />-->
        
        <div class="grid_4">       
            <label class="label">Loja</label>
            <select name="FiltroLoja">
                <option value="">Todas</option>
                <?php foreach($SelectBoxLoja as $campos=>$valores){?>
                <option value="<?php echo substr($valores['LojaCodigo'], 0, -1);?>" <?php echo substr($valores['LojaCodigo'], 0, -1)==$filtroLoja?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['LojaCodigo'])."-".$valores['LojaNome'];?></option>
                <?php }?>
            </select>                                       
        </div>
        
        <div class="grid_4">
            <label class="label">Filtro Dinâmico</label>
            <input width="155px" type="text" id="filtroDinamico" value="" name="search">
        </div>
        
        <div class="grid_2">
            <label class="label">Data Início</label>
            <input type="text" name="FiltroDataInicio"  class="data validate[custom[date],past[#FiltroDataFim]]"  value="<?php if(!empty($dataI)) echo $dataI;?>"/>               
        </div>
        
        <div class="grid_2">
            <label class="label">Data Fim</label>
            <input type="text" name="FiltroDataFim"   class="data validate[custom[date],future[#FiltroDataInicio]] "    value="<?php if(!empty($dataF)) echo $dataF;?>"/>               
        </div>
        <div class="clear"></div>
        
        <div class="grid_4">
        <label class="label">Status Associação</label>
            <select name="FiltroStatusConsumo">
                <option value="">Selecione...</option>
                <option value="999" <?php echo $filtroStatusConsumo=='999'?"selected":"";?>>Todos</option>
                <?php foreach($SelectStatusConsumo as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $valores['Codigo']==$filtroStatusConsumo?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
                <?php }?>
            </select>            
        </div>

        <div class="grid_4">
        <label class="label">Status Aprovação</label>
            <select name="FiltroStatusAprovacao">
                <option value="">Selecione...</option>
                <option value="999" <?php echo $filtroStatusAprovacao=='999'?"selected":"";?>>Todos</option>
                <?php foreach($SelectStatusAprovacao as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $filtroStatusAprovacao==$valores['Codigo']?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
                <?php }?>
            </select>            
        </div>
        
        <div class="grid_4">
        <label class="label">Status Integração</label>
            <select name="FiltroStatusIntegracao">
                <option value="">Selecione...</option>
                <option value="999" <?php echo $filtroStatusIntegracao=='999'?"selected":"";?>>Todos</option>
                <?php foreach($SelectStatusIntegracao as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $valores['Codigo']==$filtroStatusIntegracao?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
                <?php }?>
            </select>            
        </div>
        
        <div class="grid_2">
        <label class="label">Qtde Registros</label>
            <select name="FiltroRegistros">
                <option value="50"  <?php echo $filtroRegistros==50 ?"selected":""?>>50     </option>
                <option value="100" <?php echo $filtroRegistros==100?"selected":""?>>100    </option>
                <option value=""    <?php echo $filtroRegistros=="" ?"selected":""?>>Todos  </option>
            </select>            
        </div>

        <div class="grid_1">
            <input type="submit" class="botao-padrao" value="Filtrar">
        </div>
        
        <div class="clear5"></div>
                
    </form>
    
</div>

<div class="conteudo_16">    
                
    <table id="tPrincipal" class="tablesorter">
        <thead>
            <tr>
                <!--<th><input type="checkbox" value="1" class="chkSelecionaTodos" <?php echo $statusDespesa!=1?"disabled":""?>/></th>-->
                <th width="2%"><input type='checkbox' id='selecionaTodos'/></th>
                <th width="5%">Loja</th>
                <th width="5%">Lote</th>
                <th width="18%">Tipo</th>
                <th width="12%">Data/Hora</th>
                <th width="3%">Vol.</th>
                <th width="7%">Valor</th>
                <th width="12%">Associação</th>
                <th width="12%">Aprovação</th>
                <th width="12%">Integração</th>
                <th width="10%" >Ações</th>
                
<!--                <th>Data</th>
                <th>Última Etapa</th>
                <th>Valor</th>
                <th>Arquivos</th>
                <th>Ações</th>-->
            </tr>
        </thead>
        <tbody>
        <?php   foreach($RetornoLotes as $campos=>$valores)
                {
                   $existeIntranet = $obj->ConsultaLoteIntranet($valores['store_key'],$valores['lote_numero'],$CondSQL);
                   
                   if($existeIntranet)
                   {
            ?>            
            <tr class="dados">
                
                <td><?php if($valores['status_aprovacao_id']==1){ ?><input type='checkbox' class='selecionaItem' name="selecionaItem[]" value="<?php echo $valores['store_key']?>"/><?php }?></td>
                
                <td class="txtLoja"><?php echo $valores['store_key'];   ?></td>

                <td class="txtLote"
                    onmouseover ="show_tooltip_alert('','<?php echo "<B>PDV: </B>".$valores['pos_number']
                                                                    ."<BR>"
                                                                    ."<B>Cupom: </B>".$valores['ticket_number']
                                                                    ."<BR>" 
                                                                    ."<B>Operador: </B>".$valores['id']."-".$valores['alternate_id']."-".$valores['name'];
                                                             ;?>');tooltip.pnotify_display();" 
                    onmousemove ="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});"
                    onmouseout  ="tooltip.pnotify_remove();"
                ><?php echo $valores['lote_numero'];?></td>

                
                <td class="txtTipoString" width="10%"><?php echo $objEMP->RetornaStringTipo($valores['tipo_codigo']); ?></td>
                
                <td class="txtData"><?php echo $objEMP->formataDataHoraView($valores['start_time']); ?></td>
                <td class="txtVolumes" align="right"><?php  echo $valores['quantity_rows'];?></td>
                <td class="txtValor" align="right"><?php  echo $objEMP->formataMoedaSufixo($valores['amount']);?></td>
                <td
                <?php if(($valores['status_consumo_id']!=0)&&($valores['status_consumo_id']!=2))
                    { ?>
                         onmouseover ="show_tooltip_alert('<?php echo $valores['status_consumo_descricao'] ;?>'
                                                         ,'<?php echo "<B>Em: </B>".$objEMP->formataDataHoraView($valores['consumo_data'])
                                                                                  ."<BR>"
                                                                                  ."<B>Operador: </B>".$objEMP->retornaDadosOperador($valores['consumo_agent_key']);
                                                                           ;?>');tooltip.pnotify_display();" 
                         onmousemove ="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});"
                         onmouseout  ="tooltip.pnotify_remove();" 
               <?php }?>
                ><?php echo $valores['status_consumo_id'].'-'.$valores['status_consumo_descricao']; ?></td>
                <td
                <?php if($valores['status_aprovacao_id']!=1)
                    { ?>
                         onmouseover ="show_tooltip_alert('<?php echo $valores['status_aprovacao_descricao'] ;?>'
                                                         ,'<?php $Box = "<B>Em: </B>".$objEMP->formataDataHoraView($valores['aprovacao_data']);
                                                                 if(!empty($valores['aprovacao_usuario']))
                                                                     $Box .="<BR><B>Login: </B>".$valores['aprovacao_usuario'].' - '.$obj->retornaDadosUsuario($valores['aprovacao_usuario']);
                                                                 if(!empty($valores['aprovacao_agent_key']))
                                                                     $Box .="<BR><B>Operador: </B>".$objEMP->retornaDadosOperador($valores['aprovacao_agent_key']);
                                                                  echo $Box;
                                                                           ;?>');tooltip.pnotify_display();" 
                         onmousemove ="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});"
                         onmouseout  ="tooltip.pnotify_remove();" 
               <?php }?>
                ><?php echo $valores['status_aprovacao_id'].'-'.$valores['status_aprovacao_descricao']; ?> </td>
                
                <td
                <?php if($valores['status_integracao_id']!=0)
                    { ?>
                         onmouseover ="show_tooltip_alert('<?php echo $valores['status_integracao_descricao'] ;?>'
                                                         ,'<?php echo "<B>Em: </B>".$objEMP->formataDataHoraView($valores['integracao_data'])
                                                         ;?>');tooltip.pnotify_display();" 
                         onmousemove ="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});"
                         onmouseout  ="tooltip.pnotify_remove();" 
               <?php }?>
                ><?php echo $valores['status_integracao_id'].'-'.$valores['status_integracao_descricao']; ?></td>
                
                <td>                                    
                    <ul class="lista-de-acoes">                                        
                        <li><a href="#" title="Detalhes"  class="<?php echo $valores['status_aprovacao_id']==1?'DetalhesAprovar':'Detalhes';?>">     <span class='ui-icon ui-icon-search'>  </span></a></li>                                    
                        <?php // verifica se está no Status de Aprovação e apresenta os botoes
                              if($valores['status_aprovacao_id']==1)
                              { ?>
                                <li><a href="#" title="Aprovar"   class="Aprovar" >     <span class='ui-icon ui-icon-check' >  </span></a></li>
                                <li><a href="#" title="Reprovar"  class="Reprovar" >    <span class='ui-icon ui-icon-cancel'>  </span></a></li>
                        <?php } ?>  
                    </ul>
                </td>
                <td style="display:none" class="txtTipo"><?php echo $valores['tipo_codigo']; ?></td>
            </tr>
              <?php 
                   }
                }?>
        </tbody>
        
    </table>
    
    <div class="clear10"></div>
    
    <div class="grid_3">
        <input type="button" class="botao-padrao" value="Aprovar Selecionados" id="aprovarSelecionados"/>
    </div>
    
    <div class="grid_3">
        <input type="button" class="botao-padrao" value="Reprovar Selecionados" id="reprovarSelecionados"/>
    </div>
    
</div>
                        