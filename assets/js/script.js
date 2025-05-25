document.addEventListener("DOMContentLoaded", function () {
    const tabela = document.querySelector("table");
    if (tabela) {
        console.log("Tabela carregada com sucesso.");
    }

    // Função para recarregar a página automaticamente a cada 30 segundos
    setInterval(() => {
        location.reload();
    }, 30000);
});