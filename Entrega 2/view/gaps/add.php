<?php
//file: view/gaps/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

//$poll = $view->getVariable("poll");
// $gaps = $view->getVariable("gaps");
// $assignations = $view->getVariable("assignations");
// $participants = $view->getVariable("participants");

$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");
$view->setVariable("title", "Add Gap");

?>
 <!-- Kendo UI CSS -->
<?php $view->moveToFragment("javascript"); ?>
<script src="./js/common.js"></script>
<script src="./js/calendar.js"></script>
<script src="https://kendo.cdn.telerik.com/2018.3.911/js/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2018.3.911/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2018.3.911/js/cultures/kendo.culture.es-ES.min.js"></script>
<?php $view->moveToDefaultFragment(); ?>

<?php $view->moveToFragment("css"); ?>
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.3.911/styles/kendo.common-material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.3.911/styles/kendo.material.min.css" />
<?php $view->moveToDefaultFragment(); ?>


<div class="container">
        <div class="row center-row">
            <div class="col-lg-12 center-block">
                <div id="subtitle">
                    Vamos a elegir las fechas
                </div>
                <div class="col-lg-12 center-block2">
                    <form method="POST" action='Encuesta_Controller.php'>
                        <div id="selectorDate">
                            <div class="demo-section k-content" style="text-align: center;">
                                <div id="calendar">
                                </div>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-dark" value=fechas>Continuar</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
