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
            <div class="col-lg-6 center-block-login">
            <div id="subtitleLogin">
                    <a class="navbar-brand" href="index.php"><img src="/meetPoll_TSW/img/logo.png" alt="logo" class="logoLogin"></a>
                    <h5><br><?= i18n("Registry")?></h5>
                </div>
                <div class="col-lg-12 center-block2">
                    <form method="POST" action="index.php?controller=users&action=register">
                        <div id="inputLogin">
                            <div class="inputWithIconLogin inputIconBg">
                            <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                               <input type="text" name="username" value="<?= $user->getUsername() ?>" placeholder="<?= i18n("Username")?>" required>
                                <?php if(isset($errors["username"])) { ?> 
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?=i18n($errors["username"])?>
                                        </div>
                                <?php } ?>
                            </div>

                            <div class="inputWithIconLogin inputIconBg">
                                <input type="password" name="passwd" placeholder="<?= i18n("Password")?>" required>
                                <i class="fa fa-lock fa-lg fa-fw" aria-hidden="true"></i>
                                <?php if(isset($errors["passwd"])) { ?> 
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?=i18n($errors["passwd"])?>
                                        </div>
                                <?php } ?>
                            </div>

                            <div class="inputWithIconLogin inputIconBg">
                               <input type="password" name="confirmPasswd" placeholder="<?= i18n("Confirm the password")?>" required>
                               <i class="fa fa-lock fa-lg fa-fw" aria-hidden="true"></i>
                                <?php if(isset($errors["ConfirmPasswd"])) { ?> 
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?=i18n($errors["ConfirmPasswd"])?>
                                        </div>
                                <?php } ?>
                            </div>

                            <div class="inputWithIconLogin inputIconBg">
                               <input type="text" name="email" placeholder="<?= i18n("Email")?>" required>
                               <i class="fa fa-envelope fa-lg fa-fw" aria-hidden="true"></i>
                                <?php if(isset($errors["email"])) { ?> 
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?=i18n($errors["email"])?>
                                        </div>
                                <?php } ?>
                            </div><br>

                            <div class="inputWithIconLogin inputIconBg">
                                <input type="checkbox" name="notifications" class="checkbox"/>
                                <span><?= i18n("Receive notifications")?>&nbsp;</span>
                            </div><br>

                            <button type="submit" class="loginButton btn btn-dark"><?= i18n("Register")?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $view->moveToDefaultFragment(); ?>
