<?php
    class AccountHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function validateUsername($username) {

        }

        public function createPasswordSalt() {

        }

        public function hashPassword($password, $password_salt) {

        }

        public function getAccountTypeId($type) {

        }

        public function createAccount($username, $password_hash, $password_salt, $account_type) {

        }

    }
?>