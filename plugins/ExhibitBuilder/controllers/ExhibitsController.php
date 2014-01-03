<?php

/**
 * ExhibitController class
 * 
 * @version $Id$
 * @copyright Center for History and New Media, 2007-20009
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 * @author CHNM
 * */
require_once 'Exhibit.php';

class ExhibitBuilder_ExhibitsController extends Omeka_Controller_Action {

    protected $session;

    public function init() {
        if (version_compare(OMEKA_VERSION, '2.0-dev', '>=')) {
            $this->_helper->db->setDefaultModelName('Exhibit');
        } else {
            $this->_modelClass = 'Exhibit';
        }
        $this->_browseRecordsPerPage = 10;

        require_once 'Zend/Session.php';
        $this->session = new Zend_Session_Namespace('Exhibit');
        require_once 'Omeka/Core.php';
        $core = new Omeka_Core;

        try {
            $db = $core->getDb();

            //Force the Zend_Db to make the connection and catch connection errors
            try {
                $mysqli = $db->getConnection()->getConnection();
            } catch (Exception $e) {
                throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
            }
        } catch (Exception $e) {
            die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
        }
        $metadataFile = CONFIG_DIR . '/metadata.ini';
        if (!file_exists($metadataFile)) {
            throw new Zend_Config_Exception('Your Omeka metadata file is missing.');
        }        
        //$metadataFile =Zend_Config_Ini($metadataFile, NULL);
        $metadataFile = parse_ini_file($metadataFile,true);
        Zend_Registry::set('metadataFile', $metadataFile);
        $this->view->assign(compact('metadataFile'));
        Zend_Registry::set('db', $db);
    }

    public function browseAction() {
        $request = $this->getRequest();
        $sortParam = $request->getParam('sort');
        $sortOptionValue = get_option('exhibit_builder_sort_browse');

        if (!isset($sortParam)) {
            switch ($sortOptionValue) {
                case 'alpha':
                    $request->setParam('sort', 'alpha');
                    break;
                case 'recent':
                    $request->setParam('sort', 'recent');
                    break;
            }
        }
        $user = current_user(); //print_r($user);
        //custom code for loop all exhibits that are public
        $menuexhibits = exhibit_builder_get_exhibits(array('public' => '1', 'sort' => 'recent'));
        $this->view->assign(compact('menuexhibits'));


        //custom code for natural europe
        if (empty($this->_modelClass)) {
            throw new Exception('Scaffolding class has not been specified');
        }

        $pluralName = $this->getPluralized();

        $params = $this->_getAllParams();
        $user = current_user(); //print_r($user);
        // Add users to bring their exhibits
        if ($user['id'] != 1 and $user['role'] != 'super') {
            $params['user'] = $user['entity_id'];
            // get acl file properties
            $acl = get_acl();
            //if user can edit same institution exhibits
            $canEditSameInstitution = $acl->isAllowed($user, 'ExhibitBuilder_Exhibits', 'editSameInstitution');
            $sameinstitution = 0;
              if ($canEditSameInstitution && strlen($user['institution']) > 0 && isset($user['institution'])) {
                 $sqlWhereClause = "institution='" . $user['institution'] . "'";
                 $tusers = get_db()->getTable('User')->findBySql($sqlWhereClause);
                     foreach ($tusers as $tusers) {
                         $params['user'] .= ','.$tusers['entity_id'];
                     }
              }
        }

        
        $recordsPerPage = $this->_getBrowseRecordsPerPage();
        $currentPage = $this->_getBrowseRecordsPage();

        $table = $this->getTable($this->_modelClass);
        
        $params['sort'] = 'alpha';
        $records = $table->findBy($params, $recordsPerPage, $currentPage);

        // print_r($records);
//        $user = current_user();
//        $totalrecordsq = $table->findAll();
//        $count = 0;
//        foreach ($totalrecordsq as $keytotal => $totalrecord): //echo $record['id']."<br>";
//            if ($user['id'] == 1 or $user['role'] == 'super' or $totalrecord->wasAddedBy(current_user()) or sameinstitutionexhibit($totalrecord, $user)) {
//                $count+=1;
//            }
//        endforeach;

//        if ($user['id'] != 1 or $user['role'] != 'super') {
//            $totalRecords = $count;
//        } else {

            $totalRecords = $table->count($params);
//        }

        Zend_Registry::set($pluralName, $records);

        // Fire the plugin hook
        fire_plugin_hook('browse_' . strtolower(ucwords($pluralName)), $records);

        // If we are using the pagination, we'll need to set some info in the
        // registry.
        if ($recordsPerPage) {
            $pagination = array('page' => $currentPage,
                'per_page' => $recordsPerPage,
                'total_results' => $totalRecords);
            Zend_Registry::set('pagination', $pagination);
        }

        $this->view->assign(array($pluralName => $records,
            'total_records' => $totalRecords,
            'totalRecordsq' => $totalRecordsq));

        // old code which call browse action at omeka/controller/action parent::browseAction();
    }
    
