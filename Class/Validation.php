<?php
class Validation {
    // ユニコードプロパティ使用でうまく動作
    private $errors = [];
    private $pt_name = '/^[0-9a-zA-Z\p{Hiragana}\p{Katakana}\p{Han}ー・()　\s-]*$/u';
    private $pt_name_kana = '/^[\p{Katakana}・()ー　]*$/u';
    private $pt_address = '/^[0-9a-zA-Z\p{Hiragana}\p{Katakana}\p{Han}ー・()　\s-]*$/u';
    private $pt_latitude ='/^-?\d+(\.\d+)?$/';
    private $pt_longitude = '/^-?\d+(\.\d+)?$/';
    private $pt_tel = '/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/';
    private $pt_capacity = '/^[1-9]{1,}$/';
    public function va_name($name) {
        if (($name !== null) && (!preg_match($this->pt_name, $name))) {
            $this->errors['name'] = "名称が無効です。";
        }
    }
    public function va_kana($name_kana) {
        if (($name_kana !== null) && (!preg_match($this->pt_name_kana, $name_kana))) {
            $this->errors['name_kana'] = "名称（カナ）が無効です。";
        }
    }
    public function va_address($address) {
        if (($address !== null) && (!preg_match($this->pt_address, $address))) {
            $this->errors['address'] = "住所が無効です。";
        }
    }
    public function va_latitude($latitude) {
        if (($latitude !== null) && (!preg_match($this->pt_latitude, $latitude))) {
            $this->errors['latitude'] = "緯度が無効です。";
        }
    }
    public function va_longitude($longitude) {
        if (($longitude !== null) && (!preg_match($this->pt_longitude, $longitude))) {
            $this->errors['longitude'] = "経度が無効です。";
        }
    }
    public function va_tel($tel) {
        if (($tel !== null) && (!preg_match($this->pt_tel, $tel))) {
            $this->errors['tel'] = "電話番号が無効です。";
        }
    }
    public function va_capacity($capacity) {
        if (($capacity !== null) && (!preg_match($this->pt_capacity, $capacity))) {
            $this->errors['capacity'] = "収容人数が無効です。";
        }
    }
    public function error_check() {
        if (is_array($this->errors) && empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }
    public function va_error() {
        foreach ($this->errors as $erroe) {
            echo '<h3>' . $erroe . '</h3>';
        }
    }
}