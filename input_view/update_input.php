<?php
require '../Class/DB_con.php';
require '../header.php';

if (!empty($_POST)) {
    $shelter_no = $_POST['update'];
    $con = new DB_con();
    $pdo = $con->con();
    try {
        $sql_select = $pdo->prepare('SELECT * FROM shelter LEFT JOIN disaster_type ON shelter.no = disaster_type.shelter_key WHERE shelter.no =?;');
        $sql_select->execute([$shelter_no]);
        $result = $sql_select->fetch();
        echo <<<HTML
    <h1>避難所詳細　更新</h1>
    <h3>基本情報</h3>
    <form action="../sql_execute/update.php" method="post">
        <input type="hidden" name="no" value="{$shelter_no}">
        名称:
        <input type="text" name="name" value="{$result['name']}"><br>
        名称（カナ）:
        <input type="text" name="name_kana" value="{$result['name_kana']}"><br>
        住所:
        <input type="text" name="address" value="{$result['address']}"><br>
        緯度:
        <input type="text" name="latitude" value="{$result['latitude']}"><br>
        経度:
        <input type="text" name="longitude" value="{$result['longitude']}"><br>
        電話番号:
        <input type="tel" name="tel" value="{$result['tel']}"><br>
        想定収容人数:
        <input type="number" name="capacity" value="{$result['capacity']}" style="text-align:right">人<br>
    HTML;
    } catch (Exception $e) {
        echo "エラー: " . $e->getMessage();
    }
    ?>
    <h3>対応災害種別</h3>
    洪水:
    <select name="flood">
        <option value="1" <?php echo ($result['flood'] == 1) ? 'selected' : ''; ?>>〇</option>
        <option value="0" <?php echo ($result['flood'] == 0) ? 'selected' : ''; ?>>×</option>
    </select><br>
    崖崩れ、土石流及び地滑り:
    <select name="landslide">
        <option value="1" <?php echo ($result['landslide'] == 1) ? 'selected' : ''; ?>>〇</option>
        <option value="0" <?php echo ($result['landslide'] == 0) ? 'selected' : ''; ?>>×</option>
    </select><br>
    高潮:
    <select name="high_tide">
        <option value="1" <?php echo ($result['high_tide'] == 1) ? 'selected' : ''; ?>>〇</option>
        <option value="0" <?php echo ($result['high_tide'] == 0) ? 'selected' : ''; ?>>×</option>
    </select><br>
    地震:
    <select name="earthquake">
        <option value="1" <?php echo ($result['earthquake'] == 1) ? 'selected' : ''; ?>>〇</option>
        <option value="0" <?php echo ($result['earthquake'] == 0) ? 'selected' : ''; ?>>×</option>
    </select><br>
    津波:
    <select name="tsunami">
        <option value="1" <?php echo ($result['tsunami'] == 1) ? 'selected' : ''; ?>>〇</option>
        <option value="0" <?php echo ($result['tsunami'] == 0) ? 'selected' : ''; ?>>×</option>
    </select><br>
    大規模な火事:
    <select name="fire">
        <option value="1" <?php echo ($result['fire'] == 1) ? 'selected' : ''; ?>>〇</option>
        <option value="0" <?php echo ($result['fire'] == 0) ? 'selected' : ''; ?>>×</option>
    </select><br>
    内水氾濫:
    <select name="inland_flooding">
        <option value="1" <?php echo ($result['inland_flooding'] == 1) ? 'selected' : ''; ?>>〇</option>
        <option value="0" <?php echo ($result['inland_flooding'] == 0) ? 'selected' : ''; ?>>×</option>
    </select><br>
    火山現象:
    <select name="volcanic_eruption">
        <option value="1" <?php echo ($result['volcanic_eruption'] == 1) ? 'selected' : ''; ?>>〇</option>
        <option value="0" <?php echo ($result['volcanic_eruption'] == 0) ? 'selected' : ''; ?>>×</option>
    </select><br>

    <input class="button" type="submit" value="更新" onsubmit="return confirm('更新してもよろしいですか？');">
    <button type="button" class="button" onclick="history.back()">戻る</button>
    </form>
    <?php
} else {
    header('Location:../error.php');
    exit;
}

require '../footer.php'; ?>