    protected function _findByExhibitSlug($exhibitSlug = null) {
        if (!$exhibitSlug) {
            $exhibitSlug = $this->_getParam('slug');
        }
        $exhibit = $this->getTable('Exhibit')->findBySlug($exhibitSlug);
        return $exhibit;
    }

    public function tagsAction() {
        $params = array_merge($this->_getAllParams(), array('type' => 'Exhibit'));
        $tags = $this->getTable('Tag')->findBy($params);
        $this->view->assign(compact('tags'));
    }

    public function showitemAction() {
        $itemId = $this->_getParam('item_id');
        $item = $this->findById($itemId, 'Item');

        $exhibit = $this->_findByExhibitSlug();
        if (!$exhibit) {
            return $this->errorAction();
        }

        $sectionSlug = $this->_getParam('section_slug');
        $exhibitSection = $exhibit->getSectionBySlug($sectionSlug);

        if ($item && $exhibit->hasItem($item)) {

            //Plugin hooks
            fire_plugin_hook('show_exhibit_item', $item, $exhibit);

            return $this->renderExhibit(compact('exhibit', 'exhibitSection', 'item'), 'item');
        } else {
            $this->flash('This item is not used within this exhibit.');
            $this->redirect->gotoUrl('403');
        }
    }

    /**
     * 
     * @return void
     * */
    public function itemsAction() {
        $user = current_user();
        $results = $this->_helper->searchItems(array('search' => 'advanced', 'public' => '1', 'type' => '6', 'user' => '' . $user['id'] . ''));

        // Build the pagination.
        $pagination = array(
            'per_page' => $results['per_page'],
            'page' => $results['page'],
            'total_results' => $results['total_results']);
        Zend_Registry::set('pagination', $pagination);

        $this->view->items = $results['items'];
    }
     public function items2Action() {
        $user = current_user();
        $results = $this->_helper->searchItems(array('search' => 'advanced', 'public' => '1', 'user' => '' . $user['id'] . ''));

        // Build the pagination.
        $pagination = array(
            'per_page' => $results['per_page'],
            'page' => $results['page'],
            'total_results' => $results['total_results']);
        Zend_Registry::set('pagination', $pagination);

        $this->view->items = $results['items'];
    }

    public function supportingAction() {
        $user = current_user();
        $results = $this->_helper->searchItems(array('search' => 'advanced', 'user' => '' . $user['id'] . ''));

        // Build the pagination.
        $pagination = array(
            'per_page' => $results['per_page'],
            'page' => $results['page'],
            'total_results' => $results['total_results']);
        Zend_Registry::set('pagination', $pagination);

        $this->view->items = $results['items'];
    }

    public function itemContainerAction() {
        $itemId = (int) $this->_getParam('item_id');
        $orderOnForm = (int) $this->_getParam('order_on_form');
        $item = get_db()->getTable('Item')->find($itemId);
        $this->view->item = $item;
        $this->view->orderOnForm = $orderOnForm;
    }

    public function showAction() { 
        $exhibit = $this->_findByExhibitSlug();
        if (!$exhibit) {
            $this->errorAction();
        }

        $sectionSlug = $this->_getParam('section_slug');
        $exhibitSection = $exhibit->getSectionBySlug($sectionSlug);

        if ($exhibitSection) {
            $pageSlug = $this->_getParam('page_slug');
            $exhibitPage = $exhibitSection->getPageBySlug($pageSlug);
            if (!$exhibitPage) {
                if ($pageSlug == '') {
                    $exhibitPage = $exhibitSection->getPageByOrder(1);
                }
            }
            if (!$exhibitPage) {
                $this->errorAction();
            }
        } else {
            $this->errorAction();
        }

        fire_plugin_hook('show_exhibit', $exhibit, $exhibitSection, $exhibitPage);

        $this->renderExhibit(compact('exhibit', 'exhibitSection', 'exhibitPage'));
    }

    public function summaryAction() {
        $exhibit = $this->_findByExhibitSlug();
        if (!$exhibit) {
            $this->errorAction();
        }

        fire_plugin_hook('show_exhibit', $exhibit);
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->renderExhibit(compact('exhibit'), 'summary');
    }
    //Add printing functionality
    public function pdfexportAction() {
        $_GET['slug']=$_GET['slug'];
        $exhibit = $this->_findByExhibitSlug($_GET['slug']);
        if (!$exhibit) {
            $this->errorAction();
        }
        
        fire_plugin_hook('show_exhibit', $exhibit);

        $this->getResponse()->setHeader('Content-type', 'application/pdf', true);

        $this->renderExhibit(compact('exhibit'), 'print');
        

    }

