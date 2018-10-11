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
<script src="https://code.jquery.com/jquery-1.12.3.min.js" integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="./js/bootstrap-material-datetimepicker.js"></script>
<script src='./js/common.js'></script>
<script src='./js/calendar.js' defer></script>
<?php $view->moveToDefaultFragment(); ?>

<?php $view->moveToFragment("css"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css"/>
<link rel="stylesheet" href="./styles/bootstrap-material-datetimepicker.css" />
<link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<?php $view->moveToDefaultFragment(); ?>


<div class="container">
        <div class="row center-row">
            <div class="col-lg-12 center-block">
                <div id="subtitle">
                    <?= i18n("What free days do you have?") ?>
                </div>
                <div class="col-lg-12 center-block2">
                    <form method="POST" action='index.php?controller=gaps&action=add'>
                    <table id="dataTable" class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Inicio</th>
                                <th scope="col">Fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>
                                    <div id="inputDate">
                                        <div class="inputWithIconLogin inputIconBg">
                                            <input type="text" id="date-es" name="date1" required>
                                             <i class="fa fa-calendar fa-lg fa-fw" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div id="inputTime">
                                        <div class="inputWithIconLogin inputIconBg">
                                            <input type="text" id="timeStart" required>
                                             <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div id="inputTime">
                                        <div class="inputWithIconLogin inputIconBg">
                                            <input type="text" id="timeEnd" required>
                                             <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>
                                             
                                        </div>
                                    </div>
                                </td>
                                <td><button type="button" class="btn btn-success" id="botonAñadir" value="+"  onclick="addRow('dataTable');">+</button></td>
                            </tr>

                            </tbody>
                    </table>
                        <!-- <button type="button" class="btn btn-dark" value=fechas>Continuar</button> -->
                    </form>
                </div>
            </div>
        </div>
</div>


