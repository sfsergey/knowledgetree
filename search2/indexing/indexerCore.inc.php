<?php

require_once('indexing/extractorCore.inc.php');


class MatchResult
{
	protected $document_id;
	protected $title;
	protected $rank;
	protected $text;
	protected $filesize;
	protected $fullpath;
	protected $live;
	protected $version;
	protected $filename;
	protected $thumbnail; // TODO: if not null, gui can display a thumbnail
	protected $viewer; // TODO: if not null, a viewer can be used to view the document
	protected $document;
	protected $checkoutuser;
	protected $workflowstate;
	protected $workflow;

	public function __construct($document_id, $rank, $title, $text)
	{
		$this->document_id=$document_id;
		$this->rank= $rank;
		$this->title=$title;
		$this->text = $text;
		$this->loadDocumentInfo();
	}

	protected function __isset($property)
	{
		switch($property)
		{
			case 'DocumentID': return isset($this->document_id);
			case 'Rank': return isset($this->rank);
			case 'Text': return isset($this->text);
			case 'Title': return isset($this->title);
			case null: break;
			default:
				throw new Exception("Unknown property '$property' to get on MatchResult");
		}
	}

	private function loadDocumentInfo()
	{
		$sql = "SELECT
					f.full_path, f.name, dcv.size as filesize, dcv.major_version,
					dcv.minor_version, dcv.filename, cou.name as checkoutuser, w.human_name as workflow, ws.human_name as workflowstate

				FROM
					documents d
					INNER JOIN document_metadata_version dmv ON d.metadata_version_id = dmv.id
					INNER JOIN document_content_version dcv ON dmv.content_version_id = dcv.id
					LEFT JOIN folders f ON f.id=d.folder_id
					LEFT JOIN users cou ON d.checked_out_user_id=cou.id
					LEFT JOIN workflows w ON dmv.workflow_id=w.id
					LEFT JOIN workflow_states ws ON dmv.workflow_state_id = ws.id
				WHERE
					d.id=$this->document_id";

		$result = DBUtil::getOneResult($sql);

		if (PEAR::isError($result) || empty($result))
		{
			$this->live = false;
			return;
		}

		$this->live = true;
		if (is_null($result['name']))
		{
			$this->fullpath = '(orphaned)';
		}
		else
		{
			$this->fullpath = $result['full_path'] . '/' . $result['name'];
			if (substr($this->fullpath,0,1) == '/') $this->fullpath = substr($this->fullpath,1);
		}


		$this->filesize = $result['filesize'] + 0;

		if ($this->filesize > 1024 * 1024 * 1024)
		{
			$this->filesize = floor($this->filesize / (1024 * 1024 * 1024)) . 'g';
		}
		elseif ($this->filesize > 1024 * 1024)
		{
			$this->filesize = floor($this->filesize / (1024 * 1024)) . 'm';
		}
		elseif ($this->filesize > 1024)
		{
			$this->filesize = floor($this->filesize / (1024)) . 'k';
		}
		else
		{
			$this->filesize .= 'b';
		}

		$this->version = $result['major_version'] . '.' . $result['minor_version'];
		$this->filename=$result['filename'];
		$this->checkoutuser = $result['checkoutuser'];
		$this->workflow = $result['workflow'];
		$this->workflowstate = $result['workflowstate'];

	}



	protected function __get($property)
	{
		switch($property)
		{
			case 'DocumentID': return $this->document_id;
			case 'Rank': return $this->rank;
			case 'Text': return $this->text;
			case 'Title': return $this->title;
			case 'FullPath': return $this->fullpath;
			case 'IsLive': return $this->live;
			case 'Filesize': return $this->filesize;
			case 'Version': return $this->version;
			case 'Filename': return $this->filename;
			case 'Document':
					if (is_null($this->document))
						$this->document = Document::get($this->document_id);
					return $this->document;
			case 'IsAvailable':
				return $this->Document->isLive();

			case 'CheckedOutUser':
				return  $this->checkoutuser;
			case 'Workflow':
				if (is_null($this->workflow))
				{
					return '';
				}
				return "$this->workflow - $this->workflowstate";
			case null: break;
			default:
				throw new Exception("Unknown property '$property' to get on MatchResult");
		}
	}

