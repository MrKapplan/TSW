<?php
//file: view/layouts/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?><!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="../img//favicon.png" />
	<title><?= $view->getVariable("title", "no title") ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../styles/style.css">
	<script src="index.php?controller=language&amp;action=i18njs"></script>

	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
</head>

<body>
	  <!-- HEADER -->
	  <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">¿Tienes un hueco?</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Crear Encuesta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ver Encuestas</a>
                    </li>
                </ul>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Mi Cuenta
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Mi Perfil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Salir</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

	<main>
		<div id="flash">
			<?= $view->popFlash() ?>
		</div>

		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
	</main>


 <footer class="footer">
        <div class="container">
            <div class="sub-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="social-network">
                            <li><a href="#" title="Facebook"><i class="fa fa-facebook fa-1x"></i></a></li>
                            <li><a href="#" title="Twitter"><i class="fa fa-twitter fa-1x"></i></a></li>
                            <li><a href="#" title="LinkedIn"><i class="fa fa-linkedin fa-1x"></i></a></li>
                            <li><a href="#" title="Pinterest"><i class="fa fa-pinterest fa-1x"></i></a></li>
                            <li><a href="#" title="Google Plus"><i class="fa fa-google-plus fa-1x"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-12">
                        <div class="copyright">
                            <span>&copy;TienesHueco 2018. Let's do it! By </span><a href="" target="_blank">G25_TSW</a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		
		<!-- <?php
		// include(__DIR__."/language_select_element.php");
		?> -->
</footer>
</body>
</html>
