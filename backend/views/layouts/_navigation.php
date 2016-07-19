<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Nav;
use backend\widgets\AdminMenu;
 ?>
<!-- Navbar Start -->
<?=Html::beginTag('nav',['class' => 'navigation'])?>
<?php echo AdminMenu::widget([
          'options'=>['class'=>'list-unstyled'],
          'linkTemplate' => '<a href="{url}">{icon}<span class="nav-label">{label}</span>{right-icon}{badge}</a>',
          'submenuTemplate'=>"\n<ul class=\"list-unstyled\">\n{items}\n</ul>\n",
          'activateParents'=>true,
          'items'=> Yii::$app->params['navigationItems'],
]) ?>
<?=Html::endTag('nav')?>