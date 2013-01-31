<?php
/**
 * Returns the current exhibit.
 *
 * @return Exhibit|null
 **/
function exhibit_builder_get_current_exhibit()
{
    return __v()->exhibit;
}

/**
 * Sets the current exhibit.
 *
 * @param Exhibit|null $exhibit
 * @return void
 **/
function exhibit_builder_set_current_exhibit($exhibit = null)
{
    __v()->exhibit = $exhibit;
}

/**
 * Returns whether an exhibit is the current exhibit.
 *
 * @param Exhibit|null $exhibit
 * @return boolean
 **/
function exhibit_builder_is_current_exhibit($exhibit)
{
    $currentExhibit = exhibit_builder_get_current_exhibit();
    return ($exhibit == $currentExhibit || ($exhibit && $currentExhibit && $exhibit->id == $currentExhibit->id));
}

/**
 * Returns a link to the exhibit
 *
 * @param Exhibit $exhibit|null If null, it uses the current exhibit
 * @param string|null $text The text of the link
 * @param array $props
 * @param ExhibitSection|null $exhibitSection
 * @param ExhibitPage|null $exhibitPage
 * @return string
 **/
function exhibit_builder_link_to_exhibit($exhibit = null, $text = null, $props = array(), $exhibitSection = null, $exhibitPage = null)
{   
    if (!$exhibit) {
        $exhibit = exhibit_builder_get_current_exhibit();
    }
    $uri = exhibit_builder_exhibit_uri($exhibit, $exhibitSection, $exhibitPage);
    $text = !empty($text) ? $text : html_escape($exhibit->title);
    return '<a href="' . html_escape($uri) .'" '. _tag_attributes($props) . '>' . $text . '</a>';
}

/**
 * Returns a URI to the exhibit
 *
 * @param Exhibit $exhibit|null If null, it uses the current exhibit.
 * @param ExhibitSection|null $exhibitSection
 * @param ExhibitPage|null $exhibitPage 
 * @internal This relates to: ExhibitsController::showAction(), ExhibitsController::summaryAction()
 * @return string
 **/
function exhibit_builder_exhibit_uri($exhibit = null, $exhibitSection = null, $exhibitPage = null)
{
    if (!$exhibit) {
        $exhibit = exhibit_builder_get_current_exhibit();
    }
    $exhibitSlug = ($exhibit instanceof Exhibit) ? $exhibit->slug : $exhibit;
    $exhibitSectionSlug = ($exhibitSection instanceof ExhibitSection) ? $exhibitSection->slug : $exhibitSection;
    $exhibitPageSlug = ($exhibitPage instanceof ExhibitPage) ? $exhibitPage->slug : $exhibitPage;

    //If there is no section slug available, we want to build a URL for the summary page
    if (empty($exhibitSectionSlug)) {
        $uri = public_uri(array('slug'=>$exhibitSlug), 'exhibitSimple');
    } else {
        $uri = public_uri(array('slug'=>$exhibitSlug, 'section_slug'=>$exhibitSectionSlug, 'page_slug'=>$exhibitPageSlug), 'exhibitShow');
    }
    return $uri;
}

/**
 * Returns a link to the item within the exhibit.
 * 
 * @param string|null $text
 * @param array $props
 * @param Item|null $item If null, will use the current item.
 * @return string
 **/
function exhibit_builder_link_to_exhibit_item($text = null, $props = array(), $item = null)
{   
    if (!$item) {
        $item = get_current_item();
    }

    if (!isset($props['class'])) {
        $props['class'] = 'exhibit-item-link';
    }
    
    $uri = exhibit_builder_exhibit_item_uri($item);
    $text = (!empty($text) ? $text : strip_formatting(item('Dublin Core', 'Title')));
    $html = '<a href="' . html_escape($uri) . '" '. _tag_attributes($props) . '>' . $text . '</a>';
    $html = apply_filters('exhibit_builder_link_to_exhibit_item', $html, $text, $props, $item);
    return $html;
}

/**
 * Returns a URI to the exhibit item
 * 
 * @deprecated since 1.1
 * @param Item $item
 * @param Exhibit|null $exhibit If null, will use the current exhibit.
 * @param ExhibitSection|null $exhibitSection If null, will use the current exhibit section
 * @return string
 **/
function exhibit_builder_exhibit_item_uri($item, $exhibit = null, $exhibitSection = null)
{
    if (!$exhibit) {
        $exhibit = exhibit_builder_get_current_exhibit();
    }

    if (!$exhibitSection) {
        $exhibitSection = exhibit_builder_get_current_section();
    }
    
    //If the exhibit has a theme associated with it
    if (!empty($exhibit->theme)) {
        return uri(array('slug'=>$exhibit->slug,'section_slug'=>$exhibitSection->slug,'item_id'=>$item->id), 'exhibitItem');
    } else {
        return uri(array('controller'=>'items','action'=>'show','id'=>$item->id), 'id');
    }
}

/**
 * Returns an array of exhibits
 * 
 * @param array $params
 * @return array
 **/
function exhibit_builder_get_exhibits($params = array()) 
{

    return get_db()->getTable('Exhibit')->findBy($params);
}

/**
 * Returns an array of recent exhibits
 * 
 * @param int $num The maximum number of exhibits to return
 * @return array
 **/
function exhibit_builder_recent_exhibits($num = 10) 
{
    return exhibit_builder_get_exhibits(array('sort'=>'recent','limit'=>$num));
}

