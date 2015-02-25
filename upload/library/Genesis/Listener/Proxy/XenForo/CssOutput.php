<?php

/**
 *
 * @see XenForo_CssOutput
 */
class Genesis_Listener_Proxy_XenForo_CssOutput extends XFCP_Genesis_Listener_Proxy_XenForo_CssOutput
{

    public function renderCss()
    {
        $css = parent::renderCss();

        $pointsToPixels = array(
            '7pt' => '9px',
            '7.5pt' => '10px',
            '8pt' => '11px',
            '9pt' => '12px',
            '10pt' => '13px',
            '11pt' => '15px',
            '12pt' => '16px',
            '13.5pt' => '18px',
            '16pt' => '22px',
            '20pt' => '26px'
        );

        $fontSizes = array();

        $properties = $this->_getStyleProperties();

        $fontSizes['9px'] = $properties['gen_fontSize1'];
        $fontSizes['10px'] = $properties['gen_fontSize2'];
        $fontSizes['12px'] = $properties['gen_fontSize3'];
        $fontSizes['15px'] = $properties['gen_fontSize4'];
        $fontSizes['18px'] = $properties['gen_fontSize5'];
        $fontSizes['22px'] = $properties['gen_fontSize6'];
        $fontSizes['26px'] = $properties['gen_fontSize7'];
        $fontSizes['11px'] = $properties['gen_fontSmall'];
        $fontSizes['13px'] = $properties['gen_fontMedium'];
        $fontSizes['16px'] = $properties['gen_fontLarge'];

        $patterns = array();
        foreach ($fontSizes as $pixelSize => $newSize) {
            if ($pixelSize != $newSize) {
                $pointSize = array_search($pixelSize, $pointsToPixels);
                $patterns['/font-size: ' . $pixelSize . ';/'] = 'font-size: ' . $newSize . ';';
                $patterns['/font-size: ' . $pointSize . ';/'] = 'font-size: ' . $newSize . ';';
            }
        }

        if (!$patterns) {
            return $css;
        }

        $css = preg_replace(array_keys($patterns), $patterns, $css);

        $debug = (XenForo_Application::debugMode() ? 'debug' : '');
        $cacheId = 'xfCssCache_' .
             sha1(
                'style=' . $this->_styleId . 'css=' . serialize($this->_cssRequested) . 'd=' . $this->_inputModifiedDate .
                 'dir=' . $this->_textDirection . 'minify=' . XenForo_Application::get('options')->minifyCss) . $debug;

        if ($cacheObject = XenForo_Application::getCache()) {
            $cacheObject->save($css, $cacheId, array(), 86400);
        }

        return $css;
    }

    protected function _getStyleProperties()
    {
        $styles = XenForo_Application::get('styles');
        $defaultProperties = XenForo_Application::get('defaultStyleProperties');

        if ($this->_styleId && isset($styles[$this->_styleId])) {
            $style = $styles[$this->_styleId];
        } else {
            $style = reset($styles);
        }

        if ($style) {
            $properties = unserialize($style['properties']);
            $properties = XenForo_Application::mapMerge($defaultProperties, $properties);
        } else {
            $properties = $defaultProperties;
        }

        return $properties;
    }
}