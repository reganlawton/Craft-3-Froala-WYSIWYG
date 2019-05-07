<?php

namespace froala\craftfroalawysiwyg\assets\field;

use craft\web\AssetBundle;
use froala\craftfroalawysiwyg\assets\froala\FroalaAsset;
use froala\craftfroalawysiwyg\FroalaEditor;

/**
 * Class FieldAsset
 */
class FieldAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->sourcePath = __DIR__ . '/dist';
        $this->depends = [
            FroalaAsset::class,
        ];

        $this->css = [
            'css/craftcms-theme.css',
        ];

        $this->js = [
            'js/plugins/craft.js',
            'js/FroalaEditorConfig.js',
            'js/FroalaEditorInput.js',
        ];

        $this->loadCustomCSS();

        parent::init();
    }

    /**
     * Adds-in custom CSS type as part of the
     * @return void
     */
    private function loadCustomCSS()
    {
        $customCssType = FroalaEditor::getInstance()->getSettings()->customCssType;
        $customCssFile = FroalaEditor::getInstance()->getSettings()->customCssFile;

        if (!empty($customCssFile)) {

            switch (true) {
                case (substr($customCssType, 0, 6) === 'volume'):
                    $volumeId = substr($customCssType, 7);
                    $volume = \Craft::$app->getVolumes()->getVolumeById($volumeId);
                    $rootUrl = $volume->getRootUrl();
                    if (false !== $rootUrl) {
                        $this->css[] = rtrim($rootUrl, '/') . '/' . ltrim($customCssFile, '/');
                    }
                    break;
                default:
                    // strip left slash, to be sure
                    $this->css[] = '/' . ltrim($customCssFile, '/');
                    break;
            }
        }
    }
}
