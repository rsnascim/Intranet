<?php

$obj = new models_T0131();

$codigoCategoria    =   $_POST["cod"];


$tabela =   "T120_fornecedor_categoria";

$delim  =   "T120_codigo    =   ".$codigoCategoria;

$obj->excluir($tabela, $delim);

?>



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
    