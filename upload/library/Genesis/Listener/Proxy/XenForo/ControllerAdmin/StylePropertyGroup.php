<?php

/**
 *
 * @see XenForo_ControllerAdmin_StylePropertyGroup
 */
class Genesis_Listener_Proxy_XenForo_ControllerAdmin_StylePropertyGroup extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerAdmin_StylePropertyGroup
{

    /**
     *
     * @see XenForo_ControllerAdmin_StylePropertyGroup::_getGroupAddEditResponse()
     */
    protected function _getGroupAddEditResponse(array $group)
    {
        $response = parent::_getGroupAddEditResponse($group);

        if ($response instanceof XenForo_ControllerResponse_View) {
            $xenOptions = XenForo_Application::get('options');

            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($xenOptions->gen_chooserStyleProperties) {
                if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_Templates']) && !$addOnId) {
                    $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
                }
            }

            if ($addOnId && empty($group['addon_id'])) {
                $group['addon_id'] = $addOnId;
                $response->params['addOnSelected'] = $addOnId;
            }
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_StylePropertyGroup::actionSave()
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
}