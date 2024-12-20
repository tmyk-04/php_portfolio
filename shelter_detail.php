<?php
require 'Class/DB_con.php';
require 'header.php';

if (isset($_GET['shelter_no']) || !empty($_GET['shelter_no'])) {
    $shelter_no = $_GET['shelter_no'];
    $con = new DB_con();
    $pdo = $con->con();
    try {
        $sql = $pdo->prepare('SELECT * FROM shelter LEFT JOIN disaster_type ON shelter.no = disaster_type.shelter_key WHERE shelter.no =?;');
        $sql->execute([$shelter_no]);
        $result = $sql->fetch();
        echo '<h1>避難所詳細</h1>';
        if ($result) {
            echo <<<HTML
        <table id="admin" border="1">
        <thead>
            <tr>
                <th>住所</th>
                <th>緯度</th>
                <th>経度</th>
                <th>電話番号</th>
                <th>洪水</th>
                <th>土砂災害</th>
                <th>高潮</th>
                <th>地震</th>
                <th>津波</th>
                <th>火災</th>
                <th>内水氾濫</th>
                <th>火山現象</th>
                <th>収容人数</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <h4>{$result['name_kana']}</h4>
            <h2>{$result['name']}</h2>
            <td>{$result['address']}</td>
            <td>{$result['latitude']}</td>
            <td>{$result['longitude']}</td>
            <td>{$result['tel']}</td>
        HTML;
            ?>
            <td><?php echo $result['flood'] == 1 ? '〇' : '×'; ?></td>
            <td><?php echo $result['landslide'] == 1 ? '〇' : '×'; ?></td>
            <td><?php echo $result['high_tide'] == 1 ? '〇' : '×'; ?></td>
            <td><?php echo $result['earthquake'] == 1 ? '〇' : '×'; ?></td>
            <td><?php echo $result['tsunami'] == 1 ? '〇' : '×'; ?></td>
            <td><?php echo $result['fire'] == 1 ? '〇' : '×'; ?></td>
            <td><?php echo $result['inland_flooding'] == 1 ? '〇' : '×'; ?></td>
            <td><?php echo $result['volcanic_eruption'] == 1 ? '〇' : '×'; ?></td>
            <td><?php echo $result['capacity']; ?>人</td>
            </tr>
            </tbody>
            </table>
            <form action="input_view/update_input.php" method="post">
                <input type="hidden" name="update" value="<?php echo $shelter_no; ?>">
                <input class="button" type="submit" value="更新">
            </form>
            <form action="sql_execute/delete.php" method="post" onsubmit="return confirm('本当に削除しますか？');">
                <input class="button" type="hidden" name="delete" value="<?php echo $shelter_no; ?>">
                <input class="button" type="submit" value="削除">
            </form>
            <?php
        } else {
            header('Location:error.php');
            exit;
        }
    } catch (Exception $e) {
        echo "エラー: " . $e->getMessage();
    }

} else {
    header('Location:error.php');
    exit;
}

require 'footer.php'; ?>