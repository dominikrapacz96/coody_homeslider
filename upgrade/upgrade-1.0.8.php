<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_8($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    return $module->clearCache();
}
