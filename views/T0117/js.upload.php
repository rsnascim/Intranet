<?php
//print_r($_POST);
//print_r($_FILES);
if (isset($_FILES["P0117_arquivo"])){

//DECLARAÇÕES E PARAMETROS

    //Instancia Classe models_T0117
    $objUpload  =   new models_T0117();
 
//Utilizados
    $rm         =   $_POST['T113_codigo'];
    $arquivo    =   $_FILES["P0117_arquivo"];
    $tmp        =   $arquivo["tmp_name"];
    $nome       =   $arquivo["name"];
    $diretorio  =   CAMINHO_ARQUIVOS."CAT";
        //Extrai a extensão arquivo
        $extensao['extensao'] = explode('.' , $arquivo["name"]);
    $extensao = $extensao['extensao'][1];

    $data       =   date("d/m/Y");
    $categoria  =   $objUpload->preencheZero("E", 4, $_POST['T056_codigo']);

    //Selecinar extensao
    $tabela     =   "T057_extensao";
    $procura    =   $objUpload->selecionaExtensao($extensao);
    $i          =   0;
    foreach ($procura   as $campos=>$valores)
    {
        $codExt     =   $valores['COD'];
        $i++;
    }

    $_POST['T057_codigo']   =   $codExt;
    
    if($i==1)
    {
        //copia arquivo para diretóio files
        $copiar     =   move_uploaded_file($tmp, $diretorio .$categoria. "/" . $nome);
        if(!$copiar)
        {
            echo "nao copiou o arquivo!!";
            echo "arquivo nome: $arquivo";
            echo $tmp, $diretorio .$categoria. "/" . $nome;
            exit (0);
        }
        else
        {

            //Limpa variaveis array
            unset($_POST['T113_codigo']);
            //Atribui nome INTERNO (ex.: 0001.pdf)
            $_POST['T055_dt_upload']    =   $data;
            //inseri T055_arquivo
            $tabela      =  "T055_arquivos";
            $_POST['T055_nome']         =   "[Automatico] - P0117/Requisição de Mudança";
            $_POST['T055_desc']         =   "[Automatico] - P0117/Requisição de Mudança";
            $arrayArq   = array( 'T055_nome'        =>  $_POST["T055_nome"]
                                ,'T055_desc'        =>  $_POST["T055_desc"]
                                ,'T055_dt_upload'   =>  $_POST["T055_dt_upload"]
                                ,'T004_login'       =>  $_POST["T004_login"]
                                ,'T057_codigo'      =>  $_POST["T057_codigo"]
                                ,'T056_codigo'      =>  $_POST["T056_codigo"]);
            $insUpload   =  $objUpload->inserir($tabela, $arrayArq);
            $codArq      =  $objUpload->lastInsertId();
            //Renomeia arquivo
            $nomeInt    =   $objUpload->preencheZero("E", 4, $codArq).".".strtolower($extensao);
            
            if (rename($diretorio.$categoria."/".$nome,$diretorio.$categoria."/".$nomeInt))
            {
                //Inseri T113_T055
                $tabela      =  "T113_T055";
                $dados       = array('T113_codigo' => $rm
                                   , 'T055_codigo' => $codArq);

                $insUpload   =  $objUpload->inserir($tabela, $dados);
                //echo $insUpload;
                //Lê página inicial
              //  header("location:?router=T0117/home");
            }
            else
            {
                echo "teste";
            }
        }
    }
}

?>
