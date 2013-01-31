<?php
/**
 * Returns the current exhibit section.
 *
 * @return ExhibitSection|null
 **/
function exhibit_builder_get_current_section()
{
    return __v()->exhibitSection;
}

/**
 * Sets the current exhibit section.
 *
 * @param ExhibitSection|null $exhibitSection
 * @return void
 **/
function exhibit_builder_set_current_section($exhibitSection = null)
{
    __v()->exhibitSection = $exhibitSection;
}

/**
 * Returns whether an exhibit section is the current exhibit section.
 *
 * @param ExhibitSection|null $exhibitSection
 * @return boolean
 **/
function exhibit_builder_is_current_section($exhibitSection)
{
    $currentExhibitSection = exhibit_builder_get_current_section();
    return ($exhibitSection === $currentExhibitSection || ($exhibitSection && $currentExhibitSection && $exhibitSection->id == $currentExhibitSection->id));
}

/**
 * Returns whether the exhibit section has pages.
 *
 * @param ExhibitSection|null $exhibitSection If null, it uses the current exhibit section
 * @return boolean
 **/
function exhibit_builder_section_has_pages($exhibitSection = null) 
{
    if ($exhibitSection === null) {
        $exhibitSection = exhibit_builder_get_current_section();
    }
    return $exhibitSection->hasPages();
}

/**
 * Returns an exhibit section by id
 *
 * @param $exhibitSectionId The id of the exhibit section
 * @return ExhibitSection
 **/
function exhibit_builder_get_exhibit_section_by_id($exhibitSectionId) 
{
    return get_db()->getTable('ExhibitSection')->find($exhibitSectionId);
}

/**
 * Returns the HTML code of the exhibit section navigation
 *
 * @param Exhibit|null $exhibit If null, will use the current exhibit.
 * @return string
 **/
function exhibit_builder_section_nav($exhibit = null)
{


	/////////custom code for natural europe.///////////////////////
	if (!$exhibit) {
       if (!($exhibit = exhibit_builder_get_current_exhibit())) {
          return;
       }    
    }
	$count = 1;
	$totalsections=0;
	foreach ($exhibit->Sections as $key => $exhibitSection) {$totalsections+=1;}
	foreach ($exhibit->Sections as $key => $exhibitSection) {
	$uri_ext="";
		$uri = html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibitSection));
		$uri =$uri."?ajaxsection=1";
		if ($_GET["nhm"]){ $uri_ext =$uri."".target($start=0); $target=$_GET["nhm"]; }
		else{ $uri_ext = $uri; $target=""; }
		//onclick sunartisi
		$onclick="onclick=loadXMLDoc('".$uri_ext."','section1','count".$count."','counta".$count."','open','".$exhibit->id."','".$exhibitSection->id."','".$target."','".$totalsections."')";
		// This is new part added for the e-knownet portal
		//$uri_ex = exhibit_uri($exhibit);
		//if ($_GET["target"]) $uri_ex .="?target=students";
		//if(h($section->slug)!="to-begin-with" and h($section->title)!="Keywords"){
		if($count==1){
		$output .= '<h3 id="count'.$count.'" class="item_01 active"><a id="counta'.$count.'" href="javascript:void(0);" class="trigger"';
		} else{
		$output .= '<h3 id="count'.$count.'" class="item_01"><a id="counta'.$count.'" href="javascript:void(0);" class="trigger"';
		}
		
		$req = null;
		if(!$req) {
			$req = Zend_Controller_Front::getInstance()->getRequest();
		}
		$current = $req->getRequestUri();
		$current_url = 'http://'.$_SERVER['HTTP_HOST'].$current;
		//echo $current_url;
		//echo $uri;
		
		
			$output .= "' ".$onclick." >" . html_escape($exhibitSection->title) . "</a></h3>";
		
		
		
		// This is the old part
		// $output .= '<li><a href="' . $uri . '"' . (is_current($uri) ? ' class="current"' : ''). '>' . h($section->title) . '</a></li>';
		
	$count++;	
	// }//!= to begin and keywords
	}
	
	
	$output .= '';
	return $output;
	
	
	//////////////regular function from omeka/////////////////
   // if (!$exhibit) {
   //     if (!($exhibit = exhibit_builder_get_current_exhibit())) {
    //        return;
   //     }    
  //  }
  //  $html = '<ul class="exhibit-section-nav">';
  //  foreach ($exhibit->Sections as $key => $exhibitSection) {
  //      if ($exhibitSection->hasPages()) {
  //          $html .= '<li' . (exhibit_builder_is_current_section($exhibitSection) ? ' class="current"' : ''). '><a class="exhibit-section-title" href="' . html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibitSection)) . '">' . html_escape($exhibitSection->title) . '</a></li>';            
    //    }      
  //  }
   // $html .= '</ul>';
   // $html = apply_filters('exhibit_builder_section_nav', $html, $exhibit);
   // return $html;
}

