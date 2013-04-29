// Data de CriaÃ§Ã£o:
// DescriÃ§Ã£o:      
// Desenvolvedor:  

$(function(){

    $("#tPrincipal").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                , sortList: [[4,0]]               //Ordena Coluna 1 Crescente
                                , sortMultiSortKey: 'ctrlKey' // seleÃ§Ã£o de mais de uma coluna para ordenacao
                                , headers: {
                                                0:{sorter: false}   
                                              , 3: {sorter:"text"}   
                                              , 6: {sorter:"brazilCurrency"}   
                                              , 10:{sorter: false}   
                                          }
                                });

   function aprovarLote(Lote, Loja, Tipo, Obj,Next){
    var arrLote = new Array();
    var arrLoja = new Array();
    var arrTipo = new Array();
    var Valor=Obj.parents("tr").find(".txtValor").text();
    var Data=Obj.parents("tr").find(".txtData").text();
    var TipoString=Obj.parents("tr").find(".txtTipoString").text();
    $("#dialog-aprovar").html("<div class='grid_2'>"+
                                "<label class='label'>Loja: "+Loja+"</label>"+
                                "<label class='label'>Lote: "+Lote+"</label>"+
                                "<label class='label'>Data: "+Data+"</label>"+
                                "<label class='label'>Valor: "+Valor+"</label>"+
                                "<label class='label'>Tipo: "+TipoString+"</label>"+
                               "</div>"
                             );
    $("#dialog-aprovar").dialog
    ({
            resizable: false,
            height:200,
            draggable: false,
            width:300,
            modal: true,
            title:"Confirma APROVAÃ‡ÃƒO do Lote ? ",
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
                              show_stack_bottomleft(true,"Erro","Lote NÃ£o Aprovado");
                            }

                        });

                        $(this).dialog("close");
                        if(Next=="PRX")
                        {
                            var ObjNext=Obj.parents("tr").next('tr').children(".txtLote");
                            var LoteNext=Obj.parents("tr").next('tr').children(".txtLote").text();
                            var LojaNext=Obj.parents("tr").next('tr').children(".txtLoja").text();
                            var TipoNext=Obj.parents("tr").next('tr').children(".txtTipo").text();
                            detalhesAprovar(LoteNext,LojaNext,TipoNext,ObjNext);
                                
                        }
                    }
                    ,
                    Nao: function()
                    {
                        $(this).dialog("close");
                    }
            }
    });
   };
   
   function reprovarLote(Lote, Loja, Tipo, Obj,Next){
    var arrLote = new Array();
    var arrLoja = new Array();
    var arrTipo = new Array();
    var Valor=Obj.parents("tr").find(".txtValor").text();
    var Data=Obj.parents("tr").find(".txtData").text();
    var TipoString=Obj.parents("tr").find(".txtTipoString").text();
    $("#dialog-aprovar").html("<div class='grid_2'>"+
                                "<label class='label'>Loja: "+Loja+"</label>"+
                                "<label class='label'>Lote: "+Lote+"</label>"+
                                "<label class='label'>Data: "+Data+"</label>"+
                                "<label class='label'>Valor: "+Valor+"</label>"+
                                "<label class='label'>Tipo: "+TipoString+"</label>"+
                               "</div>"
                             );
    $("#dialog-aprovar").dialog
    ({
            resizable: false,
            height:200,
            draggable: false,
            width:300,
            modal: true,
            title:"Confirma REPROVAÇÃO do Lote ? ",
            buttons:
            {
                    Reprovar: function() 
                    {
                        arrLote.push(Lote);
                        arrLoja.push(Loja);
                        arrTipo.push(Tipo);
                        $.get("?router=T0119/js.AprovarReprovar",{arrLote:arrLote,arrLoja:arrLoja, arrTipo:arrTipo, Acao:7},function(retorno){
                            if(retorno==1){
                                show_stack_bottomleft(false," ","Lote Reprovado com sucesso");
                                //$($thisAprovar).remove();
                                Obj.parents("tr").remove();
                            }else{
                              show_stack_bottomleft(true,"Erro","Lote NÃ£o Reprovado");
                            }

                        });

                        $(this).dialog("close");
                        if(Next=="PRX")
                        {
                            var ObjNext=Obj.parents("tr").next('tr').children(".txtLote");
                            var LoteNext=Obj.parents("tr").next('tr').children(".txtLote").text();
                            var LojaNext=Obj.parents("tr").next('tr').children(".txtLoja").text();
                            var TipoNext=Obj.parents("tr").next('tr').children(".txtTipo").text();
                            detalhesAprovar(LoteNext,LojaNext,TipoNext,ObjNext);
                                
                        }                        
                    }
                    ,
                    Nao: function()
                    {
                        $(this).dialog("close");
                    }
            }
    });
   };
   
   function detalhesAprovar(Lote,Loja,Tipo,Obj)
   {    $("#dialog-detalhes").html("Aguarde Carregando...");
       
        $.get("?router=T0119/js.ConsultaDetalhes",{Lote:Lote,Loja:Loja,Tipo:Tipo},function(retorno){
            $("#dialog-detalhes").html(retorno);
            $("#tDetalhes").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        // , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleÃ§Ã£o de mais de uma coluna para ordenacao
                                        , headers: {
                                                        100:{sorter: false}   
                                                      , 0: {sorter:"brazilNumber"}   
                                                      , 1: {sorter:"text"}   
                                                      , 2: {sorter:"text"}   
                                                      , 3: {sorter:"brazilNumber"}   
                                                      , 4: {sorter:"brazilCurrency"} // moeda
                                                      , 5: {sorter:"brazilCurrency"}
                                                      , 6: {sorter:"brazilCurrency"}
                                                  }
                                        });
            $("#tDetalhes2").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleÃ§Ã£o de mais de uma coluna para ordenacao
                                        , headers: {
                                                        100:{sorter: false}   
                                                      , 0: {sorter:"brazilNumber"}   
                                                      , 1: {sorter:"brazilNumber"}   
                                                      , 2: {sorter:"text"}   
                                                      , 3: {sorter:"text"}   
                                                      
                                                      
                                                      , 4: {sorter:"brazilNumber"}   
                                                      , 5: {sorter:"brazilCurrency"} // moeda
                                                      , 6: {sorter:"brazilCurrency"}
                                                      , 7: {sorter:"brazilCurrency"}
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
                title:"Detalhes do Lote ",            
                buttons:
                {
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                        ,
                        Aprovar: function() 
                        {
                            aprovarLote(Lote, Loja, Tipo,Obj);
                            $(this).dialog("close");
                        }
                        ,
                        Reprovar: function() 
                        {
                           reprovarLote(Lote, Loja, Tipo,Obj);
                            $(this).dialog("close");
                        }
                        ,
                        'Aprovar e Proximo':function()
                        {
                            
                            aprovarLote(Lote, Loja, Tipo,Obj,'PRX');
                        }
                        ,
                        'Reprovar e Proximo':function()
                        {
                            
                            reprovarLote(Lote, Loja, Tipo,Obj,'PRX');
                        }
                    
                }

        });
       
   }
   
   function confirmaSelecionados(){
   };
   
    $(".Detalhes").live("click",function(e){
        e.preventDefault(); // nao aparece a "#" da tela
        var $thisAprovar=$(this);
        var Lote=$($thisAprovar).parents("tr").find(".txtLote").text();
        var Loja=$($thisAprovar).parents("tr").find(".txtLoja").text();
        var Tipo=$($thisAprovar).parents("tr").find(".txtTipo").text();
        
        $("#dialog-detalhes").html("Aguarde Carregando...");
        $.get("?router=T0119/js.ConsultaDetalhes",{Lote:Lote,Loja:Loja,Tipo:Tipo},function(retorno){
            $("#dialog-detalhes").html(retorno);
            $("#tDetalhes").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        // , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleÃ§Ã£o de mais de uma coluna para ordenacao
                                        , headers: {
                                                        100:{sorter: false}   
                                                      , 0: {sorter:"brazilNumber"}   
                                                      , 1: {sorter:"text"}   
                                                      , 2: {sorter:"text"}   
                                                      , 3: {sorter:"brazilNumber"}   
                                                      , 4: {sorter:"brazilCurrency"} // moeda
                                                      , 5: {sorter:"brazilCurrency"}
                                                      , 6: {sorter:"brazilCurrency"}
                                                  }
                                        });
            $("#tDetalhes2").tablesorter({ widgets:['zebra']                //Tabela Zebrada
                                        , locale: 'br'  // nao sei se funciona
                                        , sortList: [[0,0]]               //Ordena Coluna 1 Crescente
                                        , sortMultiSortKey: 'ctrlKey' // seleÃ§Ã£o de mais de uma coluna para ordenacao
                                        , headers: {
                                                        100:{sorter: false}   
                                                      , 0: {sorter:"brazilNumber"}   
                                                      , 1: {sorter:"brazilNumber"}   
                                                      , 2: {sorter:"text"}   
                                                      , 3: {sorter:"text"}   
                                                      
                                                      
                                                      , 4: {sorter:"brazilNumber"}   
                                                      , 5: {sorter:"brazilCurrency"} // moeda
                                                      , 6: {sorter:"brazilCurrency"}
                                                      , 7: {sorter:"brazilCurrency"}
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
                title:"Detalhes do Lote ",            
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
        
        detalhesAprovar(Lote,Loja,Tipo,$thisAprovar);

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
        $("#dialog-detalhes").html("Aguarde Carregando...");

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
        
        if($this.is(':checked'))
        {
            $.get("?router=T0119/js.ConsultaDetalhesVarios",{arrLote:Lote, arrLoja:Loja, arrTipo:Tipo},function(retorno){
              $("#dialog-detalhes").html(retorno);
            });

            $("#dialog-detalhes").dialog        
            ({
                    resizable: true,
                    height:650,
                    draggable: true,
                    width:850,
                    modal: true,
                    title:"CONFIRMAÇÃO em Lote ",
                    buttons:
                    {
                            Fechar: function()
                            {
                                $(this).dialog("close");
                            }
                            ,
                            'CONFIRMAR Todos': function() 
                            {

                                    // verifica se foi selecionado algum registro
                                    if(QtdeReg>0)
                                    {   
                                        $("#dialog-aprovar").html("<div class='grid_2'>"+
                                                                    "<label class='label'>Aprova CONFIRMAÇÃO de todos os lotes selecionados ? </label>"+
                                                                    "<label class='label'>Foram selecionados "+QtdeReg+" Lotes </label>"+
                                                                    "<label class='label'>Essa AÇÃO NÃO pode ser desfeita </label>"+
                                                                   "</div>"
                                                                  );
                                        
                                        $("#dialog-aprovar").dialog        
                                        ({
                                                resizable: true,
                                                height:200,
                                                draggable: true,
                                                width:300,
                                                modal: true,
                                                title:"Aprova CONFIRMACAO? ",
                                                buttons:
                                                {
                                                        Sim: function()
                                                        {
                                                            $.post("?router=T0119/js.AprovarReprovar",{arrLote:Lote, arrLoja:Loja, arrTipo:Tipo, Acao:2}, function(dados){
                                                                if ( dados == 1){
                                                                    $(".selecionaItem:checked").each(function(){
                                                                        $(this).parents('tr').remove();
                                                                    });

                                                                    show_stack_bottomleft(false, '', 'Lote(s) Confirmado(s) com sucesso!'); 
                                                                    $(this).dialog("close");

                                                                }
                                                                
                                                                else
                                                                    show_stack_bottomleft(true, 'Erro!', 'Lote(s) Nao Confirmado(s)'); 
                                                            });
                                                            $(this).dialog("close");
                                                        }
                                                        ,
                                                        Nao: function()
                                                        {
                                                           $(this).dialog("close");
                                                        }

                                                }


                                        });       
                                    }else
                                        show_stack_bottomleft(true, 'Erro!', 'Nao foi selecionado nenhum lote!');                 

                                $(this).dialog("close");
                            }

                    }


            });
        }else
            show_stack_bottomleft(true, 'Erro!', 'Nao foi selecionado nenhum lote!');      
  });
  
    $('#reprovarSelecionados').live("click", function(){       
        var $this           = $(".dados").find(".selecionaItem");
        var Lote            = new Array();
        var Loja            = new Array();
        var Tipo            = new Array();
        var QtdeReg         = 0;  
        $("#dialog-detalhes").html("Aguarde Carregando...");

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
        
        if($this.is(':checked'))
        {
            $.get("?router=T0119/js.ConsultaDetalhesVarios",{arrLote:Lote, arrLoja:Loja, arrTipo:Tipo},function(retorno){
              $("#dialog-detalhes").html(retorno);
            });

            $("#dialog-detalhes").dialog        
            ({
                    resizable: true,
                    height:650,
                    draggable: true,
                    width:850,
                    modal: true,
                    title:"IGNORAR em Lote ",
                    buttons:
                    {
                            Fechar: function()
                            {
                                $(this).dialog("close");
                            }
                            ,
                            'IGNORAR Todos': function() 
                            {

                                    // verifica se foi selecionado algum registro
                                    if(QtdeReg>0)
                                    {   
                                        $("#dialog-aprovar").html("<div class='grid_2'>"+
                                                                    "<label class='label'>Confirmar IGNORAR de todos os lotes selecionados ? </label>"+
                                                                    "<label class='label'>Foram selecionados "+QtdeReg+" Lotes </label>"+
                                                                    "<label class='label'>Essa AÇÃO NÃO pode ser desfeita </label>"+
                                                                   "</div>"
                                                                  );
                                        
                                        $("#dialog-aprovar").dialog        
                                        ({
                                                resizable: true,
                                                height:200,
                                                draggable: true,
                                                width:300,
                                                modal: true,
                                                title:"Confirma  IGNORAR ? ",
                                                buttons:
                                                {
                                                        Sim: function()
                                                        {
                                                            $.post("?router=T0119/js.AprovarReprovar",{arrLote:Lote, arrLoja:Loja, arrTipo:Tipo, Acao:7}, function(dados){
                                                                if ( dados == 1){
                                                                    $(".selecionaItem:checked").each(function(){
                                                                        $(this).parents('tr').remove();
                                                                    });

                                                                    show_stack_bottomleft(false, '', 'Lote(s) Ignorado(s) com sucesso!'); 
                                                                    $(this).dialog("close");

                                                                }
                                                                
                                                                else
                                                                    show_stack_bottomleft(true, 'Erro!', 'Lote(s) Nao Ignorado(s)'); 
                                                            });
                                                            $(this).dialog("close");
                                                        }
                                                        ,
                                                        Nao: function()
                                                        {
                                                           $(this).dialog("close");
                                                        }

                                                }


                                        });       
                                    }else
                                        show_stack_bottomleft(true, 'Erro!', 'Nao foi selecionado nenhum lote!');                 

                                $(this).dialog("close");
                            }

                    }


            });
        }else
            show_stack_bottomleft(true, 'Erro!', 'Nao foi selecionado nenhum lote!');      
  });
    
                
//    $('#reprovarSelecionados').live("click", function(){       
//        var $this           = $(".dados").find(".selecionaItem");
//        var Lote            = new Array();
//        var Loja            = new Array();
//        var Tipo            = new Array();
//        var QtdeReg         = 0;  
//        $("#dialog-detalhes").html("<div class='grid_2'>"+
//                                    "<label class='label'>Confirma REPROVAÃ‡ÃƒO de todos os lotes selecionados ? </label>"+
//                                    "<label class='label'>Essa AÃ§Ã£o NÃƒO pode ser desfeita </label>"+
//                                   "</div>"
//                                  );
//
//        $("#dialog-detalhes").dialog
//        ({
//                resizable: false,
//                height:200,
//                draggable: false,
//                width:250,
//                modal: true,
//                title:"REPROVAR todos ? ",
//                // escrever dentro da caixa
//                buttons:
//                {
//                        Sim: function() 
//                        {   
//                            if($this.is(':checked'))
//                            {
//                                $(".selecionaItem:checked").each(function(){
//                                     // verifica se a linha esta oculta usando o FILTRO DINAMICO
//                                    if($(this).parents('tr').css('display') != 'none')
//                                    {
//                                        Lote.push($(this).parents('tr').find('.txtLote').text());
//                                        Loja.push($(this).parents('tr').find('.txtLoja').text());
//                                        Tipo.push($(this).parents('tr').find('.txtTipo').text());
//                                        QtdeReg=QtdeReg+1;
//                                    }
//
//                                });
//                                // verifica se foi selecionado algum registro
//                                if(QtdeReg>0)
//                                {    
//                                    $.post("?router=T0119/js.AprovarReprovar",{arrLote:Lote, arrLoja:Loja, arrTipo:Tipo, Acao:7}, function(dados){
//                                        if ( dados == 1){
//                                            $(".selecionaItem:checked").each(function(){
//                                                $(this).parents('tr').remove();
//                                            });
//
//                                            show_stack_bottomleft(false, '', 'Lote(s) Reprovado(s) com sucesso!'); 
//
//                                        }                        
//                                        else
//                                            show_stack_bottomleft(true, 'Erro!', 'Lote(s) NÃ£o Reprovado(s)'); 
//                                    });
//                                }else
//                                    show_stack_bottomleft(true, 'Erro!', 'NÃ£o foi selecionado nenhum lote!');                 
//                            }else
//                                    show_stack_bottomleft(true, 'Erro!', 'NÃ£o foi selecionado nenhum lote!');                 
//                            
//                            $(this).dialog("close");
//                        },
//                        Nao: function()
//                        {
//                            $(this).dialog("close");
//                        }
//
//                }
//
//        });
//        
//        
//    });
    
                        
});
/* ============== FunÃ§Ã£o para Upload Fim  =================== */ 

/* ============== T0026/novo FIM ============================ */

/* -------- Controle de versÃµes - T0026.js --------------
 * 1.0.0 - 99/99/9999 - Rodrigo --> 1. Liberada versao inicial
 */