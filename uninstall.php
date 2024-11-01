<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ))
    exit();

function mo_azos_uninstall(){
    delete_option('mo_azos_application_config');
}