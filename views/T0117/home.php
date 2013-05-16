<?php 

//Instancia Classe
$obj    =   new models_T0117();  
 
if (!empty($_POST))    
{
    $titulo         =   $_POST['T113_titulo'];
    $descricao      =   $_POST['T113_descricao'];
    $solicitante    =   $_POST['T004_solicitante'];   
    $rm             =   $_POST['T113_codigo'];
        
    $dados          =   $obj->retornaRM($titulo, $descricao, $solicitante, $rm, $_SESSION["user"]);
}else
echo "";    

//$dados          =   $obj->retornaRM();

?>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a href="?router=T0117/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
    </ul>
</div>

<div id="dialog-upload" title="Upload" style="display:none">
	<p    class="validateTips">Selecione um tipo e um arquivo para carregar no sistema!</p>
        <span class="form-input">
	<form action="?router=T0117/js.upload" method="post" id="form-upload"  enctype="multipart/form-data">
	<fieldset>
                <label class="label">Tipo de Arquivo*</label>
                <select                 name="T056_codigo"  id="tp_codigo" class="form-input-select">
                <?php 
                    $TArq   =   $obj->selecionaTipoArquivo();
                    foreach($TArq as $campos=>$valores){?>
                    <option value="<?php echo $valores['COD']?>"><?php echo ($valores['NOM'])?></option>
                <?php }?>
                </select>
                <label class="label">Escolha o Arquivo*</label>
                <input type="file"      name="P0117_arquivo"      id="arquivo" class="form-input-text"   />
                <input type="hidden"    name="T055_nome"            value=""                             />
                <input type="hidden"    name="T055_desc"            value=""                             />
                <input type="hidden"    name="T055_dt_upload"       value=""                             />
                <input type="hidden"    name="T004_login"           value="<?php echo $user?>"           />
                <input type="hidden"    name="T057_codigo"          value=""                             />
                <input type="hidden"    name="T059_codigo"          value=""                             />
                <input type="hidden"    name="T113_codigo"          value=""      id="codArqRm"             />
                <!-- Tipo Processo (Approval/Aprovação-->
        </fieldset>
	</form>
        </span>
</div>

<!-- Divs com filtros -->
<div class="div-primaria div-filtro">
    <form action="" method="post">
        
        <div class="conteudo_16">
            
            <div class="grid_3">
                <label class="label">Título</label>
                <input  type="text" name="T113_titulo" value="<?php echo $titulo;?>"/>
            </div>
            
            <div class="grid_3">
                <label class="label">Descrição</label>
                <input  type="text" name="T113_descricao" value="<?php echo $descricao;?>"/>                
            </div>
            
            <div class="grid_3">
                <label class="label">Solicitante</label>
                <input  type="text" name="T004_solicitante" value="<?php echo $solicitante;?>"/>                
            </div>
            
            <div class="grid_2">
                <label class="label">Número RM</label>
                <input  type="text" name="T113_codigo" value="<?php echo $rm;?>"/>                
            </div>
            
            <div class="grid_2">
                <input type="submit" value="Filtrar" class="botao-padrao" />                          
            </div>
            
            <div class="clear10"></div>
            
            <table class="tablesorter tDados">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>RM </th>
                        <th>Data Hora   </th>
                        <th width="40%">Título      </th>
                        <th>Solicitante </th>
                        <th>Status      </th>
                        <th>Arquivos    </th>
                        <th>Ações       </th>
                    </tr> 
                </thead>
                <tbody class="campos">
                    <?php foreach($dados    as  $campos =>  $valores){
                        if((($valores["StatusRM"] == 1) && (($valores["SolicitanteLogin"] == $_SESSION["user"]) || ($valores["Responsavel"]  ==  $_SESSION["user"])))
                                ||(($valores["StatusRM"] > 1))){?>
                    <tr class="linha">
                        <td class="codRM"><label class="rmCmp"><?php echo $valores['CodigoRM'];?></label></td>
                        <td><?php echo $valores['DataRM'];?></td>
                        <td class="tituloRM"><?php echo $valores['TituloRM'];?></td>
                        <td><?php echo $valores['SolicitanteNome']." - ".$valores['SolicitanteLogin'];?></td>
                        <td><?php $obj->nomeStatus($valores['StatusRM']);?></td>
                        <td><table class='list-iten-arquivos'>
                                <?php $Arq = $obj->selecionaArquivos($valores['CodigoRM']);
                                        $AD = "\"";
                            foreach($Arq  as  $campos=>$valores2)
                            {
                                 if( $cont%2 == 0)
                                        $cor = "line_color";
                                 else
                                        $cor = "";
                                 $cont++;
                                   
                                 $lnkArq = $obj->preencheZero("E", 4, $valores2['CAT'])."/".$arquivo=$obj->preencheZero("E", 4, $valores2['ARQ']).".".$valores2['EXT'];
                                 ?>
                                <tr class="<?php echo $cor;?>">
                                <?php echo "<td><a target='_blank' href=".$AD.CAMINHO_ARQUIVOS."CAT".$lnkArq.$AD.">".$valores2['NOM']."</a></td>";
                                    if(($valores["SolicitanteLogin"] == $_SESSION["user"]) && ($valores["StatusRM"] == 1 )){
                                      echo "<td><a href=".$AD."javascript:excluir('T0117','T0117/home&cod=".$valores['CodigoRM']."&path=".$lnkArq."','T113_T055','T055_codigo','".$valores2['ARQ']."','".$valores["CodigoRM"]."','".$lnkArq."')".$AD." title='Excluir' class='excluir'></a></td>";
                                    }?>
                                    
                                </tr> 
                                <?php }?>
                            </table></td>
                        <td class="acoes">
                            <span class="lista_acoes">
                                <ul>
                                   
                                    <li class="ui-state-default ui-corner-all" title="Visualizar">
                                        <a href="?router=T0117/consultar&codRM=<?php echo $valores['CodigoRM'];?>" class="ui-icon ui-icon-search"></a> 
                                    </li>
                                </ul>
                                <ul>
                                   <?php 
                                   $perfilSol   =   $obj->retornaPerfil($_SESSION["user"], 57);
                                   foreach ($perfilSol as $cpsSol => $valSol) {
                                   $obj->mostraBotao(57, $valores['SolicitanteLogin'] , $valores['StatusRM'], $valores["CodigoRM"]);}
                                   $perfilGest   =   $obj->retornaPerfil($_SESSION["user"], 59);
                                   foreach ($perfilGest as $cpsGest => $valGest) {
                                   $obj->mostraBotao(59, $valores['SolicitanteLogin'] , $valores['StatusRM'], $valores["CodigoRM"]);}
                                   ?>
                                   
                                </ul>
                           </span>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>            
            
            
        </div>
        
    </form>        
</div>

