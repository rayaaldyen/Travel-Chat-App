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
        <section class="form login">
            <header>Instant Tour Chat</header>
            <form action="http://localhost/proakhir/public/user/signin" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-alert"></div>
                <div class="field input">
                    <label>Alamat Email</label>
                    <input type="text" name="email" placeholder="Masukkan Alamat Email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password Anda" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Masuk ke Chat">
                </div>
            </form>
            <div class="link">Belum punya akun? <a href="http://localhost/proakhir/public/user/signup">Daftar Sekarang</a></div>
        </section>
    </div>
    <script src="http://localhost/proakhir/public/js/pass-show-hide.js"></script>
</body>
</html>