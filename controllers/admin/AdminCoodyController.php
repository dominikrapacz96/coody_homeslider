<?php

/**
 * Parent tab for Coody modules (fallback when ds_checkout is not installed).
 */
class AdminCoodyController extends ModuleAdminController
{
    public function init()
    {
        $candidates = ['AdminDsCheckout', 'AdminCoodyHomeSlider'];

        foreach ($candidates as $className) {
            $tabId = (int) Tab::getIdFromClassName($className);
            if ($tabId <= 0) {
                continue;
            }

            $token = Tools::getAdminToken($className . $tabId . (int) $this->context->employee->id);
            Tools::redirectAdmin('index.php?controller=' . $className . '&token=' . $token);
        }

        parent::init();
    }
}
