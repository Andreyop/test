<?php

/** @var $this \yii\web\View */
/** @var $link string */

?>
<!-- 25_3 -->
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" data-mobile="true" style="background-color:rgb(255, 255, 255);">
    <tr>
        <td valign="top" align="center" style="padding:0;margin:0;">
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="564" style="width:564px;">
                <tr>
                    <td align="left" valign="top" style="padding:0;margin:0;">
                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" data-editable="text">
                            <tr>
                                <td valign="top" align="left" style="padding:5px 0 5px 15px;margin:0;font-family:Arial, sans-serif;color:rgb(255, 255, 255);background-color:rgb(163, 49, 39);">
                                    <span style="font-family:Arial,sans-serif;color:#ffffff;font-size:38px;font-weight:bold;">
                                       Данные отправлены из очереди
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top" style="padding:0;margin:0;">
                        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
                            <tr>
                                <td width="65%" valign="top" align="center">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left">
                                        <tr>
                                            <td align="left" valign="top" style="margin:0;padding:0;">
                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" data-editable="text">
                                                    <tr>
                                                        <td valign="top" align="left" style="padding:3px 10px 10px 15px;margin:0;font-family:Arial, sans-serif;color:rgb(255, 255, 255);background-color:rgb(201, 88, 78);">
                                                            <span style="font-family:Arial,sans-serif;color:#ffffff;font-size:38px;font-weight:bold;">
                                                               Содержание поста
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top" style="padding:0;margin:0;">
                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" data-editable="text">
                            <tr>
                                <td valign="top" align="left" style="padding:20px 15px 20px;margin:0;font-family:Arial, sans-serif;color:rgb(77, 77, 77);">
                                    <span style="font-family:Arial,sans-serif;color:#4d4d4d;font-size:18px;font-weight:normal;">


<div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
        <h3>№ поста: <?= $sender->id ?></h3>
        <h3>Название компании: <?= $sender->company_name ?></h3>
        <h3>Должность: <?= $sender->position ?></h3>
            <?php if(isset($sender->descriptivePost))  {?>

                <h3>Описание должности: <?= $sender->descriptivePost->position_description ?></h3>
                <h3>Размер заработной платы: <?= $sender->descriptivePost->salary ?></h3>
                <h3>Дата начала: <?= $sender->descriptivePost->dateStart ?></h3>
                <h3>Дата окончания: <?= $sender->descriptivePost->dateEnd ?></h3>

            <?php } ?>

                                        <?php if(isset($sender->contactPost))  {?>

                                            <h3>Контактное имя: <?= $sender->contactPost->contact_name ?></h3>
                                            <h3>Контактный Email: <?= $sender->contactPost->contact_email ?></h3>
                                        <?php } ?>
            </div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


