<?php
require 'Class/DB_con.php';
require 'header.php';

?>
<h1>避難所一覧</h1>
<table id="admin">
    <thead>
        <tr>
            <th>No</th>
            <th>名 称</th>
            <th>住 所</th>
            <th>詳 細</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $con = new DB_con();
        $pdo = $con->con();
        try {
            $sql = $pdo->prepare('SELECT no, name, address FROM shelter WHERE deleted_at IS NULL;');
            $sql->execute();
            foreach ($sql as $row) {
                echo <<<HTML
          <tr>
              <th>{$row['no']}</th>
              <th>{$row['name']}</th>
              <th>{$row['address']}</th>
              <th><a href="shelter_detail.php?shelter_no={$row['no']}">詳細</a></th>
          </tr>
          HTML;
            }
        } catch (Exception $e) {
            echo "エラー: " . $e->getMessage();
        }
        ?>
    </tbody>
</table>

<?php require 'footer.php'; ?>