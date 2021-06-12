<?php
require 'Repositories/CarRepository.php';
require 'BaseController.php';
require_once 'Models/Car.php';

class CarController
{
    /**
     * @var CarRepository
     */
    private $carRepository;

    public function __construct()
    {
        $this->carRepository = new CarRepository();
    }

    public function index()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $id = $_GET['id'] ?? null;
        switch ($requestMethod) {
            case 'GET':
                $this->get($id);
                break;
            case 'POST':
                $this->create();
                break;
            case 'PUT':
                $this->update($id);
                break;
            case 'DELETE':
                $this->delete($id);
                break;
            default:
                return BaseController::toJson([], 405, 'Method Not Allowed');
        }
        return true;
    }

    public function create()
    {
        $data = file_get_contents('php://input');
        $this->validate($data);
        try {
            $data = $this->carRepository->create($data);
        } catch (Exception $e) {
            return BaseController::toJson([], 500, $e->getMessage());
        }
        return BaseController::toJson($data);
    }


    public function update($id)
    {
        if (is_null($id)) {
            return BaseController::toJson([], 422, 'Validation Error!', '', ['id' => 'Route missing id']);
        }
        $data = file_get_contents('php://input');
        $this->validate($data);
        try {
            $data = $this->carRepository->update($data, $id);
        } catch (Exception $e) {
            return BaseController::toJson([], 500, $e->getMessage());
        }
        return BaseController::toJson($data);
    }

    public function delete($id)
    {
        if (is_null($id)) {
            return BaseController::toJson([], 422, 'Validation Error!', '', ['id' => 'Route missing id']);
        }
        try {
            $data = $this->carRepository->delete($id);
        } catch (Exception $e) {
            return BaseController::toJson([], 500, $e->getMessage());
        }
        return BaseController::toJson([], 200, '', 'Car deleted!');
    }

    public function get($id)
    {
        try {
            $data = $this->carRepository->list($id);
        } catch (Exception $e) {
            return BaseController::toJson([], 500, $e->getMessage());
        }
        return BaseController::toJson($data);
    }

    private function validate($data)
    {
        $data = json_decode($data, true);
        $namesToValidate = [
            'name',
            'type',
            'brand',
            'year'
        ];
        $errors = [];
        foreach ($namesToValidate as $nameToValidate) {
            if (!array_key_exists($nameToValidate, $data)) {
                $errors[$nameToValidate] = ucfirst($nameToValidate) . ' is required';
            }
        }
        if (!empty($errors)) {
            return BaseController::toJson([], 422, 'Validation Error!', '', $errors);
        }
        return true;
    }
}
