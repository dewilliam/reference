<?php
	include_once('include/mysql_connection.php');
	function similarity($code_first,$code_second){
		$a=0.65;
		$b=0.8;
		$c=0.9;
		$d=0.96;
		$e=0.5;
		$f=0.1;
		if ($code_first[0]!=$code_second[0]) {
			# code...
			return $f;
		}else if ($code_first[1]!=$code_second[1]) {
			# code...
			//求n，分支层的节点总数
			$n_array=array();
			$capital=substr($code_first, 0,1);
			$n_query="select code from code where code like '$capital%'";
			$n_result=mysql_query($n_query);
			while($n_row=mysql_fetch_array($n_result)){
				if (in_array($n_row[0][1], $n_array)) {
					# code...
					continue;
				}else{
					array_push($n_array, $n_row[0][1]);
				}
			}
			$n=count($n_array);
			//求K，两个分支的距离，字母
			$k=abs(ord($code_first[1])-ord($code_second[1]));
			//计算相似度
			$sim=abs($a*cos($n*(M_PI/180))*(($n-$k+1)/$n));
			return $sim;
		}else if ($code_first[2].$code_first[3]!=$code_second[2].$code_second[3]) {
			# code...
			//求n
			$n_array=array();
			$capital=substr($code_first, 0,2);
			$n_query="select code from code where code like '$capital%'";
			$n_result=mysql_query($n_query);
			while($n_row=mysql_fetch_array($n_result)){
				if (in_array($n_row[0][2].$n_row[0][3], $n_array)) {
					# code...
					continue;
				}else{
					array_push($n_array, $n_row[0][2].$n_row[0][3]);
				}
			}
			$n=count($n_array);
			//求k，两个数字
			$k=abs(intval($code_first[2].$code_first[3])-intval($code_second[2].$code_second[3]));
			//相似度
			$sim=$b*cos($n*(M_PI/180))*(($n-$k+1)/$n);
			return $sim;
		}else if ($code_first[4]!=$code_second[4]) {
			# code...
			//求n
			$n_array=array();
			$capital=substr($code_first, 0,4);
			$n_query="select code from code where code like '$capital%'";
			$n_result=mysql_query($n_query);
			while($n_row=mysql_fetch_array($n_result)){
				if (in_array($n_array, $n_row[0][4])) {
					# code...
					continue;
				}else{
					array_push($n_array, $n_row[0][4]);
				}
			}
			$n=count($n_array);
			//k，字母
			$k=abs(ord($code_first[4])-ord($code_second[4]));
			//sim
			$sim=$c*cos(($n*(M_PI/180)*(($n-$k+1)/$n)));
			return $sim;
		}else if ($code_first[5].$code_first[6]!=$code_second[5].$code_second[6]) {
			# code...
			//求n
			$n_array=array();
			$capital=substr($code_first, 0,5);
			$n_query="select code from code where code like '$capital%'";
			$n_result=mysql_query($n_query);
			while($n_row=mysql_fetch_array($n_result)){
				if (in_array($n_row[0][5].$n_row[0][6], $n_array)) {
					# code...
					continue;
				}else{
					array_push($n_array, $n_row[0][5].$n_row[0][6]);
				}
			}
			$n=count($n_array);
			//k,两个数字
			$k=abs(intval($code_first[5].$code_first[6])-intval($code_second[5].$code_second[6]));
			//sim
			$sim=$d*cos($n*(M_PI/180))*(($n-$k+1)/$n);
			return $sim;
		}else{
			if ($code_first[7]=='=') {
				# code...
				return 1;
			}else if ($code_first[7]=='#') {
				# code...
				return $e;
			}else{
				return 0;
			}
		}
	}
	function init_similarity($word_first,$word_second){
		if ($word_first=='['||$word_second=='['||$word_first==']'||$word_second==']') {
			# code...
			return 0.1;
		}
		if ($word_first==$word_second) {
			# code...
			return 1;
		}
		$one_query="select code from words where word='$word_first'";
		//先看一下code是否为空
		$one_test_result=mysql_query($one_query);
		$one_test_row=mysql_fetch_array($one_test_result);
		if (!$one_test_row) {
			# code...
			return 0.1;
		}
		//查看完毕，
		$one_result=mysql_query($one_query);
		$code_first=array();
		$code_second=array();
		while ($one_row=mysql_fetch_array($one_result)) {
			# code...
			array_push($code_first, $one_row[0]);
		}
		$second_query="select code from words where word='$word_second'";
		//看看code是否为空
		$second_test_result=mysql_query($second_query);
		$second_test_row=mysql_fetch_array($second_test_result);
		if (!$second_test_row) {
			# code...
			return 0.1;
		}
		//查看完毕
		$second_result=mysql_query($second_query);
		while ($second_row=mysql_fetch_array($second_result)) {
			# code...
			array_push($code_second, $second_row[0]);
		}
		$sim_list=array();
		for($i=0;$i<count($code_first);$i++){
			for($j=0;$j<count($code_second);$j++){
				$each_sim=similarity($code_first[$i],$code_second[$j]);
				// echo $each_sim;
				array_push($sim_list, $each_sim);
			}
		}
		return max($sim_list);
		// mysql_close($con);
	}
	// $word_first='揍来着';
	// $word_second='同志';
?>