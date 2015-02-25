<?php

/**
 *
 * @see XenForo_ControllerAdmin_TemplateModification
 */
class Genesis_Listener_Proxy_XenForo_ControllerAdmin_TemplateModification extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerAdmin_TemplateModification
{

    /**
     *
     * @see XenForo_ControllerAdmin_TemplateModification::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $xenOptions = XenForo_Application::get('options');

            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if ($xenOptions->gen_chooserTemplateMods) {
                if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_TemplateModifications']) && !$addOnId) {
                    $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
                }
            }

            $addOns = $response->params['addOns'];

            if ($addOnId && !empty($addOns[$addOnId])) {
                XenForo_Helper_Cookie::setCookie('edit_addon_id', $addOnId);

                $addOn = $addOns[$addOnId];

                $response->params['addOnSelected'] = $addOnId;

                if (!empty($response->params['groupedModifications'][$addOnId])) {
                    $response->params['groupedModifications'] = array(
                        $addOnId => $response->params['groupedModifications'][$addOnId]
                    );
                } else {
                    $response->params['groupedModifications'] = array();
                }

                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/template-modifications', $addOn));
            } elseif ($xenOptions->gen_chooserTemplateMods) {
                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('add-ons/template-modifications'));

                XenForo_Helper_Cookie::deleteCookie('edit_addon_id');
            }

            $response->params['addOns'] = $addOns;
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_TemplateModificationAbstract::_getModificationAddEditResponse()
     */
    protected function _getModificationAddEditResponse(array $modification)
    {
        $response = parent::_getModificationAddEditResponse($modification);

        if ($response instanceof XenForo_ControllerResponse_View) {
            $addOnId = $this->_input->filterSingle('addon_id', XenForo_Input::STRING);

            if (!empty($GLOBALS['XenForo_Route_PrefixAdmin_TemplateModifications']) && !$addOnId) {
                $addOnId = XenForo_Helper_Cookie::getCookie('edit_addon_id');
            }

            if ($addOnId && empty($modification['addon_id'])) {
                $modification['addon_id'] = $addOnId;
                $response->params['addOnSelected'] = $addOnId;
            }
        }

        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_TemplateModification::actionSave()
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