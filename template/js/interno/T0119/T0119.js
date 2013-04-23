// Data de Criação:
// Descrição:      
// Desenvolvedor:  

$(function(){
    
    //Tablesorter
    // original
    
//    $("#tPrincipal").tablesorter({widget:['zebra']                //Tabela Zebrada
//                                  , sortList: [[1,0]]               //Ordena Coluna 2 Crescente
//                                  , headers: {0:{sorter: false}    //Retira o "Sorter" da Coluna 1
//                                             , 7:{sorter: false}    //Retira o "Sorter" da Coluna 8
//                                             }
//
//                                  });

//   $("#tPrincipal").tablesorter({ widgets:['zebra']                //Tabela Zebrada
//                                , locale: 'br'  // nao sei se funciona
//                                , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
//                                , sortMultiSortKey: 'ctrlKey' // seleção de mais de uma coluna para ordenacao
//                                , headers: {
//                                                0:{sorter: false}    // retira sorter da coluna 99 ** exemplo **
//                                              , 100:{sorter: false}    // retira sorter da coluna 99 ** exemplo **
//                                              , 3: {sorter:"text"} 
//                                              , 6: {sorter:"brazilCurrency"} // moeda
//                                          }
//                                });

   function aprovarLote(Lote, Loja, Tipo, Obj){
    var arrLote = new Array();
    var arrLoja = new Array();
    var arrTipo = new Array();
    $("#dialog-aprovar").html("<p>Detalhes da chamada </p>");
    $("#dialog-aprovar").dialog
    ({
            resizable: false,
            height:200,
            draggable: false,
            width:200,
            modal: true,
            title:"Aprovar Lote "+Lote+" ? ",
            buttons:
            {
                    Aprovar: function() 
                    {
                        arrLote.push(Lote);
                        arrLoja.push(Loja);
                        arrTipo.push(Tipo);
                        $.get("?router=T0119/js.AprovarReprovar",{arrLote:arrLote,arrLoja:arrLoja, arrTipo:arrTipo, Acao:2},function(retorno){
                            if(retorno==1){
                                show_stack_bottomleft(false," ","Lote Aprovado com sucesso");
                                //$($thisAprovar).remove();
                                Obj.parents("tr").remove();
                            }else{
                              show_stack_bottomleft(true,"Erro","Lote Não Aprovado");
                            }

                        });

                        $(this).dialog("close");
                    }
                    ,
                    Sair: function()
                    {
                        $(this).dialog("close");
                    }
            }
    });
   };
   
   function reprovarLote(Lote, Loja, Tipo, Obj){
    var arrLote = new Array();
    var arrLoja = new Array();
    var arrTipo = new Array();       
    $("#dialog-aprovar").html("<p>Confirma reprovação de Lote?<BR>Essa ação <B>NÃO</B> pode ser desfeita. </p>")
    $("#dialog-aprovar").dialog
    ({
            resizable: false,
            height:200,
            draggable: false,
            width:200,
            modal: true,
            title:"Reprovar Lote "+Lote+" ? ",
            buttons:
            {
                    Reprovar: function() 
                    {                        
                        arrLote.push(Lote);
                        arrLoja.push(Loja);
                        arrTipo.push(Tipo);                        
                        $.get("?router=T0119/js.AprovarReprovar",{arrLote:arrLote, arrLoja:arrLoja, arrTipo:arrTipo, Acao:7},function(retorno){
                            if(retorno==1){
                                show_stack_bottomleft(false," ","Lote Reprovado com sucesso");
                               
                                Obj.parents("tr").remove();
                            }else{
                              show_stack_bottomleft(true,"Erro","Lote Não Reprovado");
                            }

                        });

                        $(this).dialog("close");
                    }
                    ,
                    Sair: function()
                    {
                        $(this).dialog("close");
                    }
            }
    });
   };

    $(".Detalhes").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        var Loja=$($thisAprovar).parents("tr").find(".txtLoja").text();
        var Tipo=$($thisAprovar).parents("tr").find(".txtTipo").text();

        $.get("?router=T0119/js.ConsultaDetalhes",{Lote:Lote,Loja:Loja,Tipo:Tipo},function(retorno){
            $("#dialog-detalhes").html(retorno);
            $("#tDetalhes").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleção de mais de uma coluna para ordenacao
                                        , headers: {
                                                        100:{sorter: false}   
                                                      , 3: {sorter:"brazilNumber"}   
                                                      , 4: {sorter:"brazilCurrency"} // moeda
                                                      , 5: {sorter:"brazilCurrency"}
                                                  }
                                        });
            $("#tDetalhes2").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleção de mais de uma coluna para ordenacao
                                        , headers: {
                                                        100:{sorter: false}   
                                                      , 3: {sorter:"brazilNumber"}   
                                                      , 4: {sorter:"brazilCurrency"} // moeda
                                                      , 5: {sorter:"brazilCurrency"}
                                                  }
                                        });

        });  
        
        $("#dialog-detalhes").dialog
        ({
                resizable: true,
                height:600,
                draggable: true,
                width:800,
                modal: true,
                title:"Detalhes do Lote "+Lote,            
                buttons:
                {
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }

                }

        });

    }) ;

    $(".DetalhesAprovar").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        var Loja=$($thisAprovar).parents("tr").find(".txtLoja").text();
        var Tipo=$($thisAprovar).parents("tr").find(".txtTipo").text();

        $.get("?router=T0119/js.ConsultaDetalhes",{Lote:Lote,Loja:Loja,Tipo:Tipo},function(retorno){
            $("#dialog-detalhes").html(retorno);
            $("#tDetalhes").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleção de mais de uma coluna para ordenacao
                                        , headers: {
                                                        100:{sorter: false}   
                                                      , 3: {sorter:"brazilNumber"}   
                                                      , 4: {sorter:"brazilCurrency"} // moeda
                                                      , 5: {sorter:"brazilCurrency"}
                                                  }
                                        });
            $("#tDetalhes2").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleção de mais de uma coluna para ordenacao
                                        , headers: {
                                                        100:{sorter: false}   
                                                      , 3: {sorter:"brazilNumber"}   
                                                      , 4: {sorter:"brazilCurrency"} // moeda
                                                      , 5: {sorter:"brazilCurrency"}
                                                  }
                                        });

        });  

        
        $("#dialog-detalhes").dialog
        ({
                resizable: true,
                height:600,
                draggable: true,
                width:800,
                modal: true,
                title:"Detalhes do Lote "+Lote,            
                buttons:
                {
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                        ,
                        Aprovar: function() 
                        {
                            aprovarLote(Lote, Loja, Tipo,$thisAprovar);
                            $(this).dialog("close");
                        }
                        ,
                        Reprovar: function() 
                        {
                           reprovarLote(Lote, Loja, Tipo,$thisAprovar);
                            $(this).dialog("close");
                        }

                }

        });

    }) ;
    
    $(".Aprovar").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        var Loja=$($thisAprovar).parents("tr").find(".txtLoja").text();
        var Tipo=$($thisAprovar).parents("tr").find(".txtTipo").text();
        
        aprovarLote(Lote, Loja, Tipo, $thisAprovar);
        
    }) ;
    
    $(".Reprovar").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        var Loja=$($thisAprovar).parents("tr").find(".txtLoja").text();
        var Tipo=$($thisAprovar).parents("tr").find(".txtTipo").text();
        
        reprovarLote(Lote, Loja, Tipo, $thisAprovar);
        
    }) ;
    
    $("#selecionaTodos").live("click", function(){
        var $this = $(".dados").find(".selecionaItem");
        if ($("#selecionaTodos").attr("checked")) {
           $this.attr("checked", "checked");  
        }
        else {
            $this.removeAttr("checked");
        }
    });
    
    $('#aprovarSelecionados').live("click", function(){       
        var $this           = $(".dados").find(".selecionaItem");
        var Lote            = new Array();
        var Loja            = new Array();
        var Tipo            = new Array();
        var QtdeReg         = 0;  
        $("#dialog-detalhes").html("<p>Detalhes da chamada</p>")
        $("#dialog-detalhes").dialog
        
        ({
                resizable: true,
                height:200,
                draggable: true,
                width:250,
                modal: true,
                title:"Aprovar todos selecionados ? ",
                
                buttons:
                {
                        Não: function()
                        {
                            $(this).dialog("close");
                        }
                        ,
                        Sim: function() 
                        {
                            if($this.is(':checked'))
                            {
                                $(".selecionaItem:checked").each(function(){
                                     // verifica se a linha esta oculta usando o FILTRO DINAMICO
                                    if($(this).parents('tr').css('display') != 'none')
                                    {
                                        Lote.push($(this).parents('tr').find('.txtLote').text());
                                        Loja.push($(this).parents('tr').find('.txtLoja').text());
                                        Tipo.push($(this).parents('tr').find('.txtTipo').text());
                                        QtdeReg=QtdeReg+1;
                                    }

                                });
                                // verifica se foi selecionado algum registro
                                if(QtdeReg>0)
                                {    
                                    $.post("?router=T0119/js.AprovarReprovar",{arrLote:Lote, arrLoja:Loja, arrTipo:Tipo, Acao:2}, function(dados){
                                        if ( dados == 1){
                                            $(".selecionaItem:checked").each(function(){
                                                $(this).parents('tr').remove();
                                            });

                                            show_stack_bottomleft(false, '', 'Lote(s) Aprovado(s) com sucesso!'); 

                                        }                        
                                        else
                                            show_stack_bottomleft(true, 'Erro!', 'Lote(s) Não Aprovado(s)'); 
                                    });
                                }else
                                    show_stack_bottomleft(true, 'Erro!', 'Não foi selecionado nenhum lote!');                 
                            }else
                                    show_stack_bottomleft(true, 'Erro!', 'Não foi selecionado nenhum lote!');                 
                            
                            $(this).dialog("close");
                        }

                }

        });
    });
    
    $('#reprovarSelecionados').live("click", function(){       
        var $this           = $(".dados").find(".selecionaItem");
        var Lote            = new Array();
        var Loja            = new Array();
        var Tipo            = new Array();
        var QtdeReg         = 0;  
        $("#dialog-detalhes").html("<p>Detalhes da chamada</p>")
        $("#dialog-detalhes").dialog
        ({
                resizable: false,
                height:200,
                draggable: false,
                width:250,
                modal: true,
                title:"Reprovar todos selecionados ? ",
                // escrever dentro da caixa
                buttons:
                {
                        Não: function()
                        {
                            $(this).dialog("close");
                        }
                        ,
                        Sim: function() 
                        {   
                            if($this.is(':checked'))
                            {
                                $(".selecionaItem:checked").each(function(){
                                     // verifica se a linha esta oculta usando o FILTRO DINAMICO
                                    if($(this).parents('tr').css('display') != 'none')
                                    {
                                        Lote.push($(this).parents('tr').find('.txtLote').text());
                                        Loja.push($(this).parents('tr').find('.txtLoja').text());
                                        Tipo.push($(this).parents('tr').find('.txtTipo').text());
                                        QtdeReg=QtdeReg+1;
                                    }

                                });
                                // verifica se foi selecionado algum registro
                                if(QtdeReg>0)
                                {    
                                    $.post("?router=T0119/js.AprovarReprovar",{arrLote:Lote, arrLoja:Loja, arrTipo:Tipo, Acao:7}, function(dados){
                                        if ( dados == 1){
                                            $(".selecionaItem:checked").each(function(){
                                                $(this).parents('tr').remove();
                                            });

                                            show_stack_bottomleft(false, '', 'Lote(s) Reprovado(s) com sucesso!'); 

                                        }                        
                                        else
                                            show_stack_bottomleft(true, 'Erro!', 'Lote(s) Não Reprovado(s)'); 
                                    });
                                }else
                                    show_stack_bottomleft(true, 'Erro!', 'Não foi selecionado nenhum lote!');                 
                            }else
                                    show_stack_bottomleft(true, 'Erro!', 'Não foi selecionado nenhum lote!');                 
                            
                            $(this).dialog("close");
                        }

                }

        });
        
        
    });
    
});
/* ============== Função para Upload Fim  =================== */ 

/* ============== T0026/novo FIM ============================ */

/* -------- Controle de versões - T0026.js --------------
 * 1.0.0 - 99/99/9999 - Rodrigo --> 1. Liberada versao inicial
 */