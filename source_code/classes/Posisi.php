<?php

include('config/db.php');

class Posisi extends DB
{
    function getPosisi()
    {
        $query = "SELECT * FROM posisi";
        return $this->execute($query);
    }

    function getPosisiById($id)
    {
        $query = "SELECT * FROM posisi WHERE id_posisi=$id";
        return $this->execute($query);
    }

}