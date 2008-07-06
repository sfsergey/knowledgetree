<?php


require_once('../KTapi.inc.php');
$db = KTapi::getDb();

$classes = array();


createTable('members', 'Base_Member');
createTable('groupings', 'Base_Grouping');
createTable('users', 'Base_User');
createTable('member_submembers', 'Base_MemberSubMember');

$manager = Doctrine_Manager::getInstance();
$manager->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL ); // Doctrine::EXPORT_TABLES | Doctrine::EXPORT_CONSTRAINTS
$db->export->exportClasses($classes);

//DoctrineUtil::dropField('groupings', 'id');
//DoctrineUtil::addPrimaryKey('groupings', array('member_id'));
//DoctrineUtil::dropIndex('groupings', 'member_id');

createView('groups','g','Group');
createView('roles','r','Role');
createView('units','u','Unit');
createView('fieldsets','fs','FieldSet');
createView('fields','f','Field');
createView('document_types','dt','DocumentType');

function createTable($table, $class)
{
    global $db, $classes;

    $classes [] = $class;

    $obj = new $class();

    DoctrineUtil::dropTable($obj->getTable()->getTableName());
}


function createView($name, $letter, $type)
{
    global $db;

    DoctrineUtil::dropView($name);
    $db->execute("CREATE VIEW $name AS select m.id as member_id, $letter.name, m.status, m.unit_id from groupings $letter inner join members m on $letter.member_id=m.id WHERE $letter.type='$type' AND m.status != 'Deleted'");
}

?>