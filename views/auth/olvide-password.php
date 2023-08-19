<h1>Olvidaste tu contrasena?</h1>
<p class="descripcion-pagina">Ingresa tu email para enviar el link que te permitira reiniciar tu contrasena</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email">
    </div>
    <input type="submit" value="REESTABLECER CONTRASENA" class="boton">
</form>



<div class="acciones">
    <a href="/">Iniciar sesion</a>
    <a href="/crear-cuenta">Crear cuenta</a>
</div>