/**
 * Returns the HTML for a nested navigation for exhibit sections and pages
 *
 * @param Exhibit|null $exhibit If null, will use the current exhibit
 * @param boolean $showAllPages
 * @return string
 **/
function exhibit_builder_nested_nav($exhibit = null, $showAllPages = false)
{
    if (!$exhibit) {
        if (!($exhibit = exhibit_builder_get_current_exhibit())) {
            return;
        }    
    }
    $html = '<ul class="exhibit-section-nav">';
    foreach ($exhibit->Sections as $exhibitSection) {
        $html .= '<li class="exhibit-nested-section' . (exhibit_builder_is_current_section($exhibitSection) ? ' current' : '') . '"><a class="exhibit-section-title" href="' . html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibitSection)) . '">' . html_escape($exhibitSection->title) . '</a>';
        if ($showAllPages || exhibit_builder_is_current_section($exhibitSection)) {
            $html .= exhibit_builder_page_nav($exhibitSection);
        }
        $html .= '</li>';
    }
    $html .= '</ul>';
    $html = apply_filters('exhibit_builder_nested_nav', $html, $exhibit, $showAllPages);
    return $html;
}

/**
* Gets the current exhibit section
*
* @return ExhibitSection|null
**/
function get_current_exhibit_section()
{
    return exhibit_builder_get_current_section();
}

/**
 * Sets the current exhibit section
 *
 * @see loop_exhibit_sections()
 * @param ExhibitSection
 * @return void
 **/
function set_current_exhibit_section(ExhibitSection $exhibitSection)
{
   exhibit_builder_set_current_section($exhibitSection);
}

/**
 * Sets the exhibit sections for loop
 *
 * @param array|null $exhibitSections
 * @return void
 **/
function set_exhibit_sections_for_loop($exhibitSections = null)
{
    __v()->exhibitSections = $exhibitSections;
}

/**
 * Sets the exhibit sections for loop to the exhibit sections for the current exhibit
 *
 * @param Exhibit|null $exhibit
 * @return void
 **/
function set_exhibit_sections_for_loop_by_exhibit($exhibit = null) 
{
    if (!$exhibit) {
        $exhibit = get_current_exhibit();
    }    
    if ($exhibit) {
        set_exhibit_sections_for_loop($exhibit->Sections);
    }
}

/**
 * Get the set of exhibit sections for the current loop.
 * 
 * @return array
 **/
function get_exhibit_sections_for_loop()
{
    return __v()->exhibitSections;
}

/**
 * Loops through exhibit sections assigned to the view.
 * 
 * @return mixed The current exhibit section
 */
function loop_exhibit_sections()
{
    return loop_records('exhibitSections', get_exhibit_sections_for_loop(), 'set_current_exhibit_section');
}

/**
 * Determine whether or not there are any exhibit sections in the database.
 * 
 * @return boolean
 **/
function has_exhibit_sections()
{
    return (total_exhibit_sections() > 0);    
}

/**
 * Determines whether there are any exhibit sections for loop.
 * @return boolean
 */
function has_exhibit_sections_for_loop()
{
    $view = __v();
    return ($view->exhibitSections and count($view->exhibitSections));
}

/**
  * Returns the total number of exhibit sections in the database
  *
  * @return integer
  **/
 function total_exhibit_sections() 
 {	
 	return get_db()->getTable('ExhibitSection')->count();
 }

/**
* Gets a property from an exhibit section
*
* @param string $propertyName
* @param array $options
* @param Exhibit $exhibitSection  The exhibit section
* @return mixed The exhibit section property value
**/
function exhibit_section($propertyName, $options = array(), $exhibitSection = null)
{
    if (!$exhibitSection) {
        $exhibitSection = get_current_exhibit_section();
    }
    $propertyName = Inflector::underscore($propertyName);
	if (property_exists(get_class($exhibitSection), $propertyName)) {
	    return $exhibitSection->$propertyName;
	} else {
	    return null;
	}
}