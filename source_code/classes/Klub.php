<?php

include('config/db.php');

class Klub extends DB
{
    function getKlub()
    {
        $query = "SELECT * FROM klub";
        return $this->execute($query);
    }

    function getKlubById($id)
    {
        $query = "SELECT * FROM klub WHERE id_klub=$id";
        return $this->execute($query);
    }

    function addKlub($data)
    {
        $nama_klub = $data['nama'];
        $query = "INSERT INTO klub VALUES('', '$nama_klub')";
        return $this->executeAffected($query);
    }

    function searchKlub($keyword) 
    {
        $query = "SELECT * FROM klub WHERE nama_klub LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function filterKlub($filter)
    {
        if ($filter == "ASC") {
            $query = "SELECT * FROM klub ORDER BY nama_klub ASC";
        } else if ($filter == "DESC") {
            $query = "SELECT * FROM klub ORDER BY nama_klub DESC";
        } else {
            $query = "SELECT * FROM klub ORDER BY id_klub ASC";
        }
        return $this->execute($query);
    }

    function updateKlub($id, $data)
    {
        $nama_klub = $data['nama'];
        $query = "UPDATE klub SET nama_klub = '$nama_klub' WHERE id_klub = $id";
        return $this->executeAffected($query);
    }

    function deleteKlub($id)
    {
        $query = "DELETE FROM klub WHERE id_klub = $id";
        return $this->executeAffected($query);
    }
}