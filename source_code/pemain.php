<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Pemain.php');
include('classes/Klub.php');
include('classes/Posisi.php');
include('classes/Negara.php');
include('classes/Template.php');

// buat instance pemain
$pemain = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
// buat instance posisi
$posisi = new Posisi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
// buat instance klub
$klub = new Klub($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
// buat instance negara
$negara = new Negara($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
// buat instance untuk foto
$foto = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$pemain->open();
$klub->open();
$negara->open();
$foto->open();
$posisi->open();

// Variabel global penampung nilai
$data = null;
$dataPosisi= null;

$namaPemain = '';
$negaraPemain = '';
$klubPemain = '';
$fotoPemain = '';
$posisiPemain = '';

$cancelButton = '';

// Untuk Form Tambah Data
if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($pemain->addPemain($_POST, $_FILES) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'index.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';

    $klub->getKlub();

    // Looping for Shows the data 
    while ($row = $klub->getResult()) {
        $klubPemain .= "<option value=" . $row['id_klub'] . ">" . $row['nama_klub'] . "</option>";
    }

    $negara->getNegara();

    // Looping for shows the data
    while ($row = $negara->getResult()) {
        $negaraPemain .= "<option value=" . $row['id_negara'] . ">" . $row['nama_negara'] . "</option>";
    }

    $posisi->getPosisi();

    // Looping for shows the data
    while ($row = $posisi->getResult()) {
        $posisiPemain .= "<option value=" . $row['id_posisi'] . ">" . $row['nama_posisi'] . "</option>";
    }
}



// ambil data Pemain
// gabungkan dgn tag html
// untuk di passing ke skin/template
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pemain->getPemainById($id);
    $row = $pemain->getResult();

    $namaPemain = $row['nama_pemain'];
    $negaraPemain = $row['nama_negara'];
    $klubPemain = $row['nama_klub'];
    $fotoPemain = $row['foto_pemain'];
    $posisiPemain = $row['nama_posisi'];
}

// ubah data
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cancelButton = '
    <button type="reset" class="btn btn-default"><a href="detail.php?id=' . $id . '" style="text-decoration: none;">Batal</a></button>
    ';
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($pemain->updatePemain($id, $_POST, $_FILES, $fotoPemain) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'detail.php?id=" . $id . "';
                </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'detail.php?id=" . $id . "';
                </script>";
            }
        }

    $pemain->getPemainById($id);
    $rowPemain = $pemain->getResult();
    
    $klub->getKlub();

    // Looping for Shows the data 
    while ($row = $klub->getResult()) {
        $selected = ($row['id_klub'] == $rowPemain['id_klub']) ? 'selected' : "";
        $klubPemain .= "<option value=" . $row['id_klub'] . " . $selected . >" . $row['nama_klub'] . "</option>";
    }

    $negara->getNegara();

    // Looping for shows the data
    while ($row = $negara->getResult()) {
        $selected = ($row['id_negara'] == $rowPemain['id_negara']) ? 'selected' : "";
        $negaraPemain .= "<option value=" . $row['id_negara'] . "  . $selected . >" . $row['nama_negara'] . "</option>";
    }

    $posisi->getPosisi();

    // Looping for shows the data
    while ($row = $posisi->getResult()) {
        $selected = ($row['id_posisi'] == $rowPemain['id_posisi']) ? 'selected' : "";
        $posisiPemain .= "<option value=" . $row['id_posisi'] . " . $selected .>" . $row['nama_posisi'] . "</option>";
    }
        
        $btn = 'Simpan';
        $title = 'Ubah';
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['id'];
    
    if ($id > 0) {
        if ($pemain->deletePemain($id) > 0) {
            echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = 'pemain.php';
            </script>";
        } else {
            echo "<script>
            alert('Data gagal dihapus!');
            document.location.href = 'pemain.php';
            </script>";
        }
    }
}

// Instansiasi view template untuk data dalam tabel
$view = new Template('templates/skinform.html');

// Mengisi data untuk header dari tabel form
$mainTitle = 'Pemain';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Pemain</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Pemain';

$pemain->close();
$posisi->close();
$klub->close();
$negara->close();
$foto->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('CANCEL_BUTTON', $cancelButton);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);

$view->replace('DATA_VAL_NAMA', $namaPemain);
$view->replace('SOURCE_FOTO_PEMAIN', $fotoPemain);
$view->replace('NEGARA_OPTIONS', $negaraPemain);
$view->replace('KLUB_OPTIONS', $klubPemain);
$view->replace('POSISI_OPTIONS', $posisiPemain);


$view->write();