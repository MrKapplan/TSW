<?php
//file: view/polls/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$poll = $view->getVariable("poll");
$gaps = $view->getVariable("gap");
$usersGaps = $view->getVariable("usersGaps");
$users = $view->getVariable("users");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");
$view->setVariable("title", "View Poll");
//$view->setVariable("javascript", "src='./js/common.js'");

?>



<div class="container">
        <div class="row center-row">
            <div class="col-lg-6 center-block">
                <div id="subtitle">
				<?=htmlentities($poll->getTitle());?>
                </div>
                <div id="subsubtitle">
				<?= sprintf(i18n("by %s"), $poll->getAuthor()->getUsername()) ?> - 	<?= sprintf(i18n("At %s"), $poll->getUbication()) ?>

                </div>
                <div id="link">
                    <div class="inputWithIconLogin inputIconBg">
                        <input type="text" id="linkEncuesta" placeholder="<?= $poll->getLink()?>" readonly>
                        <i class="fa fa-link fa-lg fa-fw" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="col-lg-12 center-block2">
                    <form method="POST" action="crear">
                        <table id="dataTable" class="table text-center" onload="checkboxes('dataTable')" onclick="removeCheckbox('dataTable')">
                            <thead>
                                <tr>
                                <th scope="col"></th>
                                <?php foreach ($users as $user): ?>
                                    <th scope="col"> <?=$user->getUser()->getUsername()?> </th>
                                <?php endforeach; ?>
                                    <th id="user" scope="col"><button type="button" id="addCol" class="btn btn-success" value="+" onclick="appendColumn('dataTable','addCol');">+</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($gaps as $gap){ ?>
                                    <tr id="<?= $gap->getId() ?>">
                                        <td>
                                            <div id="ytitle"><?= i18n(strtoupper(substr(date('l,', strtotime($gap->getDate())), 0, 3))), date(', d', strtotime($gap->getDate())), date(' M', strtotime($gap->getDate()))?></div>
                                            <div id="ysubtitle"><?= substr($gap->getTimeStart(), 0, 5);?> - <?= substr($gap->getTimeEnd(), 0, 5);?></div>
                                        </td>

                                          <?php foreach ($users as $user){ ?>

                                                    <td><label class="checkbox">
                                                    <input type="checkbox" class="success" checked onclick="return false;" />
                                                    <span class="success"></span>
                                                    </label></td>
         
                                                <?php  } ?>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </form>
                    <button type="button" class="btn btn-dark">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    
