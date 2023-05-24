<?php

include('config/db.php');
include('classes/DB.php');
include('classes/klub.php');
include('classes/Pemain.php');
include('classes/Template.php');

// buat instance klub
$klub = new Klub($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buat instance pemain
$pemain = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$klub->open();
$pemain->open();

$klub->getKlub();

// cari Klub
if (isset($_POST['btn-cari'])) {
    // methode mencari data Klub
    $klub->searchKlub($_POST['cari']);
} else if (isset($_POST['btn-filter'])) {
    // methode mengurutkan data klub
    $klub->filterKlub($_POST['filter']);
} else {
    // method menampilkan data Klub
    $klub->getKlub();
}

$data = null;
$cancelButton = '';

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($klub->addKlub($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'klub.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'klub.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

// instansiasi view template untuk data dalam tabel
$view = new Template('templates/skintabel.html');

// mengisi data untuk header tabel
$mainTitle = 'Klub';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Klub</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Klub';

// ambil data Klub
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($div = $klub->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_klub'] . '</td>
    <td style="font-size: 22px;">
        <a href="klub.php?id=' . $div['id_klub'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="Klub.php?hapus=' . $div['id_klub'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

// ubah data
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cancelButton = '
    <button type="reset" class="btn btn-default"><a href="klub.php" style="text-decoration: none;">Batal</a></button>
    ';
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($klub->updateKlub($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'klub.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'klub.php';
            </script>";
            }
        }

        $klub->getKlubById($id);
        $row = $klub->getResult();

        $dataUpdate = $row['nama_klub'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace("DATA_VAL_UPDATE", $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($klub->deleteKlub($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'klub.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'klub.php';
            </script>";
        }
    }
}

$klub->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('CANCEL_BUTTON', $cancelButton);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();