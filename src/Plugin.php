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

        $settings = $this->getSettings();
        $request = Craft::$app->getRequest();
        $view = Craft::$app->getView();

        // Load JS, if admin request
        if ($request->isCpRequest && $this->assetsShouldLoad()) {
            $view->registerJs('window.slugAlertMessage = "' . $settings->alertMessage . '";');
            $view->registerAssetBundle(SlugAlertJsAsset::class);
        }
    }

    protected function assetsShouldLoad()
    {
        $settings = $this->getSettings();

        // Is the plugin active?
        if (!$settings->pluginIsActive) {
            return false;
        }

        // Use URL segments to determine what type of page we're on
        $request = Craft::$app->getRequest();
        $segments = $request->getSegments();
        
        $firstSegment = $segments[0] ?? null;
        $thirdSegment = $segments[2] ?? null;

        $isEntryEditPage = $firstSegment === 'entries' && !empty($thirdSegment);
        $isCategoryEditPage = $firstSegment === 'categories' && !empty($thirdSegment);
        $isNewEntryPage = $firstSegment === 'entries' && $thirdSegment === 'new';
        $isNewCategoryPage = $firstSegment === 'categories' && $thirdSegment === 'new';

        if (
            ($isEntryEditPage && !$isNewEntryPage)
            || ($isCategoryEditPage && $isNewCategoryPage)
        ) {
            return true;
        }

        return false;
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
