<?php
/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Страница с формой';
?>
<div class="site-index container">

    <div class="body-content row">

        <div class="col-md-12">



            <?php Pjax::begin()?>


            <?php  $form = ActiveForm::begin([
                'id' => 'TestOrderID',
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


                <?= $form->field($tested, 'type')->dropDownList(['contact' => 'c1', 'descriptive' => 'd2'], ['prompt'=>'Выберите форму']);  ?>
                <?= $form->field($tested, 'name_company')->input('text', ['placeholder' => 'Название компании'])  ?>
                <?= $form->field($contacted, 'contact_name')->input('text', ['placeholder' => 'contact_name_placeholder'])  ?>
                <?= $form->field($contacted, 'contact_email')->input('email', ['placeholder' => 'contact_email_placeholder', 'value' => 'zt_052@mail.ru'])  ?>
                <?= $form->field($described, 'position_descriptive')->input('text', ['placeholder' => 'position_descriptive'])  ?>
                <?= $form->field($described, 'salary_test')->input('text', ['placeholder' => 'salary_test_placeholder'])  ?>



            <div class="form-group form-field-first">
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




        </div>

    </div>
</div>
