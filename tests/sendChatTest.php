<?php
use PHPUnit\Framework\TestCase;
require_once getcwd().'../app/models/User_model.php';
include_once getcwd().'../app/models/Connection.php';
class sendChatTest extends TestCase{
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }
    public function testSendChat(){
        $model=new User_model;
        $data =[
            // 'pesanKeluar_id' => 1293261727,
            'pesanMasuk_id' => 711488216,
            'pesan' => "mantap"
            
        ];
        $pesanKeluar_id = 1293261727;
        // $pesanMasuk_id=1293261727;
        $pesan="mantap";
        $send=$model->sendChat($pesanKeluar_id,$data['pesanMasuk_id'],$data['pesan']);
        $test = mysqli_query($this->conn->getConnection(), "SELECT * FROM pesan WHERE id_pesanKeluar = $pesanKeluar_id");
        $fetch = mysqli_fetch_assoc($test);
        $response="sukses";
        $this->assertEquals($response,$send);

    }
    
}