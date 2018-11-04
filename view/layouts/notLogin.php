<?php
//file: view/layouts/notLogin.php
$view = ViewManager::getInstance();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" href="/meetPoll_TSW/img/favicon.png" />
	<title><?= $view->getVariable("title", "no title") ?></title>
    <meta charset="UTF-8" />
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
    
</body>

</html>
