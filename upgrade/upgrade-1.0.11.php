<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * CTA button fields on slides: button_title, button_link.
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_11($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    return $module->ensureButtonFields();
}
