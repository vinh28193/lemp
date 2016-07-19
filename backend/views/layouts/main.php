<?php
/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>
    <?= Html::csrfMetaTags() ?>
    <?= Html::tag('title', Html::encode($this->title ? implode(' | ', [Yii::$app->name,$this->title]) : $this->title)) ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<!-- Aside Start-->
<aside class="left-panel">

    <!-- brand -->
    <div class="logo">
        <?=Html::a(Html::tag('span',Yii::$app->name,['class' =>'nav-label' ])
            ,['#'],['class'=>"logo-expanded"])?>
    </div>
    <!-- / brand -->

    <?=$this->render('_navigation')?>
        
</aside>
<!-- Aside Ends-->


<!--Main Content Start -->
<section class="content">
    <?=$this->render('_header')?>
    


    <!-- Page Content Start -->
    <!-- ================== -->

    <div class="wraper container-fluid">
        <?= $content ?>
    </div>
    <!-- Page Content Ends -->
    <!-- ================== -->

    <!-- Footer Start -->
    <footer class="footer">
        2015 © Velonic.
    </footer>
    <!-- Footer Ends -->



</section>
<!-- Main Content Ends -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>