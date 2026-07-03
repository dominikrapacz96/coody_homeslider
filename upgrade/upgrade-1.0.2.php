<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Naprawa wyświetlania slidera na stronie głównej (hook displayHomeSliders).
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_2($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    return $module->ensureFrontHooks() && $module->clearCache();
}
