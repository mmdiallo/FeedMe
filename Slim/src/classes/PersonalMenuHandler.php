<?php
    class PersonalMenuHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getId($user_id) {
            $id = -1;
            $statement = 'SELECT id FROM PersonalMenus WHERE user_id=:user_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':user_id', $user_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }
    }
?>