<?php
class Database {
    private $con;
    public function connect(){
        // Connect to XAMPP MySQL (local)
        $this->con = new Mysqli("localhost", "root", "", "farmtek");
        if ($this->con->connect_error) {
            die("Database Connection failed: " . $this->con->connect_error);
        }
        return $this->con;
    }
}
?>