    /**
     * Figure out how to render the exhibit.  
     * 1) the view needs access to the shared directories
     * 2) if the exhibit has an associated theme, render the pages for that specific exhibit theme, 
     *      otherwise display the generic theme pages in the main public theme
     * 
     * @return void
     * */
    protected function renderExhibit($vars, $toRender = 'show') {
        extract($vars);
        $this->view->assign($vars);

        /* If we don't pass a valid value to $toRender, thow an exception. */
        if (!in_array($toRender, array('show', 'summary', 'item', 'print'))) {
            throw new Exception('You gotta render some stuff because whatever!');
        }
        return $this->render($toRender);
    }

    public function addAction() {
        $exhibit = new Exhibit;
        require_once 'Omeka/Core.php';
        $core = new Omeka_Core;

        try {
            $db = $core->getDb();

            //Force the Zend_Db to make the connection and catch connection errors
            try {
                $mysqli = $db->getConnection()->getConnection();
            } catch (Exception $e) {
                throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
            }
        } catch (Exception $e) {
            die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
        }
        Zend_Registry::set('db', $db);
        return $this->processExhibitForm($exhibit, 'Add');
    }

    public function bypassAction() {

        $lastexid = bypass($lastexid);
        $this->redirect->goto('edit', null, null, array('id' => $lastexid));
    }

    public function teasersAction() {

        $this->render('teasers');
    }

    public function deleteelementvalueAction() {

        //$lastexid=bypass($lastexid);
        $this->render('deletefromelementvalue');
    }

    public function childsfromparentelementAction() {
        require_once 'Omeka/Core.php';
        $core = new Omeka_Core;

        try {
            $db = $core->getDb();

            //Force the Zend_Db to make the connection and catch connection errors
            try {
                $mysqli = $db->getConnection()->getConnection();
            } catch (Exception $e) {
                throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
            }
        } catch (Exception $e) {
            die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
        }
        //$lastexid=bypass($lastexid);
        libxml_use_internal_errors(false);
        $metadataFile= Zend_Registry::get('metadataFile');
        $uri = WEB_ROOT;
        $xml_general = array();
        $execvocele2_general = $db->query("SELECT DISTINCT d.vocabulary_id FROM metadata_element d JOIN  metadata_element_hierarchy e ON d.id = e.element_id WHERE e.datatype_id=? and e.is_visible=? and d.schema_id=?", array(5,1,$metadataFile[metadata_schema_resources][id]));
        $datavocele2 = $execvocele2_general->fetchAll();
        $execvocele2_general = NULL;
        $sqlvocelem = "SELECT e.value,d.id FROM metadata_vocabulary d JOIN metadata_vocabulary_record e ON d.id = e.vocabulary_id LEFT JOIN
					metadata_vocabulary_value f ON f.vocabulary_rid = e.id WHERE d.id=?";
        foreach ($datavocele2 as $datavocele2) {
        $execvocele = $db->query($sqlvocelem, array($datavocele2['vocabulary_id']));
        $datavocele = $execvocele->fetch();
        $execvocele = NULL;

            $xmlvoc = '' . $uri . '/archive/xmlvoc/' . $datavocele['value'] . '.xml';
            // $xmlvoc='http://aglr.agroknow.gr/organic-edunet/archive/xmlvoc/new_oe_ontology_hierrarchy.xml';
            $reader = new XMLReader();
            $reader->open($xmlvoc, 'urf8');
            $xml = parse_ontologies($reader);


            //$xml_general = array(''.$datavocele['id'].''=>@simplexml_load_file($xmlvoc, NULL, LIBXML_NOERROR | LIBXML_NOWARNING));
            $xml_general[$datavocele['id']] =  $xml;
        }
        $this->view->assign(compact('xml_general'));
        $this->render('childsfromparentelement');
    }

    public function findvocbyidAction() {

        //$lastexid=bypass($lastexid);
        $this->render('findvocbyid');
    }

    public function xmlselectboxAction() {

        //$lastexid=bypass($lastexid);
        $this->render('xmlselectbox');
    }

    public function parsinglomAction() {

        //$lastexid=bypass($lastexid);
        $this->render('parsinglom');
    }

    public function updatelangstringelementvalueAction() {

        //$lastexid=bypass($lastexid);
        $this->render('updatelangstringelementvalue');
    }

