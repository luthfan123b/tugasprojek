<?php 
$foto_id = @$_GET['id']; // Ambil FotoID dari parameter URL

// Query untuk mengambil detail foto berdasarkan FotoID
$details = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.UserID = user.UserID WHERE foto.FotoID = '$foto_id'");
$data = mysqli_fetch_array($details);

// Periksa apakah data ada
if (!$data) {
    echo "<p>Foto tidak ditemukan.</p>";
    exit; // Hentikan eksekusi jika tidak ada data
}

// Query untuk menghitung jumlah like
$likes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE FotoID = '$foto_id'"));

// Query untuk memeriksa apakah user sudah memberi like
$cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE FotoID = '$foto_id' AND UserID='" . @$_SESSION['user_id'] . "'"));
?>
<div class="container">
   <div class="row">
      <div class="col-10 my-2">
         <div class="card">
            <img src="uploads/<?= $data['NamaFile'] ?>" alt="<?= $data['JudulFoto'] ?>" class="object-fit-cover">
            <div class="card-body">
               <h3 class="card-title mb-0"><?= $data['JudulFoto'] ?> <a href="<?php if(isset($_SESSION['user_id'])) {echo '?url=like&&id='.$data['FotoID'];}else{echo 'login.php';} ?>" class="btn btn-sm <?php if($cek==0){echo "text-secondary";}else{echo "text-danger";} ?>"><i class="fa-solid fa-fw fa-heart"></i> <?= $likes ?></a></h3>
               <small class="text-muted mb-3">by: <?= $data['Username'] ?>, <?= $data['TanggalUnggah'] ?></small>
               <p><?= $data['DeskripsiFoto'] ?></p>
               <?php 
               // Ambil data komentar
               $komen_id = @$_GET["komentar_id"];
               $submit = @$_POST['submit'];
               $komentar = @$_POST['komentarfoto'];
               $user_id = @$_SESSION['user_id'];
               $tanggal = date('Y-m-d');
               $dataKomentar = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM komentarfoto WHERE KomentarID='$komen_id' AND UserID='$user_id' AND FotoID='$foto_id'"));

               if ($submit == 'Kirim') {
                  $komen = mysqli_query($conn, "INSERT INTO komentarfoto VALUES('', '$foto_id', '$user_id', '$komentar', '$tanggal')");
                  header("Location: ?url=detail&&id=$foto_id");
               } elseif ($submit == 'Edit') {
                  // Handle edit komentar
               }
               ?>
               <form action="?url=detail&id=<?= $foto_id ?>" method="post">
                  <div class="form-group d-flex flex-row">
                     <input type="hidden" name="foto_id" value="<?= $data['FotoID'] ?>">
                     <a href="?url=home" class="btn btn-dark">Kembali</a>
                     <?php if (isset($_SESSION['user_id'])): ?>
                        <input type="text" class="form-control" name="komentarfoto" required placeholder="Masukan Komentar">
                        <input type="submit" value="Kirim" name="submit" class="btn btn-dark">
                     <?php endif; ?>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="col-10">
         <?= @$alert ?>
         <?php 
         $UserID = @$_SESSION["user_id"]; 
         $komen = mysqli_query($conn, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.UserID=user.UserID WHERE komentarfoto.FotoID='$foto_id'");
         foreach($komen as $komens): ?>
         <p class="mb-0 fw-bold"><?= $komens['Username'] ?></p>
         <p class="mb-1"><?= $komens['Isikomentar'] ?></p>
         <p class="text-muted small mb-0"><?= $komens['TanggalKomentar'] ?></p>
         <hr>
         <?php endforeach; ?>
      </div>
   </div>
</div>