/**
 * Returns an Exhibit by id
 * 
 * @param int $exhibitId The id of the exhibit
 * @return Exhibit
 **/
function exhibit_builder_get_exhibit_by_id($exhibitId) 
{
    return get_db()->getTable('Exhibit')->find($exhibitId);
}

/**
 * Displays the exhibit header
 *
 * @return void
 * @deprecated since 1.0.1
 **/
function exhibit_builder_exhibit_head()
{
	head(compact('exhibit'));
}

/**
 * Displays the exhibit footer
 *
 * @return void
 * @deprecated since 1.0.1
 **/
function exhibit_builder_exhibit_foot()
{
	foot(compact('exhibit'));
}


/**
 * Returns the HTML code of the item attach section of the exhibit form
 *
 * @param Item $item
 * @param int $orderOnForm
 * @param string $label
 * @return string
 **/
function exhibit_builder_exhibit_form_item($item, $orderOnForm = null, $label = null, $includeCaption = true)
{
    $html = '<div class="item-select-outer exhibit-form-element">';  

    if ($item and $item->exists()) {
        set_current_item($item);
        $html .= '<div class="item-select-inner">' . "\n";
        $html .= '<div class="item_id">' . html_escape($item->id) . '</div>' . "\n";
        $html .= '<h2 class="title">' . item('Dublin Core', 'Title') . '</h2>' . "\n";
        //////gkista for natural europe
        
        //if ($file = $item->Files[0]) {
        //    $html .=  display_file($file, array('linkToFile'=>false, 'imgAttributes' => array('alt' => item('Dublin Core', 'Title'))));
       // } 
       $itemthumb=viewhyperlinkthumb($item->id,200);
        $html .= '<div class="item-file">'.$itemthumb.'</div>';
        
        if ($includeCaption) {
            $html .= exhibit_builder_layout_form_caption($orderOnForm);
        }     
        
        $html .= '</div>' . "\n";      
    } else {
        $html .= '<p class="attach-item-link">Click to attach a resource from your collection. <a href="#" class="button">Attach a Resource</a></p>' . "\n";
    }
    
    // If this is ordered on the form, make sure the generated form element indicates its order on the form.
    if ($orderOnForm) {
        $html .= __v()->formHidden('Item['.$orderOnForm.']', $item->id, array('size'=>2));
    }
    
    $html .= '</div>';
    return $html;
}

/**
 * Returns the HTML code for an item on a layout form
 *
 * @param int $order The order of the item
 * @param string $label
 * @return string
 **/
function exhibit_builder_layout_form_item($order, $label = 'Enter an Item ID #') 
{   
    return exhibit_builder_exhibit_form_item(exhibit_builder_page_item($order), $order, $label);
}

/**
 * Returns the HTML code for a textarea on a layout form
 *
 * @param int $order The order of the item
 * @param string $label
 * @return string
 **/
function exhibit_builder_layout_form_text($order, $label = 'Text') 
{
    $html = '<div class="textfield exhibit-form-element">';
    $html .= textarea(array('name'=>'Text['.$order.']','rows'=>'15','cols'=>'70','class'=>'textinput'), exhibit_builder_page_text($order)); 
    $html .= '</div>';
    $html = apply_filters('exhibit_builder_layout_form_text', $html, $order, $label);
    return $html;
}

/**
 * Returns the HTML code for a caption on a layout form
 *
 * @param int $order The order of the item
 * @param string $label
 * @return string
 **/
function exhibit_builder_layout_form_caption($order, $label = 'Caption') 
{
    $html = '<div class="caption-container">' . "\n";
    $html .= '<p>' . html_escape($label) . '</p>' . "\n";
    $html .= '<div class="caption">' . "\n";
    $html .= '<label for="Caption['.$order.']">'.$label.'</label>' . "\n";
    $html .= textarea(array('name'=>'Caption['.$order.']','rows'=>'4','cols'=>'30','class'=>'textinput'), exhibit_builder_page_caption($order)); 
    $html .= '</div>' . "\n";
    $html .= '</div>' . "\n";
    
    $html = apply_filters('exhibit_builder_layout_form_caption', $html, $order, $label);
    return $html;
}

/**
 * Returns an array of available themes
 *
 * @return array
 **/
function exhibit_builder_get_ex_themes() 
{
    $themeNames = array();

    $themes = apply_filters('browse_themes', Theme::getAvailable());
    foreach ($themes as $themeDir => $theme) {
        $title = !empty($theme->title) ? $theme->title : $themeDir;
        $themeNames[$themeDir] = $title;
    }

    return $themeNames;
}

/**
 * Returns an array of available exhibit layouts
 *
 * @return array
 **/
function exhibit_builder_get_ex_layouts()
{
    $it = new VersionedDirectoryIterator(EXHIBIT_LAYOUTS_DIR, true);
    $array = $it->getValid();
    natsort($array);
    return $array;
}

/**
 * Returns the HTML code for an exhibit layout
 *
 * @param string $layout The layout name
 * @param boolean $input Whether or not to include the input to select the layout
 * @return string
 **/
