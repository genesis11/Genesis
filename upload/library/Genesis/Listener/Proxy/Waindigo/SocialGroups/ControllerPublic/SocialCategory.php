<?php

/**
 *
 * @see Waindigo_SocialGroups_ControllerPublic_SocialCategory
 */
class Genesis_Listener_Proxy_Waindigo_SocialGroups_ControllerPublic_SocialCategory extends XFCP_Genesis_Listener_Proxy_Waindigo_SocialGroups_ControllerPublic_SocialCategory
{

    /**
     *
     * @see Waindigo_SocialGroups_ControllerPublic_SocialCategory::actionIndex()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();

        if ($response instanceof XenForo_ControllerResponse_View && $this->_routeMatch->getResponseType() != 'rss') {
            $response = $this->_getGenesisResponse($response);
        }

        return $response;
    }

    /**
     *
     * @see Waindigo_SocialGroups_ControllerPublic_SocialCategory::actionForum()
     */
    public function actionForum()
    {
        $response = parent::actionForum();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $response = $this->_getGenesisResponse($response);
        }

        return $response;
    }

    /**
     *
     * @param XenForo_ControllerResponse_View $response
     * @return XenForo_ControllerResponse_View
     */
    protected function _getGenesisResponse(XenForo_ControllerResponse_View $response)
    {
        foreach ($response->params['socialForums'] as $socialForumId => $socialForum) {
            if (isset($response->params['socialForums'][$socialForumId]['last_post_user_avatar_date'])) {
                $response->params['socialForums'][$socialForumId]['lastPost']['avatar_date'] = $response->params['socialForums'][$socialForumId]['last_post_user_avatar_date'];
                $response->params['socialForums'][$socialForumId]['lastPost']['gravatar'] = $response->params['socialForums'][$socialForumId]['last_post_user_gravatar'];
                $response->params['socialForums'][$socialForumId]['lastPost']['gender'] = $response->params['socialForums'][$socialForumId]['last_post_user_gender'];
            }
        }
        if (!empty($response->params['stickySocialForums'])) {
            foreach ($response->params['stickySocialForums'] as $socialForumId => $socialForum) {
                if (isset($response->params['stickySocialForums'][$socialForumId]['last_post_user_avatar_date'])) {
                    $response->params['stickySocialForums'][$socialForumId]['lastPost']['avatar_date'] = $response->params['stickySocialForums'][$socialForumId]['last_post_user_avatar_date'];
                    $response->params['stickySocialForums'][$socialForumId]['lastPost']['gravatar'] = $response->params['stickySocialForums'][$socialForumId]['last_post_user_gravatar'];
                    $response->params['stickySocialForums'][$socialForumId]['lastPost']['gender'] = $response->params['stickySocialForums'][$socialForumId]['last_post_user_gender'];
                }
            }
        }

        return $response;
    }

    /**
     *
     * @see Waindigo_SocialGroups_ControllerPublic_SocialCategory::_getSocialForumFetchElements()
     */
    protected function _getSocialForumFetchElements(array $forum, array $displayConditions)
    {
        /* @var $socialForumModel Waindigo_SocialGroups_Model_SocialForum */
        $forumModel = $this->_getForumModel();

        $socialForumFetchElements = parent::_getSocialForumFetchElements($forum, $displayConditions);

        $socialForumFetchConditions = $socialForumFetchElements['conditions'];
        $socialForumFetchOptions = $socialForumFetchElements['options'];

        $socialForumFetchOptions['join_genesis'] = Genesis_Listener_Proxy_Waindigo_SocialGroups_Model_SocialForum::FETCH_WAINDIGO_LASTPOST_AVATAR;

        return array(
            'conditions' => $socialForumFetchConditions,
            'options' => $socialForumFetchOptions
        );
    }
}