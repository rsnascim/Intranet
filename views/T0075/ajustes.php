<?php
///**************************************************************************
//                Intranet - DAVÓ SUPERMERCADOS
// * Criado em: 17/07/2012 por Roberta Schimidt                               
// * Descrição: Ajustes EM$
// * Entrada:   
// * Origens:   
//           
//**************************************************************************
$conn = "";
$obj = new models_T0075($conn);



$retornaAjuste = $obj->retornaAjusteEms($_GET["data"], $_GET["loja"], $_GET["pdv"], $_GET["tipo"]);

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li><a href="?router=T0075/ajustes" class="active">Ajustes</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Ajustes</a></li>
    </ul>
</div>
<span class="lista_itens">  
             <table width="80%">
		<thead >
			<tr style="background-color: #d3d3d3" >
                            <th width="3%" style="text-align: center;" >Loja   </th>
                            <th width="3%" style="text-align: center;" >Data da Operação     </th>
                            <th width="9%" style="text-align: center;">Conta</th>
                            <th width="12%"  style="text-align: center;">CPF</th>
                            <th width="3%"  style="text-align: center;">Tipo</th>
                            <th width="5%" style="text-align: center;" >À vista </th>
                            <th width="3%" style="text-align: center;" > Qtd Parc   </th>
                            <th width="5%" style="text-align: center;"  > Valor da Parcela    </th>
                            <th width="3%" style="text-align: center;"  > Total   </th>
                            <th width="3%" style="text-align: center;"  > Cupom   </th>
                            <th width="5%" style="text-align: center;"  > PDV    </th>
                            <th width="15%" style="text-align: center;"  > Motivo   </th>
                            <th width="5%" style="text-align: center;"  > Ações         </th>
                          </tr>
                </thead>
               <tbody >
                   <?php 
                   
              $data = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
              $dataInc = substr($dataInc,6,4)."-".substr($dataInc,3,2)."-".substr($dataInc,0,2);
                            foreach($retornaAjuste as $campos=>$valores){
                                
            $dataRet = $valores["DataOper"];  
            $dataRet = substr($dataRet,8,2)."/".substr($dataRet,5,2)."/".substr($dataRet,0,4);
            $dataIncR = $valores["DataLan"];
            $dataIncR = substr($dataIncR,8,2)."/".substr($dataIncR,5,2)."/".substr($dataIncR,0,4);
            
           $valores["CPF"] = str_replace(".","",$valores["CPF"]);
           $valores["CPF"] = str_replace("-","",$valores["CPF"]);
            
                               
                               
                                
                   ?>
                   <tr>
                       <td align="center"><?php echo $valores["NomeLoja"];?></td>
                       <td><?php echo $dataRet;?></td>
                       <td><?php echo $valores["Conta"];?></td>
                       <td><?php echo $valores["CPF"];?></td>
                       <td><?php echo $valores["TipoOper"];?></td>
                       <td><?php echo str_replace(".", ",",$valores["ValorVista"] );?></td>
                       <td align="center"><?php echo str_replace(".", ",", $valores["QtdParc"]);?></td>
                       <td><?php echo str_replace(".", ",", $valores["ValorParc"]) ;?></td>
                       <td align ="center"><?php echo str_replace(".", ",", $valores["ValorTotal"]) ;?></td>
                       <td><?php echo $valores["Cupom"];?></td>
                       <td><?php echo $valores["Pdv"];?></td>
                       <td><?php echo $valores["Motivo"];?></td>
                       <td>
               <a class="ui-icon ui-icon-search" href="?router=T0111/detalhes&cod=<?php echo $valores["Codigo"]?>"></a></td>
                       
                   </tr>
               </tbody>
               <?php } ?>
             </table>
         </span>
</div>