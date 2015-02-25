<?php

/**
 *
 * @see Waindigo_SocialGroups_Model_SocialForum
 */
class Genesis_Listener_Proxy_Waindigo_SocialGroups_Model_SocialForum extends XFCP_Genesis_Listener_Proxy_Waindigo_SocialGroups_Model_SocialForum
{

    /**
     * Constants to allow joins to extra tables in certain queries
     *
     * @var integer Join user table to fetch avatar info of last poster
     */
    const FETCH_WAINDIGO_LASTPOST_AVATAR = 0x01;

    /**
     *
     * @see Waindigo_SocialGroups_Model_SocialForum::prepareSocialForumFetchOptions()
     */
    public function prepareSocialForumFetchOptions(array $fetchOptions)
    {
        $selectFields = '';
        $joinTables = '';

        if (isset($fetchOptions['join_genesis'])) {
            if ($fetchOptions['join_genesis'] & self::FETCH_WAINDIGO_LASTPOST_AVATAR) {
                $selectFields .= ',
					last_post_user.avatar_date AS last_post_user_avatar_date, last_post_user.gravatar AS last_post_user_gravatar, last_post_user.gender AS last_post_user_gender';
                $joinTables .= '
					LEFT JOIN xf_user AS last_post_user ON
						(last_post_user.user_id = social_forum.last_post_user_id)';
            }
        }

        $socialForumFetchOptions = parent::prepareSocialForumFetchOptions($fetchOptions);

        return array(
            'selectFields' => $selectFields . $socialForumFetchOptions['selectFields'],
            'joinTables' => $joinTables . $socialForumFetchOptions['joinTables'],
            'orderClause' => $socialForumFetchOptions['orderClause']
        );
    }
}