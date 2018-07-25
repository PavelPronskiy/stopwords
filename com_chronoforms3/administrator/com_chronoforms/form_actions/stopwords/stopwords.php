<?php
/**
* CHRONOFORMS version 4.0
* Copyright (c) 2006 - 2011 Chrono_Man, ChronoEngine.com. All rights reserved.
* Author: Chrono_Man (ChronoEngine.com)
* @license		GNU/GPL
* Visit http://www.ChronoEngine.com for regular updates and information.
**/
defined('_JEXEC') or die('Restricted access');
class CfactionStopWords{
	var $formname;
	var $formid;
	var $group = array('id' => 'anti_spam', 'title' => 'Anti SPAM');
	var $events = array('success' => 0, 'fail' => 0);
	var $fail = array('actions' => array('show_HTML'));
	var $details = array('title' => 'Stop Words', 'tooltip' => 'Stop spam words');
	

	function get_stopwords($config)
	{
		$sw = explode(PHP_EOL, $config->get('stopwords'));
		foreach ($sw as $field => $value)
			$sw[$field] = trim($value);

		return $sw;
	}

	function check_stopwords($sw, $form)
	{
		$fsw = array();
		foreach ($sw as $field => $value)
			if (preg_grep("/\b({$value})/iu", $form->data))
				$fsw[$field] = $value;

		return $fsw;
	}


	function run($form, $actiondata){
		$config = new JParameter($actiondata->params);
		$stopwords_array = $this->get_stopwords($config);
		$found_stopwords = $this->check_stopwords($stopwords_array, $form);
		$found_stopwords_str = implode(' ', $found_stopwords);

		$fail_head_message = $config->get('fail_head', "Обнаружены запрещённые стоп-слова:");
		$fail_foot_message = $config->get('fail_foot', "Удалите их из сообщения и отправьте снова.");
		$fail_message = $fail_head_message . '<pre>' . $found_stopwords_str . '</pre>' . $fail_foot_message;

		if (sizeof($found_stopwords) > 0)
		{
			$this->events['fail'] = 1;
			$form->validation_errors['stopwords'] = $fail_message;
			$form->debug['stopwords'][] = "fail";
		}
		else
		{
			$this->events['success'] = 1;
			$form->debug['stopwords'][] = "success";
		}
	}
	
	function load($clear){
		if($clear){
			$action_params = array(
				'stopwords' => 'http',
				'fail_head_message' => "Обнаружены запрещённые стоп-слова:",
				'fail_foot_message' => "Удалите их из сообщения и отправьте снова.",
			);
		}
		return array('action_params' => $action_params);
	}
}
?>