<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Fix parent tab AdminCoody: empty icon so new-theme BO shows Coody submenu.
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_10($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    return $module->ensureAdminCoodyParentTab();
}
