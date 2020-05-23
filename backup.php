<?php
	include "../mysql/mysqli.class.php";
        require_once('settings.php');
        
        $db_host =		"localhost";		//MySQL Host
	$db_name =		"mcape067_maladb";	//MySQL DB name
	$db_user =		"mcape067_mysql";	//MySQL User
	$db_password =           "tartaruga";
        
    
backup_tables("*");

function backup_tables($tables = '*')
{	
	//$DB1 = new mysql;
    //$connec = $DB1->Connect("mcape067_maladb");
        $connec = mysqli_connect("localhost","mcape067_mysql","tartaruga", "mcape067_maladb");
	//$link = mysql_connect($host,$user,$pass);
	//mysql_select_db($name,$link);
	//mysql_query("SET NAMES 'utf8'");
	
	//get all of the tables
	if($tables == '*')
	{	
		$tables = array();
		$result = mysqli_query($connec, 'SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	$return='';
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysqli_query($connec, 'SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		$return.= 'DROP TABLE IF EXISTS '.$table.';';
		$row2 = mysqli_fetch_row(mysqli_query($connec, 'SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = str_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	//$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	//fwrite($handle,utf8_encode($return));
	//fclose($handle);

	$filename = 'mala-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
	Header("Content-type: application/octet-stream");
	Header("Content-Disposition: attachment; filename=$filename");
	echo $return;

	$DB1->Close();
}
?>