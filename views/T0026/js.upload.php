<<<<<<< HEAD
<?php
//Instancia Classe
$obj        =   new models_T0026();
$msgRetorno =   0;

if(!empty($_POST))
{
    
    $codigoDespesa          =   $_REQUEST['codigoDespesa']              ;
    $arquivo                =   $_FILES["despesaArquivo"]               ;
    $tmp                    =   $arquivo["tmp_name"]                    ;
    $nome                   =   $arquivo["name"]                        ;
    $diretorio              =   CAMINHO_ARQUIVOS."CAT0002/"             ;   //Categoria de Arquivo de RD
    $user                   =   $_SESSION['user']                       ;

    $arrExtensao            =   explode('.' , $arquivo["name"])         ;
    $extensao               =   $arrExtensao[1]                         ;

    $dataHora               =   date("d/m/Y H:i:s")                     ;

    $codigoExtensao         =   $obj->verificaExtensaoArquivo($extensao);
    $msgRetorno             =   1;
    if($codigoExtensao)
    {   
        //copia arquivo para diretóio files
        $copiar     =   move_uploaded_file($tmp, $diretorio.$nome);    
        if(!$copiar)
        {
            $msgRetorno     =   2;
        }
        else
        {
            $tabela =   "T055_arquivos";

            $campos =   array( "T055_nome"          =>  "[Automatico] - P0026/Reembolso de Despesa"
                             , "T055_desc"          =>  "[Automatico] - P0026/Reembolso de Despesa"
                             , "T055_dt_upload"     =>  $dataHora
                             , "T004_login"         =>  $user
                             , "T057_codigo"        =>  $codigoExtensao
                             , "T056_codigo"        =>  2   //Categoria de RD
                             , "T061_codigo"        =>  2   //Processo de RD
                             );

            $inseri =   $obj->inserir($tabela, $campos);
            if($inseri)
            {
                $codigoArquivo  =   $obj->lastInsertId();

                //Renomeia arquivo
                $nomeInt    =   $obj->preencheZero("E", 4, $codigoArquivo).".".strtolower($extensao);

                if (rename($diretorio.$nome,$diretorio.$nomeInt))
                {
                    $tabela      =  "T016_T055";
                    $campos      = array('T016_codigo' => $codigoDespesa
                                       , 'T055_codigo' => $codigoArquivo);

                    $obj->inserir($tabela, $campos);
                }
                else
                {
                    $msgRetorno =   2;
                }
            }
        }
    }
    else
        $msgRetorno =   2;
    
}
?>
<link rel="stylesheet" href="template/css/-estilo-include-tudo.css"/>

<?php if($_SERVER['SERVER_NAME']=='localhost'){?>
    <link rel="stylesheet" href="template/css/-layout-local.css"/>
<?php }?>
<?php if($_SERVER['SERVER_NAME']=='oraas141'){?>
    <link rel="stylesheet" href="template/css/-layout-qas.css"/>
<?php }?>
<?php if($_SERVER['SERVER_NAME']=='oraas041'){?>
    <link rel="stylesheet" href="template/css/-layout-prd.css"/>
<?php }?>

<p    class="validateTips">Selecione a despesa para efetuar o upload!</p>
<span class="form-input">
<form action="" method="post"  enctype="multipart/form-data">
    <fieldset>
            <label class="label">Escolha o Arquivo*</label>                
            <input type="file"      name="despesaArquivo"   id="arquivo"        />
            <input type="hidden"    name="codigoDespesa"    id="codigoDespesa"  />
            <p id="resposta" style="display:none"><?php echo $msgRetorno;?></p>
    </fieldset>
</form>
=======
<?php
//Instancia Classe
$obj        =   new models_T0026();
$msgRetorno =   "to aki";

if(!empty($_POST))
{
    
    $codigoDespesa          =   $_REQUEST['codigoDespesa']              ;
    $arquivo                =   $_FILES["despesaArquivo"]               ;
    $tmp                    =   $arquivo["tmp_name"]                    ;
    $nome                   =   $arquivo["name"]                        ;
    $diretorio              =   CAMINHO_ARQUIVOS."CAT0002/"             ;   //Categoria de Arquivo de RD
    $user                   =   $_SESSION['user']                       ;

    $arrExtensao            =   explode('.' , $arquivo["name"])         ;
    $extensao               =   $arrExtensao[1]                         ;

    $dataHora               =   date("d/m/Y H:i:s")                     ;

    $codigoExtensao         =   $obj->verificaExtensaoArquivo($extensao);
    $msgRetorno             =   1;
    if($codigoExtensao)
    {   
        //copia arquivo para diretóio files
        $copiar     =   move_uploaded_file($tmp, $diretorio.$nome);    
        if(!$copiar)
        {
            $msgRetorno     =   2;
        }
        else
        {
            $tabela =   "T055_arquivos";

            $campos =   array( "T055_nome"          =>  "[Automatico] - P0026/Reembolso de Despesa"
                             , "T055_desc"          =>  "[Automatico] - P0026/Reembolso de Despesa"
                             , "T055_dt_upload"     =>  $dataHora
                             , "T004_login"         =>  $user
                             , "T057_codigo"        =>  $codigoExtensao
                             , "T056_codigo"        =>  2   //Categoria de RD
                             , "T061_codigo"        =>  2   //Processo de RD
                             );

            $inseri =   $obj->inserir($tabela, $campos);
            if($inseri)
            {
                $codigoArquivo  =   $obj->lastInsertId();

                //Renomeia arquivo
                $nomeInt    =   $obj->preencheZero("E", 4, $codigoArquivo).".".strtolower($extensao);

                if (rename($diretorio.$nome,$diretorio.$nomeInt))
                {
                    $tabela      =  "T016_T055";
                    $campos      = array('T016_codigo' => $codigoDespesa
                                       , 'T055_codigo' => $codigoArquivo);

                    $obj->inserir($tabela, $campos);
                }
                else
                {
                    $msgRetorno =   2;
                }
            }
        }
    }
    else
        $msgRetorno =   2;
    
}
?>
<link rel="stylesheet" href="template/css/-estilo-include-tudo.css"/>

<?php if($_SERVER['SERVER_NAME']=='localhost'){?>
    <link rel="stylesheet" href="template/css/-layout-local.css"/>
<?php }?>
<?php if($_SERVER['SERVER_NAME']=='oraas141'){?>
    <link rel="stylesheet" href="template/css/-layout-qas.css"/>
<?php }?>
<?php if($_SERVER['SERVER_NAME']=='oraas041'){?>
    <link rel="stylesheet" href="template/css/-layout-prd.css"/>
<?php }?>

<p    class="validateTips">Selecione a despesa para efetuar o upload!</p>
<span class="form-input">
<form action="" method="post"  enctype="multipart/form-data">
    <fieldset>
            <label class="label">Escolha o Arquivo*</label>                
            <input type="file"      name="despesaArquivo"   id="arquivo"        />
            <input type="hidden"    name="codigoDespesa"    id="codigoDespesa"  />
            <p id="resposta" style="display:none"><?php echo $msgRetorno;?></p>
    </fieldset>
</form>
>>>>>>> dev-roberta
</span>