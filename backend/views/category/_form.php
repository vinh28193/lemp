<?php

use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */

    $form = ActiveForm::begin([
        'id' => 'category-form',
        'type' => ActiveForm::TYPE_HORIZONTAL
    ]); 


    echo $form->field($model, 'title')->textInput(['maxlength' => true]);

    echo $form->field($model, 'parent_id')->widget(Select2::className(),[
        'data' => $model->getSelect2Data(),
        'pluginOptions' => []
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

    ActiveForm::end(); ?>
