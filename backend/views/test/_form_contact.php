<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\test\Test */
/* @var $form ActiveForm */
?>

    <?php Pjax::begin()?>


    <?php  $form = ActiveForm::begin([
        'id' => 'FormOrderID',
        'enableClientValidation' => true,
        'options' => [
            'class' => 'form-horizontal',
            'data-pjax' => true,
        ],
        'fieldConfig' => [
            'template' => "{label} \n <div class='col-md-5'> {input} </div> \n <div class='col-md-5'>{hint} </div> \n <div class='col-md-5'> {error} </div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ]
    ]); ?>

    <?php
    $this->registerJs('$("#manager-type").on({
                        "change": function () {
                            var type = $(this);
                            var first = $(".form-field-first");
                            var second = $(".form-field-second");
                            var third = $(".form-field-third");

                            if ((type.val()) === "contact") {
                                console.log(type.val());
                                first.show();
                                second.show();
                                if(third.is(":visible")) {
                                    third.hide();
                                }
                            }
                            if ((type.val()) === "descriptive") {
                                console.log(type.val());
                                first.show();
                                third.show();
                                if(second.is(":visible")) {
                                    second.hide();
                                }
                            }
                        }
                    });', yii\web\View::POS_READY);
    ?>

    <?= $form->field($model, 'type')->dropDownList(['contact' => 'contact', 'descriptive' => 'descriptive'], ['prompt'=>'Выберите форму']);  ?>
    <div class="form-field-first" style="display: none;">
        <?= $form->field($model, 'company_name')->input('text', ['placeholder' => 'Название компании', 'value' => 'Название компании'])  ?>
        <?= $form->field($model, 'position')->input('text', ['placeholder' => 'Должность', 'value' => 'должность'])  ?>
    </div>
    <div class="form-field-second" style="display: none;">
        <?= $form->field($model, 'contact_name')->input('text', ['placeholder' => 'contact_name_placeholder', 'value' => 'имя'])  ?>
        <?= $form->field($model, 'contact_email')->input('email', ['placeholder' => 'contact_email_placeholder', 'value' => 'zt_052@mail.ru'])  ?>
    </div>
    <div class="form-field-third" style="display: none;">
        <?= $form->field($model, 'salary'/*, ['enableAjaxValidation' => true]*/)->input('text', ['placeholder' => 'contact_email_placeholder', 'value' => '300'])  ?>
        <?= $form->field($model, 'position_description')->input('text', ['placeholder' => 'position_description_placeholder', 'value' => 'position_descr'])  ?>

     </div>


    <div class="form-group form-field-first" style="display: none;">
        <div class="col-md-5 col-md-offset-2">
            <?= Html::submitButton('Заказать', ['class' =>'btn btn-primary btn-lg center-block']) ?>
        </div>
    </div>

    <?php  $form = ActiveForm::end(); ?>

    <?php if(Yii::$app->session->hasFlash('success')): ?>

        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
            <?= Yii::$app->session->getFlash('success'); ?>
        </div>

        <?php
        $this->registerJs('$(".alert").animate({opacity: 1.0}, 150000).fadeOut("slow")', yii\web\View::POS_READY);
        ?>


    <?php endif; ?>


    <?php Pjax::end()?>

