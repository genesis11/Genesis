<?php

/**
 *
 * @see XenForo_ControllerPublic_Forum
 */
class Genesis_Listener_Proxy_XenForo_ControllerPublic_Forum extends XFCP_Genesis_Listener_Proxy_XenForo_ControllerPublic_Forum
{

    /**
     *
     * @see XenForo_ControllerPublic_Forum::_getThreadFetchElements()
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