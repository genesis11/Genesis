<?php

/**
 *
 * @see XenForo_Model_Node
 */
class Genesis_Listener_Proxy_XenForo_Model_Node extends XFCP_Genesis_Listener_Proxy_XenForo_Model_Node
{

    /**
     *
     * @see XenForo_Model_Node::getNodeDataForListDisplay()
     */
    public function getNodeDataForListDisplay($parentNode, $displayDepth, array $nodePermissions = null)
    {
        $nodeData = parent::getNodeDataForListDisplay($parentNode, $displayDepth, $nodePermissions);
        if (!empty($nodeData)) {
            $groupedNodes = $nodeData['nodesGrouped'];

            $this->_addAvatarInfoForLastPostUsers($groupedNodes);

            if (XenForo_Application::$versionId < 1020000) {
                $nodeData['nodeParents'] = array();
            }

            return array(
                'nodeParents' => $nodeData['nodeParents'],
                'nodesGrouped' => $groupedNodes,
                'parentNodeId' => $nodeData['parentNodeId'],
                'nodeHandlers' => $nodeData['nodeHandlers'],
                'nodePermissions' => $nodeData['nodePermissions']
            );
        } else {
            return array();
        }
    }

    /**
     *
     * @param array $nodes
     */
    protected function _addAvatarInfoForLastPostUsers(array &$nodes)
    {
        $users = array();
        foreach ($nodes as &$depthNodes)
            foreach ($depthNodes as &$node) {
                if (isset($node['lastPost']['user_id']) && !isset($node['lastPost']['avatar_date'])) {
                    $users[$node['lastPost']['user_id']] = array();
                } elseif (isset($node['lastArticlePage']['user_id']) && !isset($node['lastArticlePage']['avatar_date'])) {
                    $users[$node['lastArticlePage']['user_id']] = array();
                }
            }
        if (isset($users[0])) {
            unset($users[0]);
        }

        if (!empty($users)) {
            $users = $this->_getAvatarInfoForUsers(array_keys($users),
                array(
                    'avatar_date',
                    'gravatar',
                    'gender'
                ));

            foreach ($nodes as &$depthNodes)
                foreach ($depthNodes as &$node) {
                    if (($node['node_type_id'] == "Category" || $node['node_type_id'] == "Forum" ||
                         $node['node_type_id'] == "SocialCategory") && isset($node['lastPost']['user_id']) &&
                         !empty($users[$node['lastPost']['user_id']])) {
                        foreach ($users[$node['lastPost']['user_id']] as $key => $value) {
                            $node['lastPost'][$key] = $value;
                        }
                    } elseif (($node['node_type_id'] == "Library") && isset($node['lastArticlePage']['user_id']) &&
                         !empty($users[$node['lastArticlePage']['user_id']])) {
                        foreach ($users[$node['lastArticlePage']['user_id']] as $key => $value) {
                            $node['lastArticlePage'][$key] = $value;
                        }
                    }
                }
        }
    }

    /**
     *
     * @param array|int $userIds
     * @return array
     */
    protected function _getAvatarInfoForUsers($userIds, array $keys)
    {
        if (!$userIds) {
            return array();
        }
        return $this->fetchAllKeyed(
            '
			SELECT user_id, ' . implode(', ', $keys) . '
			FROM xf_user AS user
			WHERE user.user_id IN (' . $this->_getDb()
                ->quote($userIds) . ')
		', 'user_id');
    }
}