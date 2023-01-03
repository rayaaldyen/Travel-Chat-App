<?php

class User extends Controller{
    public function index(){
        session_start();
        if(isset($_SESSION['id'])){
            $data = $this->model('User_model')->getUserData($_SESSION['id']);
            if(!isset($data)){
                header("location: http://localhost/proakhir/public/user/logout");
            }
            $data2 =[
                'foto' => $data['foto'],
                'namdep' => $data['namdep'],
                'nambel' => $data['nambel'],
                'status' => $data['status'],
                'output' => $this->model('User_model')->getOtherUsers($_SESSION['id'])
            ];
            $this->view('users/index', $data2);
       
    }else{
            $this->view('users/login');
        }
    }

    public function register(){
        $data = [
            'namdep' => $_POST['namdep'],
            'nambel' => $_POST['nambel'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'image' => $_FILES['image'],
            'error' => ''
        ];

        $response = $this->model('User_model')->register($data);

        if($response == "sukses"){
            header('location: http://localhost/proakhir/public/user/index');
        }else{
            $data['error'] = $response;
            session_destroy();
            $this->view('users/signup', $data);
        }
        
    }

    public function signup(){
        session_start();
        if(isset($_SESSION['id'])){
            header("location: http://localhost/proakhir/public/user/index");
        }else{
            $this->view('users/signup');
        }
    }

    public function login(){
        session_start();
        if(isset($_SESSION['id'])){
            header("location: http://localhost/proakhir/public/user/index");
        }else{
            $this->view('users/login');
        }
    }

    public function signin(){
        $data = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'error' => ''
        ];

        if($data['email'] == "admin123@gmail.com"){
            $response = $this->model('Admin_model')->login($data);

            if($response == "sukses"){
                header('location: http://localhost/proakhir/public/admin/index');
            }else{
                $data['error'] = $response;
                session_destroy();
                $this->view('users/login', $data);
            }
        }else{
            $response = $this->model('User_model')->login($data);
        
            if($response == "sukses"){
                header('location: http://localhost/proakhir/public/user/index');
            }else{
                $data['error'] = $response;
                session_destroy();
                $this->view('users/login', $data);
            }
        }
    }

    public function logout(){
        session_start();
        $data = [
            'logout_id' => $_SESSION['id']
        ];
        $response = $this->model('User_model')->logout($data);
        if($response == "sukses"){
            header('location: http://localhost/proakhir/public/user/login');
        }
    }

    public function userlist(){
        session_start();
        $output = $this->model('User_model')->getOtherUsers($_SESSION['id']);
        echo $output;
    }

    public function search(){
        session_start();
        $output = $this->model('User_model')->searchUserData($_SESSION['id'], $_POST['cariUser']);
        echo $output;
    }

    public function chat(){
        session_start();
        $data = [
            'usr_id' => $_SESSION['id']
        ];
        $response = $this->model('User_model')->checkData($data);
        if($response == "tidak kosong"){
            $url = rtrim($_GET['url'], '/');
            $url = explode('/', $url);
            $data = $this->model('User_model')->getChatData(end($url));
            $this->view('users/chat', $data);
        }else if($response == "kosong"){
            header("location: http://localhost/proakhir/public/user/logout");
        }
    }

    public function loadChat(){
       session_start();
       $output = $this->model('User_model')->loadChat($_SESSION['id'],$_POST['pesanMasuk_id']);
       echo $output;
    }

    public function sendChat(){
        session_start();
        $this->model('User_model')->sendChat($_SESSION['id'],$_POST['pesanMasuk_id'], $_POST['pesan']);
    }

    public function back(){
        session_start();
        $data = $this->model('User_model')->getUserData($_SESSION['id']);
        if($data['email'] == "admin123@gmail.com"){
            header('location: http://localhost/proakhir/public/admin/index');
        }else{
            header('location: http://localhost/proakhir/public/user/index');
        }
    }

}