<?
define('ST_SUBLABEL', 'Список стоп-слов и regex паттерны (PHP)');
define('ST_LABEL', 'Список стоп-слов');
define('ST_FAIL_MESSAGE_HEAD_LABEL', 'Сообщение об ошибке, шапка.');
define('ST_FAIL_MESSAGE_HEAD_SUBLABEL', 'Отображается вверху если обнаружены стоп-слова');
define('ST_FAIL_MESSAGE_FOOT_LABEL', 'Сообщение об ошибке, футер');
define('ST_FAIL_MESSAGE_FOOT_SUBLABEL', 'Отображается внизу если обнаружены стоп-слова');
define('ST_DEBUG_SUCCESS', 'Stopwords не обнаружил стоп-слова');
define('ST_DEBUG_FAIL', 'Stopwords обнаружил стоп-слова');
?>
<div class="dragable" id="cfaction_stopwords">Stop Words</div>
<!--start_element_code-->
<div class="element_code" id="cfaction_stopwords_element">
	<label class="action_label" style="display: block; float:none!important;">Stop Words - <?php echo $action_params['action_label']; ?></label>
	<div id="cfactionevent_stopwords_{n}_success" class="form_event good_event">
		<label class="form_event_label">OnSuccess</label>
	</div>
	<div id="cfactionevent_stopwords_{n}_fail" class="form_event bad_event">
		<label class="form_event_label">OnFail</label>
	</div>
	<textarea name="chronoaction[{n}][action_stopwords_{n}_stopwords]" id="action_stopwords_{n}_stopwords" style="display:none"><?php echo htmlspecialchars($action_params['stopwords']); ?></textarea>
	<input type="hidden" name="chronoaction[{n}][action_stopwords_{n}_fail_head]" id="action_stopwords_{n}_fail_head" value="<?php echo $action_params['fail_head']; ?>" />
	<input type="hidden" name="chronoaction[{n}][action_stopwords_{n}_fail_foot]" id="action_stopwords_{n}_fail_foot" value="<?php echo $action_params['fail_foot']; ?>" />
	<input type="hidden" id="chronoaction_id_{n}" name="chronoaction_id[{n}]" value="{n}" />
	<input type="hidden" name="chronoaction[{n}][type]" value="stopwords" />
</div>
<!--end_element_code-->
<div class="element_config" id="cfaction_stopwords_element_config">
	<?php echo $HtmlHelper->input('action_stopwords_{n}_stopwords_config', array('type' => 'textarea', 'label' => ST_LABEL, 'rows' => 8, 'cols' => 70, 'smalldesc' => ST_SUBLABEL)); ?>
	<?php echo $HtmlHelper->input('action_stopwords_{n}_fail_head_config', array('type' => 'textarea', 'label' => ST_FAIL_MESSAGE_HEAD_LABEL, 'rows' => 3, 'cols' => 70, 'smalldesc' => ST_FAIL_MESSAGE_HEAD_SUBLABEL)); ?>
	<?php echo $HtmlHelper->input('action_stopwords_{n}_fail_foot_config', array('type' => 'textarea', 'label' => ST_FAIL_MESSAGE_FOOT_LABEL, 'rows' => 3, 'cols' => 70, 'smalldesc' => ST_FAIL_MESSAGE_FOOT_SUBLABEL)); ?>
</div>