<?php

/**
 *
 * @see XenForo_ControllerAdmin_Style
 */
class Genesis_Listener_Proxy_XenForo_ControllerAdmin_Style extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerAdmin_Style
{

    /**
     *
     * @see XenForo_ControllerAdmin_Style::actionTemplates()
     */
    public function actionTemplates()
    {
        $response = parent::actionTemplates();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $xenOptions = XenForo_Application::get('options');

            $style = $response->params['style'];

            $addOns = $this->_getAddOnModel()->getAllAddOns();

            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($xenOptions->gen_chooserTemplates) {
                if (!$addOnId) {
                    $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
                }
            }

            if ($addOnId && !empty($addOns[$addOnId])) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);

                $addOn = $addOns[$addOnId];

                $response->params['addOnSelected'] = $addOnId;

                if ($addOnId) {
                    foreach ($response->params['templates'] as $templateKey => $template) {
                        if ($addOnId != $template['addon_id']) {
                            unset($response->params['templates'][$templateKey]);
                        }
                    }
                }

                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/styles/templates', $addOn, $style));
            } elseif ($xenOptions->gen_chooserTemplates) {
                $this->canonicalizeRequestUrl(
                    XenForo_Link::buildAdminLink('add-ons/styles/templates',
                        array(
                            'addon_id' => ''
                        ), $style));
            }

            $response->params['addOns'] = $addOns;
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_Style::actionStyleProperties()
     */
    public function actionStyleProperties()
    {
        $response = parent::actionStyleProperties();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $xenOptions = XenForo_Application::get('options');

            $style = $response->params['style'];

            $addOns = $this->_getAddOnModel()->getAllAddOns();

            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($xenOptions->gen_chooserStyleProperties) {
                if (!$addOnId) {
                    $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
                }
            }

            if ($addOnId && !empty($addOns[$addOnId])) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);

                $addOn = $addOns[$addOnId];

                $response->params['addOnSelected'] = $addOnId;

                if ($addOnId) {
                    foreach ($response->params['groups'] as $templateKey => $template) {
                        if ($addOnId != $template['addon_id']) {
                            unset($response->params['groups'][$templateKey]);
                        }
                    }
                }

                $data = array(
                    'style_id' => $style['style_id'],
                    'title' => $style['title']
                );
                $this->canonicalizeRequestUrl(
                    XenForo_Link::buildAdminLink('add-ons/styles/style-properties', $addOn, $data));
            } else {
                $this->canonicalizeRequestUrl(
                    XenForo_Link::buildAdminLink('add-ons/styles/style-properties',
                        array(
                            'addon_id' => ''
                        ), $style));
            }

            $response->params['addOns'] = $addOns;
        }

        return $response;
    }
}