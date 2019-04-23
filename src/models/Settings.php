<?php

namespace nilsenpaul\slugalert\models;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    public $pluginIsActive = true;
    public $alertMessage = null;

    public function init()
    {
        $this->alertMessage = Craft::t('slug-alert', 'Changing a slug can have a potentially negative effect on your site\'s SEO. Create a redirect after changing a slug, or don\'t change the slug at all');
    }

    public function rules()
    {
        return [
            [['pluginIsActive'], 'boolean'],
            [['alertMessage'], 'required'],
        ];
    }
}
