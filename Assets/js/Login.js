// Validacion visual del formulario de login en cliente.
// El backend sigue validando de nuevo por seguridad.
document.addEventListener("DOMContentLoaded", () => {
  const formulario = document.querySelector(".formulario-login");
  if (!formulario) return;

  formulario.addEventListener("submit", (e) => {
    const tipoUsuario = document.getElementById("tipousuario").value;
    const usuario = document.getElementById("usuario").value.trim();
    const contrasena = document.getElementById("contrasena").value;
    const error = document.getElementById("error");

    error.textContent = "";
    error.classList.remove("error-login");

    if (tipoUsuario === "") {
      e.preventDefault();
      error.textContent = "Elija un tipo de usuario.";
      error.classList.add("error-login");
      return;
    }

    if (usuario === "") {
      e.preventDefault();
      error.textContent = "Ingrese su nombre de usuario.";
      error.classList.add("error-login");
      return;
    }

    if (contrasena === "") {
      e.preventDefault();
      error.textContent = "Ingrese su contraseña.";
      error.classList.add("error-login");
      return;
    }

    // Si pasa validaciones del cliente, el formulario se envia a Auth/login.php.
  });
});
