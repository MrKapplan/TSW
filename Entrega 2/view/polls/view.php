<?php
//file: view/polls/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$poll = $view->getVariable("poll");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");
$view->setVariable("title", "View Post");
$view->setVariable("javascript", "../js/common.js");

?><h1><?= i18n("Post").": ".htmlentities($poll->getTitle()) ?></h1>
<em><?= sprintf(i18n("by %s"),$post->getAuthor()->getUsername()) ?></em>
<p>
	<?= htmlentities($post->getContent()) ?>
</p>

<div class="container">
        <div class="row center-row">
            <div class="col-lg-6 center-block">
                <div id="subtitle">
				<?=htmlentities($poll->getTitle());?>
                </div>
                <div id="subsubtitle">
				<?= sprintf(i18n("by %s"),$poll->getAuthor()->getUsername()) ?> - <?= sprintf(i18n("At"),$poll->getUbication()) ?>.
                </div>
                <div id="link">
                    <div class="inputWithIcon inputIconBg">
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
                                    <th scope="col">Alejandro</th>
                                    <th scope="col">Martín</th>
                                    <th scope="col">Iván</th>
                                    <th id="user" scope="col"><button type="button" id="addCol" class="btn btn-success" value="+" onclick="appendColumn('dataTable','addCol');">+</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="0">
                                    <td>
                                        <div id="ytitle">MAR 27 Sep,</div>
                                        <div id="ysubtitle">10:00 - 11:00</div>
                                    </td>
                                    <td><label class="checkbox">
                                            <input type="checkbox" onclick="return false;" />
                                        </label></td>

                                    <td><label class="checkbox">
                                            <input type="checkbox" class="success" checked onclick="return false;" />
                                            <span class="success"></span>
                                        </label></td>

                                    <td><label class="checkbox">
                                            <input type="checkbox" checked onclick="return false;" />
                                            <span class="success"></span>
                                        </label></td>
                                </tr>
                                <tr id="1">
                                    <td>
                                        <div id="ytitle">MIE 28 Sep,</div>
                                        <div id="ysubtitle">15:00 - 16:00</div>
                                    </td>
                                    <td><label class="checkbox">
                                            <input type="checkbox" checked onclick="return false;" />
                                            <span class="success"></span>
                                        </label></td>

                                    <td><label class="checkbox">
                                            <input type="checkbox" checked onclick="return false;" />
                                            <span class="success"></span>
                                        </label></td>

                                    <td><label class="checkbox">
                                            <input type="checkbox" onclick="return false;" />
                                        </label></td>

                                </tr>
                                <tr id="2">
                                    <td>
                                        <div id="ytitle">JUE 29 Sep,</div>
                                        <div id="ysubtitle">16:00 - 17:00</div>
                                    </td>
                                    <td><label class="checkbox">
                                            <input type="checkbox" checked onclick="return false;" />
                                            <span class="success"></span>
                                        </label></td>

                                    <td><label class="checkbox">
                                            <input type="checkbox" onclick="return false;" />
                                        </label></td>

                                    <td><label class="checkbox">
                                            <input type="checkbox" checked onclick="return false;" />
                                            <span class="success"></span>
                                        </label></td>
                                </tr>

                                <tr id="3">
                                    <td>
                                        <div id="ytitle">LUN 01 Oct,</div>
                                        <div id="ysubtitle">09:00 - 10:00</div>
                                    </td>
                                    <td><label class="checkbox">
                                            <input type="checkbox" checked onclick="return false;" />
                                            <span class="success"></span>
                                        </label></td>

                                    <td><label class="checkbox">
                                            <input type="checkbox" onclick="return false;" />
                                        </label></td>

                                    <td><label class="checkbox">
                                            <input type="checkbox" onclick="return false;" />
                                        </label></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <button type="button" class="btn btn-dark">Continuar</button>
                </div>
            </div>
        </div>
    </div>
