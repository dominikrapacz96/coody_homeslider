<?php
/**
 * @author    coody.it
 * @copyright 2026 coody.it
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_ . 'coody_homeslider/classes/CoodyHomeSlide.php';

class AdminCoodyHomeSliderController extends ModuleAdminController
{
    /** @var string */
    private $slideImageDir;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'coody_homeslider_slide';
        $this->className = 'CoodyHomeSlide';
        $this->lang = true;
        $this->identifier = 'id_coody_homeslider_slide';
        $this->_defaultOrderBy = 'position';
        $this->_defaultOrderWay = 'ASC';
        $this->position_identifier = 'id_coody_homeslider_slide';
        $this->slideImageDir = _PS_MODULE_DIR_ . 'coody_homeslider/img/';

        parent::__construct();

        // Must be set after parent::__construct() — AdminController overwrites tpl_folder from controller name.
        $this->tpl_folder = '_configure/';
    }

    public function initProcess()
    {
        parent::initProcess();

        if (isset($_GET['duplicate' . $this->table]) && (int) Tools::getValue($this->identifier) > 0) {
            if ($this->access('add')) {
                $this->action = 'duplicate';
            } else {
                $this->errors[] = $this->trans('You do not have permission to add this.', [], 'Admin.Notifications.Error');
            }
        }
    }

    public function processDuplicate()
    {
        $idSlide = (int) Tools::getValue($this->identifier);
        $source = new CoodyHomeSlide($idSlide);

        if (!Validate::isLoadedObject($source)) {
            $this->errors[] = $this->trans('An error occurred while loading the object.', [], 'Admin.Notifications.Error');

            return false;
        }

        $duplicate = new CoodyHomeSlide();
        $duplicate->active = (bool) $source->active;
        $duplicate->position = 0;

        foreach (Language::getLanguages(false) as $language) {
            $idLang = (int) $language['id_lang'];

            foreach (['title', 'description', 'url', 'legend', 'image', 'image_mobile'] as $field) {
                $values = $source->{$field};
                if (is_array($values) && isset($values[$idLang])) {
                    if (!is_array($duplicate->{$field})) {
                        $duplicate->{$field} = [];
                    }
                    $duplicate->{$field}[$idLang] = $values[$idLang];
                }
            }
        }

        if (!$duplicate->add()) {
            $this->errors[] = $this->trans('An error occurred while creating an object.', [], 'Admin.Notifications.Error');

            return false;
        }

        if (isset($this->module) && $this->module instanceof Coody_Homeslider) {
            $this->module->clearCache();
        }

        $this->redirect_after = self::$currentIndex . '&conf=19&token=' . $this->token;

        return $duplicate;
    }

    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('duplicate');
        $this->addRowAction('delete');

        $this->fields_list = [
            'id_coody_homeslider_slide' => [
                'title' => $this->module->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
            'image' => [
                'title' => $this->module->l('Obraz'),
                'align' => 'center',
                'callback' => 'displaySlideThumbnail',
                'orderby' => false,
                'filter' => false,
                'search' => false,
            ],
            'title' => [
                'title' => $this->module->l('Nazwa'),
            ],
            'position' => [
                'title' => $this->module->l('Pozycja'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
                'position' => 'position',
            ],
            'active' => [
                'title' => $this->module->l('Aktywny'),
                'active' => 'status',
                'type' => 'bool',
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
        ];

        return parent::renderList();
    }

    public function displaySlideThumbnail(string $value): string
    {
        if ($value === '') {
            return '-';
        }

        $url = __PS_BASE_URI__ . 'modules/coody_homeslider/img/' . rawurlencode($value);

        return '<img src="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" alt="" class="img-thumbnail" style="max-width:90px;height:auto;" />';
    }

    public function getTemplateFormVars()
    {
        return array_merge(parent::getTemplateFormVars(), [
            'image_baseurl' => __PS_BASE_URI__ . 'modules/coody_homeslider/img/',
        ]);
    }

    public function renderForm()
    {
        if ($this->object && Validate::isLoadedObject($this->object)) {
            $this->fields_value['image'] = $this->object->image;
            $this->fields_value['image_mobile'] = $this->object->image_mobile;
        }

        $this->fields_form = [
            'legend' => [
                'title' => $this->module->l('Slajd'),
                'icon' => 'icon-picture',
            ],
            'input' => [
                [
                    'type' => 'switch',
                    'label' => $this->module->l('Aktywny'),
                    'name' => 'active',
                    'is_bool' => true,
                    'values' => [
                        ['id' => 'active_on', 'value' => 1, 'label' => $this->module->l('Tak')],
                        ['id' => 'active_off', 'value' => 0, 'label' => $this->module->l('Nie')],
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => $this->module->l('Nazwa slajdu'),
                    'name' => 'title',
                    'lang' => true,
                ],
                [
                    'type' => 'textarea',
                    'label' => $this->module->l('Opis'),
                    'name' => 'description',
                    'lang' => true,
                    'autoload_rte' => true,
                    'rows' => 5,
                ],
                [
                    'type' => 'text',
                    'label' => $this->module->l('Link'),
                    'name' => 'url',
                    'lang' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->module->l('Tekst alternatywny (alt)'),
                    'name' => 'legend',
                    'lang' => true,
                ],
                [
                    'type' => 'file_lang',
                    'label' => $this->module->l('Obraz (desktop)'),
                    'name' => 'image',
                    'lang' => true,
                    'desc' => $this->module->l('Zalecane: szeroki baner na desktop.'),
                ],
                [
                    'type' => 'file_lang',
                    'label' => $this->module->l('Obraz (mobile)'),
                    'name' => 'image_mobile',
                    'lang' => true,
                    'desc' => $this->module->l('Opcjonalnie. Jeśli puste — na mobile użyty zostanie obraz desktop.'),
                ],
            ],
            'images' => [
                'image' => (is_object($this->object) && is_array($this->object->image)) ? $this->object->image : [],
                'image_mobile' => (is_object($this->object) && is_array($this->object->image_mobile)) ? $this->object->image_mobile : [],
            ],
            'submit' => [
                'title' => $this->module->l('Zapisz'),
            ],
        ];

        return parent::renderForm();
    }

    protected function copyFromPost(&$object, $table)
    {
        if (Validate::isLoadedObject($object) && (int) $object->id > 0) {
            $existing = new CoodyHomeSlide((int) $object->id);
            if (Validate::isLoadedObject($existing)) {
                $object->image = $existing->image;
                $object->image_mobile = $existing->image_mobile;
            }
        }

        parent::copyFromPost($object, $table);

        foreach (Language::getLanguages(false) as $language) {
            $idLang = (int) $language['id_lang'];

            foreach (['image', 'image_mobile'] as $field) {
                $oldValue = Tools::getValue($field . '_old_' . $idLang);
                if ($oldValue !== '' && Validate::isFileName($oldValue)) {
                    if (!is_array($object->{$field})) {
                        $object->{$field} = [];
                    }
                    $object->{$field}[$idLang] = $oldValue;
                }
            }
        }
    }

    protected function postImage($id)
    {
        $object = new CoodyHomeSlide((int) $id);
        if (!Validate::isLoadedObject($object)) {
            $this->errors[] = $this->trans('Unable to load object.', [], 'Admin.Notifications.Error');

            return false;
        }

        $hasUpload = false;

        foreach (Language::getLanguages(false) as $language) {
            $idLang = (int) $language['id_lang'];

            foreach (['image', 'image_mobile'] as $field) {
                $fileKey = $field . '_' . $idLang;

                if (!isset($_FILES[$fileKey]) || empty($_FILES[$fileKey]['tmp_name'])) {
                    continue;
                }

                $filename = $this->uploadSlideImage($_FILES[$fileKey]);
                if ($filename === false) {
                    return false;
                }

                if (!is_array($object->{$field})) {
                    $object->{$field} = [];
                }

                $this->deleteSlideImageFile($object->{$field}[$idLang] ?? '');
                $object->{$field}[$idLang] = $filename;
                $hasUpload = true;
            }
        }

        if ($hasUpload && !$object->update()) {
            $this->errors[] = $this->trans('An error occurred while updating an object.', [], 'Admin.Notifications.Error');

            return false;
        }

        return !count($this->errors);
    }

  /**
     * @param array<string, mixed> $file
     */
    private function uploadSlideImage(array $file): string|false
    {
        if ($error = ImageManager::validateUpload($file, Tools::getMaxUploadSize())) {
            $this->errors[] = $error;

            return false;
        }

        $extension = strtolower((string) pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($extension, $allowed, true)) {
            $this->errors[] = $this->trans('Invalid image format.', [], 'Admin.Notifications.Error');

            return false;
        }

        if (!is_dir($this->slideImageDir) && !@mkdir($this->slideImageDir, 0755, true) && !is_dir($this->slideImageDir)) {
            $this->errors[] = $this->trans('An error occurred while uploading the image.', [], 'Admin.Notifications.Error');

            return false;
        }

        $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '-', basename((string) $file['name']));
        $destName = sha1(uniqid((string) mt_rand(), true)) . '_' . $safeName;
        $destPath = $this->slideImageDir . $destName;

        $tempName = tempnam(_PS_TMP_IMG_DIR_, 'PS');
        if (!$tempName || !move_uploaded_file($file['tmp_name'], $tempName)) {
            $this->errors[] = $this->trans('An error occurred while uploading the image.', [], 'Admin.Notifications.Error');

            return false;
        }

        if (!ImageManager::resize($tempName, $destPath)) {
            @unlink($tempName);
            $this->errors[] = $this->trans('An error occurred while uploading the image.', [], 'Admin.Notifications.Error');

            return false;
        }

        @unlink($tempName);

        return $destName;
    }

    private function deleteSlideImageFile(string $filename): void
    {
        if ($filename === '' || !Validate::isFileName($filename)) {
            return;
        }

        $path = $this->slideImageDir . $filename;
        if (is_file($path)) {
            @unlink($path);
        }
    }

    public function postProcess()
    {
        parent::postProcess();

        if (Tools::isSubmit('submitAdd' . $this->table) || Tools::isSubmit('submitUpdate' . $this->table)) {
            if (isset($this->module) && $this->module instanceof Coody_Homeslider) {
                $this->module->clearCache();
            }
        }
    }

    public function processDelete()
    {
        $result = parent::processDelete();

        if ($result && isset($this->module) && $this->module instanceof Coody_Homeslider) {
            $this->module->clearCache();
        }

        return $result;
    }

    public function ajaxProcessUpdatePositions()
    {
        $positions = Tools::getValue('coody_homeslider_slide');
        if (!is_array($positions)) {
            $this->ajaxRender(json_encode(['hasError' => true]));

            return;
        }

        foreach ($positions as $position => $idSlide) {
            Db::getInstance()->update(
                'coody_homeslider_slide',
                ['position' => (int) $position],
                'id_coody_homeslider_slide = ' . (int) $idSlide
            );
        }

        if (isset($this->module) && $this->module instanceof Coody_Homeslider) {
            $this->module->clearCache();
        }

        $this->ajaxRender(json_encode(['hasError' => false]));
    }
}