function exhibit_builder_exhibit_layout($layout, $input = true)
{   
    //Load the thumbnail image
    try {
        $imgFile = web_path_to(EXHIBIT_LAYOUTS_DIR_NAME . "/$layout/layout.gif");
    } catch (Exception $e) {
        // Thumbnail not found, assuming this folder isn't a layout.
        return;
    }
    
    $exhibitPage = exhibit_builder_get_current_page();
    $isSelected = ($exhibitPage->layout == $layout) and $layout;
    
    $html = '';
    $html .= '<div class="layout' . ($isSelected ? ' current-layout' : '') . '" id="'. html_escape($layout) .'">';
    $html .= '<img src="'. html_escape($imgFile) .'" />';
    if ($input) {
        $html .= '<div class="input">';
        $html .= '<input type="radio" name="layout" value="'. html_escape($layout) .'" ' . ($isSelected ? 'checked="checked"' : '') . '/>';
        $html .= '</div>';
    }
    $html .= '<div class="layout-name">'.html_escape($layout).'</div>'; 
    $html .= '</div>';
    $html = apply_filters('exhibit_builder_exhibit_layout', $html, $layout, $input);
    return $html;
}

/**
 * Returns the web path to the exhibit css
 *
 * @param string $fileName The name of the CSS file (does not include file extension)
 * @return string
 * @deprecated since 1.0.1
 **/
function exhibit_builder_exhibit_css($fileName)
{
	return css($fileName);   
}

/**
 * Returns the web path to the layout css
 *
 * @param string $fileName The name of the CSS file (does not include file extension)
 * @return string
 **/
function exhibit_builder_layout_css($fileName = 'layout')
{
    if ($exhibitPage = exhibit_builder_get_current_page()) {
        return css($fileName, EXHIBIT_LAYOUTS_DIR_NAME . DIRECTORY_SEPARATOR . $exhibitPage->layout);
    }
}

/**
 * Displays an exhibit page
 * 
 * @param ExhibitPage $exhibitPage If null, will use the current exhibit page.
 * @return void
 **/
function exhibit_builder_render_exhibit_page($exhibitPage = null)
{
    if (!$exhibitPage) {
        $exhibitPage = exhibit_builder_get_current_page();
    }
    if ($exhibitPage->layout) {
     include EXHIBIT_LAYOUTS_DIR.DIRECTORY_SEPARATOR.$exhibitPage->layout.DIRECTORY_SEPARATOR.'layout.php';
    } else {
     echo "This page does not have a layout.";
    }
}

/**
 * Displays an exhibit layout form
 * 
 * @param string The name of the layout
 * @return void
 **/
function exhibit_builder_render_layout_form($layout)
{   
    include EXHIBIT_LAYOUTS_DIR.DIRECTORY_SEPARATOR.$layout.DIRECTORY_SEPARATOR.'form.php';
}

/**
 * Returns HTML for a set of linked thumbnails for the items on a given exhibit page.  Each 
 * thumbnail is wrapped with a div of class = "exhibit-item"
 *
 * @param int $start The range of items on the page to display as thumbnails
 * @param int $end The end of the range
 * @param array $props Properties to apply to the <img> tag for the thumbnails
 * @param string $thumbnailType The type of thumbnail to display
 * @return string HTML output
 **/
function exhibit_builder_display_exhibit_thumbnail_gallery($start, $end, $props = array(), $thumbnailType = 'square_thumbnail')
{
    $html = '';
    for ($i=(int)$start; $i <= (int)$end; $i++) { 
        if (exhibit_builder_use_exhibit_page_item($i)) {    
            $html .= "\n" . '<div class="exhibit-item">';
            $thumbnail = item_image($thumbnailType, $props);
            $html .= exhibit_builder_link_to_exhibit_item($thumbnail);
            $html .= exhibit_builder_exhibit_display_caption($i);
            $html .= '</div>' . "\n";
        }
    }
    $html = apply_filters('exhibit_builder_display_exhibit_thumbnail_gallery', $html, $start, $end, $props, $thumbnailType);
    return $html;
}

/**
 * Returns the HTML of a random featured exhibit
 *
 * @return string
 **/
function exhibit_builder_display_random_featured_exhibit()
{
    $html = '<div id="featured-exhibit">';
    $featuredExhibit = exhibit_builder_random_featured_exhibit();
    $html .= '<h2>Featured Exhibit</h2>';
    if ($featuredExhibit) {
       $html .= '<h3>' . exhibit_builder_link_to_exhibit($featuredExhibit) . '</h3>'."\n";
       $html .= '<p>'.snippet_by_word_count(exhibit('description', array(), $featuredExhibit)).'</p>';
    } else {
       $html .= '<p>You have no featured exhibits.</p>';
    }
    $html .= '</div>';
    $html = apply_filters('exhibit_builder_display_random_featured_exhibit', $html);
    return $html;
}

/**
 * Returns a random featured exhibit
 *
 * @return Exhibit
 **/
function exhibit_builder_random_featured_exhibit()
{
    return get_db()->getTable('Exhibit')->findRandomFeatured();
}

/**
 * Returns the html code an exhibit item
 * 
 * @param array $displayFilesOptions
 * @param array $linkProperties
 * @return string
 **/
function exhibit_builder_exhibit_display_item($displayFilesOptions = array(), $linkProperties = array(), $item = null)
{
    if (!$item) {
        $item = get_current_item();
    }
    
    // Always just display the first file (may change this in future).
    $fileIndex = 0;
    
    // Default link href points to the exhibit item page.
    if (!isset($displayFilesOptions['linkAttributes']['href'])) {
        $displayFilesOptions['linkAttributes']['href'] = exhibit_builder_exhibit_item_uri($item);
    }
    
    // Default alt text is the
    if(!isset($displayFileOptions['imgAttributes']['alt'])) {
        $displayFilesOptions['imgAttributes']['alt'] = item('Dublin Core', 'Title', array(), $item);
    }
    
    // Pass null as the 3rd arg so that it doesn't output the item-file div.
    $fileWrapperClass = null;
    $file = $item->Files[$fileIndex];
    if ($file) {
        $html = display_file($file, $displayFilesOptions, $fileWrapperClass);
    } else {
        $html = exhibit_builder_link_to_exhibit_item(null, $linkProperties, $item);
    }
    
    $html = apply_filters('exhibit_builder_exhibit_display_item', $html, $displayFilesOptions, $linkProperties, $item);

    return $html;
}

