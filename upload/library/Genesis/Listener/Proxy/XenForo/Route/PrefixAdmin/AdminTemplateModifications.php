<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_AdminTemplateModifications
 */
class Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminTemplateModifications extends XFCP_Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminTemplateModifications
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_AdminTemplateModifications::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->gen_chooserAdminTemplateMods) {
            $GLOBALS['XenForo_Route_PrefixAdmin_AdminTemplateModifications'] = $this;
        }

        return parent::match($routePath, $request, $router);
    }
}