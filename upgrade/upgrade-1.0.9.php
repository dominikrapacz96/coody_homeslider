<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Białe slajdy 2+ (konflikt Bootstrap .carousel-item), lazy load Owl, fix upgrade PHP 8.1+.
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_9($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    return $module->clearCache();
}
