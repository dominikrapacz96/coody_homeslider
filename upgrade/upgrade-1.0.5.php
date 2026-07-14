<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Fix nawigacji i overflow na domyślnych motywach.
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_5($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    return $module->clearCache();
}
