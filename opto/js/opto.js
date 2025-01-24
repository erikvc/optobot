$(document).ready(function () {



    // Função para processar o login
    $('#loginForm').on('submit', function (e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        const email = $('#email').val();
        const password = $('#password').val();

        // Verifica se os campos estão preenchidos
        if (!email || !password) {
            $('#responseMessage').text('Por favor, preencha todos os campos.').css('color', 'red');
            hideMessage(); // Oculta a mensagem após 3 segundos
            return;
        }

        // Faz a requisição AJAX para a API de login
        $.ajax({
            url: '/opto/api/login.php',
            type: 'POST',
            data: {
                email: email,
                password: password,
            },
            dataType: 'json',
            success: function (result) {
                if (result.USER_ID !== null) {
                    // Login bem-sucedido
                    $('#responseMessage').text('Login realizado com sucesso!').css('color', 'green');
                    hideMessage(); // Oculta a mensagem após 3 segundos

                    // Salva o ID do usuário na sessão
                    $.ajax({
                        url: '/opto/php/storeSession.php',
                        type: 'POST',
                        data: {
                            user_id: result.USER_ID,
                        },
                        success: function () {
                            window.location.href = 'index.php'; // Redireciona para index.php
                        },
                        error: function () {
                            $('#responseMessage').text('Erro ao salvar a sessão.').css('color', 'red');
                            hideMessage(); // Oculta a mensagem após 3 segundos
                        },
                    });
                } else {
                    // Exibe mensagem de erro
                    $('#responseMessage').text(result.MSG).css('color', 'red');
                    hideMessage(); // Oculta a mensagem após 3 segundos
                }
            },
            error: function () {
                $('#responseMessage').text('Erro ao processar o login.').css('color', 'red');
                hideMessage(); // Oculta a mensagem após 3 segundos
            },
        });
    });

    // Função para ocultar a mensagem após 3 segundos
    function hideMessage() {
        setTimeout(function () {
            $('#responseMessage').fadeOut('slow', function () {
                $(this).text('').css('display', 'block'); // Limpa o texto e garante que o elemento estará visível para mensagens futuras
            });
        }, 3000); // 3000 milissegundos = 3 segundos
    }


    
});
