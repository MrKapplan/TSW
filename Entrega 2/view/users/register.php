<?php
//file: view/users/register.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>

<?= isset($errors["general"])?$errors["general"]:"" ?>

 <div class="container">
        <div class="row center-row">
            <div class="col-lg-6 center-block">
                <div id="subtitle">
                    <h1><?= i18n("Register")?></h1>
                </div>
                <div class="col-lg-12 center-block2">
                    <form method="POST" action="index.php?controller=users&action=register">
                        <div id="loginInput">
                            <div class="inputWithIconRegister inputIconBg">
								<?= i18n("Username")?><input type="text" name="username" value="<?= $user->getUsername() ?>" placeholder="<?= i18n("UsernameAdd")?>" required>
								<?= isset($errors["username"])?i18n($errors["username"]):"" ?>
                                <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div id="loginInput">
                            <div class="inputWithIconRegister inputIconBg">
								<?= i18n("Password")?><input type="password" name="passwd" placeholder="<?= i18n("PasswdAdd")?>" required>
								<?= isset($errors["passwd"])?i18n($errors["passwd"]):"" ?>
								<i class="fa fa-lock fa-lg fa-fw" aria-hidden="true"></i>
                            </div>
							<button type="submit" class="btn btn-dark"><?= i18n("Register")?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $view->moveToDefaultFragment(); ?>
