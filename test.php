<?php
$uid = $_GET['uid'];
$status = $_GET['status'];
if($status === 1){
	
}else{
	
	
}


function up_line($uid)
{
	/*
	这里先判断最近一次下线时间大于下线时间
	*/
	if($last_online_time<$last_offline_time)
	{
		$date_time = time();
		$userModel->update('last_online_time');
	}else{
		return '在线';
	}
	
}

function down_line($uid){
	$date_time = time();
	if($last_online_time>time()){
		return '上线时间错误';
	}
	$userModel->update('date_time'); //更新下线时间
	$last_online_Y = date('Y',$last_online_time);
	$last_online_M = date('n',$last_online_time);
	$last_online_d = date('j',$last_online_time);
	$last_online_H = date('G',$last_online_time);
	$last_online_i = date('i',$last_online_time);
	$last_online_s = date('s',$last_online_time);
	
	
	$last_offline_Y = date('Y',$date_time);
	$last_offline_M = date('n',$date_time);
	$last_offline_d = date('j',$date_time);
	$last_offline_H = date('G',$date_time);
	$last_offline_i = date('i',$date_time);
	$last_offline_s = date('s',$date_time);
	if(($last_online_Y == $last_offline_Y) &&($last_online_M == $last_offline_M) && ($last_online_d==last_offline_d)){
		if($last_online_H == $last_offline_H){
			 if($last_offline_i-$last_online_i>1){
				 /*
				 在这边还需查询是不是已经达标 达标了就不需要插入
				 */
				 $online_1s->insert($last_offline_Y,$last_offline_M,$last_offline_d,$last_offline_H,$usr_id); //插入到达标表
			 }else{
				 if($last_offline_i==$last_online_i){
					 $s = $last_offline_s-$last_online_s;
					 if($s==60){
						 /*
						 在这边还需查询是不是已经达标 达标了就不需要插入
						 */
						 $online_1s->insert($last_offline_Y,$last_offline_M,$last_offline_d,$last_offline_H,$usr_id); //插入到达标表 
					 }else{
						 $online_s = $onlineMolde->('online_s'); //添加时年月日时
						 $online_s = $s +  $online_s;
						 if($online_s>=60){
							/*
						 在这边还需查询是不是已经达标 达标了就不需要插入
						 */
							$online_1s->insert($last_offline_Y,$last_offline_M,$last_offline_d,$last_offline_H,$usr_id); //插入到达标表 
						 }else{
							 $onlineMolde->save($online_s);  //存在就更新 不存在是插入
						 }
					 }
				 }else{
					 $s = $last_offline_s-$last_online_s;
					  $onlineMolde->save($online_s);  //存在就更新 不存在是插入
				 }
			 }
		}else{
			$h = $last_online_H -$last_offline_H;
			if($h >1){
				for($i=($last_online_H+1);$i<$last_offline_H;$i++)
				{
					$online_1s->insert($last_offline_Y,$last_offline_M,$last_offline_d,$i,$usr_id); //插入到达标表 
				}
				
				/*
				两级判断如下
				*/
			}else{
				$online_s =3600- ($last_online_i*60+$last_online_s);
				$online_s = $onlineMolde->('online_s'); //添加时年月日时
				$online_s = $s +  $online_s;
				 if($online_s>=60){
							/*
						 在这边还需查询是不是已经达标 达标了就不需要插入
						 */
					$online_1s->insert($last_online_Y,$last_online_M,$last_online_d,$last_online_H,$usr_id); //插入到达标表 
				}else{
					$onlineMolde->save($online_s);  //存在就更新 不存在是插入
				}
				
				$online_s = $last_offline_i*60+$last_offline_s;
				$online_s = $onlineMolde->('online_s'); //添加时年月日时
				$online_s = $s +  $online_s;
				 if($online_s>=60){
							/*
						 在这边还需查询是不是已经达标 达标了就不需要插入
						 */
					$online_1s->insert($last_offline_Y,$last_offline_M,$last_offline_d,$last_offline_H,$usr_id); //插入到达标表 
				}else{
					$onlineMolde->save($online_s);  //存在就更新 不存在是插入
				}
			}
		}
	}
	
}