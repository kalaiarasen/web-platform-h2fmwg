<?php


class CarConstant
{
    private $name;
    private $type;
    private $brand;
    private $year;

    function __construct($data)
    {
        $this->name = $data->name;
        $this->type = $data->type;
        $this->brand = $data->brand;
        $this->year = $data->year;
    }
}
