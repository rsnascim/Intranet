<?php
$obj = new models_T0131();

$fornecedorProcurado = $_GET['term'];

$rArray = array(); //array retorno

//Para Código do Fornecedor
if (is_numeric((int)$fornecedorProcurado)){
    
    $dados = $obj->retornaDadosFornecedor($fornecedorProcurado);

    foreach($dados as $campos => $valores)
    {
        $strFornecedor = $valores['CodigoFornecedor']." - ".$valores['NomeFornecedor'];
        array_push($rArray, $strFornecedor);
    }    
}else{
    //Para String

    $dados = $obj->retornaDadosFornecedor($fornecedorProcurado);

    foreach($dados as $campos => $valores)
    {
        $strFornecedor = $valores['CodigoFornecedor']." - ".$valores['NomeFornecedor'];
        array_push($rArray, $strFornecedor);
    }    
}

echo json_encode($rArray);

?>