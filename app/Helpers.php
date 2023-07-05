<?php


function getUserPermissions(){
    return  auth('web')->user()->getPermissionsViaRoles()->pluck('name');
}
