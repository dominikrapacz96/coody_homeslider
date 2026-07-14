<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Samodzielny moduł: Owl Carousel, displayWrapperTop, pełna szerokość bez motywu.
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_4($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    return $module->ensureFrontHooks() && $module->clearCache();
}
