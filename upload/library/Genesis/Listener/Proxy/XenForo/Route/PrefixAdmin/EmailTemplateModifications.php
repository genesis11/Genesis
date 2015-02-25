<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_EmailTemplateModifications
 */
class Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_EmailTemplateModifications extends XFCP_Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_EmailTemplateModifications
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_AdminTemplates::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->gen_chooserEmailTemplateMods) {
            $GLOBALS['XenForo_Route_PrefixAdmin_EmailTemplateModifications'] = $this;
        }

        return parent::match($routePath, $request, $router);
    }
}