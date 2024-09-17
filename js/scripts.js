function redirecionar() {
    window.location.href = "adicionar.php";
}

function updateValue(valor) {
    document.getElementById('valor').textContent = valor;
}

function buscarLinhaAleatoria() {
    const loadingIcon = document.getElementById('loadingIcon');
    loadingIcon.style.display = 'block';
    loadingIcon.style.animation = 'spin 1s linear';

    setTimeout(() => {
        loadingIcon.style.display = 'none';
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "sortear.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("resultado").innerHTML = xhr.responseText;
                fadeOutMessage('.sucesso');
                fadeOutMessage('.erro');
            }
        };
        xhr.send();
    }, 1000);

}

function fadeOutMessage(selector, delay=3000) {
    const messageDiv = document.querySelector(selector);
    if (messageDiv) {
        setTimeout(function() {
            messageDiv.style.opacity = '0';
        }, delay);
    }
}

document.addEventListener("DOMContentLoaded", function() {
    fadeOutMessage('.sucesso');
    fadeOutMessage('.erro');
});

$(document).ready(function() {
    $('#importUser').on('submit', function(event) {
        event.preventDefault(); // Previne o envio padrão do formulário

        var username = $('#username').val();

        $.ajax({
            url: 'import-user.php',
            type: 'POST',
            data: { username: username },
            success: function(response) {
                $('#result').html(response);
            },
            error: function() {
                $('#result').html("<div class='erro'><p>Usuario não encontrado!</p></div>");
            }
        });
    });
});