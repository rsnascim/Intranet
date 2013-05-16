<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 13/05/2013 por Roberta Schimidt
// * Descrição: Editar Categoria de Fornecedor
// * Entrada:   
// * Origens:   
//           
//**************************************************************************


$obj = new models_T0131();



$codigoCategoria = $_GET["cod"];

$dadosCat = $obj->retornaDados($codigoCategoria);


if (!empty($_POST)) {
            
    $codigoFornecedor       =   split("-",$_POST['T026_codigo'])    ;
    
    $nomeFornecedor         =   $_POST['T120_nome']                 ;
    $descricaoFornecedor    =   $_POST['T120_descricao']            ;
    
    $codigoFornecedor       =   (int)$codigoFornecedor[0];
    
    
    
    $tabela                 =   "T120_fornecedor_categoria" ;
    
    $campos                 =   array(  "T026_codigo"   =>  $codigoFornecedor,
                                        "T120_nome"     =>  $nomeFornecedor,
                                        "T120_desc"     =>  $descricaoFornecedor);
    
    $delim                   =  "T120_codigo    =   ".$codigoCategoria;
    
   $obj->altera($tabela, $campos, $delim);
    
    
}

foreach ($dadosCat as $cps => $vlr) {
    


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
            <label class="label">Fornecedor</label>
            <label class="label"></label>
            <input type="text" value="<?php echo $vlr["CodigoFornecedor"]." - ".$vlr["RazaoFornecedor"]?>" class="campoFornecedor" name="T026_codigo" />
        </div>

        <div class="clear"></div>    


        <div class="grid_6">
            <label class="label">Nome Categoria</label>
            <input type="text" name="T120_nome" value="<?php echo $vlr["NomeCategoria"]?>"/>
        </div>

        <div class="clear"></div>

        <div class="grid_4">
            <label class="label">Descrição Categoria</label>
            <textarea name="T120_descricao"   class="textarea-table" cols="122" rows="4" ><?php echo $vlr["DescricaoCategoria"]?></textarea>            
        </div>

        <div class="clear10"></div>
        
        <div class="grid_2">
            <input type="submit" value="Atualizar" class="botao-padrao" >
        </div>
    </form>



</div>

<?php }?>

