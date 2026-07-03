<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Przeniesienie zakładki slajdów pod grupę „Coody” w menu BO.
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_1($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    if (!$module->ensureAdminCoodyParentTab()) {
        return false;
    }

    $parentId = (int) Tab::getIdFromClassName('AdminCoody');
    $tabId = (int) Tab::getIdFromClassName('AdminCoodyHomeSlider');
    if ($parentId <= 0 || $tabId <= 0) {
        return true;
    }

    return $module->updateSliderTab($tabId, $parentId);
}
