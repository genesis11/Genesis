<?php

/**
 *
 * @see XenForo_ControllerPublic_Misc
 */
class Genesis_Listener_Proxy_XenForo_ControllerPublic_Misc extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerPublic_Misc
{
    
    public function actionContact()
    {
        $this->_routeMatch->setSections('contact');
        
        return parent::actionContact();
    }
}