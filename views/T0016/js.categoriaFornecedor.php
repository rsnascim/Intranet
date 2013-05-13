<?php 

//Instancia Classe
$objWkf         =   new models_T0016();

$forn   =   $_POST["forn"];
$codRms =   $_POST["codRms"];

    $forn = str_replace(".", "", $forn);
    $forn = str_replace("/", "", $forn);
    $forn = str_replace("-", "", $forn);
    

$fornecedor =   $objWkf->listaCategoriaFornecedor($forn, $codRms);
?>


<select id="categoriaFornecedor" class="form-input-text-table" style="width:350px;" name="T120_codigo">
    <option value="0">Selecione...</option>
    <?php foreach ($fornecedor as $cpsForn => $vlrForn) {
     ?>
        
    <option value="<?php echo $vlrForn["Codigo"]?>"><?php echo $vlrForn["Nome"];?></option>
        
    <?php } ?>
</select>


