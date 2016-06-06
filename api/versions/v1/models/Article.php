<?php

namespace api\versions\v1\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

class Article extends \common\models\Article implements Linkable
{
    public function fields()
    {
		return ['id','slug','title','short_description','description','body','view','status','published_at','updated_at'];
    }

    public function extraFields()
    {
        return ['author','category','updater','articleAttachments'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['article/view', 'id' => $this->id], true)
        ];
    }
}
