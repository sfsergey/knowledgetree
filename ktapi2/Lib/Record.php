<?php

abstract class KTAPI_Record extends Doctrine_Record
{
    private static $constants = null;

    const AUTOINC_ID    = 0;
    const NOTNULL       = 1;
    const UNSIGNED_NOTNULL       = 2;

    private
    function init()
    {
        if (isset(self::$constants))
        {
            return;
        }
        self::$constants[self::AUTOINC_ID] = array('unsigned' => true, 'primary' => true,  'notnull' => true, 'autoincrement'=>true );
        self::$constants[self::NOTNULL] = array('notnull' => true );
        self::$constants[self::UNSIGNED_NOTNULL] = array('notnull' => true , 'unsigned' => true);
    }

    public
    function setTableDefinition()
    {
        self::init();
        $this->option('type', 'INNODB');
        $this->setDefinition();
    }

    protected abstract
    function setDefinition();

    protected
    function addAutoInc($name = 'id')
    {
        $this->hasColumn($name, 'integer', 4, self::$constants[self::AUTOINC_ID]);
    }

    private static
    function getNotNull($notNull, $default = null)
    {
        if ($notNull)
        {
            $notnull = self::$constants[self::NOTNULL];
            if (isset($default)) $notnull['default'] = $default;
        }
        else
        {
            $notnull = null;
        }
        return $notnull;
    }

    protected
    function addStringPrimary($name, $maxLength, $notNull = true)
    {
        $options = self::getNotNull($notNull);
        $options['primary'] = true;
        $this->hasColumn($name, 'string', $maxLength, $options);
    }

    protected
    function addBlob($name)
    {
        $this->hasColumn($name, 'blob', self::$constants[self::NOTNULL]);
    }

    protected
    function addIntegerPrimary($name, $notNull = true)
    {
        $options = self::getNotNull($notNull);
        $options['primary'] = true;
        $this->hasColumn($name, 'integer', 4, $options);
    }

    protected
    function addNamespace($name, $notNull = true)
    {
        $this->addString($name, 100, $notNull);
    }

    protected
    function addString($name, $maxLength, $notNull = true)
    {
        $this->hasColumn($name, 'string', $maxLength, self::getNotNull($notNull));
    }

    protected
    function addStringWithDefault($name, $maxLength, $default, $notNull = true)
    {
        $this->hasColumn($name, 'string', $maxLength, self::getNotNull($notNull, $default));
    }

    protected
    function addArray($name,  $notNull = true)
    {
        $this->hasColumn($name, 'array', null, self::getNotNull($notNull));
    }

    protected
    function addEnumeration($name, $options,  $notNull = true)
    {
        $options = self::getNotNull($notNull);
        $options['values'] = $options;
        $this->hasColumn($name, 'enum', null, $options);
    }

    protected
    function addEnumerationWithDefault($name, $options, $default, $notNull = true)
    {
        $options = self::getNotNull($notNull, $default);
        $options['values'] = $options;
        $this->hasColumn($name, 'enum', null, $options);
    }

    protected
    function addGeneralStatus($name, $enabledByDefault, $notNull = true)
    {
        $options = self::getNotNull($notNull, $enabledByDefault?(GeneralStatus::ENABLED):(GeneralStatus::DISABLED));
        $options['values'] = GeneralStatus::get();
        $this->hasColumn($name, 'enum', null, $options);
    }

    protected
    function addNodeStatus($name, $notNull = true)
    {
        $options = self::getNotNull($notNull);
        $options['values'] = NodeStatus::get();
        $this->hasColumn($name, 'enum', null, $options);
    }


    protected
    function addInteger($name,  $notNull = true)
    {
        $this->hasColumn($name, 'integer', 4, self::getNotNull($notNull));
    }

    protected
    function addUnsignedInteger($name,  $notNull = true)
    {
        $this->hasColumn($name, 'integer', 4, self::$constants[self::UNSIGNED_NOTNULL]);
    }

    protected
    function addIntegerWithDefault($name, $default,  $notNull = true)
    {
        $this->hasColumn($name, 'integer', 4, self::getNotNull($notNull, $default));
    }

    protected
    function addBoolean($name,  $notNull = true)
    {
        $this->hasColumn($name, 'integer', 1, self::getNotNull($notNull));
    }

    protected
    function addBooleanWithDefault($name, $default, $notNull = true)
    {
        $this->hasColumn($name, 'integer', 1, self::getNotNull($notNull, $default));
    }

    protected
    function addTimestamp($name, $notNull = true)
    {
        $this->hasColumn($name, 'timestamp', null, self::getNotNull($notNull));
    }

    protected
    function addTimestampWithDefault($name, $default, $notNull = true)
    {
        $this->hasColumn($name, 'integer', null, self::getNotNull($notNull, $default));
    }

    public
    function hasOne($baseTable, $alias, $localField, $foreignField, $refClass = null)
    {
        $options = array(
                                     'local' => $localField,
                                     'foreign' => $foreignField,
                                     'onDelete'=>'CASCADE',
                                     'onUpdate'=>'CASCADE'
                                     );


        if (isset($refclass)) $options['refClass'] = $refClass;

        parent::hasOne($baseTable . ' as ' . $alias, $options);
    }

    public
    function hasMany($baseTable, $alias, $localField, $foreignField, $refClass = null)
    {
        $options = array(
                                     'local' => $localField,
                                     'foreign' => $foreignField,
                                     'onDelete'=>'CASCADE',
                                     'onUpdate'=>'CASCADE'
                                     );


        if (isset($refclass)) $options['refClass'] = $refClass;

        parent::hasMany($baseTable . ' as ' . $alias, $options);
    }

}

?>