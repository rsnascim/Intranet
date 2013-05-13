$(function(){
    
        $(".campoFornecedor").focusin(function(){
      
      $.getJSON("?router=T0131/js.autoCompleteFornecedor", function(dados){
          
       $( ".campoFornecedor" ).autocomplete(
	{
             source:dados,
             select: function(){
            
         
             }
	});
      
      })  ;
        });
    
    
    
    $(".exclui").live("click", function(){
    
        var $this           =   $(this);   
        var codigoCategoria   =   $this.parents("tr.dados").find(".codigoCategoria").text();
        
        $("#dialog-mensagem-categoria").html("<p style='padding-top:10px;'>Essa ação Excluirá a Categoria <br><br>"+codigoCategoria+" <br><br> Tem certeza que deseja fazer isso ?</p>");
        $("#dialog-mensagem-categoria").dialog
        ({
            resizable: false,
            height:180,
            width:250,
            modal: true,
            draggable: false,
            title:  "Mensagem",
            buttons:
            {
                    "Ok": function(){
                      
                        $.post("?router=T0131/js.excluirCategoria", {cod:codigoCategoria}, function(dados){
                            
                              $(".conteudo_16").load("?router=T0131/home .conteudo_16");
                            
                        });
                            $(this).dialog("close");
                
            } 
                    ,
                    Cancelar: function(){
                        $(this).dialog("close");
                    }
            }
        });  
        });
    
});