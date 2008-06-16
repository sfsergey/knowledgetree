<?php

class KTAPI_BaseMember extends KTAPI_Base
{
    private
    function setStatus($status)
    {
        $this->base->status = $status;
        $this->base->save();
    }

    protected
    function enable()
    {
        $this->setStatus('Enabled');
    }

    protected
    function disable()
    {
        $this->setStatus('Disabled');
    }

    public
    function isEnabled()
    {
        return $this->base->status == 'Enabled';
    }

    public
    function isDeleted()
    {
        return $this->base->status == 'Deleted';
    }

    function delete()
    {
        $db = KTapi::getDb();

        try
        {
            $db->beginTransaction();

            // yes, this save statement must be here.
            // it is in case the name of the grouping record has
            // changed. the grouping records are retrieved from a view,
            // a join between the groupings table and members table.
            // updating a view with a join results in a conflict if
            // updates result in updates to multiple tables.
            $this->save();

            $this->setStatus('Deleted');

            $query = Doctrine_Query::create();
            $query->delete()
                ->from('Base_MemberSubmember m')
                ->where('m.member_id = :member_id', array(':member_id'=>$this->getId()))
                ->execute();

            $query = Doctrine_Query::create();
            $query->delete()
                ->from('Base_MemberEffectiveUser u')
                ->where('u.member_id = :member_id', array(':member_id'=>$this->getId()))
                ->execute();

            $groupings = $this->getGroupings('Parents');
            foreach($groupings as $groups)
            {
                $groups->updateEffectiveUsers();
            }
            $db->commit();
        }
        catch(Exception $ex)
        {
            $db->rollback();
            throw $ex;
        }
        $this->base->clearRelated();
    }

    protected
    function getGroupings($relation)
    {
        return array();
    }

    /**
     * Get a list of groups based on a filter and optional  unit id.
     *
     * @param string $filter
     * @param int $unitId
     * @return array of Security_Group
     */
    protected static
    function getMembersByFilter($baseClass, $instanceClass, $filter, $unitId = null)
    {
        $query = Doctrine_Query::create();
        $query = $query->select('b.*')
            ->from($baseClass . ' b')
            ->where('b.name like :filter', array(':filter'=> "%$filter%"));

        if (!is_null($unitId))
        {
            $query->addWhere(' AND b.unit_id = :unit_id', array(':unit_id' => $unitId));
        }

        $rows = $query->execute();

        return Util_Doctrine::getObjectArrayFromCollection($rows, $instanceClass);

    }

}

?>