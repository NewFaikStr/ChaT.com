<?php
	include "include/august.inc.php";
	startSess ("sess");
	$Auth = new auth (isset ($_POST ['nick']) ? $_POST ['nick'] : NULL, isset ($_POST ['pass']) ? $_POST ['pass'] : NULL);
	$page = isset ($_GET ['page']) ? $_GET ['page'] : "";
	if (isset ($_GET ['logout'])) {
		$Auth->logout ();
		header ("Location: ?page=$page");
		exit;
	}
	$AUTH_ERROR = array (
		AUTH_NO_CONNECT     => "Невозможно подключиться к серверу авторизации.",
		AUTH_PROFILE_NONE   => "Такой ник не зарегистрирован.",
		AUTH_PROFILE_ERROR1 => "Система безопасности: слишком много неудачных попыток.",
		AUTH_PROFILE_ERROR2 => "Система безопасности: слишком быстрая попытка.",
		AUTH_PASSWORD_ERROR => "Неправильный пароль.",
		AUTH_PASSWORD_NONE  => "Пароль не введен.",
		AUTH_NICK_ERROR     => "Недопустимый ник."
	);

	header ("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Мой сайт</title>
<style>
div.form { float: left; width: 60px }
.clear { clear: both }
h3.err { color: red }
</style>
<script src=js/august.js></script>
<script>
onload = function () {
	if (!document.forms.auth)
		return
	document.forms.auth.onsubmit = function () {
		if (this.ok || !this.auth_nick.value || !this.auth_pass.value)
			return false
		this.ok = 1
		this.nick.value = this.auth_nick.value
		this.pass.value = this.auth_pass.value.crypt (this.getAttribute ("key"))
		this.auth_nick.value = ""
		this.auth_pass.value = ""
		return true
	}
}
</script>
</head>

<body>
<?php if ($Auth->isAuth ()): ?>
<h2>Вы зашли как <big><?= htmlentities  ($Auth->nick (), ENT_COMPAT | ENT_HTML401, "utf-8") ?></big></h2>
[<a href=?logout=1&page=<?= $page ?>>выйти</a>] [<a href="javascript:document.forms.go_chat.submit ()">в чат</a>]
<form name=go_chat method=post action=.>
<input type=hidden name=profile value=<?= $Auth->ID ?>>
<input type=hidden name=auth_key value="<?= htmlspecialchars ($Auth->get ('AuthKey')) ?>">
</form>
<?php else: ?>
<h2>Вы не авторизованы</h2>
<?php
	if ($Auth->Error and isset ($AUTH_ERROR [$Auth->ID]))
		printf ("<h3 class=err>%s</h3>", $AUTH_ERROR [$Auth->ID]);
?>
<div class=form>&nbsp;</div>Авторизуйтесь:<br><br>
<form name=auth method=post key="<?= htmlspecialchars ($Auth->get ('PassKey')) ?>">
<div class=form>Логин:</div><input name=auth_nick autofocus><br>
<div class=form>Пароль:</div><input name=auth_pass type=password><br>
<div class=form>&nbsp;</div><input type=submit value=OK><br>
<div class=clear></div>
<input type=hidden name=nick><input type=hidden name=pass>
</form>
<?php endif ?>
<hr>
Это мой сайт, загружена страница <b><?= $page ?></b>
<ul>
<li><a href=?page=main>Страница 1</a>
<li><a href=?page=about>Страница 2</a>
<li><a href=?page=cool>Страница 3</a>
</ul>
</body>
</html>
