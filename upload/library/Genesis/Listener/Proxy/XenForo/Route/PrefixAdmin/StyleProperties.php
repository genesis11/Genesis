<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_StyleProperties
 */
class Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_StyleProperties extends XFCP_Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_StyleProperties
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_StyleProperties::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->gen_chooserStyleProperties) {
            $GLOBALS['XenForo_Route_PrefixAdmin_StyleProperties'] = $this;
        }

        return parent::match($routePath, $request, $router);
    }
}