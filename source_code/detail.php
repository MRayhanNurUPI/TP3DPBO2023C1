<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Pemain.php');
include('classes/Template.php');

$pemain = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$pemain->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $pemain->getPemainById($id);
        $row = $pemain->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['nama_pemain'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto_pemain'] . '" class="img-thumbnail" alt="' . $row['foto_pemain'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['nama_pemain'] . '</td>
                                </tr>
                                <tr>
                                    <td>Kebangsaan</td>
                                    <td>:</td>
                                    <td>' . $row['nama_negara'] . '</td>
                                </tr>
                                <tr>
                                    <td>Klub</td>
                                    <td>:</td>
                                    <td>' . $row['nama_klub'] . '</td>
                                </tr>
                                <tr>
                                    <td>Posisi</td>
                                    <td>:</td>
                                    <td>' . $row['nama_posisi'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="Pemain.php?id=' . $id .'"><button type="button" class="btn btn-success text-white" name="sunting">Ubah Data</button></a>
                <a href="detail.php?hapus=' . $id .'"><button type="button" class="btn btn-danger" name="hapus">Hapus Data</button></a>
            </div>';
    } else {

    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($pemain->deletePemain($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

$pemain->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PEMAIN', $data);
$detail->write();