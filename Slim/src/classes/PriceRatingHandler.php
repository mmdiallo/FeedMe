<?php
    class PriceRatingHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllPriceRatings() {
            $ratings = array();
            $statement = 'SELECT * FROM PriceRatings';
            if ($query_result = $this->db->query($statement)) {
                while ($row = $query_result->fetchArray()) {
                    $ratings[$row['rating']] = array('lowest_price' => $row['lowest_price'], 'highest_price' => $row['highest_price']);
                }
            }
            return $ratings;
        }

        public function getRating($id) {
            $rating = -1;
            $statement = 'SELECT rating FROM PriceRatings WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $rating = $row['rating'];
            }

            return $rating;
        }

        public function getId($rating) {
            $id = -1;
            $statement = 'SELECT id FROM PriceRatings WHERE rating=:rating';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':rating', $rating, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        public function getLowestPrice($id) {
            $lowest_price = -1;
            $statement = 'SELECT lowest_price FROM PriceRatings WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $lowest_price = $row['lowest_price'];
            }

            return $lowest_price;
        }

        public function getHighestPrice($id) {
            $highest_price = -1;
            $statement = 'SELECT highest_price FROM PriceRatings WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $highest_price = $row['highest_price'];
            }

            return $highest_price;
        }
    }
?>