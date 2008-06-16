<?php

class MetadataTestCase extends KTAPI_TestCase
{
    function setUp()
    {
        $db = KTapi::getDb();
        $db->execute('DELETE FROM members');
    }

    function testMetadata()
    {
        $this->title();


        $this->title('creating Invoice (InvoiceNo, InvoiceDate)');
        $documentType = Repository_Metadata_DocumentType::create('Default Type');
        $fieldset1 = Repository_Metadata_Fieldset::create('Invoice');
        $documentType->addFieldset($fieldset1);
        $field1 = Repository_Metadata_Field::create('Invoice No');
        $fieldset1->addField($field1);
        $field2 = Repository_Metadata_Field::create('Invoice Date');
        $fieldset1->addField($field2);


        $this->title('get fields');
        $fields = $fieldset1->getFields();
        $this->assertEqual(count($fields), 2);
        $this->assertEqual($fields[0]->Id, $field1->Id);
        $this->assertEqual($fields[1]->Id, $field2->Id);

        $this->title('removing field');

        $fieldset1->removeField($field1);

        $fields = $fieldset1->getFields();
        $this->assertEqual(count($fields), 1);
        $this->assertEqual($fields[0]->Id, $field2->Id);


    }

}

?>