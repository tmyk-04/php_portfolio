<?php
require '../Class/DB_con.php';
require '../header.php';

if (!empty($_POST)) {
    $con = new DB_con();
    $pdo = $con->con();
    try {
        $sql_select = $pdo->prepare('SELECT name, name_kana FROM shelter WHERE no =?;');
        $sql_select->execute([$_POST['delete']]);
        $result = $sql_select->fetch();

        if ($result) {
            $sql_update = $pdo->prepare('UPDATE shelter SET deleted_at = NOW() WHERE no = ?;');
            $sql_update->execute([$_POST['delete']]);

            echo '<h2>以下のレコードが削除されました。</h2><br>';
            echo '<h4>' . $result['name_kana'] . '</h4>';
            echo '<h2>' . $result['name'] . '</h2>';
        } else {
            header('Location:../error.php');
            exit;
        }
    } catch (Exception $e) {
        echo "エラー: " . $e->getMessage();
    }
    echo '<form action="../shelter_list.php">
        <input class="button" type="submit" value="一覧へ">
    </form>';
} else {
    header('Location:../error.php');
    exit;
}

require '../footer.php';