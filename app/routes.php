<?php

$router = new AltoRouter();

$router->addMatchTypes(['user' => '[0-9A-Za-z-_]++']);
$router->addMatchTypes(['letter'=> '[0-9a-z]']);

$routes = [
    ['GET',      '/', 'HomeController@index', 'home'],
    ['GET',      '/captcha', 'HomeController@captcha', 'captcha'],
    ['GET',      '/closed', 'HomeController@closed'],
    ['GET|POST', '/banip', 'HomeController@banip'],

    ['GET',      '/book', 'BookController@index', 'book'],
    ['POST',     '/book/add', 'BookController@add'],
    ['GET|POST', '/book/edit/[i:id]', 'BookController@edit'],

    ['GET',      '/sitemap.xml', 'SitemapController@index'],
    ['GET',      '/sitemap/[a:action].xml', 'SitemapController'],

    ['GET',      '/blog', 'BlogController@index', 'blog'],
    ['GET',      '/blog/[i:cid]', 'BlogController@blog'],
    ['GET',      '/article/[i:id]', 'BlogController@view'],
    ['GET|POST', '/article/[i:id]/edit', 'BlogController@edit'],
    ['GET',      '/article/[i:id]/print', 'BlogController@print'],
    ['GET',      '/blog/rss', 'BlogController@rss'],
    ['GET',      '/article/[i:id]/rss', 'BlogController@rssComments'],
    ['GET|POST', '/article/[i:id]/comments', 'BlogController@comments'],
    ['GET|POST', '/article/[i:id]/[i:cid]/edit', 'BlogController@editComment'],
    ['GET',      '/article/[i:id]/end', 'BlogController@end'],
    ['GET',      '/blog/tags/[*:tag]?', 'BlogController@tags'],
    ['GET|POST', '/blog/create', 'BlogController@create'],
    ['GET',      '/blog/blogs', 'BlogController@blogs'],
    ['GET',      '/blog/new/articles', 'BlogController@newArticles'],
    ['GET',      '/blog/new/comments', 'BlogController@newComments'],
    ['GET',      '/blog/active/articles', 'BlogController@userArticles'],
    ['GET',      '/blog/active/comments', 'BlogController@userComments'],
    ['GET',      '/blog/top', 'BlogController@top'],
    ['GET|POST', '/blog/search', 'BlogController@search'],
    ['GET',      '/article/[i:id]/[i:cid]', 'BlogController@viewcomment'],

    ['GET',      '/news', 'NewsController@index', 'news'],
    ['GET',      '/news/[i:id]', 'NewsController@view'],
    ['GET|POST', '/news/[i:id]/comments', 'NewsController@comments'],
    ['GET',      '/news/[i:id]/end', 'NewsController@end'],
    ['GET',      '/news/rss', 'NewsController@rss', 'news_rss'],
    ['GET|POST', '/news/[i:nid]/[i:id]/edit', 'NewsController@editComment'],
    ['GET',      '/news/allcomments', 'NewsController@allComments'],
    ['GET',      '/news/[i:nid]/[i:id]', 'NewsController@viewComment'],

    ['GET',      '/gallery', 'PhotoController@index', 'gallery'],
    ['GET',      '/gallery/[i:gid]', 'PhotoController@view'],
    ['GET',      '/gallery/[i:gid]/[delete|end:action]', 'PhotoController'],
    ['GET|POST', '/gallery/[i:gid]/[comments:action]', 'PhotoController'],
    ['GET|POST', '/gallery/[create:action]', 'PhotoController'],
    ['GET|POST', '/gallery/[i:gid]/[edit:action]', 'PhotoController'],
    ['GET|POST', '/gallery/[i:gid]/[i:id]/edit', 'PhotoController@editComment'],
    ['GET',      '/gallery/albums', 'PhotoController@albums'],
    ['GET',      '/gallery/album/[user:login]', 'PhotoController@album'],
    ['GET',      '/gallery/comments', 'PhotoController@allComments'],
    ['GET',      '/gallery/comments/[user:login]', 'PhotoController@userComments'],
    ['GET',      '/gallery/[i:gid]/[i:id]/comment', 'PhotoController@viewcomment'],
    ['GET|POST', '/gallery/top', 'PhotoController@top'],

    ['GET',      '/forum', 'Forum\ForumController@index', 'forum'],
    ['GET',      '/forum/[i:fid]', 'Forum\ForumController@forum'],
    ['GET|POST', '/forum/create', 'Forum\ForumController@create'],
    ['GET',      '/topic/[i:tid]', 'Forum\TopicController@index'],
    ['GET',      '/topic/[i:tid]/[i:id]', 'Forum\TopicController@viewpost'],
    ['POST',     '/topic/[i:tid]/vote', 'Forum\TopicController@vote'],
    ['GET',      '/topic/[i:tid]/[end|close:action]', 'Forum\TopicController'],
    ['POST',     '/topic/[i:tid]/[create|delete:action]', 'Forum\TopicController'],
    ['GET|POST', '/topic/[i:tid]/[i:id]/edit', 'Forum\TopicController@editPost'],
    ['GET|POST', '/topic/[i:tid]/[edit:action]', 'Forum\TopicController'],
    ['GET',      '/forum/search', 'Forum\ForumController@search'],
    ['GET',      '/forum/active/[posts|themes:action]', 'Forum\ActiveController'],
    ['POST',     '/forum/active/delete', 'Forum\ActiveController@delete'],
    ['GET',      '/forum/new/[posts|themes:action]', 'Forum\NewController'],
    ['GET',      '/forum/top/posts', 'Forum\ForumController@topPosts'],
    ['GET',      '/forum/top/themes', 'Forum\ForumController@topThemes'],
    ['GET',      '/topic/[i:tid]/print', 'Forum\TopicController@print'],
    ['GET',      '/forum/rss', 'Forum\ForumController@rss'],
    ['GET',      '/topic/[i:tid]/rss', 'Forum\ForumController@rssPosts'],
    ['GET',      '/forum/bookmark', 'BookmarkController@index'],
    ['POST',     '/forum/bookmark/[delete|perform:action]', 'BookmarkController'],

    ['GET',      '/user/[user:login]', 'User\UserController@index'],
    ['GET|POST', '/user/[user:login]/note', 'User\UserController@note', 'note'],
    ['GET|POST', '/login', 'User\UserController@login', 'login'],
    ['GET',      '/logout', 'User\UserController@logout', 'logout'],
    ['GET|POST', '/register', 'User\UserController@register', 'register'],
    ['GET|POST', '/profile', 'User\UserController@profile'],
    ['GET',      '/key', 'User\UserController@key'],
    ['GET|POST', '/setting', 'User\UserController@setting'],
    ['GET',      '/account', 'User\UserController@account'],
    ['POST',     '/account/changemail', 'User\UserController@changeMail'],
    ['GET',      '/account/editmail', 'User\UserController@editMail'],
    ['POST',     '/account/editstatus', 'User\UserController@editStatus'],
    ['POST',     '/account/editpassword', 'User\UserController@editPassword'],
    ['POST',     '/account/apikey', 'User\UserController@apikey'],

    ['GET',      '/searchuser', 'User\SearchController@index'],
    ['GET',      '/searchuser/[letter:letter]', 'User\SearchController@sort'],
    ['GET|POST', '/searchuser/search', 'User\SearchController@search'],

    ['GET',      '/rating/[user:login]/[received|gave:action]?', 'RatingController@received'],
    ['POST',     '/rating/delete', 'RatingController@delete'],
    ['GET|POST', '/user/[user:login]/rating', 'RatingController@index'],

    ['GET|POST', '/mail', 'MailController@index', 'mail'],
    ['GET|POST', '/recovery', 'MailController@recovery', 'recovery'],
    ['GET',      '/recovery/restore', 'MailController@restore'],
    ['GET|POST', '/unsubscribe', 'MailController@unsubscribe', 'unsubscribe'],

    ['GET',      '/menu', 'PageController@menu'],
    ['GET',      '/page/[a:action]?', 'PageController@index'],
    ['GET',      '/tags', 'PageController@tags', 'tags'],
    ['GET',      '/rules', 'PageController@rules', 'rules'],
    ['GET',      '/smiles', 'PageController@smiles', 'smiles'],
    ['GET',      '/online/[all:action]?', 'OnlineController@index', 'online'],

    ['POST',     '/ajax/bbcode', 'AjaxController@bbCode'],
    ['POST',     '/ajax/delcomment', 'AjaxController@delComment'],
    ['POST',     '/ajax/rating', 'AjaxController@rating'],
    ['POST',     '/ajax/vote', 'AjaxController@vote'],
    ['POST',     '/ajax/complaint', 'AjaxController@complaint'],
    ['POST',     '/ajax/image', 'AjaxController@uploadImage'],

    ['GET',      '/wall/[user:login]', 'WallController@index', 'wall'],
    ['POST',     '/wall/[user:login]/create', 'WallController@create'],
    ['POST',     '/wall/[user:login]/delete', 'WallController@delete'],

    ['GET',      '/private/[outbox|history|clear:action]?', 'PrivateController@index'],
    ['POST',     '/private/[delete:action]', 'PrivateController'],
    ['GET|POST', '/private/[send:action]', 'PrivateController'],

    ['GET',      '/votes', 'VoteController@index'],
    ['GET|POST', '/votes/[i:id]', 'VoteController@view'],
    ['GET',      '/votes/[i:id]/voters', 'VoteController@voters'],
    ['GET',      '/votes/history', 'VoteController@history'],
    ['GET',      '/votes/history/[i:id]', 'VoteController@viewHistory'],
    ['GET|POST', '/votes/create', 'VoteController@create'],

    ['GET|POST', '/ignore', 'IgnoreController@index'],
    ['GET|POST', '/ignore/note/[i:id]', 'IgnoreController@note'],
    ['POST',     '/ignore/delete', 'IgnoreController@delete'],

    ['GET|POST', '/contact', 'ContactController@index'],
    ['GET|POST', '/contact/note/[i:id]', 'ContactController@note'],
    ['POST',     '/contact/delete', 'ContactController@delete'],
    ['GET',      '/counter/[day|month:action]?', 'CounterController@index'],

    ['GET',      '/transfer', 'TransferController@index'],
    ['POST',     '/transfer/send', 'TransferController@send'],

    ['GET',      '/notebook', 'NotebookController@index'],
    ['GET|POST', '/notebook/edit', 'NotebookController@edit'],

    ['GET',      '/reklama', 'RekUserController@index'],
    ['GET|POST', '/reklama/create', 'RekUserController@create'],

    ['GET',      '/authlog', 'LoginController@index'],

    ['GET',      '/adminlist', 'User\ListController@adminlist'],
    ['GET|POST', '/userlist', 'User\ListController@userlist'],
    ['GET|POST', '/authoritylist', 'User\ListController@authoritylist'],
    ['GET|POST', '/ratinglist', 'User\ListController@ratinglist'],
    ['GET|POST', '/ban', 'User\BanController@ban'],
    ['GET',      '/banhist', 'User\BanController@banhist'],
    ['GET|POST', '/unban', 'User\BanController@unban'],
    ['GET|POST', '/who', 'User\UserController@who'],

    ['GET',      '/faq', 'PageController@faq'],
    ['GET',      '/statusfaq', 'PageController@statusfaq'],
    ['GET',      '/surprise', 'PageController@surprise'],

    ['GET',      '/offers/[offer|issue:type]?', 'OfferController@index'],
    ['GET',      '/offers/[i:id]', 'OfferController@view'],
    ['GET|POST', '/offers/create', 'OfferController@create'],
    ['GET|POST', '/offers/[i:id]/edit', 'OfferController@edit'],
    ['GET|POST', '/offers/[i:id]/comments', 'OfferController@comments'],
    ['GET',      '/offers/[i:id]/end', 'OfferController@end'],
    ['GET|POST', '/offers/[i:id]/[i:cid]/edit', 'OfferController@editComment'],

    ['GET|POST', '/pictures', 'PictureController@index'],
    ['GET',      '/pictures/delete', 'PictureController@delete'],

    ['GET|POST', '/files/[*:action]?', 'FileController', 'files'],

    ['GET',      '/load', 'Load\LoadController@index'],
    ['GET',      '/load/rss', 'Load\LoadController@rss'],
    ['GET',      '/load/[i:id]', 'Load\LoadController@load'],
    ['GET|POST', '/down/create', 'Load\DownController@create'],
    ['GET',      '/down/[i:id]', 'Load\DownController@index'],
    ['POST',     '/down/[i:id]/vote', 'Load\DownController@vote'],
    ['GET|POST', '/down/[i:id]/download', 'Load\DownController@download'],
    ['GET|POST', '/down/[i:id]/comments', 'Load\DownController@comments'],
    ['GET',      '/down/[i:id]/end', 'Load\DownController@end'],
    ['GET|POST', '/down/[i:id]/[i:cid]/edit', 'Load\DownController@editComment'],
    ['GET',      '/down/[i:id]/rss', 'Load\DownController@rss'],
    ['GET',      '/down/[i:id]/zip', 'Load\DownController@zip'],
    ['GET',      '/down/[i:id]/[i:fid]/zip', 'Load\DownController@zipView'],

    ['GET|POST', '/load/active', 'load/active.php'],
    ['GET|POST', '/load/add', 'load/add.php'],
    ['GET|POST', '/load/fresh', 'load/fresh.php'],
    ['GET|POST', '/load/new', 'load/new.php'],
    ['GET|POST', '/load/search', 'load/search.php'],
    ['GET|POST', '/load/top', 'load/top.php'],

    ['GET',      '/api', 'ApiController@index'],
    ['GET',      '/api/user', 'ApiController@user'],
    ['GET',      '/api/forum', 'ApiController@forum'],
    ['GET',      '/api/private', 'ApiController@private'],

    ['GET',      '/admin', 'Admin\AdminController@index', 'admin'],
    ['GET',      '/admin/spam', 'Admin\SpamController@index'],
    ['POST',     '/admin/spam/delete', 'Admin\SpamController@delete'],
    ['GET',      '/admin/log', 'Admin\LogController@index'],
    ['GET',      '/admin/log/clear', 'Admin\LogController@clear'],
    ['GET|POST', '/admin/antimat', 'Admin\AntimatController@index'],
    ['GET',      '/admin/antimat/[delete|clear:action]', 'Admin\AntimatController'],
    ['GET',      '/admin/status', 'Admin\StatusController@index'],
    ['GET|POST', '/admin/status/[create|edit:action]', 'Admin\StatusController'],
    ['GET',      '/admin/status/delete', 'Admin\StatusController@delete'],

    ['GET',      '/admin/rules', 'Admin\RulesController@index'],
    ['GET|POST', '/admin/rules/edit', 'Admin\RulesController@edit'],

    ['GET',      '/admin/upgrade', 'Admin\AdminController@upgrade'],
    ['GET',      '/admin/phpinfo', 'Admin\AdminController@phpinfo'],

    ['GET|POST', '/admin/setting', 'Admin\SettingController@index'],
    ['GET',      '/admin/cache', 'Admin\CacheController@index'],
    ['POST',     '/admin/cache/clear', 'Admin\CacheController@clear'],

    ['GET',      '/admin/backup', 'Admin\BackupController@index'],
    ['GET|POST', '/admin/backup/create', 'Admin\BackupController@create'],
    ['GET',      '/admin/backup/delete', 'Admin\BackupController@delete'],

    ['GET|POST', '/admin/checker', 'Admin\CheckerController@index'],
    ['GET|POST', '/admin/checker/scan', 'Admin\CheckerController@scan'],

    ['GET|POST', '/admin/delivery', 'Admin\DeliveryController@index'],

    ['GET',      '/admin/logadmin', 'Admin\LogAdminController@index'],
    ['GET',      '/admin/logadmin/clear', 'Admin\LogAdminController@clear'],

    ['GET',      '/admin/notice', 'Admin\NoticeController@index'],
    ['GET|POST', '/admin/notice/create', 'Admin\NoticeController@create'],
    ['GET|POST', '/admin/notice/edit/[i:id]', 'Admin\NoticeController@edit'],
    ['GET',      '/admin/notice/delete/[i:id]', 'Admin\NoticeController@delete'],

    ['GET|POST', '/admin/delusers', 'Admin\DelUserController@index'],
    ['POST',     '/admin/delusers/clear', 'Admin\DelUserController@clear'],

    ['GET',      '/admin/files', 'Admin\FilesController@index'],
    ['GET|POST', '/admin/files/edit', 'Admin\FilesController@edit'],
    ['GET|POST', '/admin/files/create', 'Admin\FilesController@create'],
    ['GET',      '/admin/files/delete', 'Admin\FilesController@delete'],

    ['GET',      '/admin/smiles', 'Admin\SmileController@index'],
    ['GET|POST', '/admin/smiles/create', 'Admin\SmileController@create'],
    ['GET|POST', '/admin/smiles/edit/[i:id]', 'Admin\SmileController@edit'],
    ['POST',     '/admin/smiles/delete', 'Admin\SmileController@delete'],

    ['GET|POST', '/admin/ipban', 'Admin\IpBanController@index'],
    ['POST',     '/admin/ipban/delete', 'Admin\IpBanController@delete'],
    ['GET',     '/admin/ipban/clear', 'Admin\IpBanController@clear'],

    ['GET|POST', '/admin/blacklist', 'Admin\BlacklistController@index'],
    ['POST',     '/admin/blacklist/delete', 'Admin\BlacklistController@delete'],

    ['GET',      '/admin/news', 'Admin\NewsController@index'],

    ['GET|POST', '/admin/book', 'admin/book.php'],
    ['GET|POST', '/admin/blog', 'admin/blog.php'],
    ['GET|POST', '/admin/chat', 'admin/chat.php'],
    ['GET|POST', '/admin/forum', 'admin/forum.php'],
    ['GET|POST', '/admin/gallery', 'admin/gallery.php'],
    ['GET|POST', '/admin/load', 'admin/load.php'],
    ['GET|POST', '/admin/newload', 'admin/newload.php'],
    ['GET|POST', '/admin/reklama', 'admin/reklama.php'],
    ['GET|POST', '/admin/ban', 'admin/ban.php'],
    ['GET|POST', '/admin/banhist', 'admin/banhist.php'],
    ['GET|POST', '/admin/banlist', 'admin/banlist.php'],
    ['GET|POST', '/admin/adminlist', 'admin/adminlist.php'],
    ['GET|POST', '/admin/users', 'admin/users.php'],
    ['GET|POST', '/admin/reglist', 'admin/reglist.php'],
    ['GET|POST', '/admin/votes', 'admin/votes.php'],
    ['GET|POST', '/admin/invitations', 'admin/invitations.php'],
    ['GET|POST', '/admin/transfers', 'admin/transfers.php'],
    ['GET|POST', '/admin/users', 'admin/users.php'],
    ['GET|POST', '/admin/offers', 'admin/offers.php'],

    ['GET', '/search', function() {
        return view('search/index');
    }],
];

$router->addRoutes($routes);

App\Classes\Registry::set('router', $router);
