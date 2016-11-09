<?php

$domain = check_string($config['home']);

switch ($act):
############################################################################################
##                                       Авторизация                                      ##
############################################################################################
case 'index':

    $cooklog = (isset($_COOKIE['cooklog'])) ? check($_COOKIE['cooklog']): '';

    if (Request::isMethod('post')) {
        if (Request::has('login') && Request::has('pass')) {
            $login = check(utf_lower(Request::input('login')));
            $pass = md5(md5(trim(Request::input('pass'))));
            $remember = Request::input('remember');

            if ($user = App::login($login, $pass, $remember)) {
                App::setFlash('success', 'Добро пожаловать, '.$login.'!');
                App::redirect('/');
            }

            App::setInput(Request::all());
            App::setFlash('danger', 'Ошибка авторизации. Неправильный логин или пароль!');
        }

        if (Request::has('token')) {
            App::socialLogin(Request::input('token'));
        }
    }

    App::view('pages/login', compact('cooklog'));
break;
############################################################################################
##                                           Выход                                        ##
############################################################################################
case 'logout':

    $_SESSION = [];
    setcookie('cookpar', '', time() - 3600, '/', $domain, null, true);
    setcookie(session_name(), '', time() - 3600, '/', '');
    session_destroy();

    App::redirect('/');
break;

endswitch;
