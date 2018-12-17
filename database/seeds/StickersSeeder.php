<?php

use Phinx\Seed\AbstractSeed;

class Stickers extends AbstractSeed
{
    /**
     * Run Method.
     */
    public function run()
    {
        $this->execute('TRUNCATE stickers');

        $table = $this->table('stickers');

        $data = [
            ['name' => '/uploads/stickers/).gif', 'code' => ':)'],
            ['name' => '/uploads/stickers/(.gif', 'code' => ':('],
            ['name' => '/uploads/stickers/4moks.gif', 'code' => ':4moks'],
            ['name' => '/uploads/stickers/D.gif', 'code' => ':D'],
            ['name' => '/uploads/stickers/E.gif', 'code' => ':E'],
            ['name' => '/uploads/stickers/aaa.gif', 'code' => ':aaa'],
            ['name' => '/uploads/stickers/agree.gif', 'code' => ':agree'],
            ['name' => '/uploads/stickers/airkiss.gif', 'code' => ':airkiss'],
            ['name' => '/uploads/stickers/atlet.gif', 'code' => ':atlet'],
            ['name' => '/uploads/stickers/baby.gif', 'code' => ':baby'],
            ['name' => '/uploads/stickers/bant.gif', 'code' => ':bant'],
            ['name' => '/uploads/stickers/be.gif', 'code' => ':be'],
            ['name' => '/uploads/stickers/blin.gif', 'code' => ':blin'],
            ['name' => '/uploads/stickers/blum.gif', 'code' => ':blum'],
            ['name' => '/uploads/stickers/bomba.gif', 'code' => ':bomba'],
            ['name' => '/uploads/stickers/bounce.gif', 'code' => ':bounce'],
            ['name' => '/uploads/stickers/bugaga.gif', 'code' => ':bugaga'],
            ['name' => '/uploads/stickers/buhoj.gif', 'code' => ':buhoj'],
            ['name' => '/uploads/stickers/bwink.gif', 'code' => ':bwink'],
            ['name' => '/uploads/stickers/cold.gif', 'code' => ':cold'],
            ['name' => '/uploads/stickers/cool.gif', 'code' => ':cool'],
            ['name' => '/uploads/stickers/cry.gif', 'code' => ':cry'],
            ['name' => '/uploads/stickers/ded.gif', 'code' => ':ded'],
            ['name' => '/uploads/stickers/derisive.gif', 'code' => ':derisive'],
            ['name' => '/uploads/stickers/drool.gif', 'code' => ':drool'],
            ['name' => '/uploads/stickers/duma.gif', 'code' => ':duma'],
            ['name' => '/uploads/stickers/exercise.gif', 'code' => ':exercise'],
            ['name' => '/uploads/stickers/faq.gif', 'code' => ':faq'],
            ['name' => '/uploads/stickers/fermer.gif', 'code' => ':fermer'],
            ['name' => '/uploads/stickers/fingal.gif', 'code' => ':fingal'],
            ['name' => '/uploads/stickers/flirt.gif', 'code' => ':flirt'],
            ['name' => '/uploads/stickers/fuck.gif', 'code' => ':fuck'],
            ['name' => '/uploads/stickers/girl_blum.gif', 'code' => ':girl_blum'],
            ['name' => '/uploads/stickers/girl_bye.gif', 'code' => ':girl_bye'],
            ['name' => '/uploads/stickers/girl_cry.gif', 'code' => ':girl_cry'],
            ['name' => '/uploads/stickers/girl_hide.gif', 'code' => ':girl_hide'],
            ['name' => '/uploads/stickers/girl_wink.gif', 'code' => ':girl_wink'],
            ['name' => '/uploads/stickers/girls.gif', 'code' => ':girls'],
            ['name' => '/uploads/stickers/happy.gif', 'code' => ':happy'],
            ['name' => '/uploads/stickers/heart.gif', 'code' => ':heart'],
            ['name' => '/uploads/stickers/hello.gif', 'code' => ':hello'],
            ['name' => '/uploads/stickers/help.gif', 'code' => ':help'],
            ['name' => '/uploads/stickers/help2.gif', 'code' => ':help2'],
            ['name' => '/uploads/stickers/hi.gif', 'code' => ':hi'],
            ['name' => '/uploads/stickers/infat.gif', 'code' => ':infat'],
            ['name' => '/uploads/stickers/kiss.gif', 'code' => ':kiss'],
            ['name' => '/uploads/stickers/kiss2.gif', 'code' => ':kiss2'],
            ['name' => '/uploads/stickers/klass.gif', 'code' => ':klass'],
            ['name' => '/uploads/stickers/krut.gif', 'code' => ':krut'],
            ['name' => '/uploads/stickers/krutoy.gif', 'code' => ':krutoy'],
            ['name' => '/uploads/stickers/ku.gif', 'code' => ':ku'],
            ['name' => '/uploads/stickers/kuku.gif', 'code' => ':kuku'],
            ['name' => '/uploads/stickers/kulak.gif', 'code' => ':kulak'],
            ['name' => '/uploads/stickers/lamer.gif', 'code' => ':lamer'],
            ['name' => '/uploads/stickers/love.gif', 'code' => ':love'],
            ['name' => '/uploads/stickers/love2.gif', 'code' => ':love2'],
            ['name' => '/uploads/stickers/mail.gif', 'code' => ':mail'],
            ['name' => '/uploads/stickers/mister.gif', 'code' => ':mister'],
            ['name' => '/uploads/stickers/money.gif', 'code' => ':money'],
            ['name' => '/uploads/stickers/moped.gif', 'code' => ':moped'],
            ['name' => '/uploads/stickers/musik.gif', 'code' => ':musik'],
            ['name' => '/uploads/stickers/nea.gif', 'code' => ':nea'],
            ['name' => '/uploads/stickers/net.gif', 'code' => ':net'],
            ['name' => '/uploads/stickers/neznaju.gif', 'code' => ':neznaju'],
            ['name' => '/uploads/stickers/ninja.gif', 'code' => ':ninja'],
            ['name' => '/uploads/stickers/no.gif', 'code' => ':no'],
            ['name' => '/uploads/stickers/nono.gif', 'code' => ':nono'],
            ['name' => '/uploads/stickers/nozh.gif', 'code' => ':nozh'],
            ['name' => '/uploads/stickers/nyam.gif', 'code' => ':nyam'],
            ['name' => '/uploads/stickers/nyam2.gif', 'code' => ':icecream'],
            ['name' => '/uploads/stickers/obana.gif', 'code' => ':obana'],
            ['name' => '/uploads/stickers/ogogo.gif', 'code' => ':ogogo'],
            ['name' => '/uploads/stickers/oops.gif', 'code' => ':oops'],
            ['name' => '/uploads/stickers/opa.gif', 'code' => ':opa'],
            ['name' => '/uploads/stickers/otstoy.gif', 'code' => ':otstoy'],
            ['name' => '/uploads/stickers/oy.gif', 'code' => ':oy'],
            ['name' => '/uploads/stickers/pirat.gif', 'code' => ':pirat'],
            ['name' => '/uploads/stickers/pirat2.gif', 'code' => ':pirat2'],
            ['name' => '/uploads/stickers/pistolet.gif', 'code' => ':pistolet'],
            ['name' => '/uploads/stickers/pistolet2.gif', 'code' => ':pistolet2'],
            ['name' => '/uploads/stickers/pizdec.gif', 'code' => ':shok3'],
            ['name' => '/uploads/stickers/poisk.gif', 'code' => ':poisk'],
            ['name' => '/uploads/stickers/proud.gif', 'code' => ':proud'],
            ['name' => '/uploads/stickers/puls.gif', 'code' => ':puls'],
            ['name' => '/uploads/stickers/queen.gif', 'code' => ':queen'],
            ['name' => '/uploads/stickers/rap.gif', 'code' => ':rap'],
            ['name' => '/uploads/stickers/read.gif', 'code' => ':read'],
            ['name' => '/uploads/stickers/respekt.gif', 'code' => ':respekt'],
            ['name' => '/uploads/stickers/rok.gif', 'code' => ':rok'],
            ['name' => '/uploads/stickers/rok2.gif', 'code' => ':rok2'],
            ['name' => '/uploads/stickers/senjor.gif', 'code' => ':senjor'],
            ['name' => '/uploads/stickers/shok.gif', 'code' => ':shok'],
            ['name' => '/uploads/stickers/shok2.gif', 'code' => ':shok2'],
            ['name' => '/uploads/stickers/skull.gif', 'code' => ':skull'],
            ['name' => '/uploads/stickers/smert.gif', 'code' => ':smert'],
            ['name' => '/uploads/stickers/smoke.gif', 'code' => ':smoke'],
            ['name' => '/uploads/stickers/spy.gif', 'code' => ':spy'],
            ['name' => '/uploads/stickers/strela.gif', 'code' => ':strela'],
            ['name' => '/uploads/stickers/svist.gif', 'code' => ':svist'],
            ['name' => '/uploads/stickers/tiho.gif', 'code' => ':tiho'],
            ['name' => '/uploads/stickers/vau.gif', 'code' => ':vau'],
            ['name' => '/uploads/stickers/victory.gif', 'code' => ':victory'],
            ['name' => '/uploads/stickers/visavi.gif', 'code' => ':visavi'],
            ['name' => '/uploads/stickers/visavi2.gif', 'code' => ':visavi2'],
            ['name' => '/uploads/stickers/vtopku.gif', 'code' => ':vtopku'],
            ['name' => '/uploads/stickers/wackogirl.gif', 'code' => ':wackogirl'],
            ['name' => '/uploads/stickers/xaxa.gif', 'code' => ':xaxa'],
            ['name' => '/uploads/stickers/xmm.gif', 'code' => ':xmm'],
            ['name' => '/uploads/stickers/yu.gif', 'code' => ':yu'],
            ['name' => '/uploads/stickers/zlo.gif', 'code' => ':zlo'],
            ['name' => '/uploads/stickers/ban.gif', 'code' => ':ban'],
            ['name' => '/uploads/stickers/ban2.gif', 'code' => ':ban2'],
            ['name' => '/uploads/stickers/banned.gif', 'code' => ':banned'],
            ['name' => '/uploads/stickers/closed.gif', 'code' => ':closed'],
            ['name' => '/uploads/stickers/closed2.gif', 'code' => ':closed2'],
            ['name' => '/uploads/stickers/devil.gif', 'code' => ':devil'],
            ['name' => '/uploads/stickers/flood.gif', 'code' => ':flood'],
            ['name' => '/uploads/stickers/flood2.gif', 'code' => ':flood2'],
            ['name' => '/uploads/stickers/huligan.gif', 'code' => ':huligan'],
            ['name' => '/uploads/stickers/ment.gif', 'code' => ':ment'],
            ['name' => '/uploads/stickers/ment2.gif', 'code' => ':ment2'],
            ['name' => '/uploads/stickers/moder.gif', 'code' => ':moder'],
            ['name' => '/uploads/stickers/nika.gif', 'code' => ':girlmoder'],
            ['name' => '/uploads/stickers/offtop.gif', 'code' => ':offtop'],
            ['name' => '/uploads/stickers/pravila.gif', 'code' => ':pravila'],
            ['name' => '/uploads/stickers/zona.gif', 'code' => ':zona'],
            ['name' => '/uploads/stickers/zub.gif', 'code' => ':zub'],
            ['name' => '/uploads/stickers/crazy.gif', 'code' => ':crazy'],
            ['name' => '/uploads/stickers/paratrooper.gif', 'code' => ':moder2'],
            ['name' => '/uploads/stickers/bug.gif', 'code' => ':bug'],
            ['name' => '/uploads/stickers/facepalm.gif', 'code' => ':facepalm'],
            ['name' => '/uploads/stickers/wall.gif', 'code' => ':wall'],
            ['name' => '/uploads/stickers/boss.gif', 'code' => ':boss'],
        ];

        $table->insert($data)->save();
    }
}
