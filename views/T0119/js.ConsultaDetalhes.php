<?php

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);

$Lote      = $_REQUEST['Lote'];
$Loja      = $_REQUEST['Loja'];
$Tipo      = $_REQUEST['Tipo'];

$HTML      =   " 
                <div class='grid_2'>
                  <label class='label'>Alguns campos do Header do Lote</label>
                  <label class='label'>Alguns campos do Header do Lote</label>
                </div>
                
                <div class='clear'></div>
               "; 

// verifica qual será o tipo de retorno
if ($Tipo==2)
{  // 2 = Producoes, chama procedure do Emporium
    
   $RetornoDetalhes= $objEMP->ConsultaDetalhesLoteLojaProducao($Loja, $Lote);    
   
   // Divide o array em 2, para producoes e insumos
   $ArrayProducoes=Array();
   $ArrayInsumos=Array();

   foreach($RetornoDetalhes as $campos=>$valores)
   {
       if($valores['itipo']=="P")
          $ArrayProducoes[]=$valores;
       else
          $ArrayInsumos[]=$valores;
   }   
   
   // monta as duas tabelas, de producoes e insumos
   
   $HTML   .= "                
                <div class='grid_2'>
                  <label class='label'>Itens Produzidos</label>
                </div>
                
                <div class='clear'></div>

                <div class='conteudo_10'>
                <table id='tDetalhes' class='tablesorter'>
                    <thead>
                        <tr>
                            <th>PLU</th>
                            <th>Descricao</th>
                            <th>Secao</th>
                            <th>Qtde</th>
                            <th>Valor Unit.</th>
                            <th>Valor Total</th>
                            <th>Preço Venda</th>
                            <th>Carga Trib.</th>
                        </tr>
                    </thead>
                    <tbody>";
                     foreach($ArrayProducoes as $campos=>$valores){
    $HTML .=           "<tr>
                            <td>".$valores['icditem']  ."</td>
                            <td>".$valores['idsplu']."</td>
                            <td>".$valores['idepto']."</td>
                            <td align='right'>".$objEMP->formataNumero($valores['iqtde'],3)."</td>
                            <td align='right'>".$objEMP->formataMoedaSufixo($valores['iunitprice'],3)."</td>
                            <td align='right'>".$objEMP->formataMoedaSufixo($valores['ivalor'])."</td>
                            <td align='right'>".$objEMP->formataMoedaSufixo($valores['ipreco'])."</td>
                            <td align='right'>".$objEMP->formataNumero($valores['ict'])."</td>
                        </tr> ";
                     }  
    $HTML .=     "  </tbody>
                </table>
                </div> ";
   
   
   
   
   
   $HTML   .= "

                <div class='grid_2'>
                  <label class='label'>Insumos Utilizados</label>
                </div>
                
                <div class='clear'></div>

                <div class='conteudo_10'>
                <table id='tDetalhes' class='tablesorter'>
                    <thead>
                        <tr>
                            <th>LoteOrigem</th>
                            <th>PLU</th>
                            <th>Descricao</th>
                            <th>Secao</th>
                            <th>Qtde</th>
                            <th>Valor Unit.</th>
                            <th>Valor Total</th>
                            <th>Carga Trib.</th>
                        </tr>
                    </thead>
                    <tbody>";
                     foreach($ArrayInsumos as $campos=>$valores){
    $HTML .=           "<tr>
                            <td>".$valores['iloteori']."</td>
                            <td>".$valores['icditem']  ."</td>
                            <td>".$valores['idsplu']."</td>
                            <td>".$valores['idepto']."</td>
                            <td align='right'>".$objEMP->formataNumero($valores['iqtde'],3)."</td>
                            <td align='right'>".$objEMP->formataMoedaSufixo($valores['iunitprice'],3)."</td>
                            <td align='right'>".$objEMP->formataMoedaSufixo($valores['ivalor'])."</td>
                            <td align='right'>".$objEMP->formataNumero($valores['ict'])."</td>
                        </tr> ";
                     }  
    $HTML .=     "  </tbody>
                </table>
                </div> ";

}
else
{
    $RetornoDetalhes = $objEMP->ConsultaDetalhesLoteLoja($Loja,$Lote);
    $HTML   .= "
                <div class='conteudo_10'>
                <table id='tDetalhes' class='tablesorter'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PLU</th>
                            <th>Descricao</th>
                            <th>Qtde</th>
                            <th>Valor Unit.</th>
                            <th>Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>";
                     foreach($RetornoDetalhes as $campos=>$valores){
    $HTML .=           "<tr>
                            <td>".$valores['sequence']."</td>
                            <td>".$valores['plu_id']  ."</td>
                            <td>".$valores['desc_plu']."</td>
                            <td align='right'>".$objEMP->formataNumero($valores['quantity'],3)."</td>
                            <td align='right'>".$objEMP->formataMoedaSufixo($valores['unit_price'],3)."</td>
                            <td align='right'>".$objEMP->formataMoedaSufixo($valores['amount'])."</td>
                        </tr> ";
                     }  
    $HTML .=     "  </tbody>
                </table>
                </div> ";
    
}



echo $HTML ; 
?>


  
