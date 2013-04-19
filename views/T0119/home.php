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
        
    $RetornoLotes   =   $objEMP->ConsultaLotesLoja($filtroLoja, $filtroDtInicio, $filtroDtFim, $filtroStatusConsumo, $filtroStatusIntegracao, $filtroStatusAprovacao, $filtroRegistros);
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
    
    <form action="" method="post" class="div-filtro-visivel">
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
        
        <div class="grid_2">
            <label class="label">Data Início</label>
            <input type="text" name="FiltroDataInicio"  class="data"    value="<?php echo $_REQUEST['FiltroDataInicio'];?>"/>               
        </div>
        
        <div class="grid_2">
            <label class="label">Data Fim</label>
            <input type="text" name="FiltroDataFim"     class="data"    value="<?php echo $_REQUEST['FiltroDataFim'];?>"/>               
        </div>
        <div class="clear"></div>
        
        <div class="grid_4">
        <label class="label">Status Consumo</label>
            <select name="FiltroStatusConsumo">
                <option value="">Todos</option>
                <?php foreach($SelectStatusConsumo as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $valores['Codigo']==$filtroStatusConsumo?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
                <?php }?>
            </select>            
        </div>
        
        <div class="grid_4">
        <label class="label">Status Integração</label>
            <select name="FiltroStatusIntegracao">
                <option value="">Todos</option>
                <?php foreach($SelectStatusIntegracao as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $valores['Codigo']==$filtroStatusIntegracao?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
                <?php }?>
            </select>            
        </div>
        
        <div class="grid_4">
        <label class="label">Status Aprovação</label>
            <select name="FiltroStatusAprovacao">
                <option value="">Todos</option>
                <?php foreach($SelectStatusAprovacao as $campos=>$valores){?>
                <option value="<?php echo $valores['Codigo'];?>" <?php echo $valores['Codigo']==$filtroStatusAprovacao?"selected":"";?>><?php echo $obj->preencheZero("E",3,$valores['Codigo'])."-".$valores['Descricao'];?></option>
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
                <th>Loja</th>
                <th>Lote</th>
                <th>Tipo</th>
                <th>Data/Hora</th>
                <th>Volumes</th>
                <th>Valor</th>
                <th>Status Consumo</th>
                <th>Status Aprovação</th>
                <th>Status Integração</th>
                <th>Ações</th>
                
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
            <tr>
                <!--<td><?php echo "DespesaCodigo:".$valores['DespesaCodigo'].";"."EtapaCodigo:".$valores['CodigoEtapa'];?>" class="chkItem" <?php echo $statusDespesa!=1?"disabled":""?></td>-->
                <td class="txtLoja"><?php echo $valores['store_key'];   ?></td>

                <td class="txtLote"
                    onmouseover ="show_tooltip_alert('','<?php echo "Mostrar Ticket, PDV, etc...";?>');tooltip.pnotify_display();" 
                    onmousemove ="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});"
                    onmouseout  ="tooltip.pnotify_remove();"
                >
                    <?php echo $valores['lote_numero']; ?>
                </td>

                
                <td width="10%"><?php echo $objEMP->RetornaStringTipo($valores['tipo_codigo']); ?></td>
                <td style="display:none" class="txtTipo"><?php echo $valores['tipo_codigo']; ?></td>
                <td ><?php echo $objEMP->formataDataHoraView($valores['start_time']); ?></td>
                <td align="right"><?php  echo $valores['quantity_rows'];?></td>
                <td align="right"><?php  echo $objEMP->formataMoedaSufixo($valores['amount']);?></td>
                <td
                <?php if(($valores['status_consumo_id']!=0)&&($valores['status_consumo_id']!=2))
                    { ?>
                         onmouseover ="show_tooltip_alert('<?php echo $valores['status_consumo_descricao'] ;?>'
                                                         ,'<?php echo "<B>Em: </B>".$objEMP->formataDataHoraView($valores['consumo_data'])
                                                                                  ."<BR>"
                                                                                  ."<B>Usuário: </B>".$valores['consumo_agent_key']
                                                                           ;?>');tooltip.pnotify_display();" 
                         onmousemove ="tooltip.css({'top': event.clientY+12, 'left': event.clientX+12});"
                         onmouseout  ="tooltip.pnotify_remove();" 
               <?php }?>
                ><?php echo $valores['status_consumo_id'].'-'.$valores['status_consumo_descricao']; ?></td>
                <td
                <?php if($valores['status_aprovacao_id']!=1)
                    { ?>
                         onmouseover ="show_tooltip_alert('<?php echo $valores['status_aprovacao_descricao'] ;?>'
                                                         ,'<?php echo "<B>Em: </B>".$objEMP->formataDataHoraView($valores['aprovacao_data'])
                                                                                  ."<BR>"
                                                                                  ."<B>Usuário: </B>".$valores['aprovacao_usuario']
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
                        <li><a href="#" title="Detalhes"  class="Detalhes">     <span class='ui-icon ui-icon-search'>  </span></a></li>                                    
                        <?php // verifica se está no Status de Aprovação e apresenta os botoes
                              if($valores['status_aprovacao_id']==1)
                              { ?>
                                <li><a href="#" title="Aprovar"   class="Aprovar" >     <span class='ui-icon ui-icon-check' >  </span></a></li>
                                <li><a href="#" title="Reprovar"  class="Reprovar" >    <span class='ui-icon ui-icon-cancel'>  </span></a></li>
                        <?php } ?>  
                    </ul>
                </td>
            </tr>
              <?php 
                   }
                }?>
        </tbody>
        
    </table>
</div>
                        