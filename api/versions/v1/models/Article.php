<?php

namespace api\versions\v1\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;

/**
 * Article is the resources
 *
 */
class Article extends \common\models\Article implements Linkable
{

    /**
     * @inheritdoc
     *
     * The default implementation returns the names of the columns whose values have been populated into this record.
     */
    public function fields()
    {
        return [
            'id',
            'slug',
            'title',
            'thumbnail' => function(){
                return implode('/',[ $this->thumbnail_base_url, $this->thumbnail_path]);
            },
            'short_description' => function (){ 
                return $this->short_description;
            },
            'description'  => function (){ 
                return $this->description;
            },
            'body' =>function(){
                return HtmlPurifier::process($this->body);
            },
            'category_id' => function(){
                return $this->category->title ;
            },
            'author_id' => function(){
                return $this->updater->getPublicIdentity() ;
            },
            'updater_id' =>function(){
                return $this->author->getPublicIdentity() ;
            },
            'view' => function(){
                return 1000;
            },
            'status' => function (){ 
                return $this->status;
            },
            'published_at' => function(){
                return Yii::$app->formatter->asDatetime($this->published_at);
            },
            'updated_at' => function(){
                return Yii::$app->formatter->asDatetime($this->updated_at);
            },
        ];
    }

    /**
     * @inheritdoc
     *
     * The default implementation returns the names of the relations that have been populated into this record.
     */
    public function extraFields()
    {
        return [
            'author',
            'category',
            'updater'
        ];
    }

    /**
     * Returns a list of links.
     *
     * Each link is either a URI or a [[Link]] object. The return value of this method should
     * be an array whose keys are the relation names and values the corresponding links.
     *
     * If a relation name corresponds to multiple links, use an array to represent them.
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
            'thumbnail' => Yii::getAlias(implode('/',[ $this->thumbnail_base_url, $this->thumbnail_path])),
        ];
    }
}
