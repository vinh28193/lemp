<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\NotFoundHttpException;
use yii\i18n\MissingTranslationEvent;

class I18nComponent extends Component
{
    public static function missingTranslation(MissingTranslationEvent $event)
    {
        $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
    }
}
