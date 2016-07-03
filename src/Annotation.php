<?php

namespace Kaplarn\Annotation;

/**
 * @author Káplár Norbert <kaplarnorbert@webshopexperts.hu>
 */
class Annotation
{
    /**
     * @var []
     */
    protected $properites = [];
    
    /**
     * @param String $docBlock
     */
    public function __construct($docBlock)
    {
        $this->properites = $this->parse($docBlock);
    }
    
    /**
     * @param String $name
     * @param [] $arguments
     * @return Mixed
     */
    public function __call($name, $arguments)
    {
        if ($this->isHas($name)) {
            return $this->has($this->getProperty($name));
        }
        
        if ($this->isGet($name)) {
            return $this->get($this->getProperty($name));
        }
    }
    
    /**
     * @param String $name
     */
    protected function getProperty($name)
    {
        return lcfirst(preg_replace('/(has|get)/', '', $name));
    }
    
    /**
     * @param String $name
     * @return Bool
     */
    protected function isHas($name)
    {
        return strpos($name, 'has') === 0;
    }
    
    /**
     * @param String $name
     * @return Bool
     */
    protected function has($name)
    {
        return array_key_exists($name, $this->properites);
    }
    
    /**
     * @param String $name
     * @return Bool
     */
    protected function isGet($name)
    {
        return strpos($name, 'get') === 0;
    }
    
    /**
     * @param String $name
     * @return Mixed
     */
    protected function get($name)
    {
        return $this->has($name) ? $this->properites[$name] : null;
    }
    
    /**
     * @param String $docBlock
     * @return []
     */
    protected function parse($docBlock)
    {
        $match = [];
        if (!preg_match('/\[.*\]/', $docBlock, $match)) {
            return [];
        }
        
        $string = preg_replace('/\,[^\']*\'/', ', \'', $match[0]);
        $string = preg_replace('/^\[[^\']*\'/', '[\'', $string);
        $string = preg_replace('/[\ ]*\*[\ ]*\]$/', ']', $string);
        
        return eval('return ' . $string . ';');
    }
}
