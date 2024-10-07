<?php
	include "include/crawlers.inc.php";
	if (is_crawler ()) {
		include "crawler.html";
		exit;
	}
	include "include/base.php";
?>
<!DOCTYPE html>
<html class=app-chat-html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="keywords" content="сделать чат, свой чат, чат-сервер, скачать чат август бесплатно">
<meta name="description" content="Бесплатный чат. Скачать скрипт чата.">
<script defer src="js/august.js?<?= VERSION  ?>"></script>
<script src="js/august.chat.js?<?= VERSION  ?>"></script>
<script src="js/init.js.php?<?= $_SERVER ['QUERY_STRING'] ?>"></script>
<?php if ($IS_POST and isset ($_POST ['auth_key'])): ?>
<script>
INIT.PROFILE	= <?= +$_POST ['profile'] ?>;
INIT.AUTH_KEY	= "<?= august_safe_str ($_POST ['auth_key']) ?>";
</script>
<?php endif ?>
</head>

<body></body>
</html>
