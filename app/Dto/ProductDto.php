<?php

namespace App\Dto;

class ProductDto
{
    public int $eid;
    public string $title;
    public float $price;

    public static function get(mixed $args):ProductDto
    {
        $dto = new self();
        $dto->eid = $args['eid'];
        $dto->title = $args['title'];
        $dto->price = $args['price'];
        return $dto;
    }
}
