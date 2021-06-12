<?php
require 'Models/Car.php';
require 'Constants/CarConstant.php';

class CarRepository
{
    /**
     * @var Car
     */
    private $car;

    public function __construct()
    {
        $this->car = new Car();
    }

    public function list($id)
    {
        try {
            if (!is_null($id) && !is_int($id)) {
                throw new Exception('Invalid id type');
            }
            $data = $this->car->get($id);
            if ($id && empty($data)) {
                throw new Exception('No Data for Provided id');
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create($data)
    {
        $data = json_decode($data);
        $constant = new CarConstant($data);
        try {
            return $this->car->create($constant);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($data, $id)
    {
        $data = json_decode($data);
        $constant = new CarConstant($data);
        try {
            if (!is_null($id) && !is_int($id)) {
                throw new Exception('Invalid id type');
            }
            $data = $this->car->sync($constant, $id);
            if ($id && empty($data)) {
                throw new Exception('No Data for Provided id');
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            if (!is_null($id) && !is_int($id)) {
                throw new Exception('Invalid id type');
            }
            $data = $this->car->delete($id);
            if (!$data) {
                throw new Exception('No Data for Provided id');
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
