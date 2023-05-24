<?php

include('config/db.php');

class Negara extends DB
{
    function getNegara()
    {
        $query = "SELECT * FROM negara";
        return $this->execute($query);
    }

    function getNegaraById($id)
    {
        $query = "SELECT * FROM negara WHERE id_negara=$id";
        return $this->execute($query);
    }

    function addNegara($data)
    {
        $nama_negara = $data['nama'];
        $query = "INSERT INTO negara VALUES('', '$nama_negara')";
        return $this->executeAffected($query);
    }

    function searchNegara($keyword) 
    {
        $query = "SELECT * FROM negara WHERE id_negara LIKE '%$keyword%' OR nama_negara LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function filterNegara($filter)
    {
        if ($filter == "ASC") {
            $query = "SELECT * FROM negara ORDER BY nama_negara ASC";
        } else if ($filter == "DESC") {
            $query = "SELECT * FROM negara ORDER BY nama_negara DESC";
        } else {
            $query = "SELECT * FROM negara ORDER BY id_negara ASC";
        }
            return $this->execute($query);

    }

    function updateNegara($data)
    {
        $nama_negara = $data['nama'];
        $id_negara = $data['id'];
        $query = "UPDATE negara SET nama_negara = '$nama_negara' WHERE id_negara = $id_negara";
        return $this->execute($query);
    }

    function deleteNegara($id)
    {
        $query = "DELETE FROM negara WHERE id_negara = $id";
        return $this->execute($query);
    }
}