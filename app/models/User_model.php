<?php
include_once "Connection.php";
class User_model {

    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    function execute($query){
        return mysqli_query($this->conn->getConnection(),$query);
    }

    public function register($data){
        session_start();
        $namdep = mysqli_real_escape_string($this->conn->getConnection(), $data['namdep']);
        $nambel = mysqli_real_escape_string($this->conn->getConnection(), $data['nambel']);
        $email = mysqli_real_escape_string($this->conn->getConnection(), $data['email']);
        $password = mysqli_real_escape_string($this->conn->getConnection(), $data['password']);
        if(!empty($namdep) && !empty($nambel) && !empty($email) && !empty($password)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $sql = mysqli_query($this->conn->getConnection(), "SELECT * FROM user WHERE email = '{$email}'");
                if(mysqli_num_rows($sql) > 0){
                    echo "<script type='text/javascript'>alert('$email Email ini sudah terdaftar')</script>";
                }else{
                    if(isset($data['image'])){
                        $namaFoto = $data['image']['name'];
                        $tipeFoto = $data['image']['type'];
                        $tmpName = $data['image']['tmp_name'];
                        
                        $explodeFoto = explode('.',$namaFoto);
                        $img_ext = end($explodeFoto);
        
                        $ektensiFoto = ["jpeg", "png", "jpg"];
                        if(in_array($img_ext, $ektensiFoto) === true){
                            $tipe = ["image/jpeg", "image/jpg", "image/png"];
                            if(in_array($tipeFoto, $tipe) === true){
                                $time = time();
                                $namaFoto2 = $time.$namaFoto;
                                $uploadDir = "img";
                                if(move_uploaded_file($tmpName,"$uploadDir/$namaFoto2")){
                                    $random_id = rand(time(), 100000000);
                                    $status = "Sedang Aktif";
                                    $pass_user = md5($password);
                                    $query = mysqli_query($this->conn->getConnection(), "INSERT INTO user (id, namdep, nambel, email, password, foto, status)
                                    VALUES ({$random_id}, '{$namdep}','{$nambel}', '{$email}', '{$pass_user}', '{$namaFoto2}', '{$status}')");
                                    if($query){
                                        $select = mysqli_query($this->conn->getConnection(), "SELECT * FROM user WHERE email = '{$email}'");
                                        if(mysqli_num_rows($select) > 0){
                                            $fetch = mysqli_fetch_assoc($select);
                                            $_SESSION['id'] = $fetch['id'];
                                            return "sukses";
                                        }else{
                                            return "Email ini belum terdaftar!";
                                        }
                                    }else{
                                        return "Terjadi kesalahan, harap coba lagi!";
                                    }
                                }
                            }else{
                                return "Upload file gambar dalam format - jpeg, png, jpg";
                            }
                        }else{
                            return "Upload file gambar dalam format - jpeg, png, jpg";
                        }
                    }
                }
            }else{
                return "$email email tidak valid!";
            }
        }else{
            return "Semua kolom input harus terisi!";
        }
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

    public function logout($data){
        session_start();
        if(isset($_SESSION['id'])){
            $logout_id = mysqli_real_escape_string($this->conn->getConnection(), $data['logout_id']);
            if(isset($logout_id)){
                $status = "Tidak Aktif";
                $sql = mysqli_query($this->conn->getConnection(), "UPDATE user SET status = '{$status}' WHERE id={$data['logout_id']}");
                if($sql){
                    session_unset();
                    session_destroy();
                    return "sukses";
                }
            }else{
                header("location: http://localhost/proakhir/public/user/index");
            }
        }
        else{  
            header("location: http://localhost/proakhir/public/user/login");
        }
    }

    public function getOtherUsers($id){
        $pesanKeluar_id = $id;
        $sql = "SELECT * FROM user WHERE NOT id = {$pesanKeluar_id} ORDER BY usr_id DESC";
        $query = mysqli_query($this->conn->getConnection(), $sql);
        $output = "";
        if(mysqli_num_rows($query) == 0){
            $output .= "Tidak ada pengguna yang tersedia untuk obrolan ini";
        }elseif(mysqli_num_rows($query) > 0){
            while($data = mysqli_fetch_assoc($query)){
                $query2 = "SELECT * FROM pesan WHERE (id_pesanMasuk = {$data['id']}
                        OR id_pesanKeluar = {$data['id']}) AND (id_pesanKeluar = {$pesanKeluar_id} 
                        OR id_pesanMasuk = {$pesanKeluar_id}) ORDER BY id_pesan DESC LIMIT 1";
                $query3 = mysqli_query($this->conn->getConnection(), $query2);
                $data2 = mysqli_fetch_assoc($query3);
                (mysqli_num_rows($query3) > 0) ? $result = $data2['pesan'] : $result ="Tidak ada pesan yang tersedia";
                (strlen($result) > 28) ? $pesan =  substr($result, 0, 28) . '...' : $pesan = $result;
                if(isset($data2['id_pesanKeluar'])){
                    ($pesanKeluar_id == $data2['id_pesanKeluar']) ? $pengguna = "Anda: " : $pengguna = "";
                }else{
                    $pengguna = "";
                }
                ($data['status'] == "Tidak Aktif") ? $offline = "tidak" : $offline = "";
                ($pesanKeluar_id == $data['id']) ? $hide = "sembunyikan" : $hide = "";
        
                $output .= '<a href="http://localhost/proakhir/public/user/chat/'. $data['id'] .'">
                            <div class="content">
                            <img src="../../public/img/'. $data['foto'] .'" alt="">
                            <div class="details">
                                <span>'. $data['namdep']. " " . $data['nambel'] .'</span>
                                <p>'. $pengguna . $pesan .'</p>
                            </div>
                            </div>
                            <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                        </a>';
            }
        }
        return $output;
    }

    

