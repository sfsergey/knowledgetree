<?

require_once('indexing/lib/XmlRpcLucene.inc.php');

class JavaXMLRPCLuceneIndexer extends Indexer
{
	/**
	 * @var XmlRpcLucene
	 */
	private $lucene;

	/**
	 * The constructor for PHP Lucene
	 *
	 * @param boolean $create Optional. If true, the lucene index will be recreated.
	 */
	public function __construct()
	{
		parent::__construct();

		$config =& KTConfig::getSingleton();
		$javaServerUrl = $config->get('indexer/JavaLuceneURL', 'http://localhost:8875');
		$this->lucene = new XmlRpcLucene($javaServerUrl);
	}

	/**
	 * Creates an index to be used.
	 *
	 */
	public static function createIndex()
	{
		// do nothing. The java lucene indexer will create the indexes if required
	}

	/**
	 * Indexes a document based on a text file.
	 *
	 * @param int $docid
	 * @param string $textfile
	 * @return boolean
	 */
    protected function indexDocument($docid, $textfile, $title, $version)
    {
    	try
    	{
	    	return $this->lucene->addDocument($docid, $textfile, '', $title, $version);
    	}
    	catch(Exception $e)
    	{
    		return false;
    	}
    }

    /**
     * Indexes the content and discussions on a document.
     *
     * @param int $docid
     * @param string $textfile
     * @return boolean
     */
    protected function indexDocumentAndDiscussion($docid, $textfile, $title, $version)
    {
    	try
    	{
	    	$discussion = Indexer::getDiscussionText($docid);
    		return $this->lucene->addDocument($docid, $textfile, $discussion, $title, $version);
    	}
    	catch(Exception $e)
    	{
    		return false;
    	}
    }

    /**
     * Indexes a discussion on a document..
     *
     * @param int $docid
     * @return boolean
     */
    protected function indexDiscussion($docid)
    {
    	try
    	{
    		$discussion = Indexer::getDiscussionText($docid);
    		return $this->lucene->updateDiscussion($docid, $discussion);
    	}
    	catch(Exception $e)
    	{
    		return false;
    	}

		return true;
    }

    /**
     * Optimise the lucene index.
     * This can be called periodically to optimise performance and size of the lucene index.
     *
     */
    public function optimise()
    {
    	$this->lucene->optimize();
    }

    /**
     * Removes a document from the index.
     *
     * @param int $docid
     * @return array containing (content, discussion, title)
     */
    public function deleteDocument($docid)
    {
    	return $this->lucene->deleteDocument($docid);
    }

    /**
     * Enter description here...
     *
     * @param string $query
     * @return array
     */
    public function query($query)
    {
    	$results = array();
    	$hits = $this->lucene->query($query);
    	if (is_array($hits))
    	{
    		foreach ($hits as $hit)
    		{


    			$document_id 	= $hit->DocumentID;
    			$content 		= $hit->Text;
    			$discussion 	= $hit->Title; //TODO: fix to be discussion. lucen server is not returning discussion text as well..
    			$title 			= $hit->Title;
    			$score 			= $hit->Rank;

    			// avoid adding duplicates. If it is in already, it has higher priority.
    			if (!array_key_exists($document_id, $results) || $score > $results[$document_id]->Score)
    			{
    				$results[$document_id] = new QueryResultItem($document_id,  $score, $title,  $content, $discussion);
    			}
    		}
    	}
    	else
    	{
			 $_SESSION['KTErrorMessage'][] = _kt('The XMLRPC Server did not respond correctly. Please notify the system administrator to investigate.');
    	}
        return $results;
    }

}
?>