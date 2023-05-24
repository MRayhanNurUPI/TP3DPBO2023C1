<?php

include('config/db.php');
include('classes/DB.php');
include('classes/negara.php');
include('classes/Template.php');

$negara = new Negara($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$negara->open();

// cari negara
if (isset($_POST['btn-cari'])) {
    // methode mencari data negara
    $negara->searchNegara($_POST['cari']);
} else if (isset($_POST['btn-filter'])) {
    // methode mengurutkan data negara
    $negara->filterNegara($_POST['filter']);
} else {
    // method menampilkan data negara
    $negara->getNegara();

}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($negara->addNegara($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'negara.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'negara.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Negara';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Negara</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Negara';
$cancelButton = '';

while ($div = $negara->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_negara'] . '</td>
    <td style="font-size: 22px;">
        <a href="negara.php?id=' . $div['id_negara'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="negara.php?hapus=' . $div['id_negara'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
            $cancelButton = '
    <button type="reset" class="btn btn-default"><a href="negara.php" style="text-decoration: none;">Batal</a></button>
    ';
        if (isset($_POST['submit'])) {
            if ($negara->updateNegara($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'negara.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'negara.php';
            </script>";
            }
        }

        $negara->getNegaraById($id);
        $row = $negara->getResult();

        $dataUpdate = $row['nama_negara'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($negara->deleteNegara($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'negara.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'negara.php';
            </script>";
        }
    }
}

$negara->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('CANCEL_BUTTON', $cancelButton);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();