<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
require_once ('../includes/start.php');
require_once ('../includes/functions.php');
require_once ('../includes/header.php');
include_once ('../themes/header.php');

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';

show_title('Письмо Администратору');

switch ($act):
############################################################################################
##                                    Главная страница                                    ##
############################################################################################
	case 'index':

		echo '<div class="form">';
		echo '<form method="post" action="index.php?act=send">';

		if (! is_user()) {
			echo 'Ваше имя:<br /><input name="name" maxlength="20" /><br />';
			echo 'Ваш E-mail:<br /><input name="umail" maxlength="50" /><br />';
		} else {
			if (empty($udata['users_email'])) {
				echo 'Ваш E-mail:<br /><input name="umail" maxlength="50" /><br />';
			}
		}

		echo 'Сообщение:<br />';
		echo '<textarea cols="25" rows="5" name="body"></textarea><br />';

		echo 'Проверочный код:<br />';
		echo '<img src="/gallery/protect.php" alt="" /><br />';

		echo '<input name="provkod" size="6" maxlength="6" /><br />';
		echo '<input value="Отправить" type="submit" /></form></div><br />';

		echo 'Обновите страницу если вы не видите проверочный код!<br /><br />';
	break;

	############################################################################################
	##                                    Отправка сообщения                                  ##
	############################################################################################
	case 'send':

		$body = isset($_POST['body']) ? check($_POST['body']) : '';
		$name = isset($_POST['name']) ? check($_POST['name']) : '';
		$umail = isset($_POST['umail']) ? check($_POST['umail']) : '';
		$provkod = isset($_POST['provkod']) ? check(strtolower($_POST['provkod'])) : '';

		if (is_user()) {
			$name = $log;

			if (!empty($udata['users_email'])) {
				$umail = $udata['users_email'];
			}
		}

		if ($_SESSION['protect'] == $provkod) {
			if (utf_strlen($name) >= 3 && utf_strlen($name) <= 50) {
				if (utf_strlen($body) >= 5 && utf_strlen($body) <= 5000) {
					if (preg_match('#^([a-z0-9_\-\.])+\@([a-z0-9_\-\.])+(\.([a-z0-9])+)+$#', $umail)) {

						if (sendMail($config['emails'], 'Письмо с сайта '.$config['title'], html_entity_decode($body, ENT_QUOTES)."\n\nIp: $ip \nБраузер: $brow \nОтправлено: ".date_fixed(SITETIME), array('from' => array($umail => $name)))) {

							notice('Ваше письмо успешно отправлено!');
							redirect("index.php");

						} else {
							show_error('Ошибка! Не удалось отправить письмо администратору!');
						}
					} else {
						show_error('Вы ввели неверный адрес e-mail, необходим формат name@site.domen!');
					}
				} else {
					show_error('Слишком длинное или короткое сообшение, необходимо от 5 до 5000 символов!');
				}
			} else {
				show_error('Слишком длинное или короткое имя, необходимо от 3 до 50 символов!');
			}
		} else {
			show_error('Проверочное число не совпало с данными на картинке!');
		}

		echo '<img src="/images/img/back.gif" alt="image" /> <a href="index.php">Вернуться</a><br />';
	break;

default:
	redirect("index.php");
endswitch;

include_once ('../themes/footer.php');
?>
