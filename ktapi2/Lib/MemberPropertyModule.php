<?php

class MemberPropertyModule extends PluginModule
{
    public
    function register($plugin, $namespace, $baseClass, $displayName, $getter, $setter, $property, $type, $default=null)
    {
        $namespace = strtolower('member.property.' . $namespace);

        $config = array(
            'display_name' => $displayName,
            'getter' => $getter,
            'setter' => $setter,
            'type' => $type,
            'default' => $default
        );

        $this->base = Plugin_Module::registerParams($plugin, 'Property', '',
            array(
                'namespace'=>$namespace,
                'classname'=>$baseClass,
                'display_name'=>$property,
                'module_config'=>$config,
                'dependencies'=>'')
        );
    }

    public
    function getDisplayName()
    {
        return $this->getConfigValue('display_name');
    }

    public
    function getGetter()
    {
        return $this->getConfigValue('getter');
    }

    public
    function getSetter()
    {
        return $this->getConfigValue('setter');
    }

    public
    function getProperty()
    {
        return $this->module->display_name;
    }
    public
    function getType()
    {
        return $this->getConfigValue('type');
    }
    public
    function getDefault()
    {
        return $this->getConfigValue('default');
    }

    public
    function isValueValid(&$value)
    {
        switch ($this->getType())
        {
            case 'boolean':
            case 'bool':
                if (is_bool($value))
                {
                    return true;
                }
                switch ($value)
                {
                    case 0:
                    case false:
                    case 'false':
                        $value = false;
                        return true;
                    case 1:
                    case 'true':
                    case true:
                        $value = true;
                        return true;
                    default:
                        return false;
                }
            case 'int':
            case 'integer':
                if (!is_numeric($value))
                {
                    return false;
                }
                $value = (int) $value;
                return true;
            case 'float':
            case 'double':
                if (!is_numeric($value))
                {
                    return false;
                }
                $value = (double) $value;
                return true;
            default:
                return true;
        }
    }


}
?>