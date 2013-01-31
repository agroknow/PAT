<?php
    require_once("./custom/include/db_connect.php");  
    
    $path_db="./application/config/db.ini";
	db_connect($path_db);

?>
<style>
#page_navigation {
 position:absolute;
 bottom:0;
}
.comment_results{

text-align:left;
padding-left:3px;
padding-top:3px;
padding-bottom:3px;
margin-top:3px;
margin-bottom:1px;
font-size:8pt;
border:1px solid #EEE9D9;
width:90%;
}

#content_paging td{
border:0px;
}
</style>

<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js') ?>"></script>
 <script>
     jQuery.noConflict();
   </script>
<script type="text/javascript" language="javascript" src="<?php echo uri('custom/threads/pager.js'); ?>"></script>
<!-- the input fields that will hold the variables we will use -->
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />




<?php
function onlyNumbers($string){
    //This function removes all characters other than numbers
    $string = preg_replace("/[^0-9]/", "", $string);
    return (int) $string;
} 

    $check_eid=onlyNumbers($_GET['eid']);
	
$thumbs = '<ul class="actions">
					<li class="vote">
					<a class="vote-up"/>
					<a class="vote-down"/>
					</li>
					<li class="score pos">+2</li>
					<li>
					</li>
			</ul>';
			


$sql="SELECT a.text, unix_timestamp(a.post_date) AS post_date_tmp, b.username, a.id FROM omeka_threads a 
	  INNER JOIN omeka_users b ON a.user_id=b.id
	  WHERE a.exhibit_id=".$check_eid." AND is_active='1' ORDER BY post_date desc";
$res=mysql_query($sql);


$content='<div id="content_paging" style="padding-left:20px;">';//gia paging

if (mysql_num_rows($res)){

	while ($result=mysql_fetch_array($res)){
	     $content2='';
	       $sql2="SELECT a.text, unix_timestamp(a.post_date) AS post_date_tmp, b.username, a.id FROM omeka_replies a 
	               INNER JOIN omeka_users b ON a.user_id=b.id
	                     WHERE a.thread_id=".nl2br($result['id'])." AND is_active='1' ORDER BY post_date desc";
			$res2=mysql_query($sql2);
			if (mysql_num_rows($res2)){
			$content2.='<hr style="color:#EEE9D9;border : none; border-top : dashed 1px #EEE9D9;margin-left:20px;">';
			while($result2=mysql_fetch_array($res2)){ 

			$content2.='<div style="padding-left:20px;"><table border="0" width="100%">';
			$content2.=
			'<tr>
		<td align="left"><strong>'.$result2['username'].'</strong> (posted on '.date('d/m/Y',intval($result2['post_date_tmp'])).')</td>
				<td align="right">&nbsp;
		</td></tr>';
		
		$content2.='<tr><td colspan="2">'.nl2br($result2['text']).'</td></tr>';
		$content2.='<tr><td colspan="2">&nbsp;</td></tr>';
		$content2.='</table></div>'; 
		

			} }

	
	$content.='<div class="comment_results"><table border="0" width="100%">';
	$thumbs2 = '<a class="lightview" rel="iframe" title=" ::  :: width: 680, height: 500" class="lightview" target="_blank" href="'.uri('threads_reply').'?eid='.$eid.'&thread_id='.nl2br($result['id']).'">Reply</a>';
		$content.=
			'<tr>
		<td align="left"><strong>'.$result['username'].'</strong> (posted on '.date('d/m/Y',intval($result['post_date_tmp'])).')</td>
				<td align="right" style="padding-right:120px;">'.$thumbs2.'
		</td></tr>';
		
		$content.='<tr><td colspan="2">'.nl2br($result['text']).'</td></tr>';
		
		//$content.='<tr class="watch-comment-entry"><td colspan="2">'.$thumbs2.'</td></tr>';
		$content.='<tr><td colspan="2">&nbsp;</td></tr>';
		$content.='</table>';
		$content.=$content2.'</div>';
	} 
	

}

else{ $content.='<div class="comment_results">There are no discussions for this exhibit</div>';}
$content.='</div>';//gia paging

echo $content;

// To retrieve the logged user you can use the following
//echo current_user()->first_name;
?>
