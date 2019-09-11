$(function () {
    $('#forma_pago').change(function () {
        var set_forma_pago = $("#forma_pago option:selected").val();
        if (set_forma_pago === 'TC' && $('#terms').prop('checked')) {
            $('#btnAceptar').hide();
            $('#form_visa').show();
        }
        if (set_forma_pago === 'LC' && $('#terms').prop('checked')) {
            $('#btnAceptar').show();
            $('#form_visa').hide();
        }
        if (!$('#terms').prop('checked')) {
            $('#btnAceptar').hide();
            $('#form_visa').hide();
        }
    })

    $('#terms , #terms2').click(function () {

        var set_forma_pago = $("#forma_pago option:selected").val();
        var terms_chequeado_1 = $('#terms').prop('checked');
        var terms_chequeado_2 = $('#terms2').prop('checked');

        if ((set_forma_pago === 'TC' || set_forma_pago === 'LC' || set_forma_pago === '')) {
            if ((terms_chequeado_1 === false && terms_chequeado_2 === false) || (terms_chequeado_1 === false && terms_chequeado_2 === true) || (terms_chequeado_1 === true && terms_chequeado_2 === false)) {
                $('#btnAceptar').hide();
                $('#form_visa').hide();
            }
        }
        if (set_forma_pago === 'LC' && terms_chequeado_1 === true && terms_chequeado_2 === true) {
            $('#btnAceptar').show();
            $('#form_visa').hide();
        }
        if (set_forma_pago === 'TC' && terms_chequeado_1 === true && terms_chequeado_2 === true) {
            $('#btnAceptar').hide();
            $('#form_visa').show();
        }
    })
})