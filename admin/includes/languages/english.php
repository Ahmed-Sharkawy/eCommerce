<?php
function lang($phrase){
    static $lang = [
        'HOME'          => 'Admin',
        'CATEGORIES'    => 'Sections',
        'ITEMS'         => 'Items',
        'MEMBERS'       => 'Members',
        'STATISTICS'    => 'Statistics',
        'LOGS'          => 'Logs'
    ];
    return $lang[$phrase];
}