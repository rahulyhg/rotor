<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
header("Content-type:text/html; charset=utf-8");
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
echo '<title>%TITLE%</title>';
echo '<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />';
include_style();
echo '<link rel="stylesheet" href="/themes/sky/css/style.css" type="text/css" media="screen" />';
echo '<link rel="alternate" href="/news/rss" title="RSS News" type="application/rss+xml" />';
include_javascript();
echo '<meta name="keywords" content="%KEYWORDS%" />';
echo '<meta name="description" content="%DESCRIPTION%" />';
echo '<meta name="generator" content="RotorCMS '.$config['rotorversion'].'" />';
echo '</head><body>';
echo '<!--Themes by TurikUs-->';

echo '<div id="art-page-background-simple-gradient">
        <div id="art-page-background-gradient"></div>
    </div>
    <div id="art-page-background-glare">
        <div id="art-page-background-glare-image"></div>
    </div>
    <div id="art-main">
        <div class="art-Sheet">
            <div class="art-Sheet-tl"></div>
            <div class="art-Sheet-tr"></div>
            <div class="art-Sheet-bl"></div>
            <div class="art-Sheet-br"></div>
            <div class="art-Sheet-tc"></div>
            <div class="art-Sheet-bc"></div>
            <div class="art-Sheet-cl"></div>
            <div class="art-Sheet-cr"></div>
            <div class="art-Sheet-cc"></div>
            <div class="art-Sheet-body">
                <div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<ul class="art-menu">
                		<li><a href="/"><span class="l"></span><span class="r"></span><span class="t">Главная</span></a></li>
                		<li><a href="/forum"><span class="l"></span><span class="r"></span><span class="t">Форум</span></a>
                           <ul>
                                 <li><a href="/forum/new/themes">Новые темы</a></li>
                                 <li><a href="/forum/new/posts">Новые сообщения</a></li>
                		   </ul></li>



                		<li><a href="/book"><span class="l"></span><span class="r"></span><span class="t">Гостевая</span></a></li>

                        <li><a href="/load"><span class="l"></span><span class="r"></span><span class="t">Файлы</span></a>
                           <ul>
                                 <li><a href="/load/new?act=files">Новые файлы</a></li>
                                 <li><a href="/load/new?act=comments">Новые комментарии</a></li>
                		   </ul></li>

                        <li><a href="/blog"><span class="l"></span><span class="r"></span><span class="t">Блоги</span></a>
                           <ul>
                                 <li><a href="/blog/new?act=blogs">Новые статьи</a></li>
                                 <li><a href="/blog/new?act=comments">Новые комментарии</a></li>
                		   </ul></li>


                        <li><a href="/gallery"><span class="l"></span><span class="r"></span><span class="t">Галерея</span></a>
                           <ul>
                                 <li><a href="/gallery/top">Топ фото</a></li>
                                 <li><a href="/gallery/album">Все альбомы</a></li>
											<li><a href="/gallery/comments">Все комментарии</a></li>
                		   </ul></li>


                		<li><a href="#"><span class="l"></span><span class="r"></span><span class="t">Актив сайта</span></a>
                           <ul>
                                 <li><a href="/adminlist">Администрация</a></li>
                                 <li><a href="/userlist">Пользователи</a></li>
                		   </ul> </li>';
if (!is_user()) {
  echo'<li><a href="/register" ><span class="l"></span><span class="r"></span><span class="t">Регистрация</span></a></li>';
 } else {
  echo '<li><a href="/logout" onclick="return confirm(\'Вы действительно хотите выйти?\')"><span class="l"></span><span class="r"></span><span class="t">Выход</span></a></li>';
}

echo '</ul></div>';
echo '                <div class="art-contentLayout">
                    <div class="art-sidebar1">
                        <div class="art-Block">
                            <div class="art-Block-tl"></div>
                            <div class="art-Block-tr"></div>
                            <div class="art-Block-bl"></div>
                            <div class="art-Block-br"></div>
                            <div class="art-Block-tc"></div>
                            <div class="art-Block-bc"></div>
                            <div class="art-Block-cl"></div>
                            <div class="art-Block-cr"></div>
                            <div class="art-Block-cc"></div>
                            <div class="art-Block-body">
                                <div class="art-BlockContent">
                                    <div class="art-BlockContent-body">
                                        <div>';


if (is_user()) {

if (is_admin()){
echo '<div class="nmenu">';
echo '<i class="fa fa-wrench"></i> <a href="/admin">Панель</a>';

if (stats_spam()>0){
echo ' &bull; <a href="/admin/spam"><span style="color:#ff0000">Спам!</span></a>';
}

if (App::user('newchat')<stats_newchat()){
echo ' &bull; <a href="/admin/chat"><span style="color:#ff0000">Чат</span></a>';
}

echo '</div>';
}

  include (STORAGE.'/main/menu.dat');

} else {

$cooklog = (isset($_COOKIE['login'])) ? check($_COOKIE['login']): '';

echo '<div class="divb">Авторизация</div>';

echo'<form method="post" action="/login'.App::returnUrl().'">';
echo 'Логин:<br /><input name="login" value="'.$cooklog.'" /><br />';
echo 'Пароль:<br /><input name="pass" type="password" /><br />';
echo 'Запомнить меня:';
echo '<input name="cookietrue" type="checkbox" value="1" checked="checked" /><br />';

echo '<input value="Войти" type="submit" /></form>';

echo '<a href="/register">Регистрация</a><br />';
echo '<a href="/lostpassword">Забыли пароль?</a>';
}


echo '</div>
                                    </div>
                                </div>
                            </div>
                        </div>';



echo '<div class="art-Block">
                            <div class="art-Block-tl"></div>
                            <div class="art-Block-tr"></div>
                            <div class="art-Block-bl"></div>
                            <div class="art-Block-br"></div>
                            <div class="art-Block-tc"></div>
                            <div class="art-Block-bc"></div>
                            <div class="art-Block-cl"></div>
                            <div class="art-Block-cr"></div>
                            <div class="art-Block-cc"></div>
                            <div class="art-Block-body">
                                <div class="art-BlockContent">
                                    <div class="art-BlockContent-body">
                                        <div>';
echo '<div class="divb">Календарь</div>';
include (APP.'/includes/calendar.php');
echo '</div>
                                    </div>
                                </div>
                            </div>
                        </div>';



echo '<div class="art-Block">
                            <div class="art-Block-body">
<div class="art-BlockContent">


                                </div>
                            </div>
                        </div>
                    </div>';

echo '<div class="art-content">
                        <div class="art-Post">
                            <div class="art-Post-tl"></div>
                            <div class="art-Post-tr"></div>
                            <div class="art-Post-bl"></div>
                            <div class="art-Post-br"></div>
                            <div class="art-Post-tc"></div>
                            <div class="art-Post-bc"></div>
                            <div class="art-Post-cl"></div>
                            <div class="art-Post-cr"></div>
                            <div class="art-Post-cc"></div>
                            <div class="art-Post-body">
                        <div class="art-Post-inner">';

/*echo '<div class="art-PostMetadataHeader">';
render('includes/note', array('php_self' => $php_self));
echo '</div>';*/

echo '
                                <h2 class="art-PostHeaderIcon-wrapper">
                                    <img src="/themes/sky/img/PostHeaderIcon.png" width="29" height="29" alt="PostHeaderIcon" />
                                    <span class="art-PostHeader">'.$config['title'].'</span>
                                </h2>

                            <div class="art-PostContent">';



echo '<div>';
echo render('includes/note'); /*Временно пока шаблоны подключаются напрямую*/
