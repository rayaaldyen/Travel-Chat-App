<?php
class Admin extends Controller{
    
    public function index(){
        session_start();
        if(isset($_SESSION['id'])){
            $data = $this->model('User_model')->getUserData($_SESSION['id']);
            $data2 =[
                'foto' => $data['foto'],
                'namdep' => $data['namdep'],
                'nambel' => $data['nambel'],
                'status' => $data['status'],
                'output' => $this->model('User_model')->getOtherUsers($_SESSION['id'])
            ];
            $this->view('admin/index', $data2);
        }else{
            $this->view('users/login');
        }
    }

    public function end(){
        session_start();
        $data = [
            'admin_id' => $_SESSION['id']
        ];
        $response = $this->model('Admin_model')->endSession($data);
        if($response == "sukses"){
            header('location: http://localhost/proakhir/public/admin/index');
        }
    }

}
?>