const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");

// Alternar el estado del sidebar (cerrado o abierto)
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

// Alternar el modo oscuro
modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark");

    // Cambiar el texto del modo según el estado del cuerpo
    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode"; // Si está en modo oscuro, cambiar el texto a 'Light mode'
    } else {
        modeText.innerText = "Dark mode"; // Si está en modo claro, cambiar el texto a 'Dark mode'
    }
});
