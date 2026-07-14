<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Font 12px nawigacji, marginesy mobile przeniesione do motywu.
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_6($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    return $module->clearCache();
}
