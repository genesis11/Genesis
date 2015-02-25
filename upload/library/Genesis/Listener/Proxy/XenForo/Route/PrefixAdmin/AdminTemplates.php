<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_AdminTemplates
 */
class Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminTemplates extends XFCP_Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminTemplates
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_AdminTemplates::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->gen_chooserAdminTemplates) {
            $GLOBALS['XenForo_Route_PrefixAdmin_AdminTemplates'] = $this;
        }

        return parent::match($routePath, $request, $router);
    }
}