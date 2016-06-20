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
          'items'=>[
              [
                  'label'=> 'Dashboard',
                  'icon'=>'<i class="fa fa-dashboard"></i>',
                  'url'=>['/admin/'],
                  'badge'=> 5,
                  'badgeBgClass'=>'label-success',
              ],
              [
                  'label'=> 'layout','Database',
                  'url' => '#',
                  'icon'=>'<i class="fa fa-edit"></i>',
                  'options'=>['class'=>'has-submenu'],
                  'items'=>[
                      ['label'=> 'Category', 'url'=>['/admin/category/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                      ['label'=> 'Product', 'url'=>['/admin/product/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                  ]
              ],
          ]
]) ?>
<?=Html::endTag('nav')?>