<?php

class TestLanguage extends Language
{
   /* $this->registerI18nLang('knowledgeTree', "fr_FR", 'translations/');
				            $this->registerLanguage("fr_FR", "Français");
				            */

    public
    function __construct()
    {
        parent::__construct('fr_FR', 'Français', 'TestLanguage.po'); // lang, name, path to po
    }

}

?>