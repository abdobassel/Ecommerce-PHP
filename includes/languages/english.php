<?php
function lang($phrase)
{
    static $lang = array(
        // home page words
        'Admin_Home' => 'Home',
        'Catego' => 'Categories',
        'Edit' => 'Settings',
        'Members' => 'Members',
        "Items" => 'Items',
        'comnt' => 'Comments',
        'Statis' => 'Statistics',
        'Brand' => 'Bassel&Dev; ',


        // settings words
    );

    return $lang[$phrase];
}

//echo lang('ADMIN');
