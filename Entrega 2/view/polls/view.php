<?php
//file: view/polls/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$poll = $view->getVariable("poll");
$gaps = $view->getVariable("gap");
$assignations = $view->getVariable("usersGaps");
$users = $view->getVariable("users");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");
$view->setVariable("title", "View Poll");


?>
<?php $view->moveToFragment("javascript"); ?>
<script src="./js/common.js"></script>
<?php $view->moveToDefaultFragment(); ?>



<div class="container">
        <div class="row center-row">
            <div class="col-lg-12 center-block">
                <div id="subtitle">
				<?=htmlentities($poll->getTitle());?>
                </div>
                <div id="subsubtitle">
				<?= sprintf(i18n("by %s"), $poll->getAuthor()->getUsername()) ?> - 	<?= sprintf(i18n("At %s"), $poll->getUbication())?>
                </div>
                <div id="link">
                    <div class="inputWithIconLogin inputIconBg">
                        <input type="text" id="linkEncuesta" placeholder="<?= $poll->getLink()?>" readonly>
                        <i class="fa fa-link fa-lg fa-fw" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="col-lg-12 center-block2">
                <form method="POST" action="index.php?controller=assignations&action=edit&poll=<?=$poll->getId()?>" onload="removeCheckbox('dataTable')">
                        <table id="dataTable" class="table text-center" >
                            <thead>
                                <tr>
                                <th scope="col"></th>
                            
                                <?php foreach ($users as $user): ?>
                                    <?php  if($user->getUser()->getUsername() != $currentuser){ ?>
                                        <th id="<?=$user->getUser()->getUsername()?>" scope="col"> <?=$user->getUser()->getUsername()?> </th>
                                    <?php } else { ?>
                                            <th id="<?=$currentuser?>" scope="col"> <?=i18n("You")?></th>
                                   <?php } ?>
                                <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($gaps as $gap){ 
                                ?>
                                    <tr id="<?= $gap->getId() ?>">
                                        <td>
                                            <div id="ytitle"><?= i18n(strtoupper(substr(date('l,', strtotime($gap->getDate())), 0, 3))), date(', d', strtotime($gap->getDate())), date(' M', strtotime($gap->getDate()))?></div>
                                            <div id="ysubtitle"><?= substr($gap->getTimeStart(), 0, 5);?> - <?= substr($gap->getTimeEnd(), 0, 5);?></div>
                                        </td>
                                          <?php foreach ($users as $user){ 
                                                    $isAssignated=false; ?>
                                            
                                                <?php foreach($assignations as $assignation){
                                                       if($assignation->getUser()->getUsername() == $user->getUser()->getUsername() && $assignation->getGap()->getId() == $gap->getId()){
                                                        $isAssignated=true;
                                                    }
                                                }
                                                if($isAssignated){ ?>
                                                        <td><label class="checkbox">
                                                        <input type="checkbox" class="success" checked onclick="return false;" />
                                                        <span class="success"></span>
                                                        </label></td>
                                                <?php } else { ?>
                                                        <td><label class="checkbox">
                                                        <input type="checkbox"  onclick="return false;" />
                                                        </label></td>
                                                <?php  } ?>

                                                <?php  } ?>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                         <a href="./index.php?controller=polls&action=index"><?= i18n("back") ?></a>
                        <button type="submit" class="btn btn-dark"><?= i18n("Modify Participation") ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
