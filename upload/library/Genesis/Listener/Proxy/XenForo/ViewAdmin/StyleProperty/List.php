<?php

/**
 *
 * @see XenForo_ViewAdmin_StyleProperty_List
 */
class Genesis_Listener_Proxy_XenForo_ViewAdmin_StyleProperty_List extends XFCP_Genesis_Listener_Proxy_XenForo_ViewAdmin_StyleProperty_List
{

    public function renderHtml()
    {
        $scalars = $this->_params['scalars'];
        
        parent::renderHtml();
        
        foreach ($scalars as $propertyId => &$property) {
            if ($property['scalar_type'] == 'template') {
                $scalarParameters = preg_split("/\\r\\n|\\r|\\n/", $property['scalar_parameters'], 2);
                
                $templateName = $scalarParameters[0];
                
                $formatParams = array();
                if (!empty($scalarParameters[1])) {
                    $formatParams = $this->_parseNamedFormatParams($scalarParameters[1]);
                }
                
                $formatParams = $this->_replacePhrasedText($formatParams);
                
                $template = $this->createTemplateObject($templateName, 
                    array(
                        'property' => $property,
                        'formatParams' => $formatParams
                    ));
                
                $this->_params['scalars'][$property['sub_group']]['properties'][$propertyId]['template'] = $template;
            }
        }
    }
    
    /**
     * Parse named edit format parameters. Parameters use format "name => value"
     * with one parameter per line.
     *
     * @param string $params Unparsed params
     *
     * @return array Format: [name] => value/label
     */
    protected function _parseNamedFormatParams($params)
    {
        $pairs = array();
    
        preg_match_all('/
			^\s*
			(?P<name>([^=\r\n])+?)
			\s*=\s*
			(?P<value>.*?)
			\s*$
		/mix', trim($params), $matches, PREG_SET_ORDER);
    
        foreach ($matches AS $match)
        {
            $pairs[$match['name']] = $match['value'];
        }
    
        return $pairs;
    }
    
    /**
     * Replaces {xen:phrase x} references in a formatting params list for an option.
     *
     * @param array $formatParams List of format params ([name] => label string)
     *
     * @return array Format params with phrases replaced
     */
    protected function _replacePhrasedText(array $formatParams)
    {
        $replacements = array();
    
        foreach ($formatParams AS $name => $label)
        {
            preg_match_all(
            '#\{xen:phrase ("|\'|)([a-z0-9-_]+)\\1(,\s*("|\')(.+)\\4)*\}#iU',
            $label, $matches, PREG_SET_ORDER
            );
            foreach ($matches AS $match)
            {
                $params = array();
                if (!empty($match[3]))
                {
                    preg_match_all('#,\s*("|\')([^=]+)=(.*)\\1#U', $match[3], $paramMatches, PREG_SET_ORDER);
                    foreach ($paramMatches AS $paramMatch)
                    {
                        $params[$paramMatch[2]] = $paramMatch[3];
                    }
                }
    
                $replacements[$match[0]] = new XenForo_Phrase($match[2], $params);
            }
        }
        if ($replacements)
        {
            foreach ($formatParams AS $name => &$label)
            {
                foreach ($replacements AS $search => $replace)
                {
                    $label = str_replace($search, (string)$replace, $label);
                }
            }
        }
    
        return $formatParams;
    }
}