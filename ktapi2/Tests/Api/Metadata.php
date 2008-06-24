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

        $this->title('$field1->isTaggable()');
        $field1 = Repository_Metadata_Field::create('Invoice No');
        $this->assertFalse($field1->isTaggable());
        $fieldset1->addField($field1);
        $field2 = Repository_Metadata_Field::create('Invoice Date');
        $field2->setTaggable(true);
        $this->assertTrue($field2->isTaggable());
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

    function testMimeType()
    {
        MimeType::create('text/html', 'html','HTML page', array('htm','html'));


        $mime = MimeType::create('image/jpeg', 'image','JPEG Image', array('jpeg','jpg'));
        $mime->setExtensions(array('jpeg'));
        $mime->setName('JPG Image');
        $mime->save();

        $mime = MimeType::get('text/html');
        $this->assertEqual($mime->getName(), 'HTML page');

        $mime = MimeType::getByExtension('jpeg');
        $this->assertEqual($mime->getName(), 'JPEG Image');

        $mimeTypes = MimeType::getAll();
        $this->assertTrue(count($mimeTypes), 2);

        $mimeTypes = MimeType::getAll('JPEG');
        $this->assertTrue(count($mimeTypes), 1);
    }

}

?>