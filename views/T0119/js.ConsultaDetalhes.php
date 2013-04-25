<?php

//Instancia Classe
$conn      =   "emporium";
$objEMP    =   new models_T0119($conn);

$Lote      = $_REQUEST['Lote'];
$Loja      = $_REQUEST['Loja'];
$Tipo      = $_REQUEST['Tipo'];

function detalhesProducao($Loja, $Lote)
{
    $conn      =   "emporium";
    $objEMP    =   new models_T0119($conn);

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
                  <label class='label'>PRODUÇÃO : </label>
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
                            <th>Preço Liq.</th>
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
                            <td align='right'>".$objEMP->formataMoedaSufixo($valores['ipreco']*(1-$objEMP->formataNumero($valores['ict'])/100))."</td>
                        </tr> ";
                     
                        // armazena totalizadores
                        $ValorTotal    += $valores['ivalor'] ;
                        $PrecoTotal    += $valores['ipreco']*$valores['iqtde'] ;
                        $PrecoLiqTotal += ($valores['ipreco']*(1-$objEMP->formataNumero($valores['ict'])/100))*$valores['iqtde'] ;
    
                     }
                     $MargemLiq=100*($PrecoLiqTotal-$ValorTotal)/$PrecoLiqTotal;
    $HTML .=     "  </tbody>
                    <tfoot>
                        <tr style='height:10px;'>
                        </tr> 
                        <tr style='height:25px;'>
                            <td colspan='5' align='right'><b>Total</b></td>
                            <td align='right'><B>".$objEMP->formataMoedaSufixo($ValorTotal)."</B></td>
                            <td align='right'><B>".$objEMP->formataMoedaSufixo($PrecoTotal)."</B></td>
                            <td align='right'><B>".$objEMP->formataMoedaSufixo($PrecoLiqTotal)."</B></td>
                        </tr> 
                        <tr>
                            <td colspan='5' align='right'><b>Margem Potencial </b></td>
                            <td align='right'><B>".$objEMP->formataMoedaSufixo($MargemLiq)."%</B></td>
                            <td colspan='2' align='right'></td>
                        </tr> 
                    </tfoot>
                    
                </table>
                </div> ";
   
   
   
   
   
   $HTML   .= "

                <div class='grid_2'>
                  <label class='label'>INSUMOS : </label>
                </div>
                
                <div class='clear'></div>

                <div class='conteudo_10'>
                <table id='tDetalhes2' class='tablesorter'>
                    <thead>
                        <tr>
                            <th>LoteOrigem</th>
                            <th>PLU</th>
                            <th>Descricao</th>
                            <th>Secao</th>
                            <th>Qtde</th>
                            <th>Valor Unit.</th>
                            <th>Valor Total</th>
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
                        </tr> ";
                     }  
    $HTML .=     "  </tbody>
                </table>
                </div> ";
    
    return $HTML ;
    
}

$Retorno   = $objEMP->ConsultaLote($Loja, $Lote);

$HTML      =   " 
                <div class='grid_2'>
               ";
// apresenta campos do Header do Lote
foreach($Retorno as $campos=>$valores)
{ 
  $HTML     .= "<label class='label'>Loja:  ".$valores['store_key']."  -  Lote:  ".$valores['lote_numero']."</label>";
  $HTML     .= "<label class='label'>Data:  ".$objEMP->formataDataHoraView($valores['start_time'])." - Valor: ".$objEMP->formataMoedaSufixo($valores['amount'])."</label>";
  $HTML     .= "<label class='label'>Tipo: ".$objEMP->RetornaStringTipo($valores['tipo_codigo'])."</label>";
  
  
  // armazena Status da Aprovação
  // utilizado para Producoes reprovadas/rejeitadas
  $StatusAprovacao = $valores['aprovacao_status_id'];
}
                      
$HTML     .=   "
                 </div>
                <div class='clear'></div>
               "; 

// verifica qual será o tipo de retorno
if (($Tipo==2)&&($StatusAprovacao<>7)&&$StatusAprovacao<>8)
{  // 2 = Producoes, chama procedure do Emporium;
    $HTML .= detalhesProducao($Loja, $Lote);

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
                     foreach($RetornoDetalhes as $campos=>$valores)
                     {
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
if ($Tipo==1)
{ 
    $RetornoConsumos   = $objEMP->ConsultaLotesDestino($Loja, $Lote);

    if($RetornoConsumos)
    {    
        // apresenta campos do Lote do Destino
        foreach($RetornoConsumos as $campos=>$valores)
        {
           $HTML      .= "
                            <BR>
                            <BR>
                            <div class='clear'></div>
                            <div class='clear'></div>
                            <div class='grid_2'>
                              <H2><label class='label'>LOTE $Lote CONSUMIDO EM : </label></H2>
                            </div>
                           ";

            $HTML      .=   " 
                            <div class='clear'></div>
                            <div class='grid_2'>
                           ";
            
            $HTML     .=   "<label class='label'>Lote:  ".$valores['lote_numero']." - ".$objEMP->RetornaStringTipo($valores['tipo_codigo'])."</label>";
            $HTML     .=   "<label class='label'>Data:  ".$objEMP->formataDataHoraView($valores['start_time'])."</label>";
            $HTML     .=   "<label class='label'>Valor: ".$objEMP->formataMoedaSufixo($valores['amount'])."</label>";
            $HTML     .= "</div>";
            $HTML     .=   "
                            <div class='clear'>
                            </div>
                           "; 

            $HTML     .= detalhesProducao($valores['store_key'],$valores['lote_numero']);  

        }

        $HTML     .=   "
                        <div class='clear'>
                        </div>
                       "; 
    }
}
echo $HTML ; 
?>


  
