<?php
require '../Class/DB_con.php';
require '../Class/Validation.php';
require '../header.php';

if (!empty($_POST)) {
    $shelter_no = $_POST['no'];
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
            $sql_update = $pdo->prepare('UPDATE shelter AS sh JOIN disaster_type AS type ON (sh.no = type.shelter_key) SET sh.name = :name, sh.name_kana = :name_kana, sh.address = :address, sh.latitude = :latitude, sh.longitude = :longitude, sh.tel = :tel, sh.capacity = :capacity, type.flood = :flood, type.high_tide = :high_tide, type.earthquake = :earthquake, type.tsunami = :tsunami, type.fire = :fire, type.inland_flooding = :inland_flooding, type.volcanic_eruption = :volcanic_eruption WHERE sh.no = :shelter_no;');
            $sql_update->bindParam(':name', $name);
            $sql_update->bindParam(':name_kana', $name_kana);
            $sql_update->bindParam(':address', $address);
            $sql_update->bindParam(':latitude', $latitude);
            $sql_update->bindParam(':longitude', $longitude);
            $sql_update->bindParam(':tel', $tel);
            $sql_update->bindParam(':capacity', $capacity);
            $sql_update->bindParam(':flood', $flood);
            $sql_update->bindParam(':high_tide', $high_tide);
            $sql_update->bindParam(':earthquake', $earthquake);
            $sql_update->bindParam(':tsunami', $tsunami);
            $sql_update->bindParam(':fire', $fire);
            $sql_update->bindParam(':inland_flooding', $inland_flooding);
            $sql_update->bindParam(':volcanic_eruption', $volcanic_eruption);
            $sql_update->bindParam(':shelter_no', $shelter_no);
            $sql_update->execute();
            $pdo->commit();
            echo '<h3>避難所名：'.$_POST["name"].'を更新しました。</h3>';
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