	protected function __set($property, $value)
	{
		switch($property)
		{
			case 'Rank': $this->rank = number_format($value,2,'.',','); break;
			case 'Text': $this->text = $value; break;
			default:
				throw new Exception("Unknown property '$property' to set on MatchResult");
		}
	}
}

function MatchResultCompare($a, $b)
{
    if ($a->Rank == $b->Rank) {
        return 0;
    }
    return ($a->Rank < $b->Rank) ? -1 : 1;
}

class QueryResultItem extends MatchResult
{
    protected $discussion;

    public function __construct($document_id, $rank, $title, $text, $discussion)
    {
    	parent::__construct($document_id, $rank, $title, $text);
    	$this->discussion=$discussion;
    }

	protected function __isset($property)
	{
		switch($property)
		{
			case 'Discussion': return isset($this->discussion);
			default: return parent::__isset($property);
		}
	}

    protected function __get($property)
    {
    	switch($property)
    	{
    		case 'Discussion': return $this->discussion;
    		default: return parent::__get($property);
    	}
    }
}

abstract class Indexer
{
	/**
	 * Cache of extractors
	 *
	 * @var array
	 */
	private $extractorCache;

	/**
	 * Indicates if the indexer will do logging.
	 *
	 * @var boolean
	 */
	private $debug;
	/**
	 * Cache on mime related hooks
	 *
	 * @var unknown_type
	 */
	private $mimeHookCache;
	/**
	 * Cache on general hooks.
	 *
	 * @var array
	 */
	private $generalHookCache;

	/**
	 * This is a path to the extractors.
	 *
	 * @var string
	 */
	private $extractorPath;
	/**
	 * This is a path to the hooks.
	 *
	 * @var string
	 */
	private $hookPath;

	/**
	 * Initialise the indexer
	 *
	 */
	protected function __construct()
	{
		$this->extractorCache=array();
		$this->debug=true;
		$this->hookCache = array();
		$this->generalHookCache = array();

		$config = KTConfig::getSingleton();

		$this->extractorPath = $config->get('indexer/extractorPath', 'extractors');
		$this->hookPath = $config->get('indexer/extractorHookPath','extractorHooks');
	}

	/**
	 * Returns a reference to the main class
	 *
	 * @return Indexer
	 */
	public static function get()
	{
		static $singleton = null;

		if (is_null($singleton))
		{
			$config = KTConfig::getSingleton();
			$classname = $config->get('indexer/coreClass');

			require_once('indexing/indexers/' . $classname . '.inc.php');

			if (!class_exists($classname))
			{
				throw new Exception("Class '$classname' does not exist.");
			}

			$singleton = new $classname;
		}

		return $singleton;
	}

	public abstract function deleteDocument($docid);

	/**
	 * Remove the association of all extractors to mime types on the database.
	 *
	 */
	public function clearExtractors()
	{
		global $default;
		$sql = "update mime_types set extractor=null";
		DBUtil::runQuery($sql);

		$default->log->debug('clearExtractors');
	}

	/**
	 * lookup the name of the extractor class based on the mime type.
	 *
	 * @param string $type
	 * @return string
	 */
	public static function resolveExtractor($type)
	{
		global $default;
		$sql = "select extractor from mime_types where filetypes='$type'";
		$class = DBUtil::getOneResultKey($sql,'extractor');
		if (PEAR::isError($class))
		{
			$default->log->error("resolveExtractor: cannot resolve $type");
			return $class;
		}
		if ($this->debug) $default->log->debug("resolveExtractor: Resolved '$class' from mime type '$type'.");
		return $class;
	}

