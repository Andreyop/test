<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Страница с данными из базы';
?>
    <div class="site-index container">

        <div class="body-content row">

            <div class="col-md-12">

                <?= print_r($sender,1) ?>


                                <?= print_r($admin_email,1) ?>
                <?php  foreach ($posts as $post): ?>

                <hr>

                    <h2><?= $post->id ?> - <?= $post->type ?> - <?= $post->company_name ?> - <?= $post->position ?></h2>

                    <?php foreach ($post->postsQueues as $queue): ?>
                        <h3><?= $queue->datePostAt ?> - <?= $queue->notification_sent_at ?></h3>


                    <?php   endforeach; ?>
                <?php   endforeach; ?>



            </div>

        </div>
    </div>

