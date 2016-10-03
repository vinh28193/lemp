<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\searchs\CategorySearch */
/* @var $form yii\widgets\ActiveForm */

    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);

    echo $form->field($model, 'title');

    echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']);
    echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']);

    ActiveForm::end(); 
?>
