<div class="bg-dark p-2 text-white">
  <div class="container">
  <div class="row align-items-center text-center text-md-start">
    <div class="py-3 text-white">
      <p class="display-6 fw-bold"></p>
      <p class="font-weight-bold text-center display-4 fw-bold">Bunga Bunga</p>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <?php
    $tampil = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.userID=user.userID");
    foreach ($tampil as $tampils):
    ?>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card">
        <img src="uploads/<?= htmlspecialchars($tampils['NamaFile']) ?>" class="object-fit-cover" style="aspect-ratio: 4/3;" alt="<?= htmlspecialchars($tampils['JudulFoto']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($tampils['JudulFoto']) ?></h5>
            <p class="card-text text-muted">by: <?= htmlspecialchars($tampils['Username']) ?></p>
            <a href="?url=detail&&id=<?=$tampils['FotoID'] ?>" class="btn btn-primary rounded-pill">Detail</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>