<?php
return [
    'adminEmail' => 'admin@example.com',
    'menuItems' => [
    	[
            'label' => 'About', 
            'url' => ['/site/about']
        ],
        [
            'label' => 'Contact', 
            'url' => ['/site/contact'],
            'items' => [
              ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
              '<li class="divider"></li>',
              '<li class="dropdown-header">Dropdown Header</li>',
              ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
            ],
        ],
        [
            'label' => 'About', 
            'url' => ['/site/about']
        ],
    ],
    'navigationItems' =>[
      	[
          	'label'=> 'Dashboard',
          	'icon'=>'<i class="fa fa-dashboard"></i>',
          	'url'=>['/'],
          	'badge'=> 5,
          	'badgeOptions'=> [
            'class' => 'label pull-right label-success'
          	],
      ],
      [
          	'label'=> 'Article',
          	'icon'=>'<i class="fa fa-edit"></i>',
          	'options'=>['class'=>'has-submenu'],
          	'items'=>[
              	['label'=> 'Category', 'url'=>['/article-category/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
              	['label'=> 'Post', 'url'=>['/article/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
          	]
      ],
    ],
];
