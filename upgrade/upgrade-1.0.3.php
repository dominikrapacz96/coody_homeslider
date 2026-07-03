<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Pozycje slajdów od 0 (BO wyświetla position + 1).
 *
 * @param Coody_Homeslider $module
 */
function upgrade_module_1_0_3($module)
{
    if (!($module instanceof Coody_Homeslider)) {
        return false;
    }

    foreach (Shop::getShops(false, null, true) as $idShop) {
        CoodyHomeSlide::normalizePositions((int) $idShop);
    }

    return $module->clearCache();
}