    public function translatexeroxAction() {
        require_once 'Omeka/Core.php';
        $core = new Omeka_Core;

        try {
            $db = $core->getDb();

            //Force the Zend_Db to make the connection and catch connection errors
            try {
                $mysqli = $db->getConnection()->getConnection();
            } catch (Exception $e) {
                throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
            }
        } catch (Exception $e) {
            die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
        }
        Zend_Registry::set('db', $db);
        $_SESSION['get_language_for_internal_xml'] = get_language_for_internal_xml();
        $uri = WEB_ROOT;
        $xml_general = array();
        $execvocele2_general = $db->query("SELECT d.vocabulary_id FROM metadata_element d JOIN  metadata_element_hierarchy e ON d.id = e.element_id WHERE e.datatype_id=5 and e.is_visible=1");
        $datavocele2 = $execvocele2_general->fetchAll();
        $execvocele2_general = NULL;
        foreach ($datavocele2 as $datavocele2) {
            $sqlvocelem = "SELECT e.value,d.id FROM metadata_vocabulary d JOIN metadata_vocabulary_record e ON d.id = e.vocabulary_id JOIN
					metadata_vocabulary_value f ON f.vocabulary_rid = e.id WHERE d.id=" . $datavocele2['vocabulary_id'] . "";
            $execvocele = $db->query($sqlvocelem);
            $datavocele = $execvocele->fetch();
            $execvocele = NULL;
            //$xmlvoc = '' . $uri . '/archive/xmlvoc/' . $datavocele['value'] . '.xml';
            // $xmlvoc='http://aglr.agroknow.gr/organic-edunet/archive/xmlvoc/new_oe_ontology_hierrarchy.xml';
            $reader = new XMLReader();
            $reader->open('' . $uri . '/archive/xmlvoc/' . $datavocele['value'] . '.xml', 'urf8');
            //$xml = parse_ontologies($reader);
            $xml_general[$datavocele['id']] =  parse_ontologies($reader);
            //$reader->close();
        }

        //query for creating general elements pelement=0
        $sql2 = "SELECT * FROM metadata_element_hierarchy WHERE pelement_id=0 and is_visible=1  ORDER BY (case WHEN sequence IS NULL THEN '9999' ELSE sequence END) ASC;";
        $exec3 = $db->query($sql2);
        $general_pelements = $exec3->fetchAll();
        $exec3 = NULL;
        $this->view->assign(compact('general_pelements', 'xml_general', 'db'));

        if (array_key_exists('save_meta', $_POST)) {
            $lastexid = savemetadataitem($_POST);
            //print_r($_POST); 
            //break;
            $this->view->elementSets = $this->_getItemElementSets();
            $varName = strtolower($this->_modelClass);

            $record = $this->findById($lastexid);

            try {
                if ($record->saveForm($_POST)) {
                    $successMessage = $this->_getEditSuccessMessage($record);
                    if ($successMessage != '') {
                        $this->flashSuccess($successMessage);
                    }
                    $this->redirect->goto('edit', null, null, array('id' => $record->id));
                }
            } catch (Omeka_Validator_Exception $e) {
                $this->flashValidationErrors($e);
            }
            $this->view->assign(array($varName => $record));
            //$this->redirect->goto('edit', null, null, array('id' => $lastexid));
            //$this->render('metadataform',$_POST);
        } else {
            //$lastexid=bypass($lastexid);
            $item = $this->findById($_POST['item_id']);
            //print_r($item);
            $this->view->assign(compact('item'));
            $this->render('translatexerox');
        }
    }

    public function metadataformAction() {

        //$lastexid=bypass($lastexid);
        $this->render('metadataform');
    }

