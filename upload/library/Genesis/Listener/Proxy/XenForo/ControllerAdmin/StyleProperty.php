<?php

/**
 *
 * @see XenForo_ControllerAdmin_StyleProperty
 */
class Genesis_Listener_Proxy_XenForo_ControllerAdmin_StyleProperty extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerAdmin_StyleProperty
{

    /**
     *
     * @see XenForo_ControllerAdmin_StyleProperty::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $xenOptions = XenForo_Application::get('options');

            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($xenOptions->gen_chooserStyleProperties) {
                if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_StyleProperties']) && !$addOnId) {
                    $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
                }
            }

            if ($addOnId) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);
            } elseif ($xenOptions->gen_chooserStyleProperties) {
                XenForo_Helper_Cookie::deleteCookie('edit_addon_id');
            }

            $style = $this->_getStyleFromCookie();

            if ($addOnId) {
                $addOn = array(
                	'addon_id' => $addOnId
                );
                $data = array(
                	'style_id' => $style['style_id'],
                    'title' => $style['title']
                );
                return $this->responseRedirect(
                    XenForo_ControllerResponse_Redirect::RESOURCE_CANONICAL,
                    XenForo_Link::buildAdminLink('add-ons/styles/style-properties', $addOn, $data)
                );
            }
        }

        return $response;
    }
}