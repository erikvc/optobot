<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diálogo com o Bot</title>
    <!-- Link do Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

    <div class="container py-4">
        <h1 class="text-center text-primary mb-4">Diálogo com o Bot</h1>

        <!-- Indicador de carregamento -->
        <div id="loading" class="alert alert-info text-center" style="display: none;">
            Atualizando mensagens...
        </div>

        <!-- Contêiner de mensagens -->
        <div id="dialogs" class="row"></div>
    </div>

    <script>
        function fetchDialogues() {
            $.ajax({
                url: "get_dialogues.php", // Arquivo PHP para buscar os diálogos
                type: "GET",
                dataType: "json",
                cache: false,  // Impede cache
                beforeSend: function () {
                    $('#loading').show(); // Exibe o carregamento
                },
                success: function (data) {
                    $('#loading').hide(); // Oculta o carregamento
                    $('#dialogs').empty(); // Limpa os diálogos anteriores

                    if (data.length > 0) {
                        let currentNumber = null;
                        let chatContainer = null;

                        // Agrupando mensagens por número
                        data.forEach(dialogue => {
                            if (currentNumber !== dialogue.from) {
                                // Se o número mudou, cria um novo card para esse número
                                if (chatContainer) {
                                    $('#dialogs').append(chatContainer); // Adiciona o card anterior
                                }
                                chatContainer = $(`
                                    <div class="col-12 col-md-6 mb-4">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white">
                                                <strong>Conversas com ${dialogue.from}</strong>
                                            </div>
                                            <div class="card-body p-3"></div>
                                        </div>
                                    </div>
                                `);
                                currentNumber = dialogue.from;
                            }
                            // Adiciona a mensagem ao corpo do card
                            chatContainer.find('.card-body').append(`
                                <div class="mb-3 p-2 border rounded bg-light">
                                    <p class="mb-1"><strong>Mensagem:</strong> ${dialogue.message}</p>
                                    <p class="mb-1"><strong>Resposta:</strong> ${dialogue.response}</p>
                                    <small class="text-muted">${dialogue.timestamp}</small>
                                </div>
                            `);
                        });

                        // Adiciona o último card
                        if (chatContainer) {
                            $('#dialogs').append(chatContainer);
                        }
                    } else {
                        $('#dialogs').append(`
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    Nenhum diálogo encontrado.
                                </div>
                            </div>
                        `);
                    }
                },
                error: function (xhr, status, error) {
                    $('#loading').hide();
                    $('#dialogs').html(`
                        <div class="col-12">
                            <div class="alert alert-danger text-center">
                                Erro ao carregar os diálogos. Tente novamente.
                            </div>
                        </div>
                    `);
                }
            });
        }

        // Chama a função para carregar os diálogos ao carregar a página
        $(document).ready(function () {
            fetchDialogues();
            setInterval(fetchDialogues, 5000); // Atualiza os diálogos a cada 5 segundos
        });
    </script>
</body>
</html>
