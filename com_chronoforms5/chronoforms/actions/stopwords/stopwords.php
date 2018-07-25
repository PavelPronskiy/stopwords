<?php
/**
* ChronoCMS version 1.0
* Copyright (c) Pavel Pronskiy
* license: Please read LICENSE.txt
**/
namespace GCore\Admin\Extensions\Chronoforms\Actions\Stopwords;
/* @copyright:ChronoEngine.com @license:GPLv2 */defined('_JEXEC') or die('Restricted access');
defined("GCORE_SITE") or die;

define('ST_SUBLABEL', 'Список стоп-слов и regex паттерны (PHP)');
define('ST_LABEL', 'Список стоп-слов');
define('ST_STOPWORD_DETECT', 'Обнаружены запрещённые стоп-слова: ');
define('ST_STOPWORD_DETECT2', 'удалите их из сообщения и отправьте снова.');
define('ST_FAIL_MESSAGE_HEAD_LABEL', 'Сообщение об ошибке, шапка.');
define('ST_FAIL_MESSAGE_HEAD_SUBLABEL', 'Отображается вверху если обнаружены стоп-слова');
define('ST_FAIL_MESSAGE_FOOT_LABEL', 'Сообщение об ошибке, футер');
define('ST_FAIL_MESSAGE_FOOT_SUBLABEL', 'Отображается внизу если обнаружены стоп-слова');
define('ST_DEBUG_SUCCESS', 'Stopwords не обнаружил стоп-слова');
define('ST_DEBUG_FAIL', 'Stopwords обнаружил стоп-слова');

Class Stopwords extends \GCore\Admin\Extensions\Chronoforms\Action {

	static $title = 'Stopwords';
	static $group = array('anti_spam' => 'Anti Spam');

	var $events = array('success' => 0, 'fail' => 0);
	var $defaults = array(
		'stopwords' => 'http',
		'fail_head_message' => "Обнаружены запрещённые стоп-слова:",
		'fail_foot_message' => "Удалите их из сообщения и отправьте снова.",
	);

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
			if (preg_grep("/{$value}/i", $form->data))
				$fsw[$field] = $value;

		return $fsw;
	}
	
	function execute(&$form, $action_id){
		$config =  $form->actions_config[$action_id];
		$config = new \GCore\Libs\Parameter($config);

		$stopwords_array = $this->get_stopwords($config);
		$found_stopwords = $this->check_stopwords($stopwords_array, $form);
		$found_stopwords_str = implode(' ', $found_stopwords);

		$fail_head_message = $config->get('fail_head_message');
		$fail_foot_message = $config->get('fail_foot_message');
		$fail_message = $fail_head_message . '<pre>' . $found_stopwords_str . '</pre>' . $fail_foot_message;

		/* echo '<pre>';
		var_dump($found_stopwords);
		echo '</pre>';*/

		if (sizeof($found_stopwords) > 0)
		{
			$this->events['fail'] = 1;
			$form->errors['chrono_stopwords'] = $fail_message;
			$form->debug[$action_id][self::$title][] = ST_DEBUG_FAIL;
			return false;
		}
		else
		{
			$this->events['success'] = 1;
			$form->debug[$action_id][self::$title][] = ST_DEBUG_SUCCESS;
			return true;
		}
	}

	public static function config(){
		echo \GCore\Helpers\Html::formStart('action_config stopwords_action_config', 'stopwords_action_config__XNX_');
		echo \GCore\Helpers\Html::formLine('Form[extras][actions_config][_XNX_][stopwords]', array('type' => 'textarea', 'label' => ST_LABEL, 'id' => 'stopwords_message_content__XNX_', 'rows' => 10, 'cols' => 40, 'sublabel' => ST_SUBLABEL));
		echo \GCore\Helpers\Html::formLine('Form[extras][actions_config][_XNX_][fail_head_message]', array('type' => 'textarea', 'label' => ST_FAIL_MESSAGE_HEAD_LABEL, 'rows' => 5, 'cols' => 40, 'sublabel' => ST_FAIL_MESSAGE_HEAD_SUBLABEL));
		echo \GCore\Helpers\Html::formLine('Form[extras][actions_config][_XNX_][fail_foot_message]', array('type' => 'textarea', 'label' => ST_FAIL_MESSAGE_FOOT_LABEL, 'rows' => 5, 'cols' => 40, 'sublabel' => ST_FAIL_MESSAGE_FOOT_SUBLABEL));
		echo \GCore\Helpers\Html::formEnd();
	}
}