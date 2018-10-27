<?php
//file: view/poll/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", i18n("My polls"));
$polls = $view->getVariable("polls");
$errors = $view->popFlashDanger();
$currentuser = $view->getVariable("currentusername");
?>


<?php if (!empty($errors)){ ?>
    <div class="alert alert-danger text-center" id="success-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?=i18n($errors)?>
    </div>
<?php } ?>

<div class="container">
    <div class="row center-row">
      <div class="col-lg-12 center-block">
			 <div id="subtitle">
         <h1><?= i18n("My polls")?></h1>
         </div>
           <div class="col-lg-12 center-block2">
            <table id="dataTable" class="table text-center">
               <thead>
                  <tr>
                     <th scope="col"><?= i18n("Title")?></th>
                     <th scope="col"><?= i18n("Ubication")?></th>
                     <th scope="col"><?= i18n("Author")?></th>
                     <th scope="col"> </th>
							     </tr>
                   </thead>
                   <tbody>
                     <?php foreach ($polls as $poll): ?>
                       <tr>
                          <td>
                          <a title="<?= i18n("See "); echo $poll->getTitle()?>" href="index.php?controller=polls&action=view&poll=<?= $poll->getLink() ?>"><?= htmlentities($poll->getTitle()) ?></a>
                          </td>
										
                          <td>
                            <?= htmlentities($poll->getUbication()) ?>
                          </td>
                                    
                          <td>
                          <?php if($poll->getAuthor()->getUsername() == $currentuser){ ?>
                                  <?=i18n("You")?></th>
                                <?php } else { ?>
                                  <?= htmlentities($poll->getAuthor()->getUsername()) ?>
                                <?php } ?>
                          </td>

                          <td>
                            <?php	
                              if (isset($currentuser) && $currentuser == $poll->getAuthor()->getUsername()): ?>
                              <a href="index.php?controller=polls&action=edit&poll=<?= htmlentities($poll->getLink())?>">
                                <span title="<?= i18n("Edit Polls")?>" class="btn btn-primary btn-sm fa fa-pencil"></a>&nbsp;&nbsp;
                              <a href="index.php?controller=gaps&action=edit&poll=<?= htmlentities($poll->getLink())?>">
                                <span title="<?= i18n("Edit Gaps")?>" class="btn btn-success btn-sm fa fa-th-list"></a>&nbsp;&nbsp;
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
        


	



