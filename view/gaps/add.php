<?php
//file: view/gaps/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$poll = $view->getVariable("poll");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");
$view->setVariable("title", "Add Gap");

?>
<?php $view->moveToFragment("javascript"); ?>
 <!-- Kendo UI CSS -->
<script src="https://code.jquery.com/jquery-1.12.3.min.js" integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="./js/bootstrap-material-datetimepicker.js"></script>
<script src='./js/common.js'></script>
<script src='./js/calendar.js' defer></script>
<?php $view->moveToDefaultFragment(); ?>

<?php $view->moveToFragment("css"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css"/>
<link rel="stylesheet" href="./styles/bootstrap-material-datetimepicker.css" />
<link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<?php $view->moveToDefaultFragment(); ?>


<?php if (!empty($errors)){ ?>
    <div class="alert alert-danger text-center" id="success-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?=i18n(array_pop($errors))?>
    </div>
<?php } ?>

<div class="container">
    <div class="row center-row">
        <div class="col-lg-12 center-block">
            <div id="subtitle">
                <?= i18n("What free days do you have?") ?>
            </div>
            <div class="col-lg-12 center-block2">
                <form method="POST" action='index.php?controller=gaps&action=add&poll=<?= $poll->getLink()?>'>
                    <table id="dataTable" class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col"><button type="button" class="btn btn-success" id="botonAñadir" value="+"  onclick="addRow('dataTable');">+</button></th>
                                <th scope="col"><?= i18n("Date")?></th>
                                <th scope="col"><?= i18n("Start")?></th>
                                <th scope="col"><?= i18n("End")?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>
                                    <div id="inputDate">
                                        <div class="inputWithIconLogin inputIconBg">
                                            <input type="text" id="date-es" class ="date" required>
                                            <i class="fa fa-calendar fa-lg fa-fw" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div id="inputTimeStart">
                                        <div class="inputWithIconLogin inputIconBg">
                                            <input type="text" id="timeStart" class="timeStart" required>
                                            <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div id="inputTimeEnd">
                                        <div class="inputWithIconLogin inputIconBg">
                                            <input type="text" id="timeEnd" class="timeEnd" required>
                                            <i class="fa fa-clock-o fa-lg fa-fw" aria-hidden="true"></i>    
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" id="data" name="data"> 
                    <!-- <input type="hidden" id="timesStarts" name="timesStart"> 
                    <input type="hidden" id="timesEnds" name="timesEnd">  -->
                    <button type="submit" name="submit" class="btn btn-dark" onclick="valueData()"><?= i18n("Continue")?></button>
                </form>
            </div>
         </div>
     </div>
 </div>


