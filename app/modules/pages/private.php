<?php
App::view($config['themes'].'/index');

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';
$start = (isset($_GET['start'])) ? abs(intval($_GET['start'])) : 0;
$uz = (isset($_REQUEST['uz'])) ? check($_REQUEST['uz']) : '';

show_title('Приватные сообщения');

if (is_user()) {
    switch ($act):
    ############################################################################################
    ##                                    Главная страница                                    ##
    ############################################################################################
        case 'index':

            $total = DB::run() -> querySingle("SELECT count(*) FROM `inbox` WHERE `user`=?;", array($log));

            $intotal = DB::run() -> query("SELECT count(*) FROM `outbox` WHERE `author`=? UNION ALL SELECT count(*) FROM `trash` WHERE `trash_user`=?;", array($log, $log));
            $intotal = $intotal -> fetchAll(PDO::FETCH_COLUMN);

            echo '<i class="fa fa-envelope"></i> <b>Входящие ('.$total.')</b> / ';
            echo '<a href="/private?act=output">Отправленные ('.$intotal[0].')</a> / ';
            echo '<a href="/private?act=trash">Корзина ('.$intotal[1].')</a><hr />';

            if ($udata['users_newprivat'] > 0) {
                echo '<div style="text-align:center"><b><span style="color:#ff0000">Получено новых писем: '.(int)$udata['users_newprivat'].'</span></b></div>';
                DB::run() -> query("UPDATE `users` SET `users_newprivat`=?, `users_sendprivatmail`=? WHERE `users_login`=? LIMIT 1;", array(0, 0, $log));
            }

            if ($total >= ($config['limitmail'] - ($config['limitmail'] / 10)) && $total < $config['limitmail']) {
                echo '<div style="text-align:center"><b><span style="color:#ff0000">Ваш ящик почти заполнен, необходимо очистить или удалить старые сообщения!</span></b></div>';
            }

            if ($total >= $config['limitmail']) {
                echo '<div style="text-align:center"><b><span style="color:#ff0000">Ваш ящик переполнен, вы не сможете получать письма пока не очистите его!</span></b></div>';
            }

            if ($total > 0) {
                if ($start >= $total) {
                    $start = last_page($total, $config['privatpost']);
                }

                $querypriv = DB::run() -> query("SELECT * FROM `inbox` WHERE `user`=? ORDER BY `time` DESC LIMIT ".$start.", ".$config['privatpost'].";", array($log));

                echo '<form action="/private?act=del&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';
                echo '<div class="form">';
                echo '<input type="checkbox" id="all" onchange="var o=this.form.elements;for(var i=0;i&lt;o.length;i++)o[i].checked=this.checked" /> <b><label for="all">Отметить все</label></b>';
                echo '</div>';
                while ($data = $querypriv -> fetch()) {
                    echo '<div class="b">';
                    echo '<div class="img">'.user_avatars($data['author']).'</div>';
                    echo '<b>'.profile($data['author']).'</b>  ('.date_fixed($data['time']).')<br />';
                    echo user_title($data['author']).' '.user_online($data['author']).'</div>';

                    echo '<div>'.bb_code($data['text']).'<br />';

                    echo '<input type="checkbox" name="del[]" value="'.$data['id'].'" /> ';
                    echo '<a href="/private?act=submit&amp;uz='.$data['author'].'">Ответить</a> / ';
                    echo '<a href="/private?act=history&amp;uz='.$data['author'].'">История</a> / ';
                    echo '<a href="/contact?act=add&amp;uz='.$data['author'].'&amp;uid='.$_SESSION['token'].'">В контакт</a> / ';
                    echo '<a href="/ignore?act=add&amp;uz='.$data['author'].'&amp;uid='.$_SESSION['token'].'">Игнор</a> / ';
                    echo '<noindex><a href="/private?act=spam&amp;id='.$data['id'].'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" onclick="return confirm(\'Вы подтверждаете факт спама?\')" rel="nofollow">Спам</a></noindex></div>';
                }

                echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

                page_strnavigation('/private?', $config['privatpost'], $start, $total);

                echo 'Всего писем: <b>'.(int)$total.'</b><br />';
                echo 'Объем ящика: <b>'.$config['limitmail'].'</b><br /><br />';

                echo '<i class="fa fa-times"></i> <a href="/private?act=alldel&amp;uid='.$_SESSION['token'].'">Очистить ящик</a><br />';
            } else {
                show_error('Входящих писем еще нет!');
            }
        break;

        ############################################################################################
        ##                                 Исходящие сообщения                                    ##
        ############################################################################################
        case 'output':

            $total = DB::run() -> querySingle("SELECT count(*) FROM `outbox` WHERE `author`=?;", array($log));

            $intotal = DB::run() -> query("SELECT count(*) FROM `inbox` WHERE `user`=? UNION ALL SELECT count(*) FROM `trash` WHERE `trash_user`=?;", array($log, $log));
            $intotal = $intotal -> fetchAll(PDO::FETCH_COLUMN);

            echo '<i class="fa fa-envelope"></i> <a href="/private">Входящие ('.$intotal[0].')</a> / ';
            echo '<b>Отправленные ('.$total.')</b> / ';
            echo '<a href="/private?act=trash">Корзина ('.$intotal[1].')</a><hr />';

            if ($total > 0) {
                if ($start >= $total) {
                    $start = last_page($total, $config['privatpost']);
                }

                $querypriv = DB::run() -> query("SELECT * FROM `outbox` WHERE `author`=? ORDER BY `time` DESC LIMIT ".$start.", ".$config['privatpost'].";", array($log));

                echo '<form action="/private?act=outdel&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'" method="post">';
                echo '<div class="form">';
                echo '<input type="checkbox" id="all" onchange="var o=this.form.elements;for(var i=0;i&lt;o.length;i++)o[i].checked=this.checked" /> <b><label for="all">Отметить все</label></b>';
                echo '</div>';
                while ($data = $querypriv -> fetch()) {
                    echo '<div class="b">';
                    echo '<div class="img">'.user_avatars($data['user']).'</div>';
                    echo '<b>'.profile($data['user']).'</b>  ('.date_fixed($data['time']).')<br />';
                    echo user_title($data['user']).' '.user_online($data['user']).'</div>';

                    echo '<div>'.bb_code($data['text']).'<br />';

                    echo '<input type="checkbox" name="del[]" value="'.$data['id'].'" /> ';
                    echo '<a href="/private?act=submit&amp;uz='.$data['user'].'">Написать еще</a> / ';
                    echo '<a href="/private?act=history&amp;uz='.$data['user'].'">История</a></div>';
                }

                echo '<br /><input type="submit" value="Удалить выбранное" /></form>';

                page_strnavigation('/private?act=output&amp;', $config['privatpost'], $start, $total);

                echo 'Всего писем: <b>'.(int)$total.'</b><br />';
                echo 'Объем ящика: <b>'.$config['limitoutmail'].'</b><br /><br />';

                echo '<i class="fa fa-times"></i> <a href="/private?act=alloutdel&amp;uid='.$_SESSION['token'].'">Очистить ящик</a><br />';
            } else {
                show_error('Отправленных писем еще нет!');
            }
        break;

        ############################################################################################
        ##                                       Корзина                                          ##
        ############################################################################################
        case 'trash':

            $total = DB::run() -> querySingle("SELECT count(*) FROM `trash` WHERE `trash_user`=?;", array($log));

            $intotal = DB::run() -> query("SELECT count(*) FROM `inbox` WHERE `user`=? UNION ALL SELECT count(*) FROM `outbox` WHERE `author`=?;", array($log, $log));
            $intotal = $intotal -> fetchAll(PDO::FETCH_COLUMN);

            echo '<i class="fa fa-envelope"></i> <a href="/private">Входящие ('.$intotal[0].')</a> / ';
            echo '<a href="/private?act=output">Отправленные ('.$intotal[1].')</a> / ';

            echo '<b>Корзина ('.$total.')</b><hr />';
            if ($total > 0) {
                if ($start >= $total) {
                    $start = last_page($total, $config['privatpost']);
                }

                $querypriv = DB::run() -> query("SELECT * FROM `trash` WHERE `trash_user`=? ORDER BY `trash_time` DESC LIMIT ".$start.", ".$config['privatpost'].";", array($log));

                while ($data = $querypriv -> fetch()) {
                    echo '<div class="b">';
                    echo '<div class="img">'.user_avatars($data['trash_author']).'</div>';
                    echo '<b>'.profile($data['trash_author']).'</b>  ('.date_fixed($data['trash_time']).')<br />';
                    echo user_title($data['trash_author']).' '.user_online($data['trash_author']).'</div>';

                    echo '<div>'.bb_code($data['trash_text']).'<br />';

                    echo '<a href="/private?act=submit&amp;uz='.$data['trash_author'].'">Ответить</a> / ';
                    echo '<a href="/contact?act=add&amp;uz='.$data['trash_author'].'&amp;uid='.$_SESSION['token'].'">В контакт</a> / ';
                    echo '<a href="/ignore?act=add&amp;uz='.$data['trash_author'].'&amp;uid='.$_SESSION['token'].'">Игнор</a></div>';
                }

                page_strnavigation('/private?act=trash&amp;', $config['privatpost'], $start, $total);

                echo 'Всего писем: <b>'.(int)$total.'</b><br />';
                echo 'Срок хранения: <b>'.$config['expiresmail'].'</b><br /><br />';

                echo '<i class="fa fa-times"></i> <a href="/private?act=alltrashdel&amp;uid='.$_SESSION['token'].'">Очистить ящик</a><br />';
            } else {
                show_error('Удаленных писем еще нет!');
            }
        break;

        ############################################################################################
        ##                                   Отправка привата                                     ##
        ############################################################################################
        case 'submit':

            if (empty($uz)) {

                echo '<div class="form">';
                echo '<form action="/private?act=send&amp;uid='.$_SESSION['token'].'" method="post">';

                echo 'Введите логин:<br />';
                echo '<input type="text" name="uz" maxlength="20" /><br />';

                $querycontact = DB::run() -> query("SELECT `name` FROM `contact` WHERE `user`=? ORDER BY `name` DESC;", array($log));
                $contact = $querycontact -> fetchAll();

                if (count($contact) > 0) {
                    echo 'Или выберите из списка:<br />';
                    echo '<select name="uzcon">';
                    echo '<option value="0">Список контактов</option>';

                    foreach($contact as $data) {
                        echo '<option value="'.$data['name'].'">'.nickname($data['name']).'</option>';
                    }
                    echo '</select><br />';
                }

                echo '<textarea cols="25" rows="5" name="msg" id="markItUp"></textarea><br />';

                if ($udata['users_point'] < $config['privatprotect']) {
                    echo 'Проверочный код:<br />';
                    echo '<img src="/captcha" alt="" /><br />';
                    echo '<input name="provkod" size="6" maxlength="6" /><br />';
                }

                echo '<input value="Отправить" type="submit" /></form></div><br />';

                echo 'Введите логин или выберите пользователя из своего контакт-листа<br />';

            } else {
                if (!user_privacy($uz) || is_admin() || is_contact($uz, $log)){

                    echo '<i class="fa fa-envelope"></i> Сообщение для <b>'.profile($uz).'</b> '.user_visit($uz).':<br />';
                    echo '<i class="fa fa-history"></i> <a href="/private?act=history&amp;uz='.$uz.'">История переписки</a><br /><br />';

                    $ignorstr = DB::run() -> querySingle("SELECT `id` FROM `ignore` WHERE `user`=? AND `name`=? LIMIT 1;", array($log, $uz));
                    if (!empty($ignorstr)) {
                        echo '<b>Внимание! Данный пользователь внесен в ваш игнор-лист!</b><br />';
                    }

                    echo '<div class="form">';
                    echo '<form action="/private?act=send&amp;uz='.$uz.'&amp;uid='.$_SESSION['token'].'" method="post">';

                    echo '<textarea cols="25" rows="5" name="msg" id="markItUp"></textarea><br />';

                    if ($udata['users_point'] < $config['privatprotect']) {
                        echo 'Проверочный код:<br />';
                        echo '<img src="/captcha" alt="" /><br />';
                        echo '<input name="provkod" size="6" maxlength="6" /><br />';
                    }

                    echo '<input value="Отправить" type="submit" /></form></div><br />';

                } else {
                    show_error('Включен режим приватности, писать могут только пользователи из контактов!');
                }
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/private">Вернуться</a><br />';
        break;

        ############################################################################################
        ##                                   Отправка сообщений                                   ##
        ############################################################################################
        case 'send':

            $uid = !empty($_GET['uid']) ? check($_GET['uid']) : 0;
            $msg = isset($_POST['msg']) ? check($_POST['msg']) : '';
            $uz = isset($_POST['uzcon']) ? check($_POST['uzcon']) : $uz;
            $provkod = isset($_POST['provkod']) ? check(strtolower($_POST['provkod'])) : '';

            if ($uid == $_SESSION['token']) {
                if (!empty($uz)) {
                    if ($uz != $log) {
                        if (!user_privacy($uz) || is_admin() || is_contact($uz, $log)){
                            if ($udata['users_point'] >= $config['privatprotect'] || $provkod == $_SESSION['protect']) {
                                if (utf_strlen($msg) >= 5 && utf_strlen($msg) < 1000) {
                                    $queryuser = DB::run() -> querySingle("SELECT `users_id` FROM `users` WHERE `users_login`=? LIMIT 1;", array($uz));
                                    if (!empty($queryuser)) {
                                        $uztotal = DB::run() -> querySingle("SELECT count(*) FROM `inbox` WHERE `user`=?;", array($uz));
                                        if ($uztotal < $config['limitmail']) {
                                            // ----------------------------- Проверка на игнор ----------------------------//
                                            $ignorstr = DB::run() -> querySingle("SELECT `id` FROM `ignore` WHERE `user`=? AND `name`=? LIMIT 1;", array($uz, $log));
                                            if (empty($ignorstr)) {
                                                if (is_flood($log)) {

                                                    $msg = antimat($msg);

                                                    DB::run() -> query("UPDATE `users` SET `users_newprivat`=`users_newprivat`+1 WHERE `users_login`=? LIMIT 1;", array($uz));
                                                    DB::run() -> query("INSERT INTO `inbox` (`user`, `author`, `text`, `time`) VALUES (?, ?, ?, ?);", array($uz, $log, $msg, SITETIME));

                                                    DB::run() -> query("INSERT INTO `outbox` (`user`, `author`, `text`, `time`) VALUES (?, ?, ?, ?);", array($uz, $log, $msg, SITETIME));

                                                    DB::run() -> query("DELETE FROM `outbox` WHERE `author`=? AND `time` < (SELECT MIN(`time`) FROM (SELECT `time` FROM `outbox` WHERE `author`=? ORDER BY `time` DESC LIMIT ".$config['limitoutmail'].") AS del);", array($log, $log));
                                                    save_usermail(60);

                                                    $deliveryUsers = DBM::run()->select('users', array(
                                                            'users_newprivat' => array('>', 0),
                                                            'users_sendprivatmail' => 0,
                                                            'users_timelastlogin' => array('<', SITETIME - 86400 * $config['sendprivatmailday']),
                                                            'users_subscribe' => array('<>', ''),
                                                            'users_email' => array('<>', ''),
                                                            'users_confirmreg' => 0,
                                                    ), $config['sendmailpacket'], null, array('users_timelastlogin'=>'ASC'));

                                                    foreach ($deliveryUsers as $user) {
                                                        sendMail($user['users_email'],
                                                            $user['users_newprivat'].' непрочитанных сообщений ('.$config['title'].')',
                                                            nl2br("Здравствуйте ".nickname($user['users_login'])."! \nУ вас имеются непрочитанные сообщения (".$user['users_newprivat']." шт.) на сайте ".$config['title']." \nПрочитать свои сообщения вы можете по адресу ".$config['home']."/pages//private"),
                                                            array('unsubkey' => $user['users_subscribe'])
                                                        );

                                                        $user = DBM::run()->update('users', array(
                                                            'users_sendprivatmail' => 1,
                                                        ), array(
                                                            'users_login' => $user['users_login'],
                                                        ));
                                                    }
                                                    notice('Ваше письмо успешно отправлено!');
                                                    redirect("/private");

                                                } else {
                                                    show_error('Антифлуд! Разрешается отправлять сообщения раз в '.flood_period().' секунд!');
                                                }
                                            } else {
                                                show_error('Ошибка! Вы внесены в игнор-лист получателя!');
                                            }
                                        } else {
                                            show_error('Ошибка! Ящик получателя переполнен!');
                                        }
                                    } else {
                                        show_error('Ошибка! Данного адресата не существует!');
                                    }
                                } else {
                                    show_error('Ошибка! Слишком длинное или короткое сообщение!');
                                }
                            } else {
                                show_error('Ошибка! Проверочное число не совпало с данными на картинке!');
                            }
                        } else {
                            show_error('Включен режим приватности, писать могут только пользователи из контактов!');
                        }
                    } else {
                        show_error('Ошибка! Нельзя отправлять письмо самому себе!');
                    }
                } else {
                    show_error('Ошибка! Вы не ввели логин пользователя!');
                }
            } else {
                show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/private?act=submit&amp;uz='.$uz.'">Вернуться</a><br />';
            echo '<i class="fa fa-arrow-circle-up"></i> <a href="/private">К письмам</a><br />';
        break;

        ############################################################################################
        ##                                    Жалоба на спам                                      ##
        ############################################################################################
        case 'spam':

            $uid = check($_GET['uid']);
            $id = abs(intval($_GET['id']));

            if ($uid == $_SESSION['token']) {
                $data = DB::run() -> queryFetch("SELECT * FROM `inbox` WHERE `user`=? AND `id`=? LIMIT 1;", array($log, $id));
                if (!empty($data)) {
                    $queryspam = DB::run() -> querySingle("SELECT `spam_id` FROM `spam` WHERE `spam_key`=? AND `spam_idnum`=? LIMIT 1;", array(3, $id));

                    if (empty($queryspam)) {
                        if (is_flood($log)) {
                            DB::run() -> query("INSERT INTO `spam` (`spam_key`, `spam_idnum`, `spam_user`, `spam_login`, `spam_text`, `spam_time`, `spam_addtime`) VALUES (?, ?, ?, ?, ?, ?, ?);", array(3, $data['id'], $log, $data['author'], $data['text'], $data['time'], SITETIME));

                            notice('Жалоба успешно отправлена!');
                            redirect("/private?start=$start");

                        } else {
                            show_error('Антифлуд! Разрешается жаловаться на спам не чаще чем раз в '.flood_period().' секунд!');
                        }
                    } else {
                        show_error('Ошибка! Вы уже отправили жалобу на данное сообщение!');
                    }
                } else {
                    show_error('Ошибка! Данное сообщение адресовано не вам!');
                }
            } else {
                show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/private?start='.$start.'">Вернуться</a><br />';
        break;

        ############################################################################################
        ##                                 Удаление сообщений                                     ##
        ############################################################################################
        case 'del':

            $uid = check($_GET['uid']);
            if (isset($_POST['del'])) {
                $del = intar($_POST['del']);
            } else {
                $del = 0;
            }

            if ($uid == $_SESSION['token']) {
                if (!empty($del)) {
                    $del = implode(',', $del);
                    $deltrash = SITETIME + 86400 * $config['expiresmail'];

                    DB::run() -> query("DELETE FROM `trash` WHERE `trash_del`<?;", array(SITETIME));

                    DB::run() -> query("INSERT INTO `trash` (`trash_user`, `trash_author`, `trash_text`, `trash_time`, `trash_del`) SELECT `user`, `author`, `text`, `time`, ? FROM `inbox` WHERE `id` IN (".$del.") AND `user`=?;", array($deltrash, $log));

                    DB::run() -> query("DELETE FROM `inbox` WHERE `id` IN (".$del.") AND `user`=?;", array($log));
                    save_usermail(60);

                    notice('Выбранные сообщения успешно удалены!');
                    redirect("/private?start=$start");

                } else {
                    show_error('Ошибка удаления! Отсутствуют выбранные сообщения');
                }
            } else {
                show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/private?start='.$start.'">Вернуться</a><br />';
        break;

        ############################################################################################
        ##                           Удаление отправленных сообщений                              ##
        ############################################################################################
        case 'outdel':

            $uid = check($_GET['uid']);
            if (isset($_POST['del'])) {
                $del = intar($_POST['del']);
            } else {
                $del = 0;
            }

            if ($uid == $_SESSION['token']) {
                if ($del > 0) {
                    $del = implode(',', $del);

                    DB::run() -> query("DELETE FROM `outbox` WHERE `id` IN (".$del.") AND `author`=?;", array($log));

                    notice('Выбранные сообщения успешно удалены!');
                    redirect("/private?act=output&start=$start");

                } else {
                    show_error('Ошибка удаления! Отсутствуют выбранные сообщения');
                }
            } else {
                show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/private?act=output&amp;start='.$start.'">Вернуться</a><br />';
        break;

        ############################################################################################
        ##                                   Очистка входящих сообщений                           ##
        ############################################################################################
        case 'alldel':

            $uid = check($_GET['uid']);

            if ($uid == $_SESSION['token']) {
                if (empty($udata['users_newprivat'])) {
                    $deltrash = SITETIME + 86400 * $config['expiresmail'];

                    DB::run() -> query("DELETE FROM `trash` WHERE `trash_del`<?;", array(SITETIME));

                    DB::run() -> query("INSERT INTO `trash` (`trash_user`, `trash_author`, `trash_text`, `trash_time`, `trash_del`) SELECT `user`, `author`, `text`, `time`, ? FROM `inbox` WHERE `user`=?;", array($deltrash, $log));

                    DB::run() -> query("DELETE FROM `inbox` WHERE `user`=?;", array($log));
                    save_usermail(60);

                    notice('Ящик успешно очищен!');
                    redirect("/private");

                } else {
                    show_error('Ошибка! У вас имеются непрочитанные сообщения!');
                }
            } else {
                show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/private">Вернуться</a><br />';
        break;

        ############################################################################################
        ##                           Очистка отправленных сообщений                               ##
        ############################################################################################
        case 'alloutdel':

            $uid = check($_GET['uid']);

            if ($uid == $_SESSION['token']) {
                DB::run() -> query("DELETE FROM `outbox` WHERE `author`=?;", array($log));

                notice('Ящик успешно очищен!');
                redirect("/private?act=output");

            } else {
                show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/private?act=output">Вернуться</a><br />';
        break;

        ############################################################################################
        ##                              Очистка удаленных сообщений                               ##
        ############################################################################################
        case 'alltrashdel':

            $uid = check($_GET['uid']);

            if ($uid == $_SESSION['token']) {
                DB::run() -> query("DELETE FROM `trash` WHERE `trash_user`=?;", array($log));

                notice('Ящик успешно очищен!');
                redirect("/private?act=trash");

            } else {
                show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/private?act=trash">Вернуться</a><br />';
        break;

        ############################################################################################
        ##                                  Просмотр переписки                                    ##
        ############################################################################################
        case 'history':

            echo '<i class="fa fa-envelope"></i> <a href="/private">Входящие</a> / ';
            echo '<a href="/private?act=output">Отправленные</a> / ';
            echo '<a href="/private?act=trash">Корзина</a><hr />';

            if ($uz != $log) {
                $queryuser = DB::run() -> querySingle("SELECT `users_id` FROM `users` WHERE `users_login`=? LIMIT 1;", array($uz));
                if (!empty($queryuser)) {
                    $total = DB::run() -> query("SELECT count(*) FROM `inbox` WHERE `user`=? AND `author`=? UNION ALL SELECT count(*) FROM `outbox` WHERE `user`=? AND `author`=?;", array($log, $uz, $uz, $log));

                    $total = array_sum($total -> fetchAll(PDO::FETCH_COLUMN));

                    if ($total > 0) {
                        if ($start >= $total) {
                            $start = last_page($total, $config['privatpost']);
                        }

                        $queryhistory = DB::run() -> query("SELECT * FROM `inbox` WHERE `user`=? AND `author`=? UNION ALL SELECT * FROM `outbox` WHERE `user`=? AND `author`=? ORDER BY `time` DESC LIMIT ".$start.", ".$config['privatpost'].";", array($log, $uz, $uz, $log));

                        while ($data = $queryhistory -> fetch()) {
                            echo '<div class="b">';
                            echo user_avatars($data['author']);
                            echo '<b>'.profile($data['author']).'</b> '.user_online($data['author']).' ('.date_fixed($data['time']).')</div>';
                            echo '<div>'.bb_code($data['text']).'</div>';
                        }

                        page_strnavigation('/private?act=history&amp;uz='.$uz.'&amp;', $config['privatpost'], $start, $total);

                        if (!user_privacy($uz) || is_admin() || is_contact($uz, $log)){

                            echo '<br /><div class="form">';
                            echo '<form action="/private?act=send&amp;uz='.$uz.'&amp;uid='.$_SESSION['token'].'" method="post">';
                            echo 'Сообщение:<br />';
                            echo '<textarea cols="25" rows="5" name="msg"></textarea><br />';

                            if ($udata['users_point'] < $config['privatprotect']) {
                                echo 'Проверочный код:<br /> ';
                                echo '<img src="/captcha" alt="" /><br />';
                                echo '<input name="provkod" size="6" maxlength="6" /><br />';
                            }

                            echo '<input value="Быстрый ответ" type="submit" /></form></div><br />';

                        } else {
                            show_error('Включен режим приватности, писать могут только пользователи из контактов!');
                        }

                        echo 'Всего писем: <b>'.(int)$total.'</b><br /><br />';

                    } else {
                        show_error('История переписки отсутствует!');
                    }
                } else {
                    show_error('Ошибка! Данного адресата не существует!');
                }
            } else {
                show_error('Ошибка! Отсутствует переписка с самим собой!');
            }
        break;

    default:
        redirect("/private");
    endswitch;

} else {
    show_login('Вы не авторизованы, для просмотра писем, необходимо');
}

echo '<i class="fa fa-search"></i> <a href="/searchuser">Поиск контактов</a><br />';
echo '<i class="fa fa-envelope"></i> <a href="/private?act=submit">Написать письмо</a><br />';
echo '<i class="fa fa-address-book"></i> <a href="/contact">Контакт</a> / <a href="/ignore">Игнор</a><br />';

App::view($config['themes'].'/foot');