/**
 * Returns the caption at a given index
 *
 * @param index 
 **/
function exhibit_builder_exhibit_display_caption($index = 1)
{
    $html = '';
    if ($caption = exhibit_builder_page_caption($index)) {
        $html .= '<div class="exhibit-item-caption">'."\n";
        $html .= $caption."\n";
        $html .= '</div>'."\n";
    }
    
    $html = apply_filters('exhibit_builder_exhibit_fullsize', $html, $index);
    
    return $html;
}
/**
 * Returns the HTML code for an exhibit thumbnail image.
 *
 * @param Item $item
 * @param array $props
 * @param int $index The index of the image for the item
 * @return string
 **/
function exhibit_builder_exhibit_thumbnail($item, $props = array('class'=>'permalink'), $index = 0) 
{     
    $uri = exhibit_builder_exhibit_item_uri($item);
    $html = '<a href="' . html_escape($uri) . '">';
    $html .= item_thumbnail($props, $index, $item);
    $html .= '</a>';  
    $html = apply_filters('exhibit_builder_exhibit_thumbnail', $html, $item, $props, $index);
    return $html;
}

/**
 * Returns the HTML code for an exhibit fullsize image.
 *
 * @param Item $item
 * @param array $props
 * @param int $index The index of the image for the item
 * @return string
 **/
function exhibit_builder_exhibit_fullsize($item, $props = array('class'=>'permalink'), $index = 0)
{
    $uri = exhibit_builder_exhibit_item_uri($item);
    $html = '<a href="' . html_escape($uri) . '">';
    $html .= item_fullsize($props, $index, $item);
    $html .= '</a>';
    $html = apply_filters('exhibit_builder_exhibit_fullsize', $html, $item, $props, $index);
    return $html;
}

/**
 * Returns true if a given user can edit a given exhibit.
 * 
 * @param Exhibit|null $exhibit If null, will use the current exhibit
 * @param User|null $user If null, will use the current user.
 * @return boolean
 **/
function exhibit_builder_user_can_edit($exhibit = null, $user = null)
{
    if (!$exhibit) {
        $exhibit = exhibit_builder_get_current_exhibit();
    }
    if (!$user) { 
        $user = current_user();
    }
    $acl = get_acl();

    $canEditSelf = $acl->isAllowed($user, 'ExhibitBuilder_Exhibits', 'editSelf');
    $canEditOthers = $acl->isAllowed($user, 'ExhibitBuilder_Exhibits', 'editAll');

    return (($exhibit->wasAddedBy($user) && $canEditSelf) || $canEditOthers);    
}

/**
 * Returns true if a given user can delete a given exhibit.
 *
 * @param Exhibit|null $exhibit If null, will use the current exhibit
 * @param User|null $user If null, will use the current user.
 * @return boolean
 **/
function exhibit_builder_user_can_delete($exhibit = null, $user = null)
{
    if (!$exhibit) {
        $exhibit = exhibit_builder_get_current_exhibit();
    }
    if (!$user) {
        $user = current_user();
    }
    $acl = get_acl();

    $canDeleteSelf = $acl->isAllowed($user, 'ExhibitBuilder_Exhibits', 'deleteSelf');
    $canDeleteAll = $acl->isAllowed($user, 'ExhibitBuilder_Exhibits', 'deleteAll');

    return (($exhibit->wasAddedBy($user) && $canDeleteSelf) || $canDeleteAll);
}

/**
* Gets the current exhibit
*
* @return Exhibit|null
**/
function get_current_exhibit()
{
    return exhibit_builder_get_current_exhibit();
}

/**
 * Sets the current exhibit
 *
 * @see loop_exhibits()
 * @param Exhibit
 * @return void
 **/
function set_current_exhibit(Exhibit $exhibit)
{
   exhibit_builder_set_current_exhibit($exhibit);
}

/**
 * Sets the exhibits for loop
 *
 * @param array $exhibits
 * @return void
 **/
function set_exhibits_for_loop($exhibits)
{
    __v()->exhibits = $exhibits;
}

/**
 * Get the set of exhibits for the current loop.
 * 
 * @return array
 **/
function get_exhibits_for_loop()
{
    return __v()->exhibits;
}

/**
 * Loops through exhibits assigned to the view.
 * 
 * @return mixed The current exhibit
 */
function loop_exhibits()
{
    return loop_records('exhibits', get_exhibits_for_loop(), 'set_current_exhibit');
}

/**
 * Determine whether or not there are any exhibits in the database.
 * 
 * @return boolean
 **/
function has_exhibits()
{
    return (total_exhibits() > 0);    
}

/**
 * Determines whether there are any exhibits for loop.
 * @return boolean
 */
function has_exhibits_for_loop()
{
    $view = __v();
    return ($view->exhibits and count($view->exhibits));
}

/**
  * Returns the total number of exhibits in the database
  *
  * @return integer
  **/
 function total_exhibits() 
 {	
 	return get_db()->getTable('Exhibit')->count();
 }

