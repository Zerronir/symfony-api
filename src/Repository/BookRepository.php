<?php

namespace App\Repository;

interface BookRepository{
    public function findAll(): array;
    public function findById(int $id): ?array;
}

?>