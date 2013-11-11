<?php 
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
    $user = current_user();


if(isset($_GET['ts_id'])){
	$_GET['ts_id']=preg_replace("/[^0-9]/", "", $_GET['ts_id']);

$sql = 'SELECT * FROM omeka_teasers where id ="'.$_GET['ts_id'].'"';
$res = $db->query($sql);
$result_sqlexhibit = $res->fetch();

$result_sqlexhibit2=exhibit_builder_get_exhibit_by_id($result_sqlexhibit['exhibit_id']);

if ($user['id'] == 1 or $user['role'] == 'super' or $result_sqlexhibit2->wasAddedBy(current_user()) or sameinstitutionexhibit($result_sqlexhibit2, $user)) {

$sql = 'DELETE FROM omeka_teasers where id ="'.$_GET['ts_id'].'"';
$res2 = $db->query($sql);

 }
//$sql = 'SELECT a.*,b.title FROM omeka_teasers a JOIN omeka_items b ON a.item_id=b.id WHERE a.exhibit_id="'.$result_sqlexhibit['exhibit_id'].'" and a.pg_id="'.$result_sqlexhibit['pg_id'].'" and a.type!="europeana"';

//$sql="SELECT a.*,c.text FROM omeka_teasers a JOIN omeka_items b ON a.item_id=b.id JOIN omeka_element_texts c ON a.item_id=c.record_id WHERE a.exhibit_id=".$result_sqlexhibit['exhibit_id']." and a.pg_id=".$result_sqlexhibit['pg_id']." and a.type!='europeana' and c.element_id=68";


                        $sql2 = "SELECT a.*,c.text FROM omeka_teasers a JOIN omeka_items b ON a.item_id=b.id JOIN omeka_element_texts c ON a.item_id=c.record_id WHERE a.exhibit_id=" . $result_sqlexhibit['exhibit_id'] . " and a.pg_id=" . $result_sqlexhibit['pg_id'] . " and a.type!='europeana' and c.element_id=68";
                        $exec2 = $db->query($sql2);
                        $output='';
                        while ($data2 = $exec2->fetch()) {
                            //echo $data2['title'];
                            
                            $output .='<div id="pagedelete" style="padding-top:6px;">';
                            $output .='<a href="javascript:deleteObject('.$data2['id'].');"  class="delete" ><span class="section-delete">&nbsp;</span></a>';

                            $output .="<a style='padding-left:10px;' target='_new' href='" . uri('') . "items/edit/" . $data2['item_id'] . "'>" . $data2['text'] . "</a>";
                            ?>
                            </div> 
<?php } 
echo $output;
} else { echo '0'; }
?>