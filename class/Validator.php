<?php
class Validator {

    private $data;
    private $errors = [];
    public function __construct($data) {
        $this->data = $data;
    }

    private function getField($field) {

        if (!isset($this->data[$field])) {
            return NULL;
        }
        return $this->data[$field];
    }

    public function isAlpha($field, $errorMsg) {

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $this->getField($field))) {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isUniq($field, $db, $table, $errorMsg) {
        $record = $db->query("SELECT id FROM $table WHERE $field = ?", [$this->getField($field)])->fetch();    // Vérifie si l'username existe déjà dans la bdd

        if($record) {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isEmail($field, $errorMsg) {

        if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {     // Vérification présence email OU email correct
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isConfirmed($field, $errorMsg = "") {
        $value = $this->getField($field);

        if (empty($value) || $value != $this->getField('confirm_' . $field)) {     // Vérification présence password OU password correct
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isValid() {
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}