<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Klub.php');
include('classes/Posisi.php');
include('classes/Negara.php');
include('classes/Pemain.php');
include('classes/Template.php');

// buat instance Pemain
$listPemain = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listPemain->open();
// tampilkan data Pemain
$listPemain->getPemainJoin();

// cari Pemain
if (isset($_POST['btn-cari'])) {
    // methode mencari data Pemain
    $listPemain->searchPemain($_POST['cari']);
} else if (isset($_POST['btn-filter'])) {
    // methode mengurutkan data pemain
    $listPemain->filterPemain($_POST['filter']);
} else {
    // method menampilkan data Pemain
    $listPemain->getPemainJoin();
}

$data = null;

// ambil data Pemain
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listPemain->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 pemain-thumbnail">
        <a href="detail.php?id=' . $row['id_pemain'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['foto_pemain'] . '" class="card-img-top" alt="' . $row['foto_pemain'] . '">
            </div>
            <div class="card-body">
                <p class="card-text pemain-nama my-0">' . $row['nama_pemain'] . '</p>
                <p class="card-text klub-nama">' . $row['nama_klub'] . '</p>
                <p class="card-text negara-nama my-0">Kebangsaan: ' . $row['nama_negara'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listPemain->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PEMAIN', $data);
$home->write();