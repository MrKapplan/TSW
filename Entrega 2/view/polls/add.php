<?php
//file: view/polls/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$view->setVariable("title", "Add Poll"); ?>


<div class="container">
	<div class="row center-row">
		<div class="col-lg-6 center-block">
			<div id="subtitlePoll">
				<?=htmlentities(i18n("Some data to start..."))?>
			</div>
			<div class="col-lg-12 center-block2">
				<form method="POST" action="index.php?controller=polls&action=add">
					<div id="requiredInput">
						<div class="inputWithIconLogin inputIconBg">
							<input type="text" name="title" placeholder="<?= i18n("What is the matter about?")?>" required>
							<i class="fa fa-reorder fa-lg fa-fw" aria-hidden="true"></i>
						</div>
						<div id=lblBox>
						<?= i18n("Mandatory")?>
						</div>
					</div>
					<div id="optionalInput">
						<div class="inputWithIconLogin inputIconBg">
							<input type="text" name="ubication" placeholder="<?= i18n("Where are you going to celebrate?")?>">
							<i class="fa fa-map-marker fa-lg fa-fw" aria-hidden="true"></i>
						</div>
					</div>
					<button type="submit" name="submit" class="btn-dark"><?= i18n("Continue")?></button>
				</form>
			</div>
		</div>
	</div>
</div>