<?php
//file: view/polls/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$poll = $view->getVariable("poll");
$gaps = $view->getVariable("gaps");
$assignations = $view->getVariable("assignations");
$participants = $view->getVariable("participants");
$isParticipant = $view->getVariable("isParticipant");
$currentuser = $view->getVariable("currentusername");
$view->setVariable("title", "View Poll");
?>



<div class="container">
    <div class="row center-row">
        <div class="col-lg-12 center-block">
            <div id="subtitleView">
				 <?=htmlentities($poll->getTitle());?>
            </div>
            <div id="subsubtitle">
                <?= sprintf(i18n("by %s"), $poll->getAuthor()->getUsername()) ?> <?php if($poll->getUbication() != null): ?> - <?= sprintf(i18n("At %s"), $poll->getUbication()) ?><?php endif; ?>
            </div>
            <div id="link">
                <div id="inputLink" class="inputWithIconLogin inputIconBg">
                    <input type="text" placeholder="localhost/index.php?controller=polls&action=view&poll=<?= $poll->getLink()?>" readonly>
                     <i class="fa fa-link fa-lg fa-fw" aria-hidden="true"></i>
                </div>
            </div>
             <div class="col-lg-12 center-block2">
                <?php if(count($gaps) == 0): ?>
                    <div id="messageView">
                        <?= i18n("There are not gaps!");?>
                        <?php if($poll->getAuthor()->getUsername() == $currentuser): ?>
                             <?= i18n("Add it ");?><a href="index.php?controller=gaps&action=add&poll=<?= $poll->getLink() ?>"><?= i18n("here");?></a>
                        <?php endif; ?>
                    </div>
                <?php elseif(count($participants) < 1): ?>
                    <div id="messageView">
                        <?= i18n("There are not participations! Be the first to do it!");?>
                    </div>
                    <form method="POST" action='index.php?controller=assignations&action=add&poll=<?=htmlentities($poll->getLink())?>'>
                <?php elseif($isParticipant == FALSE): ?>
                    <form method="POST" action='index.php?controller=assignations&action=add&poll=<?=htmlentities($poll->getLink())?>'>   
                <?php else: ?>
                    <form method="POST" action='index.php?controller=assignations&action=edit&poll=<?=htmlentities($poll->getLink())?>'>
                <?php endif;?>

                    <?php if(count($participants) > 0): ?>
                        <table id="dataTable" class="table text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach ($participants as $user): ?>
                                        <?php  if($user->getUser()->getUsername() != $currentuser){ ?>
                                            <th id="<?=$user->getUser()->getUsername()?>" scope="col"> <?=$user->getUser()->getUsername()?> </th>
                                        <?php } else { ?>
                                            <th id="<?=$currentuser?>" scope="col"> <?=i18n("You")?></th>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($gaps as $gap):?>
                                    <tr id="<?= $gap->getId() ?>">
                                        <td>
                                            <div class="ytitle"><?= i18n(strtoupper(substr(date('l,', strtotime($gap->getDate())), 0, 3))), date(', d', strtotime($gap->getDate())), date(' M', strtotime($gap->getDate()))?></div>
                                            <div class="ysubtitle"><?= substr($gap->getTimeStart(), 0, 5);?> - <?= substr($gap->getTimeEnd(), 0, 5);?></div>
                                        </td>
                                        <?php foreach ($participants as $user): 
                                            $isAssignated=false; ?>
                                            <?php foreach($assignations as $assignation):
                                                if($assignation->getUser()->getUsername() == $user->getUser()->getUsername() && $assignation->getGap()->getId() == $gap->getId()):
                                                    $isAssignated=true;
                                                endif;
                                            endforeach;
                                            if($isAssignated): ?>
                                                <td><label class="checkbox">
                                                <input type="checkbox" class="success" checked onclick="return false;" />
                                                <span class="success"></span>
                                                </label></td>
                                            <?php else : ?>
                                                <td><label class="checkbox">
                                                <input type="checkbox"  onclick="return false;" />
                                                </label></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                
                <script>checkboxes();</script>
                <a href="./index.php?controller=polls&action=index"><?= i18n("Back") ?></a>
                <?php if(count($gaps) == 0): ?>
                <?php elseif($isParticipant): ?>
                    <button type="submit" class="btn btn-dark"><?= i18n("Modify Participation") ?></button>
                <?php else: ?>
                    <button type="submit" class="btn btn-dark"><?= i18n("Take part") ?></button>
                <?php endif; ?>
                </form>
            </div>
         </div>
     </div>
 </div>