    public function editAction() {
        require_once 'Omeka/Core.php';
        $core = new Omeka_Core;

        try {
            $db = $core->getDb();

            //Force the Zend_Db to make the connection and catch connection errors
            try {
                $mysqli = $db->getConnection()->getConnection();
            } catch (Exception $e) {
                throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
            }
        } catch (Exception $e) {
            die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
        }
        Zend_Registry::set('db', $db);
        $exhibit = $this->findById();
        $user = current_user();

        $metadataFile= Zend_Registry::get('metadataFile');
        if (!exhibit_builder_user_can_edit($exhibit)) {
            throw new Omeka_Controller_Exception_403;
        }
        $_SESSION['get_language_for_internal_xml'] = get_language_for_internal_xml();
                    $uri = WEB_ROOT;
                    $xml_general = array();
                    $execvocele2_general = $db->query("SELECT DISTINCT d.vocabulary_id FROM metadata_element d JOIN  metadata_element_hierarchy e ON d.id = e.element_id WHERE e.datatype_id=? and e.is_visible=? and d.schema_id=?", array(5,1,$metadataFile[metadata_schema_resources][id]));
                    $datavocele2 = $execvocele2_general->fetchAll();
                    $execvocele2_general = NULL;
                    $sqlvocelem = "SELECT e.value,d.id FROM metadata_vocabulary d JOIN metadata_vocabulary_record e ON d.id = e.vocabulary_id LEFT JOIN
					metadata_vocabulary_value f ON f.vocabulary_rid = e.id WHERE d.id=?";
                    foreach ($datavocele2 as $datavocele2) {
                        $execvocele = $db->query($sqlvocelem, array($datavocele2['vocabulary_id']));
                        $datavocele = $execvocele->fetch();
                        $execvocele = NULL;
                        //$xmlvoc = '' . $uri . '/archive/xmlvoc/' . $datavocele['value'] . '.xml';
                        // $xmlvoc='http://aglr.agroknow.gr/organic-edunet/archive/xmlvoc/new_oe_ontology_hierrarchy.xml';
                        $reader = new XMLReader();
                        $reader->open('' . $uri . '/archive/xmlvoc/' . $datavocele['value'] . '.xml', 'utf8');
                        //$xml = parse_ontologies($reader);
                        $xml_general[$datavocele['id']] =  parse_ontologies($reader);
                        unset($reader);
                        //$reader->close();
                    }
                    
                    //query for creating general elements pelement=0
                    $values=$metadataFile[metadata_elements_hide_from_pathways][element_hierarchy_pathways_hide];
                    if($values != false){
                        $valuesql= "and a.id NOT IN (".implode(',', $values).") ";
                    }else{$valuesql="";}
                    $sql2 = "SELECT a.* FROM metadata_element_hierarchy a JOIN metadata_element b on b.id=a.element_id WHERE b.schema_id=? and a.pelement_id=? and a.is_visible=? ".$valuesql." ORDER BY (case WHEN a.sequence IS NULL THEN 9999 ELSE a.sequence END) ASC;";
                    $exec3 = $db->query($sql2, array($metadataFile[metadata_schema_resources][id],0,1)); 
                    $general_pelements = $exec3->fetchAll();
                    $exec3 = NULL;
                    $this->view->assign(compact('general_pelements', 'xml_general', 'db'));

        return $this->processExhibitForm($exhibit, 'Edit');
    }

    public function deleteAction() {
        $exhibit = $this->findById();
        if (!exhibit_builder_user_can_delete($exhibit)) {
            throw new Omeka_Controller_Exception_403;
        }


        if (!$this->getRequest()->isPost()) {
            $this->_forward('method-not-allowed', 'error', 'default');
            return;
        }

        $record = $this->findById();

        $form = $this->_getDeleteForm();

        if ($form->isValid($_POST)) {
            $record->delete();
            deleteexhibit($exhibit['id']);
        } else {
            $this->_forward('error');
            return;
        }

        $successMessage = $this->_getDeleteSuccessMessage($record);
        if ($successMessage != '') {
            $this->flashSuccess($successMessage);
        }
        $this->redirect->goto('browse');

        //return parent::deleteAction();
    }

    /**
     * This is where all the redirects and page rendering goes
     *
     * @return mixed
     * */
    protected function processExhibitForm($exhibit, $actionName) {
        if (array_key_exists('save_meta', $_POST)) {
            $lastexid = savemetadataexhibit($lastexid);
            $this->redirect->goto('edit', null, null, array('id' => $lastexid));
            //$this->render('metadataform',$_POST);
        } elseif (array_key_exists('save_exhibit', $_POST)) {
            $lastexid = savemetadataexhibit($lastexid);
            $this->redirect->goto('browse', null, null, array('id' => $lastexid));
            //$this->render('metadataform',$_POST);
        } else {


            try {
                $retVal = $exhibit->saveForm($_POST);
                if ($retVal) { //echo $_POST['title'];break;
                    if (array_key_exists('add_section', $_POST)) {
                        //forward to addSection & unset the POST vars 
                        unset($_POST);
                        $this->redirect->goto('add-section', null, null, array('id' => $exhibit->id));
                        return;
                    } else if (array_key_exists('save_exhibit', $_POST)) {
                        $this->redirect->goto('edit', null, null, array('id' => $exhibit->id));
                    }
                }
            } catch (Omeka_Validator_Exception $e) {
                $this->flashValidationErrors($e);
            } catch (Exception $e) {
                $this->flash($e->getMessage());
            }

            if ($themeName = $exhibit->theme) {
                $theme = Theme::getAvailable($themeName);
            } else {
                $theme = null;
            }

            $this->view->assign(compact('exhibit', 'actionName', 'theme'));

            //@duplication see ExhibitsController::processSectionForm()
            //If the form submission was invalid 
            if (!$this->getRequest()->isXmlHttpRequest()) {
                $this->render('exhibit-metadata-form');
            }
        }//else metadata
    }

