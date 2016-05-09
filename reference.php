<?php
	include_once('include/mysql_connection.php');
	include_once('include/word_similarity.php');
	include_once('tags_summary.php');
	// $start=microtime(true);
	$email=$_POST['email'];
	$my_tags=tags_summary($email);
	$email_list=array();
	$tags_list=array();
	$query="select email from user_info where email!='$email' order by rank asc";
	$result=mysql_query($query);
	while ($row=mysql_fetch_array($result)) {
		# code...
		array_push($email_list, $row[0]);
		array_push($tags_list, tags_summary($row[0]));
	}
	$sim_array=array();
	for($i=0;$i<count($email_list);$i++){
		$each_sim=array();
		for($m=0;$m<count($my_tags);$m++){
			for($t=0;$t<count($tags_list[$i]);$t++){
				$sim=init_similarity($my_tags[$m],$tags_list[$i][$t]);
				array_push($each_sim, $sim);
			}
		}
		array_push($sim_array, max($each_sim));
	}
	//冒泡排序
	for($i=0;$i<count($email_list);$i++){
		for($j=$i;$j<count($email_list);$j++){
			if ($sim_array[$i]<$sim_array[$j]) {
				# code...
				$temp=$sim_array[$j];
				$sim_array[$j]=$sim_array[$i];
				$sim_array[$i]=$temp;
				$temp=$email_list[$i];
				$email_list[$i]=$email_list[$j];
				$email_list[$j]=$temp;
			}
		}
	}
	//输出排序靠前的几位信息,用户太少，暂定全部输出
	$query="select email,profile_address,biaoqian_self_num,rank,name from user_info where ";
	for($i=0;$i<count($email_list);$i++){
		$each=$email_list[$i];
		$query.="email='$each' or ";
	}
	$query=substr($query, 0,-3);
	$result=mysql_query($query);
	$whole=array();
	$num=0;
	while ($row=mysql_fetch_array($result)) {
		# code...
		$email=$row[0];
		$profile_address=$row[1];
		$biaoqian_num=$row[2];
		$rank=$row[3];
		$name=$row[4];
		$pic_query="select pic_address from nahan where email='$email' and type='1' order by id desc limit 5";
		$pic_result=mysql_query($pic_query);
		$imgs=array();
		$back_img=null;
		$img_num=0;
		while ($pic_row=mysql_fetch_array($pic_result)) {
			# code...
			if ($img_num==0) {
				# code...
				$back_img=$pic_row[0];
			}
			$each_img=$pic_row[0];
			array_push($imgs, '{"img_address":"'.$each_img.'"}');
			$img_num+=1;
		}
		$imgs='['.implode(',',$imgs).']';
		$similarity=$sim_array[$num];
		$each='{"email":"'.$email.'","name":"'.$name.'","img":"'.$profile_address.'","biaoqian_num":"'.$biaoqian_num.'","rank":"'.$rank.'","back_img":"'.$back_img.'","imgs":'.$imgs.',"similarity":"'.$similarity.'"}';
		array_push($whole, $each);
		$num+=1;
	}
	echo '['.implode(',', $whole).']';
	// $end=microtime(true);
	// $during=$end-$start;
	// echo "<br/>druing:".$during;
?>