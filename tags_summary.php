<?php
	include_once('include/mysql_connection.php');
	include_once('test_scws.php');
	include_once('default_tags.php');
	header("Content-type: text/html; charset=utf-8"); 
	function tags_summary($email,$type=0){
		//自己加的标签
		$self="";
		$self_query="select biaoqian_self from user_info where email='$email'";
		$self_result=mysql_query($self_query);
		$self_row=mysql_fetch_array($self_result);
		if ($self_row[0]=='[]') {
			# code...
			$self.="[]";
		}else{
			$container=json_decode($self_row[0],true);
			for($i=0;$i<count($container);$i++){
				$self.=$container[$i]['biaoqian'];
			}
		}
		$other="";
		$other_query="select content from biaoqian where to_email='$email'";
		$other_result=mysql_query($other_query);
		while ($other_row=mysql_fetch_array($other_result)) {
			# code...
			$other.=$other_row[0];
		}
		$tags=$self.$other;
		if ($tags=='[]') {
			# code...
			// return default_tags($email);
		}
		if ($type==1) {
			# code...
			return word_scws($tags,1);
		}else{
			return word_scws($tags,0);
		}
	}
?>