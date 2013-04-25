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

   $("#tPrincipal").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                , locale: 'br'  // nao sei se funciona
                                , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                , sortMultiSortKey: 'ctrlKey' // seleção de mais de uma coluna para ordenacao
                                , headers: {
                                                100:{sorter: false}    // retira sorter da coluna 99 ** exemplo **
                                              , 2: {sorter:"text"} 
                                              , 5: {sorter:"brazilCurrency"} // moeda
                                          }
                                });

   function aprovarLote(Lote,Loja,Obj){
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
                        $.get("?router=T0119/js.AprovarReprovar",{Lote:Lote,Loja:Loja,Acao:2},function(retorno){
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
   function reprovarLote(Lote,Loja,Obj){
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
                        $.get("?router=T0119/js.AprovarReprovar",{Lote:Lote,Loja:Loja,Acao:7},function(retorno){
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
                                                        7:{sorter: false}   
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
                            aprovarLote(Lote,Loja,$thisAprovar);
                            $(this).dialog("close");
                        }
                        ,
                        Reprovar: function() 
                        {
                           reprovarLote(Lote,Loja,$thisAprovar);
                            $(this).dialog("close");
                        }

                }
                
        })

    }) ;
    
    $(".Aprovar").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        var Loja=$($thisAprovar).parents("tr").find(".txtLoja").text();
        
        aprovarLote(Lote,Loja,$thisAprovar);
        
    }) ;
    
    $(".Reprovar").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        var Loja=$($thisAprovar).parents("tr").find(".txtLoja").text();
        
        reprovarLote(Lote,Loja,$thisAprovar);
        
    }) ;
});
/* ============== Função para Upload Fim  =================== */ 

/* ============== T0026/novo FIM ============================ */

/* -------- Controle de versões - T0026.js --------------
 * 1.0.0 - 99/99/9999 - Rodrigo --> 1. Liberada versao inicial
 */