    public function themeConfigAction() {
        $exhibit = $this->findById();
        $themeName = (string) $exhibit->theme;

        // Abort if no specific theme is selected.
        if ($themeName == '') {
            $this->flashError("You must specifically select a theme in order to configure it.");
            $this->redirect->gotoRoute(array('action' => 'edit', 'id' => $exhibit->id), 'exhibitStandard');
            return;
        }

        $theme = Theme::getAvailable($themeName);
        $previousOptions = $exhibit->getThemeOptions();

        $form = new Omeka_Form_ThemeConfiguration(array(
                    'themeName' => $themeName,
                    'themeOptions' => $previousOptions
                ));

        $themeConfigIni = $theme->path . DIRECTORY_SEPARATOR . 'config.ini';

        if (file_exists($themeConfigIni) && is_readable($themeConfigIni)) {

            try {
                $pluginsIni = new Zend_Config_Ini($themeConfigIni, 'plugins');
                $excludeFields = $pluginsIni->exclude_fields;
                $excludeFields = explode(',', $excludeFields);
            } catch (Exception $e) {
                $excludeFields = array();
            }

            foreach ($excludeFields as $excludeField) {
                trim($excludeField);
                $form->removeElement($excludeField);
            }
        }

        // process the form if posted
        if ($this->getRequest()->isPost()) {
            $configHelper = new Omeka_Controller_Action_Helper_ThemeConfiguration;

            if (($newOptions = $configHelper->processForm($form, $_POST, $previousOptions))) {
                $exhibit->setThemeOptions($newOptions);
                $exhibit->save();

                $this->flashSuccess('The theme settings were successfully saved!');
                $this->redirect->gotoRoute(array('action' => 'edit', 'id' => $exhibit->id), 'exhibitStandard');
            }
        }

        $this->view->assign(compact('exhibit', 'form', 'theme'));
    }

    /**
     * 1st URL param = 'id' for Exhibit
     *
     * */
    public function addSectionAction() {
        $exhibit = $this->findById();
        $exhibitSection = new ExhibitSection;
        $exhibitSection->exhibit_id = $exhibit->id;

        //Give the new section a section order (1, 2, 3, ...)
        $numSections = $exhibit->getSectionCount();
        $exhibitSection->order = $numSections + 1;

        //Tell the plugin hook that we are adding a section
        $this->addSection = true;

        return $this->processSectionForm($exhibitSection, 'Add', $exhibit);
    }

    protected function processSectionForm($exhibitSection, $actionName, $exhibit = null) {
        $retVal = false;

        try {
            //Section form may be prefixed with Section (like name="Section[title]") or it may not be, depending

            if (array_key_exists('Section', $_POST)) {
                $toPost = $_POST['Section'];
            } else {
                $toPost = $_POST;
            }
            $retVal = $exhibitSection->saveForm($toPost);
        } catch (Omeka_Validator_Exception $e) {
            $this->flashValidationErrors($e);
        } catch (Exception $e) {
            $this->flashError($e->getMessage());
        }

        //If successful form submission
        if ($retVal) {

            //Forward around based on what submit button was pressed
            if (array_key_exists('page_form', $_POST)) {
                //Forward to the addPage action (id is the section id)
                $this->redirect->goto('add-page', null, null, array('id' => $exhibitSection->id));
                return;
            } else {
                // Only flash this success message if it is not going to the Add Page
                $this->flashSuccess("Changes to the exhibit's section were successfully saved!");
            }

            if (array_key_exists('section_form', $_POST)) {
                $this->redirect->goto('edit-section', null, null, array('id' => $exhibitSection->id));
            }
        }

        $this->view->assign(compact('exhibit', 'exhibitSection', 'actionName'));

        // Render the big section form script if this is not an AJAX request.
        if (!$this->getRequest()->isXmlHttpRequest()) {
            $this->render('section-metadata-form');
        } else {
            // This is for AJAX requests.
            // If the form submission was not valid, render the mini-form.
            if (!$retVal) {
                $this->render('sectionform');
            } else {
                // Otherwise render the partial that displays the list of sections.
                $this->render('section-list');
            }
        }
    }

    /**
     * Add a page to a section
     *
     * 1st URL param = 'id' for the section that will contain the page
     * 
     * */
    public function addPageAction() {
        $exhibitSection = $this->findById(null, 'ExhibitSection');
        $exhibit = $exhibitSection->Exhibit;

        $exhibitPage = new ExhibitPage;
        $exhibitPage->section_id = $exhibitSection->id;

        //Set the order for the new page
        $numPages = $exhibitSection->getPageCount();
        $exhibitPage->order = $numPages + 1;

        $success = $this->processPageForm($exhibitPage, 'Add', $exhibitSection, $exhibit);
        if ($success) {
            $this->flashSuccess("Changes to the exhibit's page were successfully saved!");
            return $this->redirect->goto('edit-page-content', null, null, array('id' => $exhibitPage->id));
        }

        $this->render('page-metadata-form');
    }

