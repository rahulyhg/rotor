<h3>Поиск запроса &quot;<?=$tags?>&quot; в метках</h3>
Найдено совпадений: <b><?=$total?></b><br />

<?php foreach($blogs as $data): ?>

	<div class="b">
		<img src="/assets/img/images/edit.gif" alt="image" />
		<b><a href="/blog/blog?act=view&amp;id=<?=$data['blogs_id']?>"><?=$data['blogs_title']?></a></b> (<?=format_num($data['blogs_rating'])?>)
	</div>

	<div>
		Категория: <a href="/blog/blog?cid=<?=$data['cats_id']?>"><?=$data['cats_name']?></a><br />
		Просмотров: <?=$data['blogs_read']?><br />
		Метки: <?=$data['blogs_tags']?><br />
		Автор: <?=profile($data['blogs_user'])?>  (<?=date_fixed($data['blogs_time'])?>)
	</div>
<?php endforeach; ?>