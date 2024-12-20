<?php
require '../Class/DB_con.php';
require '../Class/Validation.php';
require '../header.php';

if (!empty($_GET)) {
    $shelter_no = $_GET['shelter_no'];
    $con = new DB_con();
    $pdo = $con->con();
    try {
        $sql = $pdo->prepare('UPDATE shelter SET deleted_at = null WHERE no = ?;');
        $sql->execute([$shelter_no]);
        header('Location:../deleted_shelter_list.php');
        exit;
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