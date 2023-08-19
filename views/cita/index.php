<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>

    <h1 class="nombre-pagina">Crear nueva cita</h1>
    <p class="descripcion-pagina">Elige los servicios e ingresa tu datos personales para reservar tu cita.</p>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Tus datos y Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios</p>
        <div id="servicios" class="listado-servicios"></div> <!--Este div se queda vacio, con javascript va a consultar la db con php la va a exportar a json y luego los inserta-->
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus datos y Cita</h2>
        <p class="text-center">Ingresa tus datos y fecha de tu cita:</p>

        <form class="formulario">
            <!--nombre-->
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>" disabled>
            </div>
            <!--Telefono-->
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu E-mail" value="<?php echo $email; ?>" disabled>
            </div>

            <!--fecha-->
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>

            <!--hora-->
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" value="10:30" min="09:00" max="19:59" step="1800" id="hora">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que los datos son correctos:</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>