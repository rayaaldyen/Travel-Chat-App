<?php 
if(isset($_SESSION['id'])){
    header("location: http://localhost/proakhir/public/user/index");
}

if(isset($data['error'])){
    $error = $data['error'];
    echo "<script type='text/javascript'>alert('$error')</script>";
}
?>

<!DOCTYPE html>
<html lang="en";>
    <head>
        <meta charset="UTF-8">
        <meta name="view" content="width=device-width, initial-scale=1.0"> 
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Instant Tour Chat</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/proakhir/public/css/style1.css" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    </head>
<body>

        
        
    <div class="layer">
        <section class="form signup">
            <header>Instant Tour Chat</header>
            <form action="http://localhost/proakhir/public/user/register" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="err-alert"></div>
                <div class="detail-nama">
                    <div class="field input">
                        <label>Nama Depan</label>
                        <input type="text" name="namdep" placeholder="Nama Depan" required>
                    </div>
                    <div class="field input">
                        <label>Nama Belakang</label>
                        <input type="text" name="nambel" placeholder="Nama Belakang" required>
                    </div>
                    </div>
                    <div class="field input">
                        <label>Alamat Email</label>
                        <input type="text" name="email" placeholder="Masukkan Alamat Email" required>
                    </div>
                    <div class="field input">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Buat Password" required>
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="field image">
                        <label>Pilih Foto</label>
                        <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                    </div>
                    <div class="field button">
                        <input type="submit" name="submit" value="Masuk ke Chat">
                    </div>
            </form>
            <div class="link">Sudah punya akun? <a href="http://localhost/proakhir/public/user/login">Login Sekarang</a></div>
        </section>
    </div>
    <script src="http://localhost/proakhir/public/js/pass-show-hide.js"></script>
</body>
</html>


