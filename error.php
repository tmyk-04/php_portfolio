<?php
require 'header.php';

echo <<<HTML
    <p>該当するデータがありません。</p>
    <form action="shelter_list.php">
        <input class="button" type="submit" value="一覧へ">
    </form>
HTML;

require 'footer.php';