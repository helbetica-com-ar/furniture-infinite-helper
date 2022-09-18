<?php

if (false === get_option('my_option') && false === update_option('my_option', false)){
    add_option('my_option','a value to add', '', 'yes'); // autoload true 
} 