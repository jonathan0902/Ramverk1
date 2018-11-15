<?=
    $di->request->getGet('ip');
?>
<h2><?= $print ?></h2>
<form method="GET">
    <input type="text" name="ip">
    <input type="submit" value="submit">
</form>
