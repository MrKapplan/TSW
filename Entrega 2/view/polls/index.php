<?php
//file: view/poll/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Polls");
$polls = $view->getVariable("polls");
$currentuser = $view->getVariable("currentusername");

?>

      <div class="container">
        <div class="row center-row">
            <div class="col-lg-6 center-block">
			<div id="subtitle">
                    <h1><?= i18n("My polls")?></h1>
                </div>
                <div class="col-lg-12 center-block2">
                    <table id="dataTable" class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col"><?= i18n("title")?></th>
                                <th scope="col"><?= i18n("ubication")?></th>
                                <th scope="col"><?= i18n("author")?></th>
                                <th scope="col"> </th>
							</tr>
                        </thead>
                        <tbody>
							<?php foreach ($polls as $poll): ?>
								<tr>
									<td>
										<a href="index.php?controller=polls&action=view&id=<?= $poll->getId() ?>"><?= htmlentities($poll->getTitle()) ?></a>
										</td>
										
										<td>
											<?= $poll->getUbication() ?>
										</td>
															 
										<td>
											<?= $poll->getAuthor()->getUsername() ?>
										</td>

										<td>
											<?php	
												if (isset($currentuser) && $currentuser == $poll->getAuthor()->getUsername()): ?>
													&nbsp;<a href="index.php?controller=polls&action=edit&id=<?= $poll->getId() ?>"><?= i18n("Edit") ?></a>

													<form method="POST "action="index.php?controller=polls&action=delete" id="delete_post_<?= $poll->getId(); ?>
														<input type="hidden" name="id" value="<?= $poll->getId() ?>">
														<a href="#"	onclick="	if (confirm('<?= i18n("are you sure?")?>')) {	document.getElementById('delete_poll_<?= $poll->getId() ?>').submit()}"><?= i18n("Delete") ?></a>
													</form>
													
												<?php endif; ?>
										</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

