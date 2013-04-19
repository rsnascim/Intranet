<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 
 * Descrição: 
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe

$obj            =   new models_T0026();

$despesaCodigo  =   $_REQUEST['despesaCodigo'];

$dadosDespesa   =   $obj->retornaDespesa($despesaCodigo);
$dadosDespesaKm =   $obj->retornaDespesaDetalhe($despesaCodigo);
$dadosDespesaDiv=   $obj->retornaDespesasDiversas($despesaCodigo);

?>
    <!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0026/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"></span>Voltar    </a></li>
    </ul>
</div>

<div class="conteudo_16">

    <?php foreach($dadosDespesa as $campos  =>  $valores){ ?>

    <div class="grid_16">
        <span class="form-titulo">
            <p>Despesa Nro.: <?php echo $valores['DespesaCodigo'];?></p>
        </span>
    </div>    
    
    <div class="grid_2">
        <label class="label">CPF Colaborador</label>
        <p><?php echo $obj->FormataCGCxCPF($valores['CpfUsuario']);?></p>
    </div>
    
    <div class="grid_2">
        <label class="label">Data Elaboração</label>
        <p><?php echo $valores['DespesaData'];?></p>
    </div>
    
    <div class="grid_3">
        <label class="label">Período</label>
        <p><?php echo $valores['DespesaDtInicio']." à ".$valores['DespesaDtFim'];?>  </p>
    </div>
    
    <div class="grid_2">
        <label class="label">Total</label>
        <p><?php echo $obj->formataMoeda($valores['DespesaValor']);?></p>
    </div>
    
    <?php }?>
    
    <div class="clear10"></div>
    
    <div class="grid_16">
        <span class="form-titulo">
            <p>Despesa(s) com Quilometragem</p>
        </span>
    </div>
    
    <div class="grid_2">
        <label class="label">Saída</label>
    </div>
    
    <div class="grid_2">
        <label class="label">Chegada</label>
    </div>
    
    <div class="grid_4">
        <label class="label">Descrição/Histórico</label>
    </div>
    
    <div class="grid_3">
        <label class="label">Origem</label>
    </div>
    
    <div class="grid_3">
        <label class="label">Destino</label>
    </div>
    
    <div class="grid_1">
        <label class="label">Distância(Km)</label>
    </div>
    
    <div class="clear10"></div>
        
    <?php foreach($dadosDespesaKm as $cpDespKm => $vlDespKm){?>

        <div class="grid_2">
            <p><?php echo $vlDespKm['DespesaSaida'];?></p>
        </div>

        <div class="grid_2">
            <p><?php echo $vlDespKm['DespesaChegada'];?></p>
        </div>

        <div class="grid_4">
            <p><?php echo $vlDespKm['DespesaDescricao'];?></p>
        </div>

        <div class="grid_3">
            <p><?php echo $vlDespKm['DespesaDescOrigem'];?></p>
        </div>

        <div class="grid_3">
            <p><?php echo $vlDespKm['DespesaDescDestino'];?></p>
        </div>

        <div class="grid_1">
            <p><?php echo $vlDespKm['DespesaKm'];?></p>
        </div>
    
        <div class="clear"></div>
    
    <?php } ?>

    <div class="clear10"></div>
    
    <div class="grid_16">
        <span class="form-titulo">
            <p>Despesa(s) Diversa(s)</p>
        </span>
    </div>
        
    <div class="grid_4">
        <label class="label">Data</label>
    </div>
    
    <div class="grid_6">
        <label class="label">Conta</label>
    </div>
    
    <div class="grid_4">
        <label class="label">Valor</label>
    </div>  
        
    <div class="clear10"></div>
    
    <?php foreach($dadosDespesaDiv as $cpDespDiv => $vlDespDiv){ ?>

        <div class="grid_4">
            <p><?php echo $vlDespDiv['DespesaData'];?></p>
        </div>

        <div class="grid_6">
            <p><?php echo $obj->preencheZero("E", 3, $vlDespDiv['ContaCodigo'])."-".$vlDespDiv['ContaNome'];?></p>
        </div>

        <div class="grid_4">
            <p><?php echo $obj->formataMoeda($vlDespDiv['DespesaValor']);?></p>
        </div>    
    
        <div class="clear"></div>
    
    <?php } ?>
    
</div>

