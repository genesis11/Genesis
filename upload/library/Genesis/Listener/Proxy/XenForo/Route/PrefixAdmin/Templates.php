<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_Templates
 */
class Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_Templates extends XFCP_Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_Templates
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_Templates::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->gen_chooserTemplates) {
            $GLOBALS['XenForo_Route_PrefixAdmin_Templates'] = $this;
        }

        return parent::match($routePath, $request, $router);
    }
}