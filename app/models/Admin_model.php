<?php
include_once "Connection.php";
class Admin_model{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    function execute($query){
        return mysqli_query($this->conn->getConnection(),$query);
    }

    public function login($data){
        session_start();
        $email = mysqli_real_escape_string($this->conn->getConnection(), $data['email']);
        $password = mysqli_real_escape_string($this->conn->getConnection(), $data['password']);
        if(!empty($email) && !empty($password)){
            $sql = mysqli_query($this->conn->getConnection(), "SELECT * FROM user WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                $data2 = mysqli_fetch_assoc($sql);
                $pass_user = md5($password);
                $pass_encript = $data2['password'];
                if($pass_user === $pass_encript){
                    $status = "Sedang Aktif";
                    $sql2 = mysqli_query($this->conn->getConnection(), "UPDATE user SET status = '{$status}' WHERE id = {$data2['id']}");
                    if($sql2){
                        $_SESSION['id'] = $data2['id'];
                        return "sukses";
                    }else{
                        return "Terdapat kesalahan, harap coba kembali!";
                    }
                }else{
                    return "Email atau Password salah";
                }
            }else{
                return "$email - Email ini belum terdaftar";
            }
        }else{
            return "Semua kolom input harus terisi!";
        }
    }

    public function endSession($data){
        // session_start();
        if(isset($_SESSION['id'])){
            $admin_id = mysqli_real_escape_string($this->conn->getConnection(), $data['admin_id']);
            $sql = mysqli_query($this->conn->getConnection(), "DELETE FROM user WHERE id!={$data['admin_id']}");
            $sql2 = mysqli_query($this->conn->getConnection(), "DELETE FROM pesan");
        }
        if($sql && $sql2){
            
            return "sukses";
        }
    }
    
}
?>