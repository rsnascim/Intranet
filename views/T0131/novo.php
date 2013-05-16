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
$obj = new models_T0131();

if (!empty($_POST)) {
            
    $codigoFornecedor       =   split("-",$_POST['T026_codigo'])    ;
    $nomeFornecedor         =   $_POST['T120_nome']                 ;
    $descricaoFornecedor    =   $_POST['T120_descricao']            ;
    
    $codigoFornecedor       =   (int)$codigoFornecedor[0];
    
    $tabela                 =   "T120_fornecedor_categoria" ;
    
    $campos                 =   array(  "T026_codigo"   =>  $codigoFornecedor,
                                        "T120_nome"     =>  $nomeFornecedor,
                                        "T120_desc"     =>  $descricaoFornecedor);
    
    $obj->inserir($tabela, $campos);
    
    
}

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="<?php echo ROUTER . "home"; ?>"    class="botao-padrao"><span class="ui-icon ui-icon-arrow-1-w"  ></span>Voltar</a></li>
    </ul>
</div>

<div class="conteudo_16">

    <form action="" method="POST" class="validaFormulario">

        <div class="grid_6">                
            <label class="label"></label>
            <input type="text" placeholder="Digite o Código ou Razão Social do Fornecedor!" class="campoFornecedor" name="T026_codigo"/>
        </div>

        <div class="clear"></div>    


        <div class="grid_6">
            <label class="label">Nome Categoria</label>
            <input type="text" name="T120_nome"/>
        </div>

        <div class="clear"></div>

        <div class="grid_4">
            <label class="label">Descrição Categoria</label>
            <textarea name="T120_descricao"   class="textarea-table" cols="122" rows="4" ></textarea>            
        </div>

        <div class="clear10"></div>
        
        <div class="grid_2">
            <input type="submit" value="Gravar" class="botao-padrao" >
        </div>
    </form>



</div>