<?php


/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/01/2012 por Jorge Nova
 * Descrição: Classe de models para o programa T077
 * Entrada:   
 * Origens:   
           
**************************************************************************
*/


class models_T0077 extends models
{

    public function __construct($conn,$verificaConexao,$db)
    {
        parent::__construct($conn,$verificaConexao,$db);
    }
    
    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluido com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');
       
       return $insere;
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
        $exclui = $this->exec($this->exclui($tabela, $delim));
        
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!');
       
       return $exclui;
    }  
    
    public function retornaMedicos($filtros)
    {
        
        $sql = "SELECT TF1.T085_crm	CRM
                     , TF1.T085_nome	Nome 
                  FROM T085_medico 	TF1";
        
        $sql .= $filtros;    
        
        $sql .= "LIMIT 50";
        
        return $this->query($sql);
        
    }    
    
}
?>
