<?php
require '../Class/DB_con.php';
require '../header.php';

echo <<<HTML
    <h1>避難所　追加</h1>
    <h3>基本情報</h3>
    <form action="../sql_execute/insert.php" method="post"  onsubmit="return confirm('追加してもよろしいですか？');">
        名称:
        <input type="text" name="name"><br>
        名称（カナ）:
        <input type="text" name="name_kana"><br>
        住所:
        <input type="text" name="address"><br>
        緯度:
        <input type="text" name="latitude"><br>
        経度:
        <input type="text" name="longitude"><br>
        電話番号:
        <input type="tel" name="tel"><br>
        想定収容人数:
        <input type="number" name="capacity" style="text-align:right">人<br>
    <h3>対応災害種別</h3>
    洪水:
    <select name="flood">
        <option value="1" selected>〇</option>
        <option value="0">×</option>
    </select><br>
    崖崩れ、土石流及び地滑り:
    <select name="landslide">
        <option value="1" selected>〇</option>
        <option value="0">×</option>
    </select><br>
    高潮:
    <select name="high_tide">
        <option value="1" selected>〇</option>
        <option value="0">×</option>
    </select><br>
    地震:
    <select name="earthquake">
        <option value="1" selected>〇</option>
        <option value="0">×</option>
    </select><br>
    津波:
    <select name="tsunami">
        <option value="1" selected>〇</option>
        <option value="0">×</option>
    </select><br>
    大規模な火事:
    <select name="fire">
        <option value="1" selected>〇</option>
        <option value="0">×</option>
    </select><br>
    内水氾濫:
    <select name="inland_flooding">
        <option value="1" selected>〇</option>
        <option value="0">×</option>
    </select><br>
    火山現象:
    <select name="volcanic_eruption">
        <option value="1" selected>〇</option>
        <option value="0">×</option>
    </select><br>

    <input class="button" type="submit" value="追加">
    </form>
    <form action="../shelter_list.php">
        <input class="button" type="submit" value="一覧へ">
    </form>
HTML;

require '../footer.php';