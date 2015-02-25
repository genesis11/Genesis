<?php

class Genesis_Listener_Template
{

    public static function templateCreate(&$templateName, array &$params, XenForo_Template_Abstract $template)
    {
        $extraCss = self::_getStylePropertyValueFromCache('gen_extraCss', $params);
        $templateNames = preg_split("/\\r\\n|\\r|\\n/", $extraCss);
        foreach ($templateNames as $_templateName) {
            $_templateName = trim($_templateName);
            if ($_templateName) {
                $template->addRequiredExternal('css', $_templateName);
            }
        }

        $extraJs = self::_getStylePropertyValueFromCache('gen_extraJs', $params);
        $fileNames = preg_split("/\\r\\n|\\r|\\n/", $extraJs);
        foreach ($fileNames as $fileName) {
            $fileName = trim($fileName);
            if ($fileName) {
                $template->addRequiredExternal('js', $fileName);
            }
        }

        $googleFonts = self::_getStylePropertyValueFromCache('gen_googleFonts', $params);

        $googleFonts = preg_split("/\\r\\n|\\r|\\n|\|/", $googleFonts);
        $googleFonts = str_replace(' ', '+', implode('|', $googleFonts));

        $params['googleFonts'] = $googleFonts;

        if (!self::_getStylePropertyValueFromCache('gen_touchBrowser', $params)) {
            $template->addRequiredExternal('js', 'js/genesis/touch.js');
        }

        if (self::_getStylePropertyValueFromCache('gen_contactUsPosition', $params) != 'footer') {
            $params['xenOptions']['contactUrl']['type'] = 'none';
        }

        if (!self::_getStylePropertyValueFromCache('gen_enableTabSelection', $params)) {
            if (!empty($params['tabs'])) {
                foreach ($params['tabs'] as $tabName => $tab) {
                    unset($params['tabs'][$tabName]['selected']);
                }
            }
        }
    }


    protected static function _getStylePropertyValueFromCache($styleProperty, array $params = array())
    {
        $defaultProperties = XenForo_Application::get('defaultStyleProperties');

        if (!empty($params['visitorStyle'])) {
            $style = $params['visitorStyle'];
            $properties = unserialize($style['properties']);

            $properties = XenForo_Application::mapMerge($defaultProperties, $properties);
        } elseif (XenForo_Application::isRegistered('adminStyleProperties')) {
            $properties = XenForo_Application::get('adminStyleProperties');

            $properties = XenForo_Application::mapMerge($defaultProperties, $properties);
        } else {
            $properties = $defaultProperties;
        }

        if (empty($properties[$styleProperty])) {
            return null;
        }

        return $properties[$styleProperty];
    }
}