	/**
	 * Return all the discussion text.
	 *
	 * @param int $docid
	 * @return string
	 */
	public static function getDiscussionText($docid)
	{
		$sql = "SELECT
					dc.subject, dc.body
				FROM
					discussion_threads dt
					INNER JOIN discussion_comments dc ON dc.thread_id=dt.id AND dc.id BETWEEN dt.first_comment_id AND dt.last_comment_id
				WHERE
					dt.document_id=$docid";
		$result = DBUtil::getResultArray($sql);
		$text = '';

		foreach($result as $record)
		{
			$text .= $record['subject'] . "\n" . $record['body'] . "\n";
		}

		return $text;
	}

	/**
	 * Schedule the indexing of a document.
	 *
	 * @param string $document
	 * @param string $what
	 */
    public static function index($document, $what='C')
    {
    	global $default;

        $document_id = $document->getId();
        $userid=$_SESSION['userID'];
        if (empty($userid)) $userid=1;

        // we dequeue the document so that there are no issues when enqueuing
        Indexer::unqueueDocument($document_id);

        // enqueue item
        $sql = "INSERT INTO index_files(document_id, user_id, what) VALUES($document_id, $userid, '$what')";
        DBUtil::runQuery($sql);

//        if ($this->debug) $default->log->debug("index: Queuing indexing of $document_id");
    }


    public static function indexAll()
    {
    	 $userid=$_SESSION['userID'];
    	 if (empty($userid)) $userid=1;
    	$sql = "INSERT INTO index_files(document_id, user_id, what) SELECT id, $userid, 'C' FROM documents WHERE status_id=1";
    	DBUtil::runQuery($sql);
    }

    /**
     * Clearout the scheduling of documents that no longer exist.
     *
     */
    public static function clearoutDeleted()
    {
    	global $default;

        $sql = 'DELETE FROM
					index_files AS iff USING index_files AS iff, documents
				WHERE
					NOT EXISTS(
						SELECT
							d.id
						FROM
							documents AS d
							INNER JOIN document_metadata_version dmv ON d.metadata_version_id=dmv.id
						WHERE
							iff.document_id = d.id OR dmv.status_id=3
					);';
        DBUtil::runQuery($sql);

      //  if ($this->debug) $default->log->debug("clearoutDeleted: remove documents");
    }


    /**
     * Check if a document is scheduled to be indexed
     *
     * @param mixed $document This may be a document or document id
     * @return boolean
     */
    public static function isDocumentScheduled($document)
    {
    	if (is_numeric($document))
    	{
    		$docid = $document;
    	}
    	else if ($document instanceof Document)
    	{
    		$docid = $document->getId();
    	}
    	else
    	{
    		return false;
    	}
    	$sql = "SELECT 1 FROM index_files WHERE document_id=$docid";
    	$result = DBUtil::getResultArray($sql);
    	return count($result) > 0;
    }

    /**
     * Filters text removing redundant characters such as continuous newlines and spaces.
     *
     * @param string $filename
     */
    private function filterText($filename)
    {
    	$content = file_get_contents($filename);

    	$src = array("([\r\n])","([\n][\n])","([\n])","([\t])",'([ ][ ])');
    	$tgt = array("\n","\n",' ',' ',' ');

    	// shrink what is being stored.
    	do
    	{
    		$orig = $content;
    		$content = preg_replace($src, $tgt, $content);
    	} while ($content != $orig);

    	return file_put_contents($filename, $content);
    }

    /**
     * Load hooks for text extraction process.
     *
     */
    private function loadExtractorHooks()
    {
    	$this->generalHookCache = array();
    	$this->mimeHookCache = array();

		$dir = opendir($this->hookPath);
		while (($file = readdir($dir)) !== false)
		{
			if (substr($file,-12) == 'Hook.inc.php')
			{
				require_once($this->hookPath . '/' . $file);
				$class = substr($file, 0, -8);

				if (!class_exists($class))
				{
					continue;
				}

				$hook = new $class;
				if (!($class instanceof ExtractorHook))
				{
					continue;
				}

				$mimeTypes = $hook->registerMimeTypes();
				if (is_null($mimeTypes))
				{
					$this->generalHookCache[] = & $hook;
				}
				else
				{
					foreach($mimeTypes as $type)
					{
						$this->mimeHookCache[$type][] = & $hook;
					}
				}

			}
        }
        closedir($dir);
    }