/**
* Gets a property from an exhibit
*
* @param string $propertyName
* @param array $options
* @param Exhibit $exhibit  The exhibit
* @return mixed The exhibit property value
**/
function exhibit($propertyName, $options = array(), $exhibit = null)
{
    if (!$exhibit) {
        $exhibit = get_current_exhibit();
    }
    $propertyName = Inflector::underscore($propertyName);
	if (property_exists(get_class($exhibit), $propertyName)) {
	    return $exhibit->$propertyName;
	} else {
	    return null;
	}
}

/**
* Returns a link to an exhibit, exhibit section, or exhibit page.
* @uses exhibit_builder_link_to_exhibit
*
* @param string|null $text The text of the link
* @param array $props
* @param ExhibitSection|null $exhibitSection
* @param ExhibitPage|null $exhibitPage
* @param Exhibit $exhibit|null If null, it uses the current exhibit
* @return string
**/
function link_to_exhibit($text = null, $props = array(), $exhibitSection = null, $exhibitPage = null, $exhibit = null)
{
	return exhibit_builder_link_to_exhibit($exhibit, $text, $props, $exhibitSection, $exhibitPage);
}

//////////////////////custom extra functions ///////////////////////////////


function exhibit_picture($ex_eid,$size,$page,$slugsec='to-begin-with'){

require_once 'Zend/Db.php';	

$configSQL = new Zend_Config_Ini('./db.ini', 'database');

$params = array(
'host' => $configSQL->host,
'dbname' => $configSQL->name,
'username'=> $configSQL->username,
'password'=> $configSQL->password);
$db = Zend_Db::factory('Mysqli',$params);
$db->query("SET NAMES 'utf8'");

$ex_eid = (int) $ex_eid;
$select = $db->select();
$select->from(array('f'=>'omeka_sections'),array('id'));
$select->where('f.exhibit_id = ?',$ex_eid);
$select->where('f.slug = ?',$slugsec);
$rowset = $db->fetchRow($select);

$select = $db->select();
$select->from(array('f'=>'omeka_section_pages'),array('id'));
$select->where('f. section_id = ?',''.$rowset['id'].'');
$select->where('f.order = ?','1');
$rowset = $db->fetchRow($select);
//echo $rowset['id'];

$select = $db->select();
$select->from(array('f'=>'omeka_items_section_pages'),array('id','item_id'));
$select->where('f. page_id = ?',''.$rowset['id'].'');
$select->where('f.order = ?','1');
$rowset = $db->fetchRow($select);
//$rowCount = count($rowset); 
if($rowset['id']>0){

$itemid=$rowset['item_id'];
$select = $db->select();
$select->from(array('f'=>'omeka_files'),array('id','archive_filename','original_filename'));
$select->where('f. item_id = ?',''.$itemid.'');
$rowset = $db->fetchRow($select);
$rowCount2 = count($rowset); 
if($rowset['id']>0){ 

$Images_jpg = explode('.',$rowset['archive_filename'],2);
			if ($Images_jpg[1]=='gif' or $Images_jpg[1]=='jpg' or $Images_jpg[1]=='png' or $Images_jpg[1]=='tif' or $Images_jpg[1]=='jpeg') {
			if ($Images_jpg[1]=='gif') {
				$Images_jpg = $Images_jpg[0].".gif";
			}
			elseif ($Images_jpg[1]=='png') {
				$Images_jpg = $Images_jpg[0].".png";
			}
			elseif ($Images_jpg[1]=='tif') {
				$Images_jpg = $Images_jpg[0].".tif";
			}
			elseif ($Images_jpg[1]=='jpeg') {
				$Images_jpg = $Images_jpg[0].".jpeg";
			}
			else
			{
				$Images_jpg = $Images_jpg[0].".jpg";
			}

			}


if($page=='browse'){

$returnimage=" 
			<p align='center'>
<img src='".uri("custom/phpThumb/phpThumb.php?src=/natural_europe/archive/files/".$Images_jpg."")."&h=".$size."'>
</p>  ";

}
elseif($page=='index'){

$returnimage=" 
			<p align='center'>
<img src='".uri("custom/phpThumb/phpThumb.php?src=/natural_europe/archive/files/".$Images_jpg."")."&h=".$size."' width='200px' height='135'>
</p>  ";

}
elseif($page=='indexstund'){

	//echo $Images_jpg;
$returnimage=" 
			
<img src='".uri("custom/phpThumb/phpThumb.php?src=/natural_europe/archive/files/".$Images_jpg."")."&w=".$size."' height='90' width='135'  class='left'/> ";

}
elseif($page=='indexstunds'){

$returnimage=" 
			
<img src='".uri("custom/phpThumb/phpThumb.php?src=/natural_europe/archive/files/".$Images_jpg."")."&h=".$size."' height='120' class='left'/> ";

}

else{
 $returnimage=" 
			
<a class='lightview'  href='".uri("archive/fullsize/".$Images_jpg."")." '
title='".$rowset['description']." :: ".$rowset['rights']."' >
<img src='".uri("custom/phpThumb/phpThumb.php?src=/natural_europe/archive/files/".$rowset['archive_filename']."")."&w=".$size."'></a>
 ";
}

echo $returnimage; 

}

}

}

