<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_TemplateModifications
 */
class Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_TemplateModifications extends XFCP_Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_TemplateModifications
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_TemplateModifications::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $xenOptions = XenForo_Application::get('options');

        if ($xenOptions->gen_chooserTemplateMods) {
            $GLOBALS['XenForo_Route_PrefixAdmin_TemplateModifications'] = $this;
        }

        return parent::match($routePath, $request, $router);
    }
}