<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_AdminStyleProperties
 */
class Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminStyleProperties extends XFCP_Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AdminStyleProperties
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_StyleProperties::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->gen_chooserAdminStyleProperties) {
            $GLOBALS['XenForo_Route_PrefixAdmin_AdminStyleProperties'] = $this;
        }

        return parent::match($routePath, $request, $router);
    }
}