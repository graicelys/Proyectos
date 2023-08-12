console.log ("scrool aqui");

$(document).ready(function () {
   
    // Llama a la función desde este archivo
    console.log('jquery cargado');
    refreshChat();

    $('form').on('submit', function (event) {
        console.log('sending form!');
        event.preventDefault();
        var formData = $(this).serialize();
        var form = $(this);

        $.ajax({
            type: "POST",
            url: 'chatbot.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log('form enviado');
                form[0].reset(); // Resetear el formulario.
                refreshChat();
                setTimeout(checkPendingBotAnswer, 3000);
                refreshChat();

                
        
            
            },
            error: function (xhr, status, error) {
                console.log("No se envio el formulario");
                //alert("No se envio el formulario");
            },
        });
    });

    
    function refreshChat() {
        console.log('refreshChat fn starts');
        $('.chat-container').html('');
        $.ajax({
            type: "GET",
            url: "display/chat_refresh.php",
            dataType: "html",
            success: function (html) {
                console.log('refreshChat fn success response');
                $('.chat-form-submit').prop('disabled', false);
                $('.chat-container').html(html);
                scroll(); // Llamado a la función scroll() después de que se completa refreshChat().
                fetchChatMessage();// Llama a la función para mostrar el resultado
                
                
                
            },
            error: function (xhr, status, error) {
                console.log("No se realizo la acción de refresh");
            }
        });
    }

    function checkPendingBotAnswer() {
        $('.chat-container1').html('');
        $.ajax({
            type: "GET",
            url: "display/chatbot_response.php",
            dataType: "json",
            success: function (response) {
                console.log('BotAnswer fn success response');
                $('.chat-form-submit').prop('disabled', true);
                console.log('BotAnswer fn waiting answer');
                refreshChat();
                
            },
            error: function (xhr, status, error) {
                console.log("No se realizo la acción de check");
            }
        });
    }

    function fetchChatMessage() {
        // Obtener el último registro de laika_user_questions
        $.ajax({
            type: "GET",
            url: "display/chatbot_default.php",
            dataType: "html",
            success: function (response) {
                // Verificar si el último registro tiene exact_question_id igual a 2
                $.ajax({
                    type: "GET",
                    url: "display/display_chat.php",
                    dataType: "json",
                    success: function (result) {
                        if (result.exact_question_id === '2') {
                            // El último registro tiene exact_question_id igual a 2
                            $('.chat-container').append(response);
                            scroll(); // Llamado a la función scroll() después de mostrar el mensaje.
                        } else {
                            console.log("El último registro no tiene exact_question_id igual a 2");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("No se pudo obtener el último registro de laika_user_questions");
                    }
                });
            },
            error: function (xhr, status, error) {
                console.log("No se pudo obtener el mensaje del chat");
            }
        });
    }

    function scroll() {
        // Desplazar hacia abajo
        var sidebar = $('.sidebar');
        sidebar.scrollTop(sidebar[0].scrollHeight);
    }
});