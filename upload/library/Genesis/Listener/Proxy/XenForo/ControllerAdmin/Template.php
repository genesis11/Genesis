<?php

/**
 *
 * @see XenForo_ControllerAdmin_Template
 */
class Genesis_Listener_Proxy_XenForo_ControllerAdmin_Template extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerAdmin_Template
{

    /**
     *
     * @see XenForo_ControllerAdmin_Template::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $xenOptions = XenForo_Application::get('options');

            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($xenOptions->gen_chooserTemplates) {
                if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_Templates']) && !$addOnId) {
                    $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
                }
            }

            if ($addOnId) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);

                $styleModel = $this->_getStyleModel();

                $styleId = $styleModel->getStyleIdFromCookie();

                $style = $this->_getStyleModel()->getStyleById($styleId, true);
                if (!$style || !$this->_getTemplateModel()->canModifyTemplateInStyle($styleId)) {
                    $style = $this->_getStyleModel()->getStyleById(XenForo_Application::get('options')->defaultStyleId);
                }

                return $this->responseRedirect(XenForo_ControllerResponse_Redirect::RESOURCE_CANONICAL,
                    XenForo_Link::buildAdminLink('add-ons/styles/templates',
                        array(
                            'addon_id' => $addOnId
                        ),
                        array(
                            'style_id' => $styleId,
                            'title' => $style['title']
                        )));
            } elseif ($xenOptions->gen_chooserTemplates) {
                XenForo_Helper_Cookie::deleteCookie('edit_addon_id');
            }
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_Template::_getTemplateAddEditResponse()
     */
    protected function _getTemplateAddEditResponse(array $template, $inputStyleId)
    {
        $response = parent::_getTemplateAddEditResponse($template, $inputStyleId);

        if ($response instanceof XenForo_ControllerResponse_View) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_Templates']) && !$addOnId) {
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
     * @see XenForo_ControllerAdmin_Template::actionSave()
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
     * @see XenForo_ControllerAdmin_Template::actionSaveMultiple()
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