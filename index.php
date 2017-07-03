<?php
//
//  index.php
//  redkitty
//
//  Created by Anze on 2011-06-06.
//  Copyright 2011 0804Team. All rights reserved.
//  Licensed under MIT
//

if (isset($_GET['param'])) {
	$url = explode('/', $_GET['param']);
}
else {
	$url = array();
}

try {
	require_once('config.php');
	require_once('autoload.php');

	if ($config['core']['debug']) {
		ini_set('display_errors', 'On');
		error_reporting($config['core']['debug_reporting']);
	}
	else {
		ini_set('display_errors', 'Off');
		error_reporting(0);
	}

	date_default_timezone_set($config['core']['timezone']);

	if ($config['redis']['enabled']) {
		$redis = new Redis($config['redis']);
	}
	else {
		throw new Exception('Redis not enabled');
	}

	if (($url[0]=='console')&&(isset($_GET['command']))) {
		@session_start();
		$user_command = urldecode($_GET['command']);

		$command = explode(' ', $user_command);
		$method = array_shift($command);

		if ($method=='select') {
			if ((empty($_SESSION['db_selected']))||($_SESSION['db_selected']!==$command[0])) {
				$_SESSION['db_selected'] = $command[0];
			}
		}
		elseif (!empty($_SESSION['db_selected'])) {
			$redis->select($_SESSION['db_selected']);
		}

		$output = $redis->$method($command);

		header("Content-Type: text/plain");
		echo Helper::format($output);
		die;
	}

	$info = $redis->info();
	$info = explode("\n", $info);

	$ro = array();
	$dbs = array();
	$template = '';
	$per_page = 20;

	foreach($info as $t) {
		if (($t[0]=='d')&&($t[1]=='b'))
			$dbs[] = $t;
	}
	foreach($dbs as $k=>$db) {
		$str = str_replace(':', ',', $db);
		$ex = explode(',', $str);
		$item = array(
			'db' => str_replace('db', '', $ex[0]),
			'keys' => str_replace('keys=', '', $ex[1]),
			'expires' => str_replace('expires=', '', $ex[2])
		);
		$ro['dbs'][] = $item;
	}

	if ($url[0]=='info') {
		$template = '_statistics';
		foreach($info as $t) {
			if ($t) {
				if (strstr($t, 'allocation_stats')) {
					$tup = explode(':', $t);
					$ro[$tup[0]]['values'] = explode(',', $tup[1]);
				}
				else {
					$tup = explode(':', $t);
					$ro[$tup[0]] = $tup[1];
				}
			}
		}
	}
	elseif ($url[0]=='server') {
		$template = '_server';
		$page = intval($_GET['page']);
		$pager['current'] = $page;

		$db = str_replace('db', '', $url[1]);
		if (!is_numeric($db)) {
			throw new Exception('Not a db');
		}
		$db = intval($db);
		$tmp = $redis->select($db);
		$ro['server'] = $db;
		$ro['keys_cnt'] = $redis->dbsize();

		if (($url[2]=='key') && (isset($url[3]))) {
			$template = '_key';
			$keys = $redis->keys(urldecode($url[3]));
			$inkey = $url[3];
			if (count($keys)==1) {
				$ro['key'] = $keys[0];
				$ro['type'] = $redis->type($ro['key']);
				if ($ro['type']=='hash') {
					$ro['lenght'] = $redis->hlen($ro['key']);
					$values = $redis->hgetall($ro['key']);
					$cnt = count($values);
				
					$pager['total'] = 0;
					$pager['start'] = 0;
					$pager['stop'] = 0;
				
					for($i=0; $i<$cnt; $i+=2) {
						$item = array();
						$item['key'] = $values[$i];
						$item['value'] = $values[$i+1];
						$ro['values'][] = $item;
					}
				}
				elseif ($ro['type']=='list') {
					$ro['lenght'] = $redis->llen($ro['key']);

					$pager['total'] = ceil($ro['lenght']/$per_page);
					$pager['start'] = (($page>0)?($page-1):0)*$per_page;
					$pager['stop'] = $pager['start']+$per_page;
					if ($pager['stop']>$ro['lenght'])
						$pager['stop']=$ro['lenght'];

					for($i=$pager['start']; $i<$pager['stop']; $i++) {
						$item = array();
						$item['key'] = sprintf("%05d", $i);
						$item['value'] = $redis->lindex(array($ro['key'], $i));
						$ro['values'][] = $item;
					}
				}
				elseif ($ro['type']=='string') {
					$ro['lenght'] = $redis->strlen($ro['key']);
					$values = $redis->get($ro['key']);
					$item = array();
					$item['key'] = $ro['key'];
					$item['value'] = $values;
					$ro['values'][] = $item;
				}
				elseif ($ro['type']=='set') {
					$ro['lenght'] = $redis->scard(array($ro['key']));
					$values = $redis->smembers(array($ro['key']));

					$pager['total'] = ceil($ro['lenght']/$per_page);
					$pager['start'] = (($page>0)?($page-1):0)*$per_page;
					$pager['stop'] = $pager['start']+$per_page;
					if ($pager['stop']>$ro['lenght'])
						$pager['stop']=$ro['lenght'];

					for($i=$pager['start']; $i<$pager['stop']; $i++) {
						$item = array();
						$item['key'] = sprintf("%05d", $i);
						$item['value'] = $values[$i];
						$ro['values'][] = $item;
					}
				}
				elseif ($ro['type']=='zset') {
					$ro['lenght'] = $redis->zcount(array($ro['key'], 0, 10000000));
					$values = $redis->zrangebyscore(array($ro['key'], 0, 1000000));

					$pager['total'] = ceil($ro['lenght']/$per_page);
					$pager['start'] = (($page>0)?($page-1):0)*$per_page;
					$pager['stop'] = $pager['start']+$per_page;
					if ($pager['stop']>$ro['lenght'])
						$pager['stop']=$ro['lenght'];

					for($i=$pager['start']; $i<$pager['stop']; $i++) {
						$item = array();
						$item['key'] = sprintf("%05d", $i);
						$item['value'] = $values[$i];
						$ro['values'][] = $item;
					}
				}
			}
			else {
				foreach($keys as $key) {
					$item = array();
					$item['key'] = $key;
					$item['type'] = $redis->type($key);
					if ($item['type']=='hash')
						$item['lenght'] = $redis->hlen($key);
					elseif ($item['type']=='list')
						$item['lenght'] = $redis->llen($key);
					elseif ($item['type']=='string')
						$item['lenght'] = $redis->strlen($key);
					elseif ($item['type']=='set')
						$item['lenght'] = $redis->scard(array($key));
					elseif ($item['type']=='zset')
						$item['lenght'] = $redis->zcount(array($key, 0, 10000000));

					$ro['keys'][] = $item;
				}
			}
		}
		else {
			if ($ro['keys_cnt']<200) {
				$keys = $redis->keys('*');
			}
			else {
				$message = ', selected 20 random keys';
				for($i=0; $i<20; $i++)
					$keys[] = $redis->randomkey();
			}

			foreach($keys as $key) {
				$item = array();
				$item['key'] = $key;
				$item['type'] = $redis->type($key);
				if ($item['type']=='hash')
					$item['lenght'] = $redis->hlen($key);
				elseif ($item['type']=='list')
					$item['lenght'] = $redis->llen($key);
				elseif ($item['type']=='string')
					$item['lenght'] = $redis->strlen($key);
				elseif ($item['type']=='set')
					$item['lenght'] = $redis->scard(array($key));
				elseif ($item['type']=='zset')
					$item['lenght'] = $redis->zcount(array($key, 0, 10000000));

				$ro['keys'][] = $item;
			}
		}
	}
	elseif ($url[0]=='console') {
		$template = '_console';
		foreach($info as $t) {
			if ($t) {
				if (strstr($t, 'allocation_stats')) {
					$tup = explode(':', $t);
					$ro[$tup[0]]['values'] = explode(',', $tup[1]);
				}
				else {
					$tup = explode(':', $t);
					$ro[$tup[0]] = $tup[1];
				}
			}
		}
	}
	else {
		$uptime = 0;
		$version = '';
		$fragmentation = 0;
		$memory = array();
		$dbs = array();
		foreach($info as $t) {
			if (($t[0]=='d') && ($t[1]=='b'))
				$dbs[] = $t;
			elseif (strstr($t, 'redis_version')) {
				$tup = explode(':', $t);
				$version = $tup[1];
			}
			elseif (strstr($t, 'uptime_in_days')) {
				$tup = explode(':', $t);
				$uptime = $tup[1];
			}
			elseif (strstr($t, 'used_memory')) {
				$tup = explode(':', $t);
				$memory[$tup[0]] = $tup[1];
			}
			elseif (strstr($t, 'mem_fragmentation_ratio')) {
				$tup = explode(':', $t);
				$fragmentation = $tup[1];
			}
		}

		$ro['keys_cnt'] = $redis->dbsize();
		$ro['uptime'] = $uptime;
		$ro['version'] = $version;
		$ro['memory'] = $memory;
		$ro['fragmentation'] = $fragmentation;
		$ro['last_save'] = $redis->lastsave();
	}

	require_once('templates/kitty'.$template.'.php');
}
catch(Exception $e) {
	if ($_GET['command'])
		echo $e->getMessage();
	else
		require_once('templates/error.php');
}

die;
?>