<?php

namespace nilsenpaul\slugalert;

use nilsenpaul\slugalert\models\Settings;
use nilsenpaul\slugalert\assetbundles\SlugAlertJsAsset;

use Craft;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\web\UrlManager;
use craft\web\View;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;
use yii\helpers\Html;
use yii\helpers\Markdown;

class Plugin extends \craft\base\Plugin
{
    public static $instance;

    public $hasCpSettings = true;

    public function init()
    {
        parent::init();

        // Set instance
        self::$instance = $this;

        // Load settings
        $settings = $this->getSettings();

        $request = Craft::$app->getRequest();
        $view = Craft::$app->getView();

        // Load JS, if admin request
        if ($settings->pluginIsActive && $request->isCpRequest) {
            $view->registerJs('window.slugAlertMessage = "' . $settings->alertMessage . '";');
            $view->registerAssetBundle(SlugAlertJsAsset::class);
        }
    }

    protected function settingsHtml()
    {
        return \Craft::$app->getView()->renderTemplate('slug-alert/settings', [
            'settings' => $this->getSettings()
        ]);
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }
}