    public function getUserData($id){
        $sql = mysqli_query($this->conn->getConnection(), "SELECT * FROM user WHERE id = '{$id}'");
        $fetch = mysqli_fetch_assoc($sql);
        return $fetch;
    }

    public function searchUserData($id, $cariU){
        $cariUser = mysqli_real_escape_string($this->conn->getConnection(), $cariU);
        $sql = "SELECT * FROM user WHERE NOT id = {$id} AND (namdep LIKE '%{$cariUser}%' OR nambel LIKE '%{$cariUser}%') ";
        $output = "";
        $query = mysqli_query($this->conn->getConnection(), $sql);
        if(mysqli_num_rows($query) > 0){
            while($data = mysqli_fetch_assoc($query)){
                $query2 = "SELECT * FROM pesan WHERE (id_pesanMasuk = {$data['id']}
                        OR id_pesanKeluar = {$data['id']}) AND (id_pesanKeluar = {$id} 
                        OR id_pesanMasuk = {$id}) ORDER BY id_pesan DESC LIMIT 1";
                $query3 = mysqli_query($this->conn->getConnection(), $query2);
                $data2 = mysqli_fetch_assoc($query3);
                (mysqli_num_rows($query3) > 0) ? $result = $data2['pesan'] : $result ="Tidak ada pesan yang tersedia";
                (strlen($result) > 28) ? $pesan =  substr($result, 0, 28) . '...' : $pesan = $result;
                if(isset($data2['id_pesanKeluar'])){
                    ($id == $data2['id_pesanKeluar']) ? $pengguna = "Anda: " : $pengguna = "";
                }else{
                    $pengguna = "";
                }
                ($data['status'] == "Tidak Aktif") ? $offline = "tidak" : $offline = "";
                ($id == $data['id']) ? $hide = "sembunyikan" : $hide = "";
        
                $output .= '<a href="http://localhost/proakhir/public/user/chat/'. $data['id'] .'">
                            <div class="content">
                            <img src="../../public/img/'. $data['foto'] .'" alt="">
                            <div class="details">
                                <span>'. $data['namdep']. " " . $data['nambel'] .'</span>
                                <p>'. $pengguna . $pesan .'</p>
                            </div>
                            </div>
                            <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                        </a>';
            }
        }else{
            $output .= 'Tidak ada pengguna yang dapat ditemukan berdasarkan hasil pencarian.';
        }
        return $output;
    }

    public function getChatData($usr_id){
        $ID = mysqli_real_escape_string($this->conn->getConnection(), $usr_id);
        $sql = mysqli_query($this->conn->getConnection(), "SELECT * FROM user WHERE id = {$ID}");
        if(mysqli_num_rows($sql) > 0){
            $data = mysqli_fetch_assoc($sql);
            return $data;
        }
        else{
            header("location: http://localhost/proakhir/public/user/login");
        }
    }


    public function sendChat($id, $psn_id, $psn){
        if(isset($id)){
            $pesanKeluar_id = $id;
            $pesanMasuk_id = mysqli_real_escape_string($this->conn->getConnection(), $psn_id);
            $pesan = mysqli_real_escape_string($this->conn->getConnection(), $psn);
            if(!empty($pesan)){
                if(mysqli_query($this->conn->getConnection(), "INSERT INTO pesan (id_pesanMasuk, id_pesanKeluar, pesan) VALUES ({$pesanMasuk_id}, {$pesanKeluar_id}, '{$pesan}')")){
                    return "sukses";
                }
            }
        }else{
            header("location: http://localhost/proakhir/public/user/login");
        }
    }

    public function loadChat($id,$psn_Msk){
        if(isset($id)){
            $pesanMasuk_id = mysqli_real_escape_string($this->conn->getConnection(), $psn_Msk);
            $output = "";
            $query = mysqli_query($this->conn->getConnection(), "SELECT * FROM pesan LEFT JOIN user ON user.id = pesan.id_pesanKeluar
            WHERE (id_pesanKeluar = {$id} AND id_pesanMasuk = {$pesanMasuk_id}) OR (id_pesanKeluar = {$pesanMasuk_id} AND id_pesanMasuk = {$id}) ORDER BY id_pesan");
            if(mysqli_num_rows($query) > 0){
                while($data = mysqli_fetch_assoc($query)){
                    if($data['id_pesanKeluar'] === $id){
                        $output .= '<div class="Pesan Keluar">
                                    <div class="info">
                                        <p>'. $data['pesan'] .'</p>
                                    </div>
                                    </div>';
                    }else{
                        $output .= '<div class="Pesan Masuk">
                        <img src="../../../public/img/'.$data['foto'].'" alt="">
                                    <div class="info">
                                        <p>'. $data['pesan'] .'</p>
                                    </div>
                                    </div>';
                    }
                }
            }else{
                $output .= '<div class="text">Tidak ada pesan yang tersedia, jika anda mengirim pesan maka pesan akan muncul pada halaman ini.</div>';
            }
            return $output;
        }
    }
    public function checkData($data){
        // session_start();
        if(isset($_SESSION['id'])){
            $user_id = mysqli_real_escape_string($this->conn->getConnection(), $data['usr_id']);
            $sql = mysqli_query($this->conn->getConnection(), "SELECT * FROM user WHERE id = {$user_id}");
        //     $sql2 = mysqli_query($this->conn->getConnection(), "DELETE FROM pesan");
        // }
        if(mysqli_num_rows($sql) > 0){
            
            return "tidak kosong";
        }else{
            return "kosong";
        }}
}
}
?>