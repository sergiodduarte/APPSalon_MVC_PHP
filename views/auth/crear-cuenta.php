<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Diligencia el siguiente formulario para crear tu cuenta</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" value="<?php echo s($usuario -> nombre); ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Tu apellido" value="<?php echo s($usuario -> apellido); ?>">
    </div>

    <div class="campo">
        <label for="telefono">Numero de Telefono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Telefono de contacto" value="<?php echo s($usuario -> telefono); ?>">
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" value="<?php echo s($usuario -> email); ?>">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password">
    </div>

    <input type="submit" value="CREAR CUENTA" class="boton">
</form>

<div class="acciones">
    <a href="/">Inicia sesion</a>
    <a href="/olvide">Olvidaste tu password?</a>
</div>