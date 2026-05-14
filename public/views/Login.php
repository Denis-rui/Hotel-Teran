<section class="login">
    <div class="contenido-login">
        <div class="login-logo">
            <img src="./public/assets/img/image.jpeg" alt=" Teran Hotel Logo" />
            <h1>Teran Hotel</h1>
        </div>
        <div class="formulario">
            <form action="./Api/auth/login.php" class="formulario-login" method="post">
                <h2>Iniciar Sesión</h2>
                <div class="tipousuario label-input">
                    <label for="tipousuario">Tipo de Usuario</label>
                    <select id="tipousuario" name="tipousuario" class="input" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="administrador">Administrador</option>
                        <option value="recepcionista">Recepcionista</option>
                    </select>
                </div>
                <div class="usuario label-input">
                    <label for="usuario">Usuario</label>
                    <input
                        type="text"
                        id="usuario"
                        name="usuario"
                        class="input"
                        required />
                </div>
                <div class="contrasena label-input">
                    <label for="contrasena">Contraseña</label>
                    <input
                        type="password"
                        id="contrasena"
                        name="contrasena"
                        class="input"
                        required />
                </div>
                <div id="error" class=""></div>
                <?php if (isset($_GET["error"])): ?>
                    <div style="color:red;">Credenciales incorrectas</div>
                <?php endif; ?>
                <button class="boton" id="btnLogin" type="submit">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</section>