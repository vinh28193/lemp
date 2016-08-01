<?php
/**
 * @package   yii2-detail-view
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   1.7.5
 */

namespace backend\widgets;

use Yii;
use kartik\detail\DetailView;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

use yii\web\View;

/**
 * Enhances the Yii Detail widget with various options to include Bootstrap specific styling enhancements. Also
 * allows to simply disable Bootstrap styling by setting `bootstrap` to false. In addition, it allows you to directly
 * edit the detail grid data using a form.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class Detail extends DetailView
{

    
    protected function initWidget()
    {
        parent::initWidget();
        $this->panel = [
            'heading'=> 'dfdsf',
            'type'=> self::TYPE_DEFAULT,
            'footer'=>false
        ];
    }

    protected function runWidget()
    {
        if (empty($this->container['id'])) {
            $this->container['id'] = $this->getId();
        }
        $this->initI18N(__DIR__);
        Html::addCssClass($this->alertContainerOptions, 'panel-body kv-alert-container');
        $this->alertMessageSettings += [
            'kv-detail-error' => 'alert alert-danger',
            'kv-detail-success' => 'alert alert-success',
            'kv-detail-info' => 'alert alert-info',
            'kv-detail-warning' => 'alert alert-warning'
        ];
        $this->registerAssets();
        $output = $this->renderDetailView();
        if (is_array($this->panel) && !empty($this->panel) && $this->panel !== false) {
            $output = $this->renderPanel($output);
        }
        $output = strtr(
            $this->mainTemplate,
            ['{detail}' => Html::tag('div', $output, $this->container)]
        );
        Html::addCssClass($this->viewButtonsContainer, 'kv-buttons-1');
        $buttons = Html::tag('span', $this->renderButtons(1), $this->viewButtonsContainer);
        if ($this->enableEditMode) {
            Html::addCssClass($this->editButtonsContainer, 'kv-buttons-2');
            $buttons .= Html::tag('span', $this->renderButtons(2), $this->editButtonsContainer);
        }
        echo str_replace('{buttons}', Html::tag('div', $buttons, $this->buttonContainer), $output);
        if ($this->enableEditMode) {
            /**
             * @var ActiveForm $formClass
             */
            $formClass = $this->formClass;
            $formClass::end();
        }
        
    }
    protected function renderPanel($content)
    {
        $panel = $this->panel;
        $type = ArrayHelper::remove($panel, 'type', self::TYPE_DEFAULT);
        if (($heading = $this->renderPanelTitleBar('heading')) !== false) {
            $panel['heading'] = $heading;
        }
        if (($footer = $this->renderPanelTitleBar('footer')) !== false) {
            $panel['footer'] = $footer;
        }
        $panel['preBody'] = $content;
        return Html::panel($panel, $type);
    }
    protected function renderPanelTitleBar($type)
    {
        $title = ArrayHelper::getValue($this->panel, $type, ($type === 'heading' ? '' : false));
        if ($title === false) {
            return false;
        }
        $options = ArrayHelper::getValue($this->panel, $type . 'Options', []);
        $tag = ArrayHelper::remove($options, 'tag', ($type === 'heading' ? 'h3' : 'h4'));
        $template = ArrayHelper::remove($options, 'template', ($type === 'heading' ? '{buttons}{title}' : '{title}'));
        Html::addCssClass($options, 'panel-title');
        $title = Html::tag($tag, $title, $options);
        return str_replace('{title}', $title, $template);
    }
    /**
     * Renders the buttons for a specific mode
     *
     * @param integer $mode
     *
     * @return string the buttons content
     */
    protected function renderButtons($mode = 1)
    {
        $buttons = "buttons{$mode}";
        return strtr(
            $this->$buttons,
            [
                '{view}' => $this->renderButton('view'),
                '{update}' => $this->renderButton('update'),
                '{delete}' => $this->renderButton('delete'),
                '{save}' => $this->renderButton('save'),
                '{reset}' => $this->renderButton('reset'),
            ]
        );
    }

    /**
     * Renders a button
     *
     * @param string $type the button type
     *
     * @return string
     */
    protected function renderButton($type)
    {
        if (!$this->enableEditMode) {
            return '';
        }
        switch ($type) {
            case 'view':
                return $this->getDefaultButton('view', 'eye-open', Yii::t('kvdetail', 'View'));
            case 'update':
                return $this->getDefaultButton('update', 'pencil', Yii::t('kvdetail', 'Update'));
            case 'delete':
                return $this->getDefaultButton('delete', 'trash', Yii::t('kvdetail', 'Delete'));
            case 'save':
                return $this->getDefaultButton('save', 'floppy-disk', Yii::t('kvdetail', 'Save'));
            case 'reset':
                return $this->getDefaultButton('reset', 'ban-circle', Yii::t('kvdetail', 'Cancel Changes'));
            default:
                return '';
        }
    }
    protected function getDefaultButton($type, $icon, $title)
    {
        $buttonOptions = $type . 'Options';
        $options = $this->$buttonOptions;
        $label = ArrayHelper::remove($options, 'label', "<i class='glyphicon glyphicon-{$icon}'></i>");
        if (empty($options['class'])) {
            $options['class'] = 'kv-action-btn';
        }
        Html::addCssClass($options, 'kv-btn-' . $type);
        $options = ArrayHelper::merge(['title' => $title], $options);
        if ($this->tooltips) {
            $options['data-toggle'] = 'tooltip';
            $options['data-container'] = 'body';
        }
        switch ($type) {
            case 'reset':
                return Html::resetButton($label, $options);
            case 'save':
                return Html::submitButton($label, $options);
            case 'delete':
                $url = ArrayHelper::remove($options, 'url', '#');
                return Html::a($label, $url, $options);
        }
        $options['type'] = 'button';
        return Html::button($label, $options);
    }

}
