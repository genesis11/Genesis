<?php

/**
 *
 * @see XenForo_Model_Thread
 */
class Genesis_Listener_Proxy_XenForo_Model_Thread extends XFCP_Genesis_Listener_Proxy_XenForo_Model_Thread
{

    /**
     * Constants to allow joins to extra tables in certain queries
     *
     * @var integer Join user table to fetch avatar info of last poster
     */
    const FETCH_WAINDIGO_LASTPOST_AVATAR = 0x01;

    /**
     *
     * @see XenForo_Model_Thread::prepareThreadFetchOptions()
     */
    public function prepareThreadFetchOptions(array $fetchOptions)
    {
        $threadFetchOptions = parent::prepareThreadFetchOptions($fetchOptions);

        if ((!empty($fetchOptions['join']) && $fetchOptions['join'] & self::FETCH_FIRSTPOST)
            || (!empty($fetchOptions['join_genesis']) && $fetchOptions['join_genesis'] & self::FETCH_WAINDIGO_LASTPOST_AVATAR)) {
            $threadFetchOptions['selectFields'] .= ',
				last_post_user.avatar_date AS last_post_user_avatar_date, last_post_user.gravatar AS last_post_user_gravatar, last_post_user.gender AS last_post_user_gender';
            $threadFetchOptions['joinTables'] .= '
				LEFT JOIN xf_user AS last_post_user ON
					(last_post_user.user_id = thread.last_post_user_id)';
        }

        return array(
            'selectFields' => $threadFetchOptions['selectFields'],
            'joinTables' => $threadFetchOptions['joinTables'],
            'orderClause' => $threadFetchOptions['orderClause']
        );
    }

    /**
     *
     * @see XenForo_Model_Thread::prepareThread()
     */
    public function prepareThread(array $thread, array $forum, array $nodePermissions = null, array $viewingUser = null)
    {
        $thread = parent::prepareThread($thread, $forum, $nodePermissions, $viewingUser);

        if (isset($thread['last_post_user_avatar_date'])) {
            $thread['lastPostInfo']['avatar_date'] = $thread['last_post_user_avatar_date'];
        }
        if (isset($thread['last_post_user_gravatar'])) {
            $thread['lastPostInfo']['gravatar'] = $thread['last_post_user_gravatar'];
        }
        if (isset($thread['last_post_user_gender'])) {
            $thread['lastPostInfo']['gender'] = $thread['last_post_user_gender'];
        }

        return $thread;
    }
}