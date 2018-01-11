<?php
view(setting('themes').'/index');

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';

if (isAdmin([101, 102, 103])) {
    //show_title('Денежные операции');

    switch ($action):


        ############################################################################################
        ##                                Просмотр по пользователям                               ##
        ############################################################################################
        case 'view':

            $uz = (isset($_GET['uz'])) ? check($_GET['uz']) : '';

            if (getUser($uz)) {

                $total = DB::run() -> querySingle("SELECT COUNT(*) FROM `transfers` WHERE `user`=?;", [$uz]);
                $page = paginate(setting('listtransfers'), $total);

                if ($total > 0) {

                    $queryhist = DB::select("SELECT * FROM `transfers` WHERE `user`=? ORDER BY `time` DESC LIMIT ".$page['offset'].", ".setting('listtransfers').";", [$uz]);

                    while ($data = $queryhist -> fetch()) {
                        echo '<div class="b">';
                        echo '<div class="img">'.userAvatar($data['user']).'</div>';
                        echo '<b>'.profile($data['user']).'</b> '.userOnline($data['user']).' ';

                        echo '<small>('.dateFixed($data['time']).')</small>';
                        echo '</div>';

                        echo '<div>';
                        echo 'Кому: '.profile($data['login']).'<br>';
                        echo 'Сумма: '.plural($data['summ'], setting('moneyname')).'<br>';
                        echo 'Комментарий: '.$data['text'].'<br>';
                        echo '</div>';
                    }

                    pagination($page);

                    echo 'Всего операций: <b>'.$total.'</b><br><br>';

                } else {
                    showError('Истории операций еще нет!');
                }
            } else {
                showError('Ошибка! Данный пользователь не найден!');
            }

            echo '<i class="fa fa-arrow-circle-left"></i> <a href="/admin/transfers">Вернуться</a><br>';
        break;

    endswitch;

    echo '<i class="fa fa-wrench"></i> <a href="/admin">В админку</a><br>';

} else {
    redirect("/");
}

view(setting('themes').'/foot');