    public function editPageContentAction() {
        
        if (array_key_exists('add_new_item', $_POST)) {
            $lastexid = savenewitem($lastexid, null);
            //$this->view->elementSets = $this->_getExhibitElementSets();

            $varName = strtolower($this->_modelClass);

            $record = $this->findById($lastexid,'Item');

            try {
                if ($record->saveForm($_POST)) {
                     $exhibitPage = $this->findById(null, 'ExhibitPage');
                     $exhibitSection = $exhibitPage->Section;
                     $exhibit = $exhibitSection->Exhibit;
                    addteasers_to_pathway_page($exhibit->id,$exhibitSection->id,$exhibitPage->id,$lastexid);
                    $this->redirect->goto('edit-page-content', null, null, array('id' => $exhibitPage->id));
                }
            } catch (Omeka_Validator_Exception $e) {
                $this->flashValidationErrors($e);
            }
            $this->view->assign(array($varName => $record));
            //$this->redirect->goto('edit', null, null, array('id' => $lastexid));
            //$this->render('metadataform',$_POST);
        }elseif (array_key_exists('add_new_item_link', $_POST)) {
            $lastexid = savenewitem($lastexid, '11');
            //$this->view->elementSets = $this->_getItemElementSets();

            $varName = strtolower($this->_modelClass);

            $record = $this->findById($lastexid,'Item');

            try {
                if ($record->saveForm($_POST)) {
                     $exhibitPage = $this->findById(null, 'ExhibitPage');
                     $exhibitSection = $exhibitPage->Section;
                     $exhibit = $exhibitSection->Exhibit;
                    addteasers_to_pathway_page($exhibit->id,$exhibitSection->id,$exhibitPage->id,$lastexid);
                    $this->redirect->goto('edit-page-content', null, null, array('id' => $exhibitPage->id));
                }
            } catch (Omeka_Validator_Exception $e) {
                $this->flashValidationErrors($e);
            }
            $this->view->assign(array($varName => $record));
            //$this->redirect->goto('edit', null, null, array('id' => $lastexid));
            //$this->render('metadataform',$_POST);
          }elseif (array_key_exists('add_new_item2', $_POST)) {
                  require_once 'Omeka/Core.php';
    $core = new Omeka_Core;

    try {
        $db = $core->getDb();

        //Force the Zend_Db to make the connection and catch connection errors
        try {
            $mysqli = $db->getConnection()->getConnection();
        } catch (Exception $e) {
            throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
        }
    } catch (Exception $e) {
        die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
    }
              
            $lastexid = savenewitem($lastexid, null);
            //$this->view->elementSets = $this->_getExhibitElementSets();

            $varName = strtolower($this->_modelClass);

            $record = $this->findById($lastexid,'Item');

            try {
                if ($record->saveForm($_POST)) {
                     $exhibitPage = $this->findById(null, 'ExhibitPage');
                     $exhibitSection = $exhibitPage->Section;
                     $exhibit = $exhibitSection->Exhibit;
                     $orderitem=preg_replace("/[^0-9]/", "", $_POST['order']);
                     if($record['item_type_id']==6){
                     $query_teaser = "update omeka_items_section_pages set item_id=" . $lastexid . " where omeka_items_section_pages.page_id=".$exhibitPage->id." and omeka_items_section_pages.order=".$orderitem."";
                     $result_teaser = $db->query($query_teaser);
                     }
                    $this->redirect->goto('edit-page-content', null, null, array('id' => $exhibitPage->id));
                }
            } catch (Omeka_Validator_Exception $e) {
                $this->flashValidationErrors($e);
            }
            $this->view->assign(array($varName => $record));
            //$this->redirect->goto('edit', null, null, array('id' => $lastexid));
            //$this->render('metadataform',$_POST);
       
        } else {
        
        $exhibitPage = $this->findById(null, 'ExhibitPage');
        $exhibitSection = $exhibitPage->Section;
        $exhibit = $exhibitSection->Exhibit;

        if (!exhibit_builder_user_can_edit($exhibit)) {
            throw new Omeka_Controller_Exception_403;
        }

        $layoutIni = $this->layoutIni($exhibitPage->layout);

        $layoutName = $layoutIni->name;
        $layoutDescription = $layoutIni->description;

        $success = $this->processPageForm($exhibitPage, 'Edit', $exhibitSection, $exhibit);

        if ($success and (array_key_exists('section_form', $_POST) or array_key_exists('section_form_ret_to_path', $_POST))) {
            //Return to the section form
            // return $this->redirect->goto('edit-section', null, null, array('id'=>$exhibitSection->id));
        } else if ($success and array_key_exists('section_form_return', $_POST)) {
            return $this->redirect->goto('edit', null, null, array('id' => $exhibit->id));
        } else if ($success and array_key_exists('page_metadata_form', $_POST)) {
            return $this->redirect->goto('edit-page-metadata', null, null, array('id' => $exhibitPage->id));
        } else if (array_key_exists('page_form', $_POST)) {
            //Forward to the addPage action (id is the section id)
            return $this->redirect->goto('add-page', null, null, array('id' => $exhibitPage->Section->id));
        }

        $this->view->layoutName = $layoutName;
        $this->view->layoutDescription = $layoutDescription;
        
        if(array_key_exists('section_form_ret_to_path', $_POST)){
           $this->redirect->gotoRoute(array('action' => 'edit', 'id' => $exhibit->id), 'exhibitStandard');
        }else{
          $this->render('page-content-form');  
        }
        
        }
        
    }

