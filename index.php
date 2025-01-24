<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'opto/api/conexaoPDO.php';

$pdo = getConexao();

// Consulta para listar números de telefone únicos com o último timestamp
$stmt = $pdo->query("
    SELECT tel, MAX(timestamp) AS timestamp
    FROM question
    GROUP BY tel
    ORDER BY MAX(timestamp) DESC
");
$phoneNumbers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtém o número de telefone mais recente
$latestPhoneNumber = $phoneNumbers[0]['tel'] ?? null; // O primeiro número na lista
?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPTOBOT v1.0</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700&display=swap" rel="stylesheet">


    <!-- Normalize CSS -->
    <link href="opto/css/normalize.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="opto/css/style.css" rel="stylesheet">

    <!--Font Awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body style="background-color: #050505;">
    <div class="logo-watermark"><img src="opto/images/OPTOBOT.png"></div>
    <section class="containerPai">
       <section class="leftCol">
            <div class="leftColContainer">
                <div class="leftColHeader">
                    <img src="opto/images/logoSmallIndex.png">
                </div>
                <div class="leftColButtons">
                    <a href="#">
                        <div class="leftColButtonsContainer">
                            <div class="leftColButtonsIcon"><img src="opto/images/icons/Book.svg" width="30" height="30"></div>
                            <div class="leftColButtonsText">Knowledge</div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="leftColButtonsContainer">
                            <div class="leftColButtonsIcon"><img src="opto/images/icons/BotActive.svg" width="30" height="30"></div>
                            <div class="leftColButtonsTextActive">Chat</div>
                            <div class="leftColButtonsActive">&nbsp;</div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="leftColButtonsContainer">
                            <div class="leftColButtonsIcon"><img src="opto/images/icons/Gear.svg" width="30" height="30"></div>
                            <div class="leftColButtonsText">Settings</div>
                        </div>
                    </a>
                </div>
            </div>
       </section>
       <section class="rightCol">

            <div class="rightColContent">

                <div class="rigtCol1Container">

                    <div class="rigthColHeader">Chat</div>
                    <div class="rigthColSubHeader">Track all interactions</div>

                    <div class="rightColSearchContainer">
                        <form id="formSearch">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" placeholder="Search">
                            <button type="submit" style="display: none;"></button> <!-- Botão invisível para permitir o submit -->
                        </form>
                    </div>

                    <div class="rightColChatContainer">
                        <!-- Botões serão carregados dinamicamente aqui -->
                    </div>


                </div> 
                
                <div class="rigtCol2Container">

                    <div class="rigtCol2TextTop">
                        <div style="float: left;">Conversation with <span style="color: #14BDEB;">Opto</span> . WhatsApp</div>
                        <div style="float: right;"><a href="#"><img src="opto/images//icons/MenuVertical.svg"></a></div>
                    </div>


                    <div class="rigtCol2MsgContainer">

                        <div class="loading-spinner" style="display: none;"></div> <!-- Spinner -->
                        <div class="messages-container"></div> <!-- Contêiner para as mensagens -->


                    <!--
                        <div class="rigtCol2MsgSopportContainer">
                            <div class="rigtCol2MsgSopportIcon"><img src="opto/images//icons/botMessage.svg"></div>
                            <div class="rigtCol2MsgSopportTextContainer">
                                <div class="rigtCol2MsgSopportTextTitle">Support</div>
                                <div class="rigtCol2MsgSopportText">
                                    Yes, Masterclass on November 13th has already taken place. If you’re looking  for future events or additional information, I recommend checking the Optoshpere Masterclass website for upcoming dates and locations. Let me know if you need any further assistance!
                                </div>
                                <div class="rigtCol2MsgSopportTextFooter">09:15AM </div>
                            </div>
                        </div>

                        <div style="width: 100%; overflow: auto;">
                            <div class="rigtCol2MsgUserContainer">
                                <div class="rigtCol2MsgUserTitle">User</div>
                                <div class="rigtCol2MsgUserText">
                                    Yes, Masterclass on
                                    <div class="rigtCol2MsgUserFooter">09:51AM</div>
                                </div>
                            </div>
                        </div>

                        <div class="rigtCol2MsgSopportContainer">
                            <div class="rigtCol2MsgSopportIcon"><img src="opto/images//icons/botMessage.svg"></div>
                            <div class="rigtCol2MsgSopportTextContainer">
                                <div class="rigtCol2MsgSopportTextTitle">Support</div>
                                <div class="rigtCol2MsgSopportText">
                                    Yes, Masterclass on November 13th has already taken place. If you’re looking  for future events or additional information, I recommend checking the Optoshpere Masterclass website for upcoming dates and locations. Let me know if you need any further assistance!
                                </div>
                                <div class="rigtCol2MsgSopportTextFooter">09:15AM </div>
                            </div>
                        </div>

                        <div style="width: 100%; overflow: auto;">
                            <div class="rigtCol2MsgUserContainer">
                                <div class="rigtCol2MsgUserTitle">User</div>
                                <div class="rigtCol2MsgUserText">
                                    Yes, Masterclass on
                                    <div class="rigtCol2MsgUserFooter">09:51AM</div>
                                </div>
                            </div>
                        </div>
                    -->

                    </div>    

                </div>

            </div> 

       </section>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="opto/js/opto.js"></script> <!-- Referência ao arquivo JS -->


    <script>

    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);

        // Configurações para formatação da data e hora
        const formattedDate = `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()}`;
        const formattedTime = `${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}hrs`;

        return `${formattedDate} - ${formattedTime}`;
    }





    $(document).ready(function () {
        // Função para carregar os botões dinamicamente
        function loadButtons(search = '') {
            $.ajax({
                url: 'opto/php/getPhoneNumbers.php', // Caminho correto do backend
                type: 'GET',
                data: { search: search },
                dataType: 'json',
                success: function (phoneNumbers) {
                    // Limpa o contêiner de botões
                    $('.rightColChatContainer').html('');

                    // Verifica se existem números de telefone retornados
                    if (phoneNumbers.length > 0) {
                        // Adiciona os botões dinamicamente
                        phoneNumbers.forEach((phone, index) => {
                            $('.rightColChatContainer').append(`
                                <a href="#" class="phone-btn" data-phone="${phone.tel}">
                                    <div class="${index === 0 ? 'rightColChatBoxActive' : 'rightColChatBox'}">
                                        <div class="${index === 0 ? 'rightColChatIconActive' : 'rightColChatIcon'}">
                                            ${phone.tel.charAt(0)}
                                        </div>
                                        <div class="${index === 0 ? 'rightColChatTextActive' : 'rightColChatText'}">
                                            <div class="${index === 0 ? 'rightColChatText1Active' : 'rightColChatText1'}">Última interação...</div>
                                            <div class="rightColChatText2">Phone Number: ${phone.tel}</div>
                                            <div class="rightColChatText3">Created: 
                                                <span class="rightColChatText4">
                                                    ${formatTimestamp(phone.timestamp)}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            `);
                        });

                        // Carrega as mensagens do primeiro botão automaticamente, se não estiver em pesquisa
                        if (!search) {
                            const firstPhoneNumber = phoneNumbers[0].tel;
                            fetchMessages(firstPhoneNumber);
                        }
                    } else {
                        $('.rightColChatContainer').html('<p>Nenhum telefone encontrado.</p>');
                    }
                },
                error: function () {
                    alert('Erro ao carregar os botões.');
                }
            });
        }

        // Função para formatar o timestamp
        function formatTimestamp(timestamp) {
            const date = new Date(timestamp);
            const formattedDate = `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()}`;
            const formattedTime = `${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')}hrs`;
            return `${formattedDate} - ${formattedTime}`;
        }

        // Carrega os botões ao carregar a página
        loadButtons();

        // Evento de pesquisa instantânea
        $('input[name="search"]').on('keyup', function () {
            const search = $(this).val().trim();
            loadButtons(search);
        });

        // Delegação de evento para os botões criados dinamicamente
        $('.rightColChatContainer').on('click', '.phone-btn', function (e) {
            e.preventDefault();

            const phoneNumber = $(this).data('phone');

            if (!phoneNumber) {
                alert('Erro: Número de telefone não fornecido.');
                return;
            }

            // Remove as classes "Active" de todos os botões
            $('.rightColChatBoxActive').removeClass('rightColChatBoxActive').addClass('rightColChatBox');
            $('.rightColChatTextActive').removeClass('rightColChatTextActive').addClass('rightColChatText');
            $('.rightColChatText1Active').removeClass('rightColChatText1Active').addClass('rightColChatText1');
            $('.rightColChatIconActive').removeClass('rightColChatIconActive').addClass('rightColChatIcon');

            // Adiciona as classes "Active" ao botão clicado
            $(this).find('.rightColChatBox').removeClass('rightColChatBox').addClass('rightColChatBoxActive');
            $(this).find('.rightColChatText').removeClass('rightColChatText').addClass('rightColChatTextActive');
            $(this).find('.rightColChatText1').removeClass('rightColChatText1').addClass('rightColChatText1Active');
            $(this).find('.rightColChatIcon').removeClass('rightColChatIcon').addClass('rightColChatIconActive');

            // Carrega as mensagens para o número clicado
            fetchMessages(phoneNumber);
        });

        // Função para buscar mensagens via AJAX
        function fetchMessages(phoneNumber) {
            // Mostra o spinner
            $('.loading-spinner').show();

            // Esconde as mensagens enquanto carrega
            $('.messages-container').hide();

            $.ajax({
                url: 'opto/php/getMessages.php', // Altere para o caminho correto
                type: 'GET',
                data: { phone_number: phoneNumber },
                dataType: 'json',
                success: function (response) {
                    // Esconde o spinner
                    $('.loading-spinner').hide();

                    // Mostra o contêiner de mensagens
                    $('.messages-container').show();

                    if (response.success) {
                        const messages = response.messages;

                        // Limpa apenas o contêiner de mensagens
                        $('.messages-container').html('');

                        // Adiciona as mensagens dinamicamente
                        messages.forEach(msg => {

                             // Resposta do bot
                             if (msg.bot_response) {
                                $('.messages-container').append(`
                                    <div class="rigtCol2MsgSopportContainer">
                                        <div class="rigtCol2MsgSopportIcon"><img src="opto/images/icons/botMessage.svg"></div>
                                        <div class="rigtCol2MsgSopportTextContainer">
                                            <div class="rigtCol2MsgSopportTextTitle">Support</div>
                                            <div class="rigtCol2MsgSopportText">
                                                ${msg.bot_response}
                                            </div>
                                            <div class="rigtCol2MsgSopportTextFooter">${formatTimestamp(msg.user_timestamp)}</div>
                                        </div>
                                    </div>
                                `);
                            }

                            // Mensagem do usuário
                            $('.messages-container').append(`
                                <div style="width: 100%; overflow: auto;">
                                    <div class="rigtCol2MsgUserContainer">
                                        <div class="rigtCol2MsgUserTitle">${phoneNumber}</div>
                                        <div class="rigtCol2MsgUserText">
                                            ${msg.user_message}
                                            <div class="rigtCol2MsgUserFooter">${formatTimestamp(msg.user_timestamp)}</div>
                                        </div>
                                    </div>
                                </div>
                            `);

                           
                        });

                        // Rolagem automática para o final
                        const container = $('.messages-container');
                        container.scrollTop(container.prop('scrollHeight'));
                    } else {
                        $('.messages-container').html('<p>Nenhuma mensagem encontrada.</p>');
                    }
                },
                error: function () {
                    // Esconde o spinner e exibe mensagem de erro
                    $('.loading-spinner').hide();
                    $('.messages-container').show().html('<p>Erro ao buscar mensagens.</p>');
                }
            });
        }


    });



    </script>








</body>
</html>
