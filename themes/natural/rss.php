<?php 

require_once 'Zend/Db.php';	

$configSQL = new Zend_Config_Ini('./application/config/db.ini', 'database');

$params = array(
'host' => $configSQL->host,
'dbname' => $configSQL->name,
'username'=> $configSQL->username,
'password'=> $configSQL->password,
'charset'   => $configSQL->charset);
$db = Zend_Db::factory('Mysqli',$params);
$db->query("SET NAMES 'utf8'");



if(isset($_GET['rss']) and $_GET['rss']=='exhibits'){
$select = $db->select();
$select->distinct();
$select->from(array('exhib'=>'omeka_exhibits'),array('*'));
$select->join(array('sec'=>'omeka_sections'),'exhib.id=sec.exhibit_id',array());
$select->join(array('sec_pag'=>'omeka_section_pages'),'sec_pag.section_id=sec.id',array());
$select->join(array('sec_pag_it'=>'omeka_items_section_pages'),'sec_pag_it.page_id=sec_pag.id',array('text'));
$select->where('exhib.public = ?','1');
$select->where('sec.order = ?','1');
$select->order(array('exhib.id DESC'));
$select->limit(10);



//Create an array for our feed
$feed = array();

//Setup some info about our feed
$feed['title']        	= "ScienceTweets portal Exhibits";

$feed['link']         	= 'http://education.natural-europe.eu/test/portal/rss?rss=exhibits';

$feed['charset']   	= 'utf-8';

$feed['language'] 	= 'en-us';

$feed['published'] 	= time();

$feed['entries']   	= array();//Holds the actual items

//Loop through the stories, adding them to the entries array

$row = $db->fetchAll($select);
foreach($row as $story){
	$entry = array(); //Container for the entry before we add it on

	$entry['title'] 	= $story['title']; //The title that will be displayed for the entry

	$entry['link'] 		= uri("exhibits/".$story['slug']."/to-begin-with"); //The url of the entry

	$entry['description'] 	= $story['text']; //Short description of the entry

	$entry['content'] 	= $story['text']; //Long description of the entry
	
	$entry['lastUpdate']    = $story['date_modified'];

	$feed['entries'][] 	= $entry;
}

$rssFeedFromArray =
    Zend_Feed::importArray($feed, 'rss');

//Return the feed as a string, we're not ready to output yet
$feedString = $rssFeedFromArray->saveXML();

//Or we can output the whole thing, headers and all, with
$rssFeedFromArray->send();
}//rss=exhibits





if(isset($_GET['rss']) and $_GET['rss']=='collections'){
$select = $db->select();
$select->distinct();
$select->from(array('col'=>'omeka_collections'),array('*'));
$select->where('col.public = ?','1');
$select->order(array('col.id DESC'));
$select->limit(10);


//Create an array for our feed
$feed = array();

//Setup some info about our feed
$feed['title']        	= "ScienceTweets portal Collections";

$feed['link']         	= 'http://education.natural-europe.eu/test/portal/rss?rss=collections';

$feed['charset']   	= 'utf-8';

$feed['language'] 	= 'en-us';

$feed['published'] 	= time();

$feed['entries']   	= array();//Holds the actual items

//Loop through the stories, adding them to the entries array

$row = $db->fetchAll($select);
foreach($row as $story){
	$entry = array(); //Container for the entry before we add it on

	$entry['title'] 	= $story['name']; //The title that will be displayed for the entry

	$entry['link'] 		= uri("items/browse/?collection=".$story['id']."&amp;title=".$story['name']); //The url of the entry

	$entry['description'] 	= $story['description']; //Short description of the entry

	$entry['content'] 	= $story['description']; //Long description of the entry
	
	$feed['entries'][] 	= $entry;
}

$rssFeedFromArray =
    Zend_Feed::importArray($feed, 'rss');

//Return the feed as a string, we're not ready to output yet
$feedString = $rssFeedFromArray->saveXML();

//Or we can output the whole thing, headers and all, with
$rssFeedFromArray->send();
}//rss=collections


if(isset($_GET['rss']) and $_GET['rss']=='videos'){
$select = $db->select();
$select->distinct();
$select->from(array('text'=>'omeka_metatext'),array('text'));
$select->join(array('tpfld'=>'omeka_types_metafields'),'tpfld.metafield_id=text.metafield_id',array());
$select->join(array('fld'=>'omeka_metafields'),'fld.id=text.metafield_id',array());
$select->join(array('item'=>'omeka_items'),'item.id=text.item_id',array('title'));
$select->where('tpfld.type_id = ?','14');
$select->where('text.text <> ?','');
$select->where('fld.name = ?','Video');
$select->order(array('text.id DESC'));
$select->limit(10);

$iconM = '<img alt="" src="'.uri('themes/natural/images/bullet_medium.gif').'"/>';
	$iconE = '<img alt="" src="'.uri('themes/natural/images/bullet_easy.gif').'"/>';
	$iconA = '<img alt="" src="'.uri('themes/natural/images/bullet_advanced.gif').'"/>';


//Create an array for our feed
$feed = array();

//Setup some info about our feed
$feed['title']        	= "ScienceTweets portal Videos";

$feed['link']         	= 'http://education.natural-europe.eu/test/portal/rss?rss=videos';

$feed['charset']   	= 'utf-8';

$feed['language'] 	= 'en-us';

$feed['published'] 	= time();

$feed['entries']   	= array();//Holds the actual items

//Loop through the stories, adding them to the entries array

$row = $db->fetchAll($select);
foreach($row as $story){


             $item = str_replace("[M]", $iconM, $story["text"]);
			$item = str_replace("[E]", $iconE, $item);
			$item = str_replace("[A]", $iconA, $item);


	$entry = array(); //Container for the entry before we add it on

	$entry['title'] 	= $story['text']; //The title that will be displayed for the entry

	$entry['link'] 		= uri(""); //The url of the entry

	$entry['description'] 	= $item; //Short description of the entry

	$entry['content'] 	= $item; //Long description of the entry
	
	$feed['entries'][] 	= $entry;
}

$rssFeedFromArray =
    Zend_Feed::importArray($feed, 'rss');

//Return the feed as a string, we're not ready to output yet
$feedString = $rssFeedFromArray->saveXML();

//Or we can output the whole thing, headers and all, with
$rssFeedFromArray->send();
}//rss=videos




?>