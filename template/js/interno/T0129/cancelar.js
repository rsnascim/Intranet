function cancelar(prog,pagina,tabela,status,campo,valor,etapa)
{
    document.prog   =   prog;
    document.pagina =   pagina;
    document.tabela =   tabela;
    document.status =   status;
    document.campo  =   campo;
    document.valor  =   valor;
    document.etapa  =   etapa;
    $("#dialog-cancelar").dialog
    ({
            resizable: false,
            height:140,
            modal: true,
            buttons:
            {
                    "Cancelar": function()
                    {
                       $.get('?router='+document.prog+'/js.cancelar&pagina='+document.pagina+'&tabela='+document.tabela+'&status='+document.status+'&campo='+document.campo+'&valor='+document.valor+'&etapa='+document.etapa);
                       $(this).dialog("close");
                        var qs =    $("#id_search").quicksearch(".dados", {
                                    noResults: '#semresultado',
                                    stripeRows: ['odd', 'even'],
                                    loader: 'span.loading'
                                    });
                        var tipo    =   10;
                        var filtro  =   $("#aps").val();
                        var itens   =   "";
                        $("#carregando").html("Carregando...");
                        $.getJSON("?router=T0129/busca&tipo="+tipo+"&filtro="+filtro, function(dados){
                            if (dados == null)
                                {
                                    $(".dados").remove();
                                    $("#carregando").html("Não existem dados para esta seleção...");
                                }
                            else
                                {
                                $.each(dados, function(i, item){
                                    itens = itens + item;
                                })
                                $(".campos").html(itens);
                                //Utiliza o que tem no cache para efetuar o filtro em elemento dinamico
                                qs.cache();
                                $("#carregando").html("");
                                }
                        })
                    }
                    ,
                    Fechar: function()
                    {
                        $(this).dialog("close");
                    }
            }
    });
}