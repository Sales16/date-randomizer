document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll(".links-container a");
  const sidebarToggle = document.querySelector("#sidebar-active");

  // Função para abrir/fechar o menu lateral e animar os links
  function toggleMenu() {
    if (sidebarToggle.checked) {
      links.forEach((link, index) => {
        link.style.transitionDelay = `${index * 0.2}s`;
        link.style.opacity = "1";
        link.style.transform = "translateX(0)";
      });
    } else {
      links.forEach(link => {
        link.style.transitionDelay = "0s";
        link.style.opacity = "0";
        link.style.transform = "translateX(50px)";
      });
    }
  }

  // Evento de mudança no checkbox para abrir/fechar o menu
  sidebarToggle.addEventListener("change", toggleMenu);

  // Evento de redimensionamento da tela para restaurar os links em telas maiores
  window.addEventListener("resize", () => {
    if (window.innerWidth > 860) {
      // Em telas maiores, garantir que os links fiquem visíveis
      links.forEach(link => {
        link.style.opacity = "1";
        link.style.transform = "translateX(0)";
        link.style.transitionDelay = "0s";
      });
    } else if (!sidebarToggle.checked) {
      // Em telas menores, se o menu não estiver ativo, esconder os links
      links.forEach(link => {
        link.style.opacity = "0";
        link.style.transform = "translateX(50px)";
      });
    }
  });
});
