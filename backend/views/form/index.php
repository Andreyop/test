<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\DatePicker;

$this->title = 'Форма';
?>

<?php Pjax::begin()?>


<?php
$this->registerJs('$("#form-type").on({
                        "change": function () {
                            var type_form = $(this);
                            var first = $(".form-field-first");
                            var second = $(".form-field-second");
                            var third = $(".form-field-third");

                            if ((type_form.val()) === "contact") {
                                first.show();
                                second.show();
                                if(third.is(":visible")) {
                                    third.hide();
                                }
                            }
                            if ((type_form.val()) === "descriptive") {
                                first.show();
                                third.show();
                                if(second.is(":visible")) {
                                    second.hide();
                                }
                            }
                        }
                    });', yii\web\View::POS_READY);
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

                <?php if(Yii::$app->session->hasFlash('success')): ?>

                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <?= Yii::$app->session->getFlash('success'); ?>
                    </div>

                    <?php
                    $this->registerJs('$(".alert").animate({opacity: 1.0}, 15000).fadeOut("slow")', yii\web\View::POS_READY);
                    ?>
                <?php endif; ?>

                <?php if(Yii::$app->session->hasFlash('danger')): ?>

                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <?= Yii::$app->session->getFlash('danger'); ?>
                    </div>

                    <?php
                    $this->registerJs('$(".alert").animate({opacity: 1.0}, 15000).fadeOut("slow")', yii\web\View::POS_READY);
                    ?>

                <?php endif; ?>


                <?php Pjax::end()?>



