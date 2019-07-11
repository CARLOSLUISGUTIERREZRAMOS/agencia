$(function(){
    $('#forma_pago').change(function(){
        var set_forma_pago = $("#forma_pago option:selected").val();
        if(set_forma_pago ===  'TC' && $('#terms').prop('checked')){
            $('#btnAceptar').hide();
            $('#form_visa').show();
        }
        if(set_forma_pago ===  'LC' && $('#terms').prop('checked')){
            $('#btnAceptar').show();
            $('#form_visa').hide();
        }
        if(!$('#terms').prop('checked')){
            $('#btnAceptar').hide();
            $('#form_visa').hide();
        }
    })

    $('#terms').click(function(){
        
        var set_forma_pago = $("#forma_pago option:selected").val();
        var terms_chequeado = $('#terms').prop('checked')

        
        if((set_forma_pago ==='TC' || set_forma_pago ==='LC' || set_forma_pago ==='') && terms_chequeado === false){
            $('#btnAceptar').hide();
            $('#form_visa').hide();
        }
        if(set_forma_pago ==='LC' && terms_chequeado === true){
            $('#btnAceptar').show();
            $('#form_visa').hide();
        }
        if(set_forma_pago ==='TC' && terms_chequeado === true){
            $('#btnAceptar').hide();
            $('#form_visa').show();
        }
    })
})