    /**
     * This is a refactored function to execute the hooks.
     *
     * @param DocumentExtractor $extractor
     * @param string $phase
     * @param string $mimeType Optional. If set, indicates which hooks must be used, else assume general.
     */
    private function executeHook($extractor, $phase, $mimeType = null)
    {
    	$hooks = array();
		if (is_null($mimeType))
		{
			$hooks = $this->generalHookCache;
		}
		else
		{
			if (array_key_exists($mimeType, $this->mimeHookCache))
			{
				$hooks = $this->mimeHookCache[$mimeType];
			}
		}
		if (empty($hooks))
		{
			return;
		}

		foreach($hooks as $hook)
		{
			$hook->$phase($extractor);
		}
    }

    /**
     * The main function that may be called repeatedly to index documents.
     *
     * @param int $max Default 20
     */
    public function indexDocuments($max=null)
    {
    	global $default;

		$config =& KTConfig::getSingleton();

    	if (is_null($max))
    	{
			$max = $config->get('indexer/batchDocuments',20);
    	}

    	$this->loadExtractorHooks();

    	Indexer::clearoutDeleted();

    	// identify the indexers that must run
        // mysql specific limit!
        $sql = "SELECT
        			iff.document_id, mt.filetypes, mt.mimetypes, mt.extractor, iff.what
				FROM
					index_files iff
					INNER JOIN documents d ON iff.document_id=d.id
					INNER JOIN document_metadata_version dmv ON d.metadata_version_id=dmv.id
					INNER JOIN document_content_version dcv ON dmv.content_version_id=dcv.id
					INNER JOIN mime_types mt ON dcv.mime_id=mt.id
 				WHERE
 					iff.processdate IS NULL AND dmv.status_id=1
				ORDER BY indexdate
 					LIMIT $max";
        $result = DBUtil::getResultArray($sql);
        if (PEAR::isError($result))
        {
        	return;
        }

        // bail if no work to do
        if (count($result) == 0)
        {
            return;
        }

        // identify any documents that need indexing and mark them
        // so they are not taken in a followup run
		$ids = array();
		foreach($result as $docinfo)
		{
			$ids[] = $docinfo['document_id'];
		}

		// mark the documents as being processed
		$date = date('Y-m-d H:j:s');
        $ids=implode(',',$ids);
        $sql = "UPDATE index_files SET processdate='$date' WHERE document_id in ($ids)";
        DBUtil::runQuery($sql);

        $extractorCache = array();
        $storageManager = KTStorageManagerUtil::getSingleton();

        $tempPath = $config->get("urls/tmpDirectory");

        foreach($result as $docinfo)
        {
        	$docId=$docinfo['document_id'];
        	$extension=$docinfo['filetypes'];
        	$mimeType=$docinfo['mimetypes'];
        	$extractorClass=$docinfo['extractor'];
        	$indexDocument = in_array($docinfo['what'], array('A','C'));
        	$indexDiscussion = in_array($docinfo['what'], array('A','D'));

        	if ($this->debug) $default->log->debug("Indexing docid: $docId extension: '$extension' mimetype: '$mimeType' extractor: '$extractorClass'");

        	if (empty($extractorClass))
        	{
	        	if ($this->debug) $default->log->debug("No extractor for docid: $docId");

        		Indexer::unqueueDocument($docId);
        		continue;
        	}

        	if ($this->debug) print "Processing document $docId.\n";
        	if ($indexDocument)
        	{
        		if (array_key_exists($extractorClass, $extractorCache))
        		{
        			$extractor = $extractorCache[$extractorClass];
        		}
        		else
        		{
        			require_once('extractors/' . $extractorClass . '.inc.php');

        			if (!class_exists($extractorClass))
        			{
        				$default->log->error("indexDocuments: extractor '$extractorClass' does not exist.");
						continue;
        			}

        			$extractor = $extractorCache[$extractorClass] = new $extractorClass();
        		}

        		if (is_null($extractor))
        		{
        			$default->log->error("indexDocuments: extractor '$extractorClass' not resolved - it is null.");
        			continue;
        		}

				if (!($extractor instanceof DocumentExtractor))
				{
        			$default->log->error("indexDocuments: extractor '$extractorClass' is not a document extractor class.");
					continue;
				}

        		$document = Document::get($docId);
        		$sourceFile = $storageManager->temporaryFile($document);

        		if (empty($sourceFile) || !is_file($sourceFile))
        		{
        			$default->log->error("indexDocuments: source file '$sourceFile' for document $docId does not exist.");
        			Indexer::unqueueDocument($docId);
        			continue;
        		}

        		if ($extractor->needsIntermediateSourceFile())
        		{
        			$intermediate = $tempPath . '/'. $document->getFileName();
        			$result = @copy($sourceFile, $intermediate);
        			if ($result === false)
        			{
        				$default->log->error("Could not create intermediate file from document $docid");
        				// problem. lets try again later. probably permission related. log the issue.
        				continue;
        			}
        			$sourceFile = $intermediate;
        		}

        		$targetFile = tempnam($tempPath, 'ktindexer') . '.txt';

        		$extractor->setSourceFile($sourceFile);
        		$extractor->setMimeType($mimeType);
        		$extractor->setExtension($extension);
        		$extractor->setTargetFile($targetFile);
        		$extractor->setDocument($document);
        		$extractor->setIndexingStatus(null);
        		$extractor->setExtractionStatus(null);
        		if ($this->debug) $default->log->debug("Extra Info docid: $docId Source File: '$sourceFile' Target File: '$targetFile'");

        		$this->executeHook($extractor, 'pre_extract');
				$this->executeHook($extractor, 'pre_extract', $mimeType);

        		if ($extractor->extractTextContent())
        		{
        			$extractor->setExtractionStatus(true);
        			$this->executeHook($extractor, 'pre_index');
					$this->executeHook($extractor, 'pre_index', $mimeType);

					$title = $document->getName();
        			if ($indexDiscussion)
        			{
        				$indexStatus = $this->indexDocumentAndDiscussion($docId, $targetFile, $title);

        				if (!$indexStatus) $default->log->error("Problem indexing document $docId");

        				$extractor->setIndexingStatus($indexStatus);
        			}
        			else
        			{
        				if (!$this->filterText($targetFile))
        				{
        					$default->log->error("Problem filtering document $docId");
        				}
						else
						{
							$indexStatus = $this->indexDocument($docId, $targetFile, $title);

							if (!$indexStatus) $default->log->error("Problem indexing document $docId");

        					$extractor->setIndexingStatus($indexStatus);
						}
        			}

					$this->executeHook($extractor, 'post_index', $mimeType);
        			$this->executeHook($extractor, 'post_index');
        		}
        		else
        		{
        			$extractor->setExtractionStatus(false);
        			$default->log->error("Could not extract contents from document $docId");
        		}

				$this->executeHook($extractor, 'post_extract', $mimeType);
        		$this->executeHook($extractor, 'post_extract');

        		if ($extractor->needsIntermediateSourceFile())
        		{
        			@unlink($sourceFile);
        		}

        		@unlink($targetFile);
        	}
        	else
        	{
				$this->indexDiscussion($docId);
        	}

			Indexer::unqueueDocument($docId);
			if ($this->debug) $default->log->debug("Done indexing docid: $docId");

        }
        if ($this->debug) print "Done.\n";
    }

