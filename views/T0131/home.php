<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 08/05/2013 por Rodrigo Alfieri
// * Descrição: Categoria de Fornecedor
// * Entrada:   
// * Origens:   
//           
//**************************************************************************


//Instancia Classe
$obj    =   new models_T0131();
if(!empty($_POST)){
    
    $codigoCategoria    =   $_POST[''];
    $codigoFornecedor   =   split("-",$_POST['']);
    $nomeCategoria      =   $_POST[''];
    
    $codigoFornecedor   =   (int)$codigoFornecedor[0];
    
    
        $dados  =   $obj->retornaDados($codigoCategoria, $codigoFornecedor, $nomeCategoria);
    
    
}else
    $dados  =   $obj->retornaDados();


?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a href="<?php echo ROUTER."novo";?>"    class="botao-padrao"><span class="ui-icon ui-icon-plus"  ></span>Novo</a></li>
    </ul>
</div>
<div id="dialog-mensagem-categoria">
    
</div>
<div class="conteudo_16">
    <div class="grid_1">
        <label class="label">Código</label>
        <input type="text" name="T120_codigo"/>
    </div>
    
    <div class="grid_6">
        <label class="label">Fornecedor</label>
        <input type="text" name="T026_codigo" class="campoFornecedor"/>
    </div>
        
    <div class="grid_6">
        <label class="label">Nome</label>
        <input type="text" name="T120_nome"/>
    </div>
    
    <div class="grid_2">
        <input type="submit" value="Filtrar" class="botao-padrao" >
    </div>
    
    <div class="clear10"></div>
    
    <div  class="tabCategoria">
    <table id="tPrincipal" class="tablesorter">
        <thead>
            <tr>
                <th width="12%">Código Categoria    </th>
                <th width="12%">Nome Categoria      </th>
                <th width="12%">Fornecedor          </th>
                <th width="12%">Descrição Categoria </th>
                <th width="10%" >Ações              </th>
            </tr>
        </thead>
        <tbody>
        <?php   foreach($dados as $campos=>$valores){?>            
            <tr class="dados">                
                <td class="codigoCategoria"><?php echo $valores['CodigoCategoria'];?></td>
                <td><?php echo $valores['NomeCategoria'];?></td>                
                <td><?php echo $obj->preencheZero("E", 3, $valores['CodigoFornecedor'])." - ".$valores['RazaoFornecedor'];?></td>
                <td><?php echo $valores['DescricaoCategoria'];?></td>                
                <td>                                    
                    <ul class="lista-de-acoes">                                        
                        <li><a href="<?php echo "?router=T0131/editar&cod=".$valores['CodigoCategoria']?>" title="Editar"  class="">    <span class='ui-icon ui-icon-pencil'>  </span></a></li>                                    
                        <li><a href="#" title="Excluir"  class="exclui">     <span class='ui-icon ui-icon-closethick'>  </span></a></li>                                    
                    </ul>
                </td>
            </tr>
        <?php }?>
        </tbody>
        
    </table>    
    </div>
</div>
