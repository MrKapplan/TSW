<?php
//file: view/poll/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", i18n("My polls"));
$polls = $view->getVariable("polls");
$currentuser = $view->getVariable("currentusername");
?>


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
                          <a href="index.php?controller=polls&action=view&poll=<?= $poll->getLink() ?>"><?= htmlentities($poll->getTitle()) ?></a>
                          </td>
										
                          <td>
                            <?= htmlentities($poll->getUbication()) ?>
                          </td>
                                    
                          <td>
                            <?= htmlentities($poll->getAuthor()->getUsername()) ?>
                          </td>

                          <td>
                            <?php	
                              if (isset($currentuser) && $currentuser == $poll->getAuthor()->getUsername()): ?>
                              <a href="index.php?controller=polls&action=edit&poll=<?= htmlentities($poll->getLink())?>">
                                <span title="Edit" class="btn btn-primary btn-sm  fa fa-pencil"></a>&nbsp;&nbsp;
                                
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
        


	



