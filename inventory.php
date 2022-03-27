<?php

foreach (glob('classes/' . "*.php") as $file)
{
    include_once $file;
}

User::check_page();

?>
