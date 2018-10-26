<?php
//file: view/layouts/notLogin.php

$view = ViewManager::getInstance();

?><!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="./img/favicon.png" />
	<title><?= $view->getVariable("title", "no title") ?></title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet">

    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="./styles/style.css"/>
	<!-- enable ji18n() javascript function to translate inside your scripts -->
    <script src="index.php?controller=language&action=i18njs"></script>
    <script src="./js/common.js"></script>
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>

</head>


<body>
    <!-- HEADER -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.php"><img src="../img/logo.png" alt="logo" class="logo"></a>
        </nav>
    </header>

        <main>
            <?php $message = $view->popFlash(); ?>
            <?php if (!empty($message)){ ?>
                    <div class="alert alert-success text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?=i18n($message)?>
                    </div>
            <?php } ?>
            <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
    </main>

	   <!-- FOOTER-->
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
    </footer>
</body>

</html>
