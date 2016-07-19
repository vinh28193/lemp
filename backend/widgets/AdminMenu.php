<?php
namespace backend\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
/**
 * Class Menu
 * @package backend\widget\AdminMenu
 */
class AdminMenu extends Menu
{
    /**
     * @var string
     */
    public $linkTemplate = "<a href=\"{url}\">\n{icon}\n{label}{badge}</a>";
    /**
     * @var string
     */
    public $labelTemplate = "{icon}\n{label}\n{badge}";

    /**
     * @var string
     */
    public $badgeTag = 'span';

    /**
     * @var string
     */
    public $badgeOptions = '';

    /**
     * @var string
     */
    public $parentRightIcon = '';

    /**
     * @inheritdoc
     */
    protected function renderItem($item)
    {


        $badgeOption = ArrayHelper::keyExists('badgeOptions',$item) ? ArrayHelper::getValue($item,'badgeOptions') : $this->badgeOptions;

        Html::addCssClass($this->badgeOptions,'label pull-right');
        
        $this->badgeOptions = ArrayHelper::merge($this->badgeOptions,$badgeOption);
        

        if (isset($item['items']) && !isset($item['right-icon'])) {
            $item['right-icon'] = $this->parentRightIcon;
        }

        $label = $this->_has('label',$item);
        $badge = $this->renderBadge($this->_has('badge',$item));
        $icon = $this->_has('icon',$item);
        $rightIcon = $this->_has('right-icon',$item);
        $url = Url::to($this->_has('url',$item,['#']));

        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

        return strtr($template, [
            '{badge}'=> $badge,
            '{icon}'=> $icon,
            '{right-icon}'=>$rightIcon,
            '{url}' => $url,
            '{label}' => $label,
        ]);

    }

    private function _has($key,$array,$default = null){
        return ArrayHelper::keyExists($key, $array) ? ArrayHelper::getValue($array, $key) : $default;
    }

    public function renderBadge($badge,$default = ''){
        return $badge ? Html::tag($this->badgeTag, $badge, $this->badgeOptions): $default ;
    }
}
