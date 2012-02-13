<?php
include_once 'templates/style.css';

if(!@$_GET['database'])
{
	die($lang['dieDatabaseChoose']);
}
else
{
	include_once 'config.inc.php';

	$transport->open();

	$client->execute('add jar '.$env['hive_jar']);
	$client->execute('use '.$_GET['database']);

	$client->execute($env['showTables']);
	$db_array = $client->fetchAll();

	if(!@$_POST["table_name"] || "" == $_POST["table_name"])
	{
		$i = 0;
		echo "<form method=post action=dbStructure.php name=tablenames>";
		echo "<table border=1>\n";
		echo "<tr bgcolor=#FFFF99><td><input name=\"allSelect\" type=\"checkbox\" id=\"allSelect\" value=\"\" onClick=\"javascript:isSelect(\'tablenames\');\" /></td><td>Table Name</td><td>Action</td></tr>";
		while ('' != @$db_array[$i])
		{
			if(($i % 2) == 0)
			{
				$color = $env['trColor1'];
			}
			else
			{
				$color = $env['trColor2'];
			}
			echo "<tr bgcolor=".$color.">\n";

			echo "<td>\n";
			echo "<input type=checkbox name=table_name[] value=".$db_array[$i].">";
			echo "</td>\n";
		
			echo "<td>\n";
			echo '<a href=sqlQuery.php?table='.$db_array[$i].'&database='.$_GET['database'].' target="right">'.$db_array[$i].'</a>';
			echo "</td>\n";
		
			echo "<td>\n";
			echo "<a href=alterTable.php?database=".$_GET['database']."&table=".$db_array[$i].">".$lang['alterTable']."</a>";
			echo "</td>\n";
		
			//echo "<td>\n";
			//echo "<a href=dropTable.php?database=".$_GET['database']."&table=".$db_array[$i].">".$lang['dropTable']."</a>";
			//echo "</td>\n";
		
			echo "</tr>\n";
			$i++;
		}
		echo "</table>\n";
		echo '<input name="allSelect" type="checkbox" id="allSelect" value="" onClick="isSelect(\'tablenames\')" />';
		echo $lang['select']." / ".$lang['deselect']."<bR><br>\n";
		echo "<input type=submit name=submit value=".$lang['submit'].">";
		echo "</form>";
		echo "";
	}
	else
	{
		var_dump($_POST["table_name"]);
	}
	$transport->close();
}
?>