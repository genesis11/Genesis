<?php

/**
 *
 * @see Waindigo_SocialGroups_ControllerPublic_SocialForum
 */
class Genesis_Listener_Proxy_Waindigo_SocialGroups_ControllerPublic_SocialForum extends XFCP_Genesis_Listener_Proxy_Waindigo_SocialGroups_ControllerPublic_SocialForum
{

    /**
     *
     * @see Waindigo_SocialGroups_ControllerPublic_SocialForum::_getThreadFetchElements()
     */
    protected function _getThreadFetchElements(array $forum, array $displayConditions)
    {
        /* @var $threadModel XenForo_Model_Thread */
        $threadModel = $this->_getThreadModel();

        $threadFetchElements = parent::_getThreadFetchElements($forum, $displayConditions);

        $threadFetchConditions = $threadFetchElements['conditions'];
        $threadFetchOptions = $threadFetchElements['options'];

        $threadFetchOptions['join_genesis'] = Genesis_Listener_Proxy_XenForo_Model_Thread::FETCH_WAINDIGO_LASTPOST_AVATAR;

        return array(
            'conditions' => $threadFetchConditions,
            'options' => $threadFetchOptions
        );
    }
}