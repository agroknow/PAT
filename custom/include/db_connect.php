<?php

function db_connect($path_db){
    $file_array=file($path_db) or die("Unable to open file!");


    for ($i=0;$i<count($file_array);$i++){
        //host extract
        if ( strlen(strstr(str_replace(' ', '', $file_array[$i]), "host=" )) > 0 ){
            $host_line=str_replace(' ', '', $file_array[$i]);
            $value_array=str_split($host_line);
            $count=0;
            $real_value="";
            for($j=0;$j<count($value_array);$j++){
                if ( $count == 1 && $value_array[$j] != '"' && $value_array[$j] != " " ){
                    $real_value.=$value_array[$j];
                }
                
                if ( $value_array[$j] == '"' ){
                    $count++;                    
                }    
            }
            $host=$real_value;
        }
        
        //username extract
        if ( strlen(strstr(str_replace(' ', '', $file_array[$i]), "username=" )) > 0 ){
            $host_line=str_replace(' ', '', $file_array[$i]);
            $value_array=str_split($host_line);
            $count=0;
            $real_value="";
            for($j=0;$j<count($value_array);$j++){
                if ( $count == 1 && $value_array[$j] != '"' && $value_array[$j] != " " ){
                    $real_value.=$value_array[$j];
                }
                
                if ( $value_array[$j] == '"' ){
                    $count++;                    
                }    
            }
            $username=$real_value;
        }
        
        //password extract
        if ( strlen(strstr(str_replace(' ', '', $file_array[$i]), "password=" )) > 0 ){
            $host_line=str_replace(' ', '', $file_array[$i]);
            $value_array=str_split($host_line);
            $count=0;
            $real_value="";
            for($j=0;$j<count($value_array);$j++){
                if ( $count == 1 && $value_array[$j] != '"' && $value_array[$j] != " " ){
                    $real_value.=$value_array[$j];
                }
                
                if ( $value_array[$j] == '"' ){
                    $count++;                    
                }    
            }
            $password=$real_value;
        }
        
        //database extract
        if ( strlen(strstr(str_replace(' ', '', $file_array[$i]), "name=" )) > 0 ){
            $host_line=str_replace(' ', '', $file_array[$i]);
            $value_array=str_split($host_line);
            $count=0;
            $real_value="";
            for($j=0;$j<count($value_array);$j++){
                if ( $count == 1 && $value_array[$j] != '"' && $value_array[$j] != " " ){
                    $real_value.=$value_array[$j];
                }
                
                if ( $value_array[$j] == '"' ){
                    $count++;                    
                }    
            }
        }          
        $name=$real_value;
    }



$con=mysql_connect($host,$username,$password) 
	 or exit("<html>
			<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html;charset=windows-1253\">
			</head>
			<body>
			<h2 align=center>Error in Connecting with the Database</h2>
			<p align=center>The connection with the Database is temporarily down. Please <strong>try later</strong></p>
			</body>
			</html>");

$db_selected = mysql_select_db($name,$con);

mysql_query ("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'"); 
}
?>