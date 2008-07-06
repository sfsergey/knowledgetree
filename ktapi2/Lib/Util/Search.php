<?php

class SearchUtil
{

    public static
    function validateExtractor($extractor)
    {
        return KTapi::validateClass('Search_Indexing_Extractor', $extractor);
    }

}

?>