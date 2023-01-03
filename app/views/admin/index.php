<?php
if(!isset($_SESSION['id'])){
    header("location: http://localhost/proakhir/public/user/login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://localhost/proakhir/public/css/style2.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <title>ITC</title>
</head>
<body>
<div class="layer">
        <section class="user">
            <header>
                <div class="konten">
                    <img src="../../public/img/<?php echo $data['foto']; ?>" alt="">
                    <div class="info">
                        <span> <?php echo $data['namdep']. " " . $data['nambel'] ?> </span>
                        <p> <?php echo $data['status']; ?> </p>
                    </div>
                </div>
                <a href="http://localhost/proakhir/public/user/logout" class="logout">Logout</a>
            </header>
            
            <div class="cari">
                <span class="text">Pilih pengguna</span>
                <input type="text" placeholder="Masukkan nama pengguna...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="list-pengguna">
            </div>
        </section>
        <a href="http://localhost/proakhir/public/admin/end" class="endBtn">End Session</a>
    </div>
    <script src="http://localhost/proakhir/public/js/users.js"></script>
</body>
</html>