<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_AddOns
 */
class Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AddOns extends XFCP_Genesis_Listener_Proxy_XenForo_Route_PrefixAdmin_AddOns
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_AddOns::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        $parts = explode('/', $routePath, 3);

        switch ($parts[0]) {
            case 'admin-style-properties':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_AdminStyleProperty', $routePath,
                    'adminStyleProperties');
            case 'admin-template-mods':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_AdminTemplateModification', $routePath, 'adminTemplateMods');
            case 'admin-templates':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_AdminTemplate', $routePath, 'adminTemplates');
            case 'email-template-mods':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_EmailTemplateModification', $routePath, 'emailTemplateMods');
            case 'styles':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                $action = $router->resolveActionWithIntegerParam($routePath, $request, 'style_id');
                return $router->getRouteMatch('XenForo_ControllerAdmin_Style', $action, 'styles');
            case 'style-properties':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_StyleProperty', $routePath, 'styleProperties');
            case 'style-property-groups':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_StylePropertyGroup', $routePath,
                    'styleProperties');
            case 'template-modifications':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_TemplateModification', $routePath, 'templateModifications');
            case 'templates':
                $parts = array_slice($parts, 1);
                $routePath = implode('/', $parts);
                return $router->getRouteMatch('XenForo_ControllerAdmin_Template', $routePath, 'templates');
        }

        if (count($parts) > 1) {
            switch ($parts[1]) {
                case 'admin-style-properties':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_AdminStyleProperty', $routePath,
                        'adminStyleProperties');
                case 'admin-template-mods':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_AdminTemplateModification', $routePath, 'adminTemplateMods');
                case 'admin-templates':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_AdminTemplate', $routePath, 'adminTemplates');
                case 'email-template-mods':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_EmailTemplateModification', $routePath, 'emailTemplateMods');
                case 'styles':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    $action = $router->resolveActionWithIntegerParam($routePath, $request, 'style_id');
                    return $router->getRouteMatch('XenForo_ControllerAdmin_Style', $action, 'styles');
                case 'style-properties':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_StyleProperty', $routePath,
                        'styleProperties');
                case 'style-property-groups':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_StylePropertyGroup', $routePath,
                        'styleProperties');
                case 'template-modifications':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_TemplateModification', $routePath, 'templateModifications');
                case 'templates':
                    $action = $router->resolveActionWithStringParam($routePath, $request, 'addon_id');
                    $parts = array_slice($parts, 2);
                    $routePath = implode('/', $parts);
                    return $router->getRouteMatch('XenForo_ControllerAdmin_Template', $routePath, 'templates');
            }
        }

        return parent::match($routePath, $request, $router);
    }

    /**
     *
     * @see XenForo_Route_PrefixAdmin_AddOns::buildLink()
     */
    public function buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams)
    {
        $parts = explode('/', $action, 2);

        if (count($parts) > 1) {
            if ($parts[0] == 'styles') {
                if (empty($data['addon_id'])) {
                    $link = $outputPrefix . '/';
                } else {
                    $link = XenForo_Link::buildBasicLinkWithStringParam($outputPrefix, '', $extension, $data,
                        'addon_id');
                }
                $link = $link . XenForo_Link::buildBasicLinkWithIntegerParam('styles', $parts[1], $extension,
                    $extraParams, 'style_id', 'title');
                unset($extraParams['style_id'], $extraParams['title']);
                return $link;
            }
        }

        return parent::buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, $extraParams);
    }
}