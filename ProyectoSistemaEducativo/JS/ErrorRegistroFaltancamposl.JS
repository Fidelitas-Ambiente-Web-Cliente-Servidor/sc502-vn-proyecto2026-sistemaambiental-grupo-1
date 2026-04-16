$(function () {
    const formRegister = $('#formRegister');
    const endpointRegistro = '../../PHPLogicaNegocio/ParteSantiLN/registroLN.PHP';
    const urlCartaError = 'CartaErrorDinamica.HTML';
    const urlRegistro = "registro.html";

    function irACartaError(tipo, mensaje) {
        const params = new URLSearchParams({ tipo: tipo });
        if (mensaje) {
            params.set('mensaje', mensaje);
        }
        window.location.href = urlCartaError + '?' + params.toString();
    }

    function irARegistro() {
        window.location.href = urlRegistro;
    }

    function mostrarCartaSegunTipo() {
        const parametros = new URLSearchParams(window.location.search);
        const tipo = (parametros.get('tipo') || '').toLowerCase();
        const mensaje = parametros.get('mensaje') || '';

        const mapaCartas = {
            campos: '#errorCampos',
            usuario: '#errorUsuario',
            servidor: '#errorServidor'
        };

        const selector = mapaCartas[tipo] || '#errorDefault';
        const tarjeta = $(selector);

        if (tarjeta.length) {
            tarjeta.removeClass('d-none');
            if (mensaje) {
                tarjeta.find('.card-text').first().text(mensaje);
            }
        }
    }

    function manejarErrorRegistro(jqXHR) {
        const mensaje = jqXHR.responseJSON && jqXHR.responseJSON.message
            ? jqXHR.responseJSON.message
            : 'No se pudo completar el registro.';

        if (jqXHR.status === 400) {
            irACartaError('campos', mensaje);
            return;
        }

        if (jqXHR.status === 409) {
            irACartaError('usuario', mensaje);
            return;
        }

        irACartaError('servidor', mensaje);
    }

    $('.volver-registro').on('click', function () {
        irARegistro();
    });

    if ($('#errorCampos').length || $('#errorUsuario').length || $('#errorServidor').length || $('#errorDefault').length) {
        mostrarCartaSegunTipo();
    }

    if (formRegister.length) {
        formRegister.on('submit', function (event) {
            event.preventDefault();

            const username = $.trim($('#username').val() || '');
            const password = $.trim($('#password').val() || '');

            if (username === '' || password === '') {
                irACartaError('campos', 'Faltan datos: username y password son obligatorios.');
                return;
            }

            $.ajax({
                url: endpointRegistro,
                method: 'POST',
                dataType: 'json',
                data: {
                    username: username,
                    password: password
                }
            })
                .done(function (respuesta) {
                    $('#mensaje')
                        .removeClass('d-none alert-danger')
                        .addClass('alert-success')
                        .text((respuesta && respuesta.message) || 'Usuario registrado correctamente.');

                    formRegister[0].reset();

                    if (respuesta && respuesta.redirect) {
                        window.location.href = respuesta.redirect;
                    }
                })
                .fail(function (jqXHR) {
                    manejarErrorRegistro(jqXHR);
                });
        });
    }
});