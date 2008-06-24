<?php

class Util_Search
{

    public static
    function validateExtractor($extractor)
    {
        return KTapi::validateClass('Search_Indexing_Extractor', $extractor);
    }

}

?>