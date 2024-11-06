<!DOCTYPE html>
<html lang="es">

<!--
Pagina del login:
http://localhost/analisis/public/login
-->


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistema de Administración</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="<?= base_url() ?>"><b>Admin</b>ITSI</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Inicia sesión para comenzar</p>

            

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger">
                    <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>






            <div style="display:none">
                URL base: <?= base_url() ?><br>
                URL actual: <?= current_url() ?><br>
                URL login: <?= base_url('login') ?>
            </div>



            <form action="<?= base_url('login') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Usuario" value="<?= old('username') ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                    </div>
                </div>
            </form>




        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>





<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        console.log('Formulario enviado');
        // Ver los datos que se están enviando
        console.log({
            username: $('input[name="username"]').val(),
            password: $('input[name="password"]').val(),
            csrf: $('input[name="csrf_token_name"]').val()
        });
    });
});
</script>



<script>
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault(); // Detener el envío temporalmente
    console.log('Formulario enviándose a:', this.action);
    console.log('Método:', this.method);
    console.log('Datos:', {
        username: this.querySelector('[name="username"]').value,
        password: this.querySelector('[name="password"]').value,
        csrf: this.querySelector('[name="csrf_token_name"]').value
    });
    this.submit(); // Continuar con el envío
});
</script>









</body>
</html>