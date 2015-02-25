<?php

class Genesis_Listener_Proxy_XenForo_Model_ThreadWatch extends XFCP_Genesis_Listener_Proxy_XenForo_Model_ThreadWatch
{

    public function getThreadsWatchedByUser($userId, $newOnly, array $fetchOptions = array())
	{
	    $threadModel = $this->_getThreadModel();

	    $fetchOptions['join_genesis'] = Genesis_Listener_Proxy_XenForo_Model_Thread::FETCH_WAINDIGO_LASTPOST_AVATAR;

	    return parent::getThreadsWatchedByUser($userId, $newOnly, $fetchOptions);
	}
}