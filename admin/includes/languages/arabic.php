<?php
function lang($phrase)
{
    static $lang = [
        'MESSAGE' => 'اهلا',
        'admin' => 'ادمن'
    ];
    return $lang[$phrase];
}