    /**
     * Index a document. The base class must override this function.
     *
     * @param int $docId
     * @param string $textFile
     */
    protected abstract function indexDocument($docId, $textFile, $title='');

    /**
     * Index a discussion. The base class must override this function.
     *
     * @param int $docId
     */
    protected abstract function indexDiscussion($docId);

    /**
     * Diagnose the extractors.
     *
     * @return array
     */
    public function diagnose()
    {
		$diagnosis = $this->_diagnose($this->extractorPath, 'DocumentExtractor', 'Extractor.inc.php');
		$diagnosis = array_merge($diagnosis, $this->_diagnose($this->hookPath, 'Hook', 'Hook.inc.php'));

		return $diagnosis;
    }

    /**
     * This is a refactored diagnose function.
     *
     * @param string $path
     * @param string $class
     * @param string $extension
     * @return array
     */
    private function _diagnose($path, $baseclass, $extension)
    {
    	global $default;

    	$diagnoses = array();
    	$dir = opendir($path);
    	$extlen = - strlen($extension);
		while (($file = readdir($dir)) !== false)
		{
			if (substr($file,$extlen) != $extension)
			{
				$default->log->error("diagnose: '$file' does not have extension '$extension'.");
				continue;
			}

			require_once($path . '/' . $file);

			$class = substr($file, 0, -8);
			if (!class_exists($class))
			{
				$default->log->error("diagnose: class '$class' does not exist.");
				continue;
			}

			$extractor = new $class();
			if (!is_a($extractor, $baseclass))
			{
				$default->log->error("diagnose(): '$class' is not of type DocumentExtractor");
				continue;
			}

			$types = $extractor->getSupportedMimeTypes();
			if (empty($types))
			{
				if ($this->debug) $default->log->debug("diagnose: class '$class' does not support any types.");
				continue;
			}

			$diagnosis=$extractor->diagnose();
			if (empty($diagnosis))
			{
				continue;
			}
			$diagnoses[$class] = array(
			'name'=>$extractor->getDisplayName(),
			'diagnosis'=>$diagnosis
			);

        }
        closedir($dir);

        return $diagnoses;
    }


