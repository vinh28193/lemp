<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-color panel-primary">
    <div class="panel-heading"> 
       <h3 class="text-center m-t-10"><?= Html::encode($this->title) ?></h3>
    </div> 

    <?php $form = ActiveForm::begin(['id' => 'login-form','class' => 'form-horizontal m-t-40']); ?>
                                
        <div class="form-group ">
            <div class="col-xs-12">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(false) ?>
            </div>
        </div>
        <div class="form-group ">
            
            <div class="col-xs-12">
                <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
            </div>
        </div>

        <div class="form-group ">
            <div class="col-xs-12">
                 <?= $form->field($model, 'rememberMe')->checkbox()->label(false) ?>
            </div>
        </div>
        
        <div class="form-group text-right">
            <div class="col-xs-12">
                <?= Html::submitButton('Login', ['class' => 'btn btn-purple w-md', 'name' => 'login-button']) ?>
            </div>
        </div>
        <div class="form-group m-t-30">
            <div class="col-sm-7">
                <a href="recoverpw.html"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
            </div>
            <div class="col-sm-5 text-right">
                <a href="register.html">Create an account</a>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>