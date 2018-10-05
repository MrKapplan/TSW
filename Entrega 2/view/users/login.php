<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<?= isset($errors["general"])?$errors["general"]:"" ?>

  <div class="container">
        <div class="row center-row">
            <div class="col-lg-6 center-block">
                <div id="subtitle">
                    <h1>LOGIN</h1>
                </div>
                <div class="col-lg-12 center-block2">
                    <form method="POST" action="crearUsuario">
                        <div id="loginInput">
                            <div class="inputWithIcon inputIconBg">
                                <input type="text" id="Usuario" placeholder="Usuario">
                                <i class="fa fa-reorder fa-lg fa-fw" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                        <div id="loginInput">
                            <div class="inputWithIcon inputIconBg">
                                <input type="password" id="Contraseña" placeholder="Contraseña">
                                <i class="fa fa-map-marker fa-lg fa-fw" aria-hidden="true"></i>
                            </div>
  
                        </div>
                        <button type="button" class="btn btn-dark">Entrar</button>
                    </form>
                    <div id="loginPerdidaDeDatos">
                    <a class="font-weight-light" href="">Has olvidado tus datos?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



