<?php
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 * @access private
 */

/**
 * The only thing this controller does is load the home page of the theme
 * at index.php within any given theme.
 *
 * @internal This implements Omeka internals and is not part of the public API.
 * @access private
 * @package Omeka
 * @subpackage Controllers
 * @author CHNM
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 */
class BrowseController extends Omeka_Controller_Action
{
  
    public function browseAction()
    {
        //custom code for loop all exhibits that are public
		//$menuexhibits = exhibit_builder_get_exhibits(array('public' => '1'));
		$params = $this->_getAllParams();
		//print_r($params); break;
		//$params['user']=1;
		$params['public']=1;
		$params['sort']='recent';
		$menuexhibits=get_db()->getTable('Exhibit')->findBy($params);
                $results['per_page']=15;
                $results['total_results']= count($menuexhibits);
                if($params['page']){
                $resultPage = $params['page'];
                } else{ $resultPage = 1; }
                $menuexhibits_paging=get_db()->getTable('Exhibit')->findBy($params, $results['per_page'], $resultPage);
        /**
         * Now process the pagination
         * 
         * */
       $paginationUrl = $this->getRequest()->getBaseUrl() . ''; 

        //Serve up the pagination
        $pagination = array('menu' => null, // This hasn't done anything since $menu was never instantiated in ItemsController::browseAction()
            'page' => $resultPage,
            'per_page' => $results['per_page'],
            'total_results' => $results['total_results'],
            'link' => $paginationUrl);

        Zend_Registry::set('pagination', $pagination);
	
		//print_r($params);
		$this->view->assign(compact('menuexhibits'));
                $this->view->assign(compact('menuexhibits_paging'));
		
        $this->_helper->viewRenderer->renderScript('browse.php');
    }
}
