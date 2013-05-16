$(function(){
    
 $("#categoriaFornecedor").focusin(function(){
     
      forn = $("#cnpj_for").val();

//    if($("#cpf_for").val() == "") {
//        forn = $("#cnpj_for").val();}
//    else {
//        forn = $("#cpf_for").val();}
//    
//    
//    if($("#rms_codigo").val() == "") {
//        codRms = $("#cpf_rms_codigo").val();}
//    else {
//        codRms = $("#rms_codigo").val();}
    
     $.post("?router=T0016/js.categoriaFornecedor", {forn:forn}, function(dados){      
  
         $("#comboCategoria").html(dados);
        
    });
    
 });
 
});