    public function editPageMetadataAction() {
        $exhibitPage = $this->findById(null, 'ExhibitPage');
        $exhibitSection = $exhibitPage->Section;
        $exhibit = $exhibitSection->Exhibit;

        if (!exhibit_builder_user_can_edit($exhibit)) {
            throw new Omeka_Controller_Exception_403;
        }

        $success = $this->processPageForm($exhibitPage, 'Edit', $exhibitSection, $exhibit);

        if ($success) {
            return $this->redirect->goto('edit-page-content', null, null, array('id' => $exhibitPage->id));
        }

        $this->render('page-metadata-form');
    }

    protected function processPageForm($exhibitPage, $actionName, $exhibitSection = null, $exhibit = null) {
        $this->view->assign(compact('exhibit', 'exhibitSection', 'exhibitPage', 'actionName'));
        if (!empty($_POST)) {
            try {
                $success = $exhibitPage->saveForm($_POST);
            } catch (Exception $e) {
                $this->flashError($e->getMessage());
            }
        }
        return $success;
    }

    /**
     * 1st URL param = Section ID
     *
     * */
    public function editSectionAction() {
        $exhibitSection = $this->findById(null, 'ExhibitSection');
        $exhibit = $exhibitSection->Exhibit;

        if (!exhibit_builder_user_can_edit($exhibit)) {
            throw new Omeka_Controller_Exception_403;
        }

        return $this->processSectionForm($exhibitSection, 'Edit', $exhibit);
    }

    public function deleteSectionAction() {
        //Delete the section and re-order the rest of the sections in the exhibit

        $exhibitSection = $this->findById(null, 'ExhibitSection');
        $exhibit = $exhibitSection->Exhibit;

        if (!exhibit_builder_user_can_delete($exhibit)) {
            throw new Omeka_Controller_Exception_403;
        }

        $exhibitSection->delete();

        // If we are making an AJAX request to delete a section, return the XHTML for the list partial
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->view->exhibit = $exhibit;
            $this->render('section-list');
        } else {
            // For non-AJAX requests, redirect to the exhibits/edit page.
            $this->redirect->goto('edit', null, null, array('id' => $exhibit->id));
        }
    }

    /**
     * @internal There's a lot of duplication between this and deleteSectionAction().  Is that a problem?
     * */
    public function deletePageAction() {
        $exhibitPage = $this->findById(null, 'ExhibitPage');
        $exhibitSection = $exhibitPage->Section;

        if (!exhibit_builder_user_can_delete($exhibitSection->Exhibit)) {
            throw new Omeka_Controller_Exception_403;
        }

        $exhibitPage->delete();

        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->view->exhibitSection = $exhibitSection;
            $this->render('page-list');
        } else {
            $this->redirect->goto('edit-section', null, null, array('id' => $exhibitSection->id));
        }
    }

    /////HERE WE HAVE SOME AJAX-ONLY ACTIONS /////
    
    public function addteasersAction() {
        return $this->render('addteasers');
    }
    
    public function deleteteasersAction() {
        return $this->render('deleteteasers');
    }
    
    public function sectionListAction() {
        $this->view->exhibit = $this->findOrNew();
        return $this->render('section-list');
    }

    public function pageListAction() {
        $this->view->exhibitSection = $this->findById(null, 'ExhibitSection');
        $this->render('page-list');
    }

    protected function findOrNew() {
        try {
            $exhibit = $this->findById();
        } catch (Exception $e) {
            $exhibit = new Exhibit;
        }
        return $exhibit;
    }

    protected function layoutIni($layout) {
        $iniPath = EXHIBIT_LAYOUTS_DIR . DIRECTORY_SEPARATOR . "$layout" . DIRECTORY_SEPARATOR . "layout.ini";
        if (file_exists($iniPath) && is_readable($iniPath)) {
            $ini = new Zend_Config_Ini($iniPath, 'layout');
            return $ini;
        }
        return false;
    }

    /////END AJAX-ONLY ACTIONS
}

class ExhibitsController_BadSlug_Exception extends Zend_Controller_Exception {
    
}