    /**
     * Register the extractor types.
     *
     * @param boolean $clear. Optional. Defaults to false.
     */
    public function registerTypes($clear=false)
    {
    	if ($clear)
    	{
    		$this->clearExtractors();
    	}
    	$dir = opendir($this->extractorPath);
		while (($file = readdir($dir)) !== false)
		{
			if (substr($file,-17) == 'Extractor.inc.php')
			{
				require_once($this->extractorPath . '/' . $file);
				$class = substr($file, 0, -8);

				if (class_exists($class))
				{
					continue;
				}

				$extractor = new $class;
				if (!($class instanceof DocumentExtractor))
				{
					continue;
				}

				$extractor->registerMimeTypes();
			}
        }
        closedir($dir);
    }

    /**
     * This is used as a possible obtimisation effort. It may be overridden in that case.
     *
     * @param int $docId
     * @param string $textFile
     */
    protected function indexDocumentAndDiscussion($docId, $textFile, $title='')
    {
    	$this->indexDocument($docId, $textFile, $title);
    	$this->indexDiscussion($docId);
    }

    /**
     * Remove the document from the queue. This is normally called when it has been processed.
     *
     * @param int $docid
     */
    public static function unqueueDocument($docid)
    {
    	$sql = "DELETE FROM index_files WHERE document_id=$docid";
        DBUtil::runQuery($sql);
    }

    /**
     * Run a query on the index.
     *
     * @param string $query
     * @return array
     */
    public abstract function query($query);

	/**
	 * Converts an integer to a string that can be easily compared and reversed.
	 *
	 * @param int $int
	 * @return string
	 */
	public static function longToString($int)
    {
    	$maxlen = 14;

        $a2z = array('a','b','c','d','e','f','g','h','i','j');
        $o29 = array('0','1','2','3','4','5','6','7','8','9');
        $l = str_pad('',$maxlen - strlen("$int"),'0') . $int;

        return str_replace($o29,  $a2z, $l);
    }

    /**
     * Converts a string to an integer.
     *
     * @param string $str
     * @return int
     */
	public static function stringToLong($str)
    {
        $a2z = array('a','b','c','d','e','f','g','h','i','j');
        $o29 = array('0','1','2','3','4','5','6','7','8','9');

        $int = str_replace($a2z, $o29, $str) + 0;

        return $int;
    }

    /**
     * Possibly we can optimise indexes. This method must be overriden.
     *
     */
    public function optimise()
    {
    	// do nothing
    }
}

?>