<?php

/**
 *
 * @see XenForo_ControllerAdmin_AdminTemplate
 */
class Genesis_Listener_Proxy_XenForo_ControllerAdmin_AdminTemplate extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerAdmin_AdminTemplate
{

    /**
     *
     * @see XenForo_ControllerAdmin_AdminTemplate::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $xenOptions = XenForo_Application::get('options');

            if ($xenOptions->gen_chooserAdminTemplates) {
                $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

                if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_AdminTemplates']) && !$addOnId) {
                    $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
                }

                $addOns = $this->_getAddOnModel()->getAllAddOns();

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

                    $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/admin-templates', $addOn));
                } else {
                    $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/admin-templates'));

                    XenForo_Helper_Cookie::deleteCookie('edit_addon_id');
                }

                $response->params['addOns'] = $addOns;
            }
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_AdminTemplate::_templateEditResponse()
     */
    protected function _templateEditResponse(array $template)
    {
        $response = parent::_templateEditResponse($template);

        if ($response instanceof XenForo_ControllerResponse_View) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_AdminTemplates']) && !$addOnId) {
                $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
            }

            if ($addOnId && empty($template['addon_id'])) {
                $template['addon_id'] = $addOnId;
                $response->params['addOnSelected'] = $addOnId;
            }
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_AdminTemplate::actionSave()
     */
    public function actionSave()
    {
        $response = parent::actionSave();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($addOnId) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);
            }
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_AdminTemplate::actionSaveMultiple()
     */
    public function actionSaveMultiple()
    {
        $response = parent::actionSaveMultiple();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($addOnId) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);
            }
        }

        return $response;
    }
}