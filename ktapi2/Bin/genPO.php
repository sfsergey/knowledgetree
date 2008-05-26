<?php

require_once('../KTapi.inc.php');
// TODO: generate po file for library

class POGenerator
{
    private $tokens;

    public
    function __construct()
    {
        $this->tokens = array();
    }

    private static
    function extractString($startChar, $subject)
    {
        $startPos = strpos($subject, $startChar) + 1;
        $done = false;
        $nextPos = $startPos;
        $oppositeChar = ($startChar == '\'')?'"':'\'';

        while (!$done)
        {
            $endPos = strpos($subject, $startChar, $nextPos);
            if ($endPos === false)
            {
                return false;
            }
            if ($subject[$endPos-1] == '\\')
            {
                $nextPos = $endPos + 1;
                continue;
            }
            $done = true;
        }
        $str = substr($subject, $startPos, $endPos - $startPos);

        //if ($startChar == '"') $str = addcslashes($str, $startChar);

        return $str;
    }

    private static
    function extractStartChar($subject)
    {
        $singleQuote = strpos($subject, '\'');
        $doubleQuote = strpos($subject, '"');
        if ($singleQuote !== false && $doubleQuote === false)
        {
            return '\'';
        }

        if ($doubleQuote !== false && $singleQuote === false)
        {
            return '"';
        }

        return ($doubleQuote < $singleQuote)?'"':'\'';
    }

    private
    function extractPO($filename)
    {
        $translate = array();

        $content = file_get_contents($filename);

        preg_match_all('/_kt\s*\(\s*[^)]*\s*\)/', $content, $matches);

        foreach($matches[0] as $item)
        {
            $translate[] = $item;
        }

        foreach($translate as $k=>$item)
        {
            $char = self::extractStartChar($item);
            $translate[$k] = self::extractString($char, $item);
        }
        foreach($translate as $item)
        {
            if ($item === false)
            {
                continue;
            }
            $this->tokens[$item][] = $filename;
        }
    }

    public
    function scanDirectory($path)
    {
        if (!is_dir($path))
        {
            throw new Exception(_kt('Expected directory, but was provided with: %s', $path));
        }

        if (substr($path,-1) != '/')
        {
            $path .= '/';
        }

        $dh = opendir($path);
        while ($name = readdir($dh))
        {
            if (strpos($name, '.') === 0)
            {
                continue;
            }

            $fullName = $path . $name;
            if (is_dir($fullName))
            {
                $this->scanDirectory($fullName);
            }
            else
            {
                $this->extractPO($fullName);
            }
        }
        closedir($dh);
    }

    public
    function createCfile($Cfile=null)
    {
        $txt = '';
        foreach($this->tokens as $token=>$filenames)
        {

            foreach($filenames as $filename)
            {
                $filename = substr($filename, strlen(KTAPI2_DIR));
                $txt .= "/* $filename */\n";
            }
            //$token = addcslashes($token,'"');
            $txt .= "gettext(\"$token\")\n\n";
        }
        if (is_null($Cfile))
        {
            print $txt;
        }
        else
        {
            file_put_contents($Cfile, $txt);
        }
    }

    public
    function createPOfile($POfile=null)
    {
        $txt = '';
        $txt .= "Project-Id-Version: KnowledgeTree English Auto Generation\n";
        $txt .= "Report-Msgid-Bugs-To: support@knowledgetree.com\n";
        $txt .= "POT-Creation-Date: " . date('Y-m-d H:i:s'). "\n";
        $txt .= "PO-Revision-Date: " . date('Y-m-d H:i:s'). "\n";
        $txt .= "Last-Translator: Translation Team <translations@knowledgetree.com>\n";
        $txt .= "Language-Team: Translation Team <translations@knowledgetree.com>\n";
        $txt .= "MIME-Version: 1.0\n";
        $txt .= "Content-Type: text/plain; charset=CHARSET\n";
        $txt .= "Content-Transfer-Encoding: 8bit\n\n";

        foreach($this->tokens as $token=>$filenames)
        {

            foreach($filenames as $filename)
            {
                $filename = substr($filename, strlen(KTAPI2_DIR));
                $txt .= "#: $filename\n";
            }
            if (strpos($token,'%') !== false)
            {
                $txt .= "#, php-format\n";
            }

            //$token = addcslashes($token,'"');
            $txt .= "msgid \"$token\"\n";
            $txt .= "msgstr \"\"\n\n";
        }
        if (is_null($POfile))
        {
            print $txt;
        }
        else
        {
            file_put_contents($POfile, $txt);
        }
    }

}

// _kt ("basad's");
// _kt ("basad's %s %s" , 'conrad', 'Vermeulen");
// _kt ( 'basad\'\"','sdfdsf' );
// _kt ('hello %s', 'conrad');
// _kt('\'', sprintf('')));
// _kt("\"\'", sprintf('')));


$gen = new POGenerator();
$gen->scanDirectory(KTAPI2_DIR);
$gen->createPOfile();
$gen->createCfile();

?>