function return_user_of_exhibit($ex_id)
	{
require_once 'Zend/Db.php';	

$configSQL = new Zend_Config_Ini('./db.ini', 'database');

$params = array(
'host' => $configSQL->host,
'dbname' => $configSQL->name,
'username'=> $configSQL->username,
'password'=> $configSQL->password,
'charset'   => $configSQL->charset);
$db = Zend_Db::factory('Mysqli',$params);
$db->query("SET NAMES 'utf8'");


$select = $db->select();
$select->from(array('f'=>'omeka_entities_relations'),array('entity_id','id'));
$select->where('f.relation_id = ?',$ex_id);
$select->where('f.type = ?','Exhibit');
$select->where('f.relationship_id = ?','1');
$select->orwhere('f.relationship_id = ?','2');
$select->order(array('f.id ASC'));
$rowset = $db->fetchRow($select);

		return $rowset['entity_id'];
	}
function return_user_of_exhibit2($ex_id)
	{
require_once 'Zend/Db.php';	

$configSQL = new Zend_Config_Ini('./db.ini', 'database');

$params = array(
'host' => $configSQL->host,
'dbname' => $configSQL->name,
'username'=> $configSQL->username,
'password'=> $configSQL->password,
'charset'   => $configSQL->charset);
$db = Zend_Db::factory('Mysqli',$params);
$db->query("SET NAMES 'utf8'");


$select = $db->select();
$select->from(array('f'=>'omeka_entities_relations'),array('entity_id','id'));
$select->join(array('sec'=>'omeka_entities'),'f.entity_id=sec.id',array('first_name','last_name'));
$select->where('f.relation_id = ?',$ex_id);
$select->where('f.type = ?','Exhibit');
$select->where('f.relationship_id = ?','1');
$select->order(array('f.id ASC'));
$rowset = $db->fetchRow($select);
		$name= $rowset['last_name']." ".$rowset['first_name'];
		return $name;
	}

function bypass(){
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
$exhibitdb=$db->Exhibit;
$sectiondb=$db->ExhibitSection;
$sectionPagedb=$db->ExhibitPage;
$sectionPageTextdb=$db->ExhibitPageEntry;


$maxIdSQL="SELECT MAX(id) AS MAX_ID FROM ". $exhibitdb." LIMIT 0,1";
$exec=$db->query($maxIdSQL);
$row=$exec->fetch();
$max_id=$row["MAX_ID"];
$exec=null;

if($_POST['slug']){$path_slug=$_POST['slug'];} else{
	$path_slug=str_replace(" ","-",$_POST['title']);
	$path_slug=preg_replace('/[^a-zA-Z0-9\-_]/', '', $path_slug);
	$path_slug=str_replace(" ","-",$path_slug);
	$countslug=strlen($path_slug); if($countslug<2){$path_slug="Pathway-slug-".$max_id;}
}
$maxIdSQL="SELECT id FROM ". $exhibitdb." WHERE slug='".$path_slug."' LIMIT 0,1";
$exec=$db->query($maxIdSQL);
$row=$exec->fetch();
$slug_id=0;
if(isset($row["id"])){$slug_id=$row["id"];}
$exec=null;
if($slug_id>0){$path_slug="Pathway-slug-".$max_id;} //echo $slug_id;break;
if($_POST['title']){$path_title=addslashes($_POST['title']);} else{$path_title="pathway-title-".$max_id."";}
if($_POST['description']){$path_description=addslashes($_POST['description']);} else{$path_description="";}
$path_language=$_POST['language'];
if($_POST['public']){$path_public=$_POST['public'];} else{$path_public="0";}
$mainAttributesSql="INSERT INTO $exhibitdb (id, title, description, credits, featured, public, theme, slug, target_group, date_modified) VALUES (NULL,'".$path_title."',\"Pathway's Subtitle\", 'Write the credits for this exhibits. If no credits, then erase this line', 0, ".$path_public.", '','".$path_slug."', 'test','')";
$db->exec($mainAttributesSql);


$lastExhibitIdSQL="SELECT LAST_INSERT_ID() AS LAST_EXHIBIT_ID FROM ". $exhibitdb;
$exec=$db->query($lastExhibitIdSQL);
$row=$exec->fetch();
$last_exhibit_id=$row["LAST_EXHIBIT_ID"];
$exec=null;

/*===================================INSERT record for METADATA===================================*/
$metadatarecordSql="INSERT INTO metadata_record (id, object_id, object_type) VALUES ('', ".$last_exhibit_id.",'exhibit')";
$execmetadatarecordSql=$db->query($metadatarecordSql);

$lastExhibitIdSQL="SELECT LAST_INSERT_ID() AS LAST_EXHIBIT_ID FROM metadata_record";
$exec=$db->query($lastExhibitIdSQL);
$row=$exec->fetch();
$last_record_id=$row["LAST_EXHIBIT_ID"];
$exec=null;

$metadatarecordSql="INSERT INTO metadata_element_value (element_hierarchy, value, language_id, multi, record_id) VALUES ('6','".$path_title."','en',1, ".$last_record_id.")";
$execmetadatarecordSql=$db->query($metadatarecordSql);
$exec=null;

$metadatarecordSql="INSERT INTO metadata_element_value (element_hierarchy, value, language_id, multi, record_id) VALUES ('8','".$path_description."','en',1, ".$last_record_id.")";
$execmetadatarecordSql=$db->query($metadatarecordSql);
$exec=null;

$metadatarecordSql="INSERT INTO metadata_element_value (element_hierarchy, value, language_id, multi, record_id) VALUES ('7','".$path_language."','none',1, ".$last_record_id.")";
$execmetadatarecordSql=$db->query($metadatarecordSql);
$exec=null;
/*===================================CREATE THE SECTIONS AND THE SECTIONS' PAGES===================================*/
$sectionsSql="INSERT INTO ".$sectiondb." (id, title, description, exhibit_id, `order`, slug) VALUES (NULL, ?,'',".$last_exhibit_id.", ?, ?)";
$sectionPageSql="INSERT INTO ". $sectionPagedb ."(id, section_id, layout, `order`, title ) VALUES (NULL, ?, 'text-image-right', ?, ?)";
$sectionPageTextSql="INSERT INTO ". $sectionPageTextdb ."(id, item_id, page_id, text, `order`) VALUES (NULL, NULL, LAST_INSERT_ID(), 'Put text here',1)";
//sections is an array of section. Each section is an array that contains 4 attributes:
//$section[0]. The title of the Section  
//$section[1]. The sequence of the Section  
//$section[2]. The slug of the Section
//$section[3]. The number of the pages of the Section 
$sections=array(
array('Introduction',1,'to-begin-with',1),
				array('Pre-visit Phase',2,'pre-visit-phase',1),
				array('Visit Phase',3,'visit-phase',1),
				array('Post-visit Phase',4,'post-visit-phase',1)
				);

foreach ($sections as $v){
	//print_r($v);
	$db->exec($sectionsSql,array($v[0],$v[1],$v[2]));
	$lastSectionIdSQL="SELECT LAST_INSERT_ID() AS LAST_SECTION_ID FROM ". $sectiondb;
	$exec=$db->query($lastSectionIdSQL);
	$row=$exec->fetch();
	$last_section_id=$row["LAST_SECTION_ID"];
	$exec=null;
	if($v[2]=='to-begin-with'){
		$db->exec($sectionPageSql,array($last_section_id,'1','Guidance for preparation'));
		$db->exec($sectionPageTextSql);
		
		$db->exec($sectionPageSql,array($last_section_id,'2','Connection with curriculum'));
		$db->exec($sectionPageTextSql);
	}
	if($v[2]=='pre-visit-phase'){
		$db->exec($sectionPageSql,array($last_section_id,'1','Provoke curiosity'));
		$db->exec($sectionPageTextSql);
		
		$db->exec($sectionPageSql,array($last_section_id,'2','Define questions from current knowledge'));
		$db->exec($sectionPageTextSql);
		
		$db->exec($sectionPageSql,array($last_section_id,'3','Propose preliminary explanations or hypotheses'));
		$db->exec($sectionPageTextSql);
		
		$db->exec($sectionPageSql,array($last_section_id,'4','Plan and conduct simple investigation'));
		$db->exec($sectionPageTextSql);
	}
	
	if($v[2]=='visit-phase'){
		$db->exec($sectionPageSql,array($last_section_id,'1','Gather evidence from observation'));
		$db->exec($sectionPageTextSql);
		
		$db->exec($sectionPageSql,array($last_section_id,'2','Explanation based on evidence'));
		$db->exec($sectionPageTextSql);
		
		$db->exec($sectionPageSql,array($last_section_id,'3','Consider other explanations'));
		$db->exec($sectionPageTextSql);

	}
	
	if($v[2]=='post-visit-phase'){
		$db->exec($sectionPageSql,array($last_section_id,'1','Communicate explanation'));
		$db->exec($sectionPageTextSql);
		
		$db->exec($sectionPageSql,array($last_section_id,'2','Follow-up activities and materials'));
		$db->exec($sectionPageTextSql);
		
		$db->exec($sectionPageSql,array($last_section_id,'3','Sustainable contact'));
		$db->exec($sectionPageTextSql);

	}
	
	
	
}
$entitiesRelationsdb=$db->EntitiesRelations;
$entity_id = current_user();
$entitiesRelationsSql="INSERT INTO ".$entitiesRelationsdb." (entity_id, relation_id, relationship_id, type, time) VALUES (".$entity_id->entity_id.", ".$last_exhibit_id.",1,'Exhibit','".date("Y-m-d H:i:s")."')";
$exec=$db->query($entitiesRelationsSql);
return $last_exhibit_id;
//header('Location:'.uri('exhibits/edit/'.$last_exhibit_id));

}

function savemetadataexhibit(){

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

$maxIdSQL="select * from metadata_record where object_id=".$_POST['exhibit_id']." and object_type='exhibit'";
$exec=$db->query($maxIdSQL);
$row=$exec->fetch();
$record_id=$row["id"];
$exec=null;

foreach($_POST as $var => $value)
{


if($var!='exhibit_id' and $var!='title' and $var!='Pages' and $var!='hdnLine' and $var!='slug' and $var!='public' and $var!='Sections' and $var!='save_exhibit' and $var!='date_modified' and $var!='save_meta'){
$var1=explode("_",$var); //split form name at _
$var=$var1[0]; 
$varlan=$var1[2]; 



if($var1[2]!='lan' and $var!='hdnLine'){ //not get in if is language name at form or name is hdnline



if(isset($_POST[$var.'_'.$var1[1].'_lan'])){$language=$_POST[$var.'_'.$var1[1].'_lan'];} else{$language='none';}//langueage for this form name


if($var==6 and $language=='en'){$exhibit_title_from_metadata=$value;}//title gia pathway


$maxIdSQL="select * from metadata_element_hierarchy where id=".$var."";
$exec=$db->query($maxIdSQL);
$result_multi=$exec->fetch();
//$exec=null;

if($result_multi['max_occurs']>0){ $multi=$var1[1]; } else{$multi=1;}

if(strlen($value)>1){
$value=addslashes($value);
$maxIdSQL="insert into metadata_element_value SET element_hierarchy=".$var.",value='".addslashes($value)."',language_id='".$language."',record_id=".$record_id.",multi=".$multi." ON DUPLICATE KEY UPDATE value='".addslashes($value)."'";
$exec=$db->query($maxIdSQL);
//$result_multi=$exec->fetch();
$exec=null;

//$sql="insert into metadata_element_value SET element_hierarchy=".$var.",value='".$value."',language_id='".$language."',record_id=".$record_id.",multi=".$multi." ON DUPLICATE KEY UPDATE value='".$value."'";
//$result_teaser=mysql_query($sql) or die(mysql_error());

}//if strlen >1 if exist value
}//end not get in if is language name at form 
}
}
if(strlen($exhibit_title_from_metadata)>2){$exhibit_title_from_metadata=$exhibit_title_from_metadata;} else{$exhibit_title_from_metadata=$_POST['6_1'];}//title gia pathway
$path_slug=$_POST['slug'];
$path_slug=preg_replace('/[^a-zA-Z0-9\-_]/', '', $path_slug);
$path_slug=str_replace(" ","-",$path_slug);
$countslug=strlen($path_slug); if($countslug<2){$path_slug="Pathway-slug-".$_POST['exhibit_id'];}

$maxIdSQL="SELECT slug FROM omeka_exhibits WHERE id=".$_POST['exhibit_id']." LIMIT 0,1"; //echo $maxIdSQL;break;
$exec=$db->query($maxIdSQL);
$row2=$exec->fetch();
//$exec=null;
$maxIdSQL="SELECT id,slug FROM omeka_exhibits WHERE slug='".$path_slug."' LIMIT 0,1";
$exec=$db->query($maxIdSQL);
$row=$exec->fetch();
$slug_id=0;
$slug_slug=$row["slug"];
if(isset($row["id"])){$slug_id=$row["id"];}
$exec=null;
if($slug_id>0 and $slug_id!=$_POST['exhibit_id']){$path_slug=$row2["slug"];} //echo $slug_id;break;

$maxIdSQL="update omeka_exhibits SET title='".addslashes($exhibit_title_from_metadata)."',slug='".addslashes($path_slug)."',public=".$_POST['public'].",date_modified='".$_POST['date_modified']."' where id=".$_POST['exhibit_id']."";
$exec=$db->query($maxIdSQL);
//$result_multi=$exec->fetch();
$exec=null;

//$result_teaser2=mysql_query("update omeka_exhibits SET title='".$exhibit_title_from_metadata."',slug='".$_POST['slug']."',public=".$_POST['public'].",date_modified='".$_POST['date_modified']."' where id=".$_POST['exhibit_id']."");  //update exhibit table

return $_POST['exhibit_id'];
}


function teaser($ex_eid,$type='null',$sec_id){
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

$maxIdSQL="select * from omeka_teasers where exhibit_id=".$ex_eid." and type!='europeana' and sec_id=".$sec_id;
//echo $maxIdSQL;break;
$exec=$db->query($maxIdSQL);
$result_multi=$exec->fetchAll();
if($result_multi){
foreach($result_multi as $teaser){

if(isset($teaser['item_id']) and $teaser['item_id']>1){

$sqlpub="select * from omeka_items where id=".$teaser['item_id']."";
//echo $sql;break;
$execpub=$db->query($sqlpub);
$resultrecpub=$execpub->fetch();

if($resultrecpub['public']==1){

$sql="select * from metadata_record where object_id=".$teaser['item_id']." and object_type='item' ";
//echo $sql;break;
$exec=$db->query($sql);
$resultrec=$exec->fetch();

if(isset($resultrec['id']) and $resultrec['id']>1){
$sql="select * from metadata_element_value where record_id=".$resultrec['id']." and element_hierarchy=6 and language_id='en'";
//echo $sql."<br>";
$exec=$db->query($sql);
$result=$exec->fetch();

$sql="select * from metadata_element_value where record_id=".$resultrec['id']." and element_hierarchy=32";
//echo $sql;break;
$exec=$db->query($sql);
$resultloc=$exec->fetch();



echo "
<div style='float:left;position:relative; width:50px;'>
<a href='".uri('items/show/')."".$teaser['item_id']."?eidteaser=".$ex_eid."".target($start=0)."'>";
echo viewhyperlinkthumb($teaser['item_id']);
echo "</a> </div>";

echo "
<div style='float:left;position:relative; left:3px; width:170px; text-align:left; vertical-align:middle;'>
<a href='".uri('items/show/')."".$teaser['item_id']."?eidteaser=".$ex_eid."".target($start=0)."'>".$result['value']." ";
echo "</a> </div>";

echo "<br style='clear:both;'><br>";
echo "<div style='width:100%;text-align:center;'><hr style='width:100px; border-color:#999999;'></div>";
echo "<br>";

}
}
}
}
}
}

function deleteexhibit($ex_eid){
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

$maxIdSQL="DELETE from metadata_record where object_id=".$ex_eid." and object_type='exhibit'";
//echo $maxIdSQL;break;
$exec=$db->query($maxIdSQL);
//$result_multi=$exec->fetchAll();

/////////////delete teasers that exhibit has//////////////
$maxIdSQL="DELETE from omeka_teasers where exhibit_id=".$ex_eid."";
//echo $maxIdSQL;break;
$exec=$db->query($maxIdSQL);

}



