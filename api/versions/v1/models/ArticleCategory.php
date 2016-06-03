<?php

namespace api\versions\v1\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

class ArticleCategory extends \common\models\ArticleCategory implements Linkable
{
    public function fields()
    {
		return ['id','slug','title','parent_id','status','created_at','updated_at'];
    }

    public function extraFields()
    {
        return ['articles','parent','articleCategories'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['article-category/view', 'id' => $this->id], true)
        ];
    }
}
