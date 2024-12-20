<?php
require 'Class/DB_con.php';
require 'header.php';

?>
<h1>避難所一覧　削除済み</h1>
<table id="admin">
    <thead>
        <tr>
            <th>No</th>
            <th>名 称</th>
            <th>住 所</th>
            <th>削 除 日</th>
            <th>詳 細</th>
            <th>削除 取消</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $con = new DB_con();
        $pdo = $con->con();
        try {
            $sql = $pdo->prepare('SELECT no, name, address, deleted_at FROM shelter WHERE deleted_at IS NOT NULL;');
            $sql->execute();
            $result = $sql->fetchAll();
            if (!empty($result)) {
                foreach ($result as $row) {
                    echo <<<HTML
              <tr>
                  <th>{$row['no']}</th>
                  <th>{$row['name']}</th>
                  <th>{$row['address']}</th>
                  <th>{$row['deleted_at']}</th>
                  <th><a href="shelter_detail.php?shelter_no={$row['no']}">詳細</a></th>
                  <th><a href="sql_execute/delete_cancel.php?shelter_no={$row['no']}">取消</a></th>
              </tr>
              HTML;
                }
            } else {
                header('Location:error.php');
                exit;
            }
        } catch (Exception $e) {
            echo "エラー: " . $e->getMessage();
        }
        ?>
    </tbody>
</table>
<button type="button" class="button" onclick="history.back()">戻る</button>

<?php require 'footer.php'; ?>