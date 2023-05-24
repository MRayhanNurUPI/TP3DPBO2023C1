<?php

include('config/db.php');

class Pemain extends DB
{
    public function getPemainJoin()
    {
        $query = "SELECT * FROM pemain JOIN klub ON pemain.id_klub=klub.id_klub JOIN negara ON pemain.id_negara=negara.id_negara JOIN posisi ON pemain.id_posisi=posisi.id_posisi ORDER BY pemain.id_pemain";
        return $this->execute($query);
    }

    public function getPemain()
    {
        $query = "SELECT * FROM pemain";
        return $this->execute($query);
    }

    public function getPemainById($id)
    {
        $query = "SELECT * FROM pemain JOIN klub ON pemain.id_klub=klub.id_klub JOIN negara ON pemain.id_negara=negara.id_negara JOIN posisi ON pemain.id_posisi=posisi.id_posisi WHERE id_pemain=$id";
        return $this->execute($query);
    }

    public function searchPemain($keyword)
    {
        $query = "SELECT * FROM pemain JOIN klub ON pemain.id_klub=klub.id_klub JOIN negara ON pemain.id_negara=negara.id_negara JOIN posisi ON pemain.id_posisi=posisi.id_posisi WHERE nama_pemain LIKE '%$keyword%' OR nama_klub LIKE '%$keyword%' OR nama_negara LIKE '%$keyword%' OR nama_posisi LIKE '%$keyword%'ORDER BY id_pemain ASC ";
        return $this->execute($query);
    }

    public function addPemain($data, $file)
    {
        $nama = $data['nama'];
        $posisi = $data['posisi'];
        $id_klub = $data['klub'];
        $id_negara = $data['negara'];

        $tmp_file = $file['foto']['tmp_name'];
        $fotoPemain = $file['foto']['name'];
        if ($fotoPemain == "") {
            $fotoPemain="avatar.png";
        }

        $dir = "assets/images/$fotoPemain";
        move_uploaded_file($tmp_file, $dir);
        
        $query = "INSERT INTO pemain VALUES('', '$nama', '$fotoPemain', $posisi, $id_klub, $id_negara)";
        return $this->executeAffected($query);
    }

    public function updatePemain($id, $data, $file, $foto)
    {
        $nama = $data['nama'];
        $posisi = $data['posisi'];
        $id_klub = $data['klub'];
        $id_negara = $data['negara'];

        $tmp_file = $file['foto']['tmp_name'];
        $fotoPemain = $file['foto']['name'];
        if ($fotoPemain == "") {
            $fotoPemain = $foto;
        }

        $dir = "assets/images/$fotoPemain";
        move_uploaded_file($tmp_file, $dir);

        $query = "UPDATE pemain SET nama_pemain = '$nama', foto_pemain = '$fotoPemain', id_posisi = '$posisi', id_klub = '$id_klub', id_negara = '$id_negara' WHERE id_pemain='$id'";
        return $this->executeAffected($query);
    }

    public function deletePemain($id)
    {
        $query = "DELETE FROM pemain WHERE id_pemain='$id'";
        return $this->executeAffected($query);
    }

    function filterPemain($filter)
    {
        if ($filter == "ASC") {
            $query = "SELECT * FROM pemain JOIN klub ON pemain.id_klub=klub.id_klub JOIN negara ON pemain.id_negara=negara.id_negara JOIN posisi ON pemain.id_posisi=posisi.id_posisi ORDER BY pemain.nama_pemain ASC";
        } else if ($filter == "DESC"){
            $query = "SELECT * FROM pemain JOIN klub ON pemain.id_klub=klub.id_klub JOIN negara ON pemain.id_negara=negara.id_negara JOIN posisi ON pemain.id_posisi=posisi.id_posisi ORDER BY pemain.nama_pemain DESC";
        } else {
            $query = "SELECT * FROM pemain JOIN klub ON pemain.id_klub=klub.id_klub JOIN negara ON pemain.id_negara=negara.id_negara JOIN posisi ON pemain.id_posisi=posisi.id_posisi ORDER BY pemain.id_pemain ASC";
        }
        return $this->execute($query);
    }
}