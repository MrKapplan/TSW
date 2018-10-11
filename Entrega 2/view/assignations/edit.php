<?php
//file: view/assignations/edit.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$poll = $view->getVariable("poll");
$gaps = $view->getVariable("gaps");
$assignations = $view->getVariable("assignations");
$participants = $view->getVariable("participants");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");
$view->setVariable("title", "Edit Assignation");

?>


<div class="container">
        <div class="row center-row">
            <div class="col-lg-12 center-block">
                <div id="subtitleView">
				    <?=htmlentities($poll->getTitle());?>
                </div>
                <div id="subsubtitle">
				    <?= sprintf(i18n("by %s"), $poll->getAuthor()->getUsername()) ?> - 	<?= sprintf(i18n("At %s"), $poll->getUbication())?>
                </div>
                <div id="link">
                    <div id="inputLink" class="inputWithIconLogin inputIconBg">
                        <input type="text" id="linkEncuesta" placeholder="<?= $poll->getLink()?>" readonly>
                        <i class="fa fa-link fa-lg fa-fw" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="col-lg-12 center-block2">
                    <form method="POST" action="index.php?controller=assignations&action=edit&poll=<?=$poll->getId()?>">
                        <table id="dataTable" class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <?php foreach ($participants as $participant): ?>
                                        <?php  if($participant->getUser()->getUsername() != $currentuser){ ?>
                                            <th id="<?=$participant->getUser()->getUsername()?>" scope="col"> <?=$participant->getUser()->getUsername()?> </th>
                                        <?php } else { ?>
                                            <th class="zoom" id="<?=$currentuser?>" scope="col"> <?=i18n("You")?></th>
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
                                          <?php foreach ($participants as $participant){ 
                                                    $isAssignated=false; 
                                                    $currentUserAsignation = false; ?>
    
                                                <?php foreach($assignations as $assignation){
                                                     $currentUserAsignation = false;
                                                    if($assignation->getUser()->getUsername() == $participant->getUser()->getUsername() && $assignation->getGap()->getId() == $gap->getId()){
                                                        $isAssignated=true;
                                                }
                                            }
                                            if($participant->getUser()->getUsername() == $currentuser){
                                                $currentUserAsignation = true;         
                                            }
                                                if($currentUserAsignation && $isAssignated){ ?>
                                                        <td class="zoom"><label class="checkbox">
                                                        <input type="checkbox" name="assignation" value="<?=$gap->getId()?>" checked/>
                                                        <span class="success"></span>
                                                        </label></td>
                                             <?php   } else if($currentUserAsignation && !$isAssignated){ ?>
                                                        <td class="zoom"><label class="checkbox">
                                                        <input type="checkbox" name="assignation" value="<?=$gap->getId()?>"/>
                                                        <span class="success"></span>
                                                        </label></td>                                                 
                                               <?php } else if($isAssignated){ ?>
                                                        <td><label class="checkbox">
                                                        <input type="checkbox" class="success" checked onclick="return false;" />
                                                        <span class="success"></span>
                                                        </label></td>
                                                <?php } else { ?>
                                                        <td><label class="checkbox">
                                                        <input type="checkbox" onclick="return false;" />
                                                        </label></td>
                                                <?php  } ?>

                                                <?php  } ?>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                         <a href="./index.php?controller=polls&action=view&poll=<?=$poll->getId()?>"><?= i18n("Back") ?></a>
                        <input type="hidden" id="hidden" name="assignations" > 
                        <button type="submit" name="submit" class="btn btn-dark" onclick="validateCheckboxes()"><?= i18n("Save")?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
