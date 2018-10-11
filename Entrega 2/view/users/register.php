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
                    <h1><?= i18n("Registry")?></h1>
                </div>
                <div class="col-lg-12 center-block2">
                    <form method="POST" action="index.php?controller=users&action=register">
                        <div id="inputLogin">
                            <div class="inputWithIconRegister inputIconBg">
                                <?= i18n("Username")?><input type="text" name="username" value="<?= $user->getUsername() ?>" placeholder="<?= i18n("UsernameAdd")?>" required>
                                <?php if(isset($errors["username"])) { ?> 
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?=i18n($errors["username"])?>
                                        </div>
                                <?php } ?>
                                <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div id="inputLogin">
                            <div class="inputWithIconRegister inputIconBg">
                                <?= i18n("Password")?><input type="password" name="passwd" placeholder="<?= i18n("PasswdAdd")?>" required>
                                <?php if(isset($errors["passwd"])) { ?> 
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?=i18n($errors["passwd"])?>
                                        </div>
                                <?php } ?>
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
