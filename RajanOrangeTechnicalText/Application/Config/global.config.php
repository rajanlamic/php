<?php

return array(
    'services' => array(
        'socialsecurity' => array(
            'url' => 'http://www.socialsecurity.gov/',
            'methods' => array(
                'getPolularity' => array(
                  'namespace' => 'cgi-bin/popularnames.cgi'  
                ),
            ),
        )
    ),
);