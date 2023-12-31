<?php 
// tokens(id INT PRIMARY KEY, token text unique not null, expire text not null, service text not null);

  class Database
{
  public $db;

  function __construct() {
    //move db file path on production!!
    $this->db = new SQLite3('database.db');
  }
    public function addToken(String $token, String $expdate, String $service)
    {
        $insertToken = $this->db->prepare("INSERT INTO tokens(token, expire, service) VALUES (?, ?, ?)");
        $insertToken->bindParam(1, $token);
        $insertToken->bindParam(2, $expdate);
        $insertToken->bindParam(3, $service);

        return $insertToken->execute();
    }

    public function deleteToken(String $token) {
      $deleteToken = $this->db->prepare("DELETE FROM tokens WHERE token is ?");
      $deleteToken->bindParam(1, $token);

      return $deleteToken->execute();
    }

    public function getTokenInfo(String $token) {
      $readTokenInfo = $this->db->prepare("SELECT * FROM tokens WHERE token is ?");
      $readTokenInfo->bindParam(1, $token);

      $result = $readTokenInfo->execute();
      return $result->fetchArray();
    }

    public function getAllToken() {
      $readAllToken = $this->db->prepare("SELECT * FROM tokens");
      $queryResult = $readAllToken->execute();

      $out = array();

      while ($tmp = $queryResult->fetchArray()) {
        $out[] = $tmp;
      }
      return $out;
    } 

}


?>