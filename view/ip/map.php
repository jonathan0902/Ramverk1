<?=
    $di->request->getGet('ip');
?>
<ul>
    <li><?= $ip ?></li>
    <li><?= $country ?></li>
    <li><?= $region_name ?></li>
    <li><?= $city ?></li>
    <li><?= $zip ?></li>
</ul>
<form method="GET">
    <input type="text" name="ipMap">
    <p></p>
    <input class="btn btn-warning" type="submit" value="Skicka">
</form>
