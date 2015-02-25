<?php

class Genesis_Listener_Proxy
{

    public static function loadAddOnsRoutePrefixAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AddOns';
    }

    public static function loadAdminStylePropertiesRoutePrefixAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminStyleProperties';
    }

    public static function loadAdminTemplateModificationsRoutePrefixAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminTemplateModifications';
    }

    public static function loadAdminTemplatesRoutePrefixAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminTemplates';
    }

    public static function loadStylePropertiesRoutePrefixAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_StyleProperties';
    }

    public static function loadTemplateModificationsRoutePrefixAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_TemplateModifications';
    }

    public static function loadTemplatesRoutePrefixAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_Templates';
    }

    public static function loadEmailTemplateModificationsRoutePrefixAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_EmailTemplateModifications';
    }

    public static function loadAdminStylePropertyControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_AdminStyleProperty';
    }

    public static function loadAdminTemplateControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_AdminTemplate';
    }

    public static function loadAdminTemplateModificationControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_AdminTemplateModification';
    }

    public static function loadStylePropertyControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_StyleProperty';
    }

    public static function loadTemplateControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_Template';
    }

    public static function loadTemplateModificationControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_TemplateModification';
    }

    public static function loadStyleControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_Style';
    }

    public static function loadStylePropertyGroupControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_StylePropertyGroup';
    }

    public static function loadEmailTemplateModificationControllerAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerAdmin_EmailTemplateModification';
    }

    public static function loadSocialCategoryController($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_Waindigo_SocialGroups_ControllerPublic_SocialCategory';
    }

    public static function loadSocialForumController($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_Waindigo_SocialGroups_ControllerPublic_SocialForum';
    }

    public static function loadForumController($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerPublic_Forum';
    }

    public static function loadMiscController($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ControllerPublic_Misc';
    }

    public static function loadSocialForumModel($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_Waindigo_SocialGroups_Model_SocialForum';
    }

    public static function loadNodeModel($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Model_Node';
    }

    public static function loadThreadModel($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Model_Thread';
    }

    public static function loadThreadWatchModel($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_Model_ThreadWatch';
    }

    public static function loadCssOutput($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_CssOutput';
    }

    public static function loadStylePropertyListViewAdmin($class, array &$extend)
    {
        $extend[] = 'Genesis_Listener_Proxy_XenForo_ViewAdmin_StyleProperty_List';
    }

    public static function navigationTabs(array &$extraTabs, $selectedTabId)
    {
        $contactUsPosition = self::_getStylePropertyValueFromCache('gen_contactUsPosition');

        if ($contactUsPosition == 'navigation') {
            $xenOptions = XenForo_Application::get('options');

            $href = '';
            if ($xenOptions->contactUrl['type'] == 'default') {
                $href = XenForo_Link::buildPublicLink('misc/contact');
            } elseif ($xenOptions->contactUrl['type'] == 'custom') {
                $href = $xenOptions['contactUrl']['custom'];
            }

            if ($href) {
                $extraTabs['contact'] = array(
                    'title' => new XenForo_Phrase('contact_us'),
                    'href' => $href,
                    'position' => 'end'
                );
            }
        }
    }

    protected static function _getStylePropertyValueFromCache($styleProperty)
    {
        $user = XenForo_Visitor::getInstance();
        $styleId = (!empty($user['style_id']) ? $user['style_id'] : 0);
        $forceStyleId = ($user['is_admin'] ? true : false);

        $styles = (XenForo_Application::isRegistered('styles') ? XenForo_Application::get('styles') : XenForo_Model::create(
            'XenForo_Model_Style')->getAllStyles());

        if ($styleId && isset($styles[$styleId]) && ($styles[$styleId]['user_selectable'] || $forceStyleId)) {
            $style = $styles[$styleId];
        } else {
            $defaultStyleId = XenForo_Application::get('options')->defaultStyleId;
            $style = (isset($styles[$defaultStyleId]) ? $styles[$defaultStyleId] : reset($styles));
        }

        $defaultProperties = XenForo_Application::get('defaultStyleProperties');

        if ($style) {
            $properties = unserialize($style['properties']);

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