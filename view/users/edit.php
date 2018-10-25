<?php
//file: view/users/edit.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "MyProfile");
$user = $view->getVariable("user");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");
?>

 <div class="container">
        <div class="row center-row">
            <div class="col-lg-6 center-block">
                <div id="subtitle">
                    <h1><?= i18n("MyProfile")?></h1>
                </div>
                <div class="col-lg-12 center-block2">
                    <form method="POST" action="index.php?controller=users&action=edit">
                        <div id="inputLogin">
                            <div class="inputWithIconLogin inputIconBg">
								<input type="text" name="username" placeholder="<?= $user->getUsername()?>" readonly>
                                <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div id="inputLogin">
                            <div class="inputWithIconLogin inputIconBg">
								<input type="password" name="passwd" placeholder="<?= i18n("PasswdAdd")?>" required>
                                <?php $message = $errors["passwd"]; ?>
                                <?php if (!empty($message)){ ?>
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong><?=$message?></strong>
                                        </div>
                                        <?php $message=null; ?>
                                <?php } ?>
								<i class="fa fa-lock fa-lg fa-fw" aria-hidden="true"></i>
                            </div>
                            
                            <button type="submit" class="btn btn-dark"><?= i18n("Edit")?></button>
                            <a href="./index.php?controller=polls&action=index"><?= i18n("Back") ?></a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>