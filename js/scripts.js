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
            setTimeout(function() {
                messageDiv.remove();
            }, 500);
        }, delay);
    }
}

document.addEventListener("DOMContentLoaded", function() {
    fadeOutMessage('.sucesso');
    fadeOutMessage('.erro');
});

function confirmarAcao(acao) {
    let mensagem = '';

    if (acao === 'excluirDados') {
        mensagem = "Tem certeza que deseja apagar todos os dados da conta? Essa ação é irreversível!";
    } else if (acao === 'excluirConta') {
        mensagem = "Tem certeza que deseja excluir a conta? Essa ação é irreversível!";
    }

    if (confirm(mensagem)) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "excluir-dados.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('navbar').insertAdjacentHTML('afterend', xhr.responseText);     
                fadeOutMessage('.erro')
                fadeOutMessage('.sucesso')
                if (acao === 'excluirConta') {
                    window.location.href = "login.php";
                }

            } else {
                document.getElementById('navbar').insertAdjacentHTML('afterend', "<div class='erro'><p>Erro ao processar sua solicitação!</p></div>");
                fadeOutMessage('.erro')
            }
        };
        xhr.send("acao=" + acao);
    }
}