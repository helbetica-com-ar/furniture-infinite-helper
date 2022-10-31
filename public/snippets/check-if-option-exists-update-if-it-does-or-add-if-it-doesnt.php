<?php

if (get_option('some_option')) {
    update_option('some_option', 'value_we_want_to_add');
} else {
    add_option('some_option', 'value_we_want_to_add');
}