<?php
require '../Class/DB_con.php';
require '../Class/Validation.php';
require '../header.php';

if (!empty($_POST)) {
    $name = (trim($_POST['name']) === '') ? null : $_POST['name'];
    $name_kana = (trim($_POST['name_kana']) === '') ? null : $_POST['name_kana'];
    $address = (trim($_POST['address']) === '') ? null : $_POST['address'];
    $latitude = (trim($_POST['latitude']) === '') ? null : $_POST['latitude'];
    $longitude = (trim($_POST['longitude']) === '') ? null : $_POST['longitude'];
    $tel = (trim($_POST['tel']) === '') ? null : $_POST['tel'];
    $capacity = (trim($_POST['capacity']) === '') ? null : $_POST['capacity'];
    $flood = $_POST['flood'];
    $landslide = $_POST['landslide'];
    $high_tide = $_POST['high_tide'];
    $earthquake = $_POST['earthquake'];
    $tsunami = $_POST['tsunami'];
    $fire = $_POST['fire'];
    $inland_flooding = $_POST['inland_flooding'];
    $volcanic_eruption = $_POST['volcanic_eruption'];

    $vl = new Validation();
    $vl->va_name($name);
    $vl->va_kana($name_kana);
    $vl->va_address($address);
    $vl->va_latitude($latitude);
    $vl->va_longitude($longitude);
    $vl->va_tel($tel);
    $vl->va_capacity($capacity);

    // var_dump($name);
    // var_dump($name_kana);
    // var_dump($address);

    if ($vl->error_check()) {
        $con = new DB_con();
        $pdo = $con->con();
        $pdo->beginTransaction();
        try {
            $sql_insert_shelter = $pdo->prepare('INSERT INTO shelter (name, name_kana, address, latitude, longitude, tel, capacity) VALUES (:name, :name_kana, :address, :latitude, :longitude, :tel, :capacity);');
            $sql_insert_shelter->bindParam(':name', $name);
            $sql_insert_shelter->bindParam(':name_kana', $name_kana);
            $sql_insert_shelter->bindParam(':address', $address);
            $sql_insert_shelter->bindParam(':latitude', $latitude);
            $sql_insert_shelter->bindParam(':longitude', $longitude);
            $sql_insert_shelter->bindParam(':tel', $tel);
            $sql_insert_shelter->bindParam(':capacity', $capacity);
            $sql_insert_shelter->execute();

            $last_no = $pdo->lastInsertId();

            $sql_insert_type = $pdo->prepare('INSERT INTO disaster_type (shelter_key, flood, high_tide, earthquake, tsunami, fire, inland_flooding, volcanic_eruption) VALUES (:shelter_key, :flood, :high_tide, :earthquake, :tsunami, :fire, :inland_flooding, :volcanic_eruption);');
            $sql_insert_type->bindParam(':shelter_key', $last_no);
            $sql_insert_type->bindParam(':flood', $flood);
            $sql_insert_type->bindParam(':high_tide', $high_tide);
            $sql_insert_type->bindParam(':earthquake', $earthquake);
            $sql_insert_type->bindParam(':tsunami', $tsunami);
            $sql_insert_type->bindParam(':fire', $fire);
            $sql_insert_type->bindParam(':inland_flooding', $inland_flooding);
            $sql_insert_type->bindParam(':volcanic_eruption', $volcanic_eruption);
            $sql_insert_type->execute();

            $pdo->commit();
            echo '<h3>新しい避難所を追加しました。</h3>';
            echo '<form action="../shelter_list.php">
                <input class="button" type="submit" value="一覧へ">
            </form>';
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "エラー: " . $e->getMessage();
            echo '<form action="../shelter_list.php">
                <input class="button" type="submit" value="戻る">
            </form>';
        }
    } else {
        $vl->va_error();
        echo '<button type="button" class="button" onclick="history.back()">戻る</button>';
    }
} else {
    header('Location:../error.php');
    exit;
}

require '../footer.php';