<?php
//captura nome do arquivo
$arquivo     = $_GET['file'];
//captura categoria do arquivo
$categoria   = $_GET['categoria'];
//captura nome da extensão
$extensao    = $_GET['extensao'];

//formata o path do caminho atual do arquivo
echo $path     = CAMINHO_ARQUIVOS."CAT".$categoria."/".$arquivo;
//formata o path do caminho temporário para fazer o download
echo $path_tmp = CAMINHO_ARQUIVOS."tmp"."/".$arquivo;
//formata o path para renomear o arquivo movido ao temporário   
echo $path_tmp_rename = CAMINHO_ARQUIVOS."tmp"."/".$arquivo.".".$extensao;

//Inicia a manipulação do arquivo
if (copy($path, $path_tmp))
   { //Copia o arquivo original para o diretório temporário
    echo "ARQUIVO COPIADO!";
    echo "<br/>";      
    if (rename($path_tmp, $path_tmp_rename))
       { //Renomeia o arquivo temporário
        echo "ARQUIVO RENOMEADO";
        echo "<br/>";
        //abre o arquivo
        header("location:$path_tmp_rename");
       }
    else
       {
        echo "ARQUIVO NÃO RENOMEADO";
        echo "<br/>";           
       }
   }
else
   {
    echo "NÃO COPIOU"; 
   }
?>
