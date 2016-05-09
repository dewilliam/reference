<?php
	include_once('mysql_connection.php');
	include_once('tags_summary.php');
	function default_tags($email){
		$like_list_query="select to_email from niubility where from_email='$email'";
		$like_list_result=mysql_query($like_list_query);
		$like_list=array();
		while ($like_list_row=mysql_fetch_array($like_list_result)) {
			# code...
			array_push($like_list, $like_list_row[0]);
		}
		if (count($like_list)==0) {
			# code...
			return '[]';
		}
		//把每个被该用户点过赞的用户的标签找出来
		$tags_list=array();
		$tags_weight_list=array();
		for($i=0;$i<count($like_list);$i++){
			$each=tags_summary($like_list[$i],1);
			for($j=0;$j<count($each);$j++){
				array_push($tags_list, $each[0][$j]);
				array_push($tags_weight_list, $each[0][$j]);
			}
		}
		$max_weight=-1;
		$max_num=0;
		for($i=0;$i<count($tags_list);$i++){
			if ($tags_weight_list[$i]>=$max_weight) {
				# code...
				$max_num=$i;
			}
		}
		return array($tags_list[$max_num]);
	}
?>
