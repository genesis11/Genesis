<?php

class Genesis_Install_Controller
{

    public static function install($previous)
    {
        $db = XenForo_Application::getDb();

        if (XenForo_Application::$versionId < 1020070) {
            // note: this can't be phrased
            throw new XenForo_Exception('This add-on requires XenForo 1.2.0 or higher.', true);
        }

        if (!$previous) {
            /* @var $addOnModel XenForo_Model_AddOn */
            $addOnModel = XenForo_Model::create('XenForo_Model_AddOn');

            $addOns = $addOnModel->getAllAddOns();

            if (!empty($addOns['Waindigo_Appearance'])) {
                $dw = XenForo_DataWriter::create('XenForo_DataWriter_AddOn');
                $dw->setExistingData($addOns['Waindigo_Appearance']);
                $dw->delete();
            }

            if (!empty($addOns['Waindigo_Genesis'])) {
                $dw = XenForo_DataWriter::create('XenForo_DataWriter_AddOn');
                $dw->setExistingData($addOns['Waindigo_Genesis']);
                $dw->delete();
            }

            if (!empty($addOns['Waindigo_LastPostAvatar'])) {
                $dw = XenForo_DataWriter::create('XenForo_DataWriter_AddOn');
                $dw->setExistingData($addOns['Waindigo_LastPostAvatar']);
                $dw->delete();
            }

            if (!empty($addOns['Waindigo_TemplateMods'])) {
                $dw = XenForo_DataWriter::create('XenForo_DataWriter_AddOn');
                $dw->setExistingData($addOns['Waindigo_TemplateMods']);
                $dw->delete();
            }
        }
    }
}