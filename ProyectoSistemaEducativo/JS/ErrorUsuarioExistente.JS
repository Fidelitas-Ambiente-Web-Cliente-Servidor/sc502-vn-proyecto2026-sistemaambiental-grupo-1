$(function () {
    const formRegister = $('#formRegister');
    const urlCartaError = 'CartaErrorDinamica.HTML';
    const urlRegistroPasado = "registro.html";

    function irACartaErrorCampos() {
        window.location.href = urlCartaError + '?tipo=campos';
    }

    function irARegistro() {
        window.location.href = urlRegistroPasado;
    }

    function mostrarFaltaCampos() {
        const errorCampos = $('#errorCampos');
        if (errorCampos.length) {
            errorCampos.removeClass('d-none');
        }
    }

    $('.volver-registro').on('click', function () {
        irARegistro();
    });

    if ($('#errorCampos').length) {
        mostrarFaltaCampos();
    }

    if (formRegister.length) {
        formRegister.on('submit', function (event) {
            event.preventDefault();

            const username = $.trim($('#username').val() || '');
            const password = $.trim($('#password').val() || '');

            if (username === '' || password === '') {
                irACartaErrorCampos();
                return;
            }

            $('#mensaje')
                .removeClass('d-none alert-danger')
                .addClass('alert-success')
                .text('Campos completos.');
        });
    }
});