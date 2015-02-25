<?php

/**
 *
 * @see XenForo_ControllerAdmin_AdminStyleProperty
 */
class Genesis_Listener_Proxy_XenForo_ControllerAdmin_AdminStyleProperty extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerAdmin_AdminStyleProperty
{

    /**
     *
     * @see XenForo_ControllerAdmin_AdminStyleProperty::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $xenOptions = XenForo_Application::get('options');

            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($xenOptions->gen_chooserAdminStyleProperties) {
                if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_AdminStyleProperties']) && !$addOnId) {
                    $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
                }
            }

            $addOns = $this->_getAddOnModel()->getAllAddOns();

            if ($addOnId && !empty($addOns[$addOnId])) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);

                $addOn = $addOns[$addOnId];

                $response->params['addOnSelected'] = $addOnId;

                $groupId = $this->_input->filterSingle('group', XenForo_Input::STRING);
                if ($addOnId && !$groupId) {
                    foreach ($response->params['groups'] as $groupKey => $group) {
                        if ($addOnId != $group['addon_id']) {
                            unset($response->params['groups'][$groupKey]);
                        }
                    }
                }

                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/admin-style-properties', $addOn));
            } elseif ($xenOptions->gen_chooserAdminStyleProperties) {
                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/admin-style-properties'));

                XenForo_Helper_Cookie::deleteCookie('edit_addon_id');
            }

            $response->params['addOns'] = $addOns;
        }

        return $response;
    }

    /**
     * Get the add-on model.
     *
     * @return XenForo_Model_AddOn
     */
    protected function _getAddOnModel()
    {
        return $this->getModelFromCache('XenForo_Model_AddOn');
    }
}