<?php
//file: view/polls/edit.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$poll = $view->getVariable("poll");
$errors = $view->getVariable("errors");
$view->setVariable("title", "Add Poll"); ?>


<div class="container">
	<div class="row center-row">
		<div class="col-lg-6 center-block">
			<div id="subtitlePoll">
				<?=htmlentities(i18n("Do you want to change something?"))?>
			</div>
			<div class="col-lg-12 center-block2">
				<form method="POST" action="index.php?controller=polls&action=edit&poll=<?=$poll->getLink()?>">
					<div id="requiredInput">
						<div class="inputWithIconLogin inputIconBg">
							<input type="text" name="title" placeholder="<?= i18n("What is the matter about?")?>"  value="<?=htmlentities($poll->getTitle())?>" required>
							<i class="fa fa-reorder fa-lg fa-fw" aria-hidden="true"></i>
						</div>
						<div id=lblBox>
						<?= i18n("Mandatory")?>
						</div>
					</div>
					<div id="optionalInput">
						<div class="inputWithIconLogin inputIconBg">
							<input type="text" name="ubication" placeholder="<?= i18n("Where are you going to celebrate?")?>" value="<?=htmlentities($poll->getUbication())?>">
							<i class="fa fa-map-marker fa-lg fa-fw" aria-hidden="true"></i>
						</div>
					</div>
	                <div id="optionalInput">
                    	<div class="inputWithIconLogin inputIconBg">
                        	<input type="text" placeholder="localhost/index.php?controller=polls&action=view&poll=<?=$poll->getLink()?>" readonly>
                        	<i class="fa fa-link fa-lg fa-fw" aria-hidden="true"></i>
                   		 </div>
					</div>
					<button type="submit" name="submit" class="btn-dark"><?= i18n("Save")?></button>
				</form>
				<div id="subtitle">
					<button type="submit" class="btn btn-dark"><a href="index.php?controller=gaps&action=edit&poll=<?=$poll->getLink()?>"><?= i18n("Modify Gap") ?></a></button>
				</div>
				<a href="./index.php?controller=polls&action=index"><?= i18n("Back") ?></a>
			</div>
		</div>
	</div>
</div>