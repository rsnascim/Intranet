// Data de Criação: 12/01/2012
// Descrição:      Funções do programa T0026 - Reembolso de Despesas
// Desenvolvedor:  Rodrigo Alfieri

$(function(){
    
    document.activeAjaxConnections = 0                      ;
        
    function calculaTotalDespesaKm()
    {
        var total   =   0;
        $.each($("#dDados").find("tr"), function(){
            var tKm     =   parseInt($(this).find(".qKm").text())   ;
            var vKm     =   $("#parametroKm").val()                 ; //Valor Km                                                             
                total  +=   tKm * vKm                               ;  
        });
        $("#totalDespesaKm").val(total.toFixed(2));
        $("#totalDespesaKm").priceFormat({
                                            prefix: 'R$ ',
                                            centsSeparator: ',',
                                            thousandsSeparator: '.'
                                          });   
    }
    
    function calculaTotalDespesaDiversa()
    {
        var total   =   0;
        $.each($("#dDadosDiversos").find("tr"), function(){

            var vValor  =   $(this).find(".vValor").text()  ;

            vValor  =   vValor.replace('.','');
            vValor  =   vValor.replace(',','.');

                total  +=   parseFloat(vValor);  

        });
        $("#totalDespesaDiversas").val(total.toFixed(2));
        $("#totalDespesaDiversas").priceFormat({
                                            prefix: 'R$ ',
                                            centsSeparator: ',',
                                            thousandsSeparator: '.'
                                          });   
    }
    
    function calculaTotalGeral()
    {
        // ******* INICIO CALCULO TOTAL GERAL ****** //
        var despesaKm   =   $("#totalDespesaKm").val();
        if (despesaKm!='')
        {
            despesaKm   =   despesaKm.replace('R$ ','');
            despesaKm   =   despesaKm.replace('.','');
            despesaKm   =   despesaKm.replace(',','.');
        }
        else
            despesaKm   =   0;

        var despesaDiv  =   $("#totalDespesaDiversas").val();
        if (despesaDiv!='')
        {
            despesaDiv  =   despesaDiv.replace('R$ ','');
            despesaDiv  =   despesaDiv.replace('.','');
            despesaDiv  =   despesaDiv.replace(',','.');
        }
        else
            despesaDiv  =   0;

        var totalGeral  =   parseFloat(despesaKm)+parseFloat(despesaDiv);

        $("#totalGeral").val(totalGeral.toFixed(2)).priceFormat({
                                            prefix: 'R$ ',
                                            centsSeparator: ',',
                                            thousandsSeparator: '.'
                                          }); 

        // ******* FIM CALCULO TOTAL GERAL ****** //         
    }                                   
        
    //Caixa com Formulário
    $(".botaoAddDespesa").click(function(){
        function validaForm(form)
        {
            var err = 0;
            form.children().children('.required').each(function(){
                if($(this).val() == '' || $(this).val() == null){
                    $(this).addClass('error');
                    form.children('.error_form').show();
                    err++;
                }
            });
            if(err == 0)
                return true;
            else
            {
                show_stack_bottomleft(true, 'Erro!', 'Preencha todos os campos!');  
                return false;
            }
        }
                
        function limpaCampos()
        {
            $("#dialogData").val("");
            $("#dialogKm").val("");
            $("#dialogHistorico").val("");
            $("#dialogLojaOrigem option[value='']").attr('selected', 'selected');
            $("#dialogHoraOrigem option[value='']").attr('selected', 'selected');
            $("#dialogLojaDestino option[value='']").attr('selected', 'selected');
            $("#dialogHoraDestino option[value='']").attr('selected', 'selected');
            
        }
        
        $(".dialog-despesa").dialog
        ({
                resizable: false,
                height:400,
                draggable: false,
                width:420,
                modal: true,
                buttons:
                {
                        Ok: function() 
                        {
                            var html        =   ""                              ;
                            
                            var data        =   $("#dialogData").val()          ;
                            var historico   =   $("#dialogHistorico").val()     ;
                            var lojaOrigem  =   $("#dialogLojaOrigem").val()    ;
                            var lojaDestino =   $("#dialogLojaDestino").val()   ;
                            var horaOrigem  =   $("#dialogHoraOrigem").val()    ;
                            var horaDestino =   $("#dialogHoraDestino").val()   ;
                            var km          =   $("#dialogKm").val()            ;                            
                              
                            if (lojaOrigem=="999")  
                                lojaOrigem  =   "999-"+$("#txtExternoOrigem").val();
                            else
                                lojaOrigem  =   $("#dialogLojaOrigem option[value='"+lojaOrigem+"']").attr('selected', 'selected').html();
                            
                            
                            if (lojaDestino=="999")
                                lojaDestino =   "999-"+$("#txtExternoDestino").val();
                            else
                                lojaDestino =   $("#dialogLojaDestino option[value='"+lojaDestino+"']").attr('selected', 'selected').html();
                            
                            $("#linhaInfo").remove();
                             
                            html    +=  "<tr>";
                            html    +=  "   <td class='vData'>"+data+"</td>";
                            html    +=  "   <td class='vHist'>"+historico+"</td>";
                            html    +=  "   <td class='vLjOrig'>"+lojaOrigem+"</td>";
                            html    +=  "   <td class='vHrOrig'>"+$("#dialogHoraOrigem option[value='"+horaOrigem+"']").attr('selected', 'selected').html()+"</td>";
                            html    +=  "   <td class='vLjDest'>"+lojaDestino+"</td>";
                            html    +=  "   <td class='vHrDest'>"+$("#dialogHoraDestino option[value='"+horaDestino+"']").attr('selected', 'selected').html()+"</td>";
                            html    +=  "   <td class='qKm'>"+km+"</td>";                                                        
                            html    +=  "   <td class='acoes'>";
                            html    +=  "       <span class='lista_acoes'>";
                            html    +=  "           <ul>";
                            html    +=  "               <li class='ui-state-default ui-corner-all excluiLinha' title='Excluir'  ><a href='#'   class='ui-icon ui-icon-closethick'></a></li>";
                            html    +=  "           </ul>";
                            html    +=  "       </span>";
                            html    +=  "   </td>";                                                        
                            html    +=  "</tr>"; 
                                                                                                             
                            if(validaForm($("#dialogForm")))
                            {    
                                $("#dDados").append(html);
                                
                                calculaTotalDespesaKm();                                
                                
                                calculaTotalGeral();
                                
                                limpaCampos();   
                                
                                $(this).dialog("close");
                            }
                            
                        }
                        ,
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                }
        }); 
    });    
        
    //Caixa com Formulário
    $(".botaoAddDespesaDiversas").click(function(){
        function validaFormDiversas(form)
        {
            var err = 0;
            form.children().children('.required').each(function(){
                if($(this).val() == '' || $(this).val() == null){
                    $(this).addClass('error');
                    form.children('.error_form').show();
                    err++;
                }
            });
            if(err == 0)
                return true;
            else
            {
                show_stack_bottomleft(true, 'Erro!', 'Preencha todos os campos!');  
                return false;
            }
        }
                
        function limpaCampos()
        {
            $("#dialogDataDiversos").val("");
            $("#dialogContaDiversos option[value='']").attr('selected', 'selected');
            $("#dialogValorDiversos").val("");
            
        }
        
        $(".dialog-despesa-diversas").dialog
        ({
                resizable: false,
                height:220,
                draggable: false,
                width:400,
                modal: true,
                buttons:
                {
                        Ok: function() 
                        {
                            var html        =   ""                              ;
                            
                            var data        =   $("#dialogDataDiversos").val()          ;
                            var conta       =   $("#dialogContaDiversos").val()     ;
                            var valor       =   $("#dialogValorDiversos").val()    ;
                              
                            $("#linhaInfoDiversos").remove();
                             
                            html    +=  "<tr>";
                            html    +=  "   <td class='vData'>"+data+"</td>";                            
                            html    +=  "   <td class='vConta'>"+$("#dialogContaDiversos option[value='"+conta+"']").attr('selected', 'selected').html()+"</td>";
                            html    +=  "   <td class='vValor'>"+valor+"</td>";
                            html    +=  "   <td class='acoes'>";
                            html    +=  "       <span class='lista_acoes'>";
                            html    +=  "           <ul>";
                            html    +=  "               <li class='ui-state-default ui-corner-all excluiLinhaDiversos' title='Excluir'  ><a href='#'   class='ui-icon ui-icon-closethick'></a></li>";
                            html    +=  "           </ul>";
                            html    +=  "       </span>";
                            html    +=  "   </td>";                             
                            html    +=  "</tr>"; 
                                                                                                             
                            if(validaFormDiversas($("#dialogFormDiversos")))
                            {    
                                $("#dDadosDiversos").append(html);

                                calculaTotalDespesaDiversa();
                                
                                calculaTotalGeral();
                                
                                limpaCampos();   
                                $(this).dialog("close");
                            }
                            
                        }
                        ,
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                }
        }); 
    });    
    
    //Busca CPF
    $(".cpf").blur(function(){
        var $this   =   $(this);
        var cpf     =   $this.val();
        $.getJSON("?router=T0026/js.verificaCpf",{cpf:cpf},function(dados){
            if (dados==0)
                {
                    show_stack_bottomleft(true, 'Erro!', 'Você não tem cadastro no RMS favor entrar em contato com...');  
                    $this.val("");
                    $this.focus();
                    $("#nomeColaborador").val();
                    $("#abasDespesa").css("display", "none");
                    $("#botaoIncluir").css("display", "none");
                    $("#parametro").css("display", "none");
                    
                }else
                    {
                        $.each(dados, function(i,itm){
                            $("#nomeColaborador").val(itm);
                        });
                        
                        $("#abasDespesa").css("display", "block");
                        $("#botaoIncluir").css("display", "block");
                        $("#parametro").css("display", "block");
                        
                    };
        });
    });
    
    $("#dialogLojaOrigem").focus(function(){
        var $this   =   $(this);
        $.get("?router=T0026/js.lojas",function(dados){
            $this.html(dados)            
        }); 
    });
    
    $("#dialogLojaOrigem").change(function(){
        var $this   =   $(this);
        var loja    =   $this.val();
        $.get("?router=T0026/js.lojas",{loja:loja},function(dados){
            $("#dialogLojaDestino").html(dados)            
        });
        
        if(loja=="999")
        {
            $(".dialog-despesa").dialog({ height:430});
            $("#externoOrigem").css("display","block");
            $("#externoOrigem").addClass("required");
            $("#dialogKm").removeAttr("disabled");
        }else
        {
            $("#externoOrigem").css("display","none");
            $("#externoOrigem").removeClass("required");
            $("#dialogKm").attr("disabled","disabled");
        }
    });
    
    $("#dialogLojaDestino").change(function(){
        var $this           =   $(this);
        var lojaOrigem      =   $("#dialogLojaOrigem").val();
        var lojaDestino     =   $this.val();
        
        if(lojaDestino=="999")
        {
            $(".dialog-despesa").dialog({ height:430});
            $("#externoDestino").css("display","block");
            $("#externoOrigem").addClass("required");
            $("#dialogKm").removeAttr("disabled");
        }else
        {
            $("#externoDestino").css("display","none");
            $("#externoOrigem").removeClass("required");
            $("#dialogKm").attr("disabled","disabled");
        }
        
        $.get("?router=T0026/js.km",{lojaOrigem:lojaOrigem,lojaDestino:lojaDestino}, function(dados){
            $("#dialogKm").val(dados);
        });
        
    });  
    
    $("#dialogKm").bind("keyup blur focus", function(e) {
        e.preventDefault();
        var expre = /[^0-9]/g;
        // REMOVE OS CARACTERES DA EXPRESSAO ACIMA
        if ($(this).val().match(expre))
            $(this).val($(this).val().replace(expre,''));
    });    
    
    $(".botaoInserir").click(function(){
        $("#dialog-modal").text("Tem certeza que deseja incluir a despesa!");
        $("#dialog-modal").dialog
        ({
                resizable: false,
                height:120,
                draggable: false,
                width:220,
                modal: true,
                title: "Mensagem!",
                buttons:
                {
                        Ok: function() 
                        {                            
                            var vCpf            =   $("#campoCpf").val()            ;
                            var totalGeral      =   $("#totalGeral").val()          ;
                            //InsereDados
                            $.get("?router=T0026/js.insereDados",{  tipo:1 //Despesa com Km
                                                                   , cpf:vCpf
                                                                   , totalGeral:totalGeral
                                                                   }
                            , function(dados){
                                if(dados!=0)
                                 {
                                      $("#codigoDespesa").val(dados);
                                      $.each($("#dDados").find("tr"), function(){
                                          var codigoDespesa   =   $("#codigoDespesa").val()       ;                                                                                                                                   
                                          var vData           =   $(this).find(".vData").text()   ;
                                          var vHist           =   $(this).find(".vHist").text()   ;
                                          var vLjOrig         =   $(this).find(".vLjOrig").text() ;
                                          var vHrOrig         =   $(this).find(".vHrOrig").text() ;
                                          var vLjDest         =   $(this).find(".vLjDest").text() ;
                                          var vHrDest         =   $(this).find(".vHrDest").text() ;
                                          var qKm             =   $(this).find(".qKm").text()     ; //Qtde Km
                                          var totalDespesa    =   $("#totalDespesaKm").val()      ; 
                                          var totalDespesaDiv =   $("#totalDespesaDiversas").val();

                                          //InsereDados
                                        $.ajax({
                                            url: "?router=T0026/js.insereDados",
                                            type: 'get',
                                            data: {   tipo:2 //Despesa com Km
                                                    , codigoDespesa:codigoDespesa
                                                    , data:vData
                                                    , historico:vHist
                                                    , lojaOrigem:vLjOrig
                                                    , hrOrigem:vHrOrig
                                                    , lojaDestino:vLjDest
                                                    , hrDestino:vHrDest
                                                    , km:qKm
                                                    , totalDespesa:totalDespesa
                                                    , totalDespesaDiv:totalDespesaDiv
                                                  },
                                            
                                            beforeSend: function() {
                                                document.activeAjaxConnections++;
                                                console.log(document.activeAjaxConnections);
                                            },
                                            success: function() {
                                                document.activeAjaxConnections--;
                                                if (0 == document.activeAjaxConnections) {
                                                   //executou todos os get 
                                                   $(location).attr('href','?router=T0026/home&statusDespesa=1');
                                                }

                                            },
                                            error :function(){
                                                document.activeAjaxConnections--;
                                            }                  
                                        });                                               
                                                                                   
                                      });
                                     //Despesas Diversas
                                     $.each($("#dDadosDiversos").find("tr"), function(){
                                         var codigoDespesa   =   $("#codigoDespesa").val()       ;                                                                                                                                   
                                         var vData           =   $(this).find(".vData").text()   ;
                                         var vConta          =   $(this).find(".vConta").text()   ;
                                         var vValor          =   $(this).find(".vValor").text() ;

                                         //InsereDados
                                        $.ajax({
                                            url: "?router=T0026/js.insereDados",
                                            type: 'get',
                                            data: {  tipo:3 //Despesa com Km
                                                   , codigoDespesa:codigoDespesa
                                                   , data:vData
                                                   , conta:vConta
                                                   , valor:vValor
                                                  },
                                           
                                            beforeSend: function() {                                                
                                                document.activeAjaxConnections++;
                                            },
                                            success: function() {
                                                document.activeAjaxConnections--;
                                                if (0 == document.activeAjaxConnections) {
                                                   //executou todos os get 
                                                   $(location).attr('href','?router=T0026/home&statusDespesa=1');
                                                }  

                                            },
                                            error :function(){
                                                document.activeAjaxConnections--;
                                            }                  
                                        }); 

                                     });  
                                     
                                     

                                 }else
                                     show_stack_bottomleft(true, 'Erro!', 'Não foi possível inserir!');  
                            });  
                            
                            $(this).dialog("close");                                                        
                            
                        }
                        ,
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                }
        });                        
    });
    
    $(".excluiLinha").live("click",function(e){
        e.preventDefault();                
        $(this).parents("tr").remove();
        
        calculaTotalDespesaKm();
        
        calculaTotalGeral();
        
    });
    
    $(".excluiLinhaDiversos").live("click",function(e){
        e.preventDefault();
        
        $(this).parents("tr").remove();  
        
        calculaTotalDespesaDiversa();
        
        calculaTotalGeral();
                      
    });
    
    $(".aprovarDespesa").live("click",function(e){
        e.preventDefault();
        var $this           =   $(this)             ;
        var codigoEtapa     =   $this.parents("tr").find(".codigoEtapa").text() ;
        var codigoDespesa   =   $this.parents("tr").find(".codigoDespesa").text();

        $("#dialog-aprovar").dialog
        ({
                resizable: false,
                height:130,
                draggable: false,
                width:300,
                modal: true,
                buttons:
                {
                        Ok: function() 
                        {   var $thisDialog =   $(this);
                            $.get("?router=T0026/js.aprovar" ,{  codigoEtapa:codigoEtapa
                                                               , codigoDespesa:codigoDespesa}
                                                               , function(dados){
                                                                   if(dados==1)
                                                                       {
                                                                           $this.parents("tr").remove();
                                                                           $thisDialog.dialog("close");
                                                                           show_stack_bottomleft(false, 'Alerta!', 'Despesa(s) aprovada(s) com sucesso!');  
                                                                           
                                                                       }
                                                                   else
                                                                       {
                                                                           $thisDialog.dialog("close");
                                                                           show_stack_bottomleft(true, 'Erro!', 'Despesa(s) não foram aprovada(s)!');  
                                                                       }
                                                               });
                            
                            
                            
                        }
                        ,
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                }
        }); 
    });
    
    $(".cancelarDespesa").live("click",function(e){
        e.preventDefault();
        var $this           =   $(this)                                             ;
        var codigoDespesa   =   $this.parents("tr").find(".codigoDespesa").text()   ;
        
        $("#dialog-cancelar").dialog
        ({
                resizable: false,
                height:130,
                draggable: false,
                width:300,
                modal: true,
                buttons:
                {
                        Ok: function() 
                        {
                            var $thisDialog =   $(this);
                            $.post("?router=T0026/js.cancelar",{codigoDespesa:codigoDespesa},function(dados){
                                if (dados==1)
                                    {
                                        show_stack_bottomleft(false, 'Alerta', 'Despesa cancelada com sucesso!');
                                        $this.parents("tr").remove();                                                                                
                                    }else
                                        {
                                            show_stack_bottomleft(true, 'Erro!', 'Não foi possível cancelar a Despesa!');  
                                        }                                                                                                                            
                            });
                            
                            $thisDialog.dialog("close");
                            
                        }
                        ,
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                }
        });         
        
    });
    
    $(".uploadArquivo").live("click",function(e){
        e.preventDefault();
        var $this           =   $(this);
        var codigoDespesa   =   $this.parents("tr").find(".codigoDespesa").text();
        $(".externalSite").remove();
        $('<iframe class="externalSite" src="?router=T0026/js.upload" />').dialog({
            title:'Upload', 
            autoOpen: true, 
            width: 320, 
            height: 170, 
            modal: true, 
            resizable: false,
            buttons:{                
                'Upload':function(){
                    $(".externalSite").contents().find("#codigoDespesa").val(codigoDespesa);
                    $(".externalSite").contents().find('form').submit();
                                        
                    $(this).dialog("close");
                },
                
                'Fechar':function(){
                    $(this).dialog("close");
                }}
        }).width(800 - 25);
        
    });
    
});