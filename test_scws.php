<?php
function word_scws($text,$type){
	$sh = scws_open();
	scws_set_charset($sh, 'utf8');
	// scws_set_dict($sh, '/path/to/dict.xdb');
	// scws_set_rule($sh, '/path/to/rules.ini');
	// $text = "习近平表示，这次访问给我和我的夫人留下了深刻美好的印象。我对英国王室、政府和人民给予的热情接待和周到安排表示诚挚谢意。访问期间，中英双方一致同意共同构建中英面向21世纪全球全面战略伙伴关系，开启持久、开放、共赢的中英关系“黄金时代”。我对中英关系未来充满信心";
	scws_send_text($sh, $text);
	$top = scws_get_tops($sh, 5);
	$top_list=array();
	$top_score_list=array();
	for($i=0;$i<count($top);$i++){
		// echo $top[$i]['word'];
		// echo $top[$i]['weight'];
		// echo $top[$i]['attr'];
		// echo "<br/>";
		array_push($top_list, $top[$i]['word']);
		array_push($top_score_list, $top[$i]['weight']);
	}
	if (count($top)==0) {
		# code...
		return "[]";
	}
	if ($type==1) {
		# code...
		return array($top_list,$top_score_list);
	}else{
		return $top_list;
	}
	// print_r($top);
}
?>