<?php

///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 08/05/2013 por Rodrigo Alfieri
// * Descrição: Cadastro de categoria por fornecedor
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
//*/
//
//
class models_T0131 extends models
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
       
       return $insere;
    }      
    
    public function retornaDados($codigoCategoria, $codigoFornecedor, $nomeCategoria){
        $sql    =   "  SELECT T120.T120_codigo           CodigoCategoria
                            , T120.T026_codigo           CodigoFornecedor
                            , T26.T026_rms_razao_social  RazaoFornecedor
                            , T120.T120_nome             NomeCategoria
                            , T120.T120_desc             DescricaoCategoria
                         FROM T120_fornecedor_categoria T120
                         JOIN T026_fornecedor T26 ON T120.T026_codigo = T26.T026_codigo
                        WHERE 1  = 1 ";
        
        if(!empty($codigoCategoria))
            $sql  .=  " AND T120.T120_codigo =    $codigoCategoria";
        if(!empty($codigoFornecedor))
            $sql  .=  " AND T120.T026_codigo =    $codigoFornecedor";
        if(!empty($nomeCategoria))
            $sql  .=  " AND T120.T120_nome   LIKE  '%$nomeCategoria%'";
        
        return $this->query($sql);
        
    }
    
    public function retornaDadosFornecedor($fornecedorProcurado){
        
        $sql    =   "  SELECT T26.T026_codigo           CodigoFornecedor
                            , T26.T026_rms_razao_social NomeFornecedor
                         FROM T026_fornecedor T26 ";
        
        
        if(is_numeric($fornecedorProcurado))
            $sql    .=  " WHERE T26.T026_codigo =   $fornecedorProcurado";
        else
            $sql    .=  " WHERE T26.T026_rms_razao_social LIKE   '%$fornecedorProcurado%'";
        
        
        return $this->query($sql);
    }
    
    
      public function altera($tabela,$campos,$delim)
    {
       $conn = "";
       
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');          
       
       return $altera;
    }


        public function excluir($tabela, $delim)
    {
        $exclui =  $this->exec($this->exclui($tabela, $delim));
        
        if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
        else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!');         
        
        return $exclui;
    }
    
    
}
 ?>
