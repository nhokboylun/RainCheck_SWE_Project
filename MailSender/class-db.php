<?php
class DB {
    private $dbHost     = "localhost";
    private $dbUsername = "u647272286_swe2023";
    private $dbPassword = "Heoboy123$%^&*(";
    private $dbName     = "u647272286_swe";
    private $db;
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
  
    public function is_token_empty() {
        $result = $this->db->query("SELECT id FROM google_oauth WHERE provider = 'google'");
        if($result->num_rows) {
            return false;
        }
  
        return true;
    }
  
    public function get_access_token() {
        // $sql = $this->db->query("SELECT provider_value FROM google_oauth WHERE provider='google'");
        // $result = $sql->fetch_assoc();
        // return json_decode($result['provider_value']);
        return json_decode('{"access_token":"ya29.a0AVvZVsrKx7upY9nUfaX9IuqlKs4uiNuT05nZRIR8KBZz9jnQyS9ZVu4GzJTHmu6_eBx6BjRmALI8bS0qC_C3ER_sU287YXS6Y-eL1Qy777swGA35xjJOGONtIPlgU12_8YXRimIAAXJrlRmzm9E-VQpqyphd1goXB8UaCgYKAZUSARASFQGbdwaI2Q7wP5z877c8j08H6icMVg0170","token_type":"Bearer","expires_in":3599,"expires_at":1677963139}');
    }
  
    public function get_refersh_token() {
        $result = $this->get_access_token();
        return $result->refresh_token;
    }
  
    public function update_access_token($token) {
        if($this->is_token_empty()) {
            $this->db->query("INSERT INTO google_oauth(provider, provider_value) VALUES('google', '$token')");
        } else {
            $this->db->query("UPDATE google_oauth SET provider_value = '$token' WHERE provider = 'google'");
        }
    }
}