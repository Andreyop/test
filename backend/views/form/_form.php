<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<?php  $form = ActiveForm::begin([
    'id' => 'FormOrderID',
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute('form/validate'),
    'options' => [
        'data-pjax' => true,
    ],
]); ?>

<?= $form->field($model, 'type')->dropDownList(['descriptive' => 'Форма 1', 'contact' => 'Форма 2'], ['prompt'=>'Выберите форму']);  ?>
<div class="form-field-first" style="display: none;">
    <?= $form->field($model, 'company_name')->input('text')  ?>
    <?= $form->field($model, 'position')->input('text')  ?>
</div>
<div class="form-field-second" style="display: none;">
    <?= $form->field($model, 'contact_name')->input('text')  ?>
    <?= $form->field($model, 'contact_email')->input('text')  ?>
</div>
<div class="form-field-third" style="display: none;">
    <?= $form->field($model, 'salary')->input('text')  ?>
    <?= $form->field($model, 'position_description')->input('text')  ?>

    <?= $form->field($model, 'dateStart')->widget(DatePicker::class, [
        'language' => 'ru',
//        'dateFormat' => 'dd.mm.yyyy',
        'options' => [
//                            'placeholder' => date("d.m.Y"),
            'class'=> 'form-control',
            'autocomplete'=>'off',
            'format' => 'dd.mm.yyyy'
        ],
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
            'yearRange' => '1950:2050',
        ]])->label('Дата начала') ?>

    <?= $form->field($model, 'dateEnd')->widget(DatePicker::class, [
        'language' => 'ru',
//        'dateFormat' => 'dd.mm.yyyy',
        'options' => [
//                            'placeholder' => date("d.m.Y", strtotime(date("d.m.Y") ."+3 Month")),
            'class'=> 'form-control',
            'autocomplete'=>'off',
            'format' => 'dd.mm.yyyy',
            'readonly' => 'readonly'
        ],
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
            'yearRange' => '1950:2050',
            'todayHighlight' => true,
            'clientEvents' => [
                'changeDate' => false
            ],

        ]])->label('Дата окончания') ?>

</div>


<div class="form-group form-field-first" style="display: none;">
    <?= $form->field($model, 'datePostAt')->widget(
        buibr\datepicker\DatePicker::class, [
        'language' => 'ru',
        'addon' => false,
        'size' => 'sm',
        'clientOptions' => [
            'format' => 'L LT',
            'stepping' => 5,
        ],
    ]);?>
<!--    --><?//= $form->field($model, 'datePostAt')->widget(DatePicker::class, [
//        'language' => 'ru',
//        'options' => [
//            'class'=> 'form-control',
//            'autocomplete'=>'off',
//            'format' => 'dd.mm.yyyy'
//        ],
//        'clientOptions' => [
//            'changeMonth' => true,
//            'changeYear' => true,
//            'yearRange' => '2021:2050',
//        ]])->label('Дата размещения') ?>

    <div class="col-md-5 col-md-offset-2">
        <?= Html::submitButton('Разместить', ['class' =>'btn btn-dark']) ?>
    </div>
</div>
<?php  $form = ActiveForm::end(); ?>
