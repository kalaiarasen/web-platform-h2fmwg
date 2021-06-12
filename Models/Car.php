<?php
require_once 'DatabaseConfig.php';
session_status() === PHP_SESSION_ACTIVE ? true : session_start();

class Car
{
    private $dbConfig;
    /**
     * @var string
     */
    private $table = 'cars';

    public function __construct()
    {
        $this->dbConfig = new DatabaseConfig();
    }

    public function get($id = null)
    {
        try {
            $this->dbConfig->openConnection();
            if ($id) {
                $query = pg_query($this->dbConfig->connection, "SELECT * FROM " . $this->table . " where id=" . $id);
                $result = pg_fetch_all($query)[0] ?? [];
            } else {
                $query = pg_query($this->dbConfig->connection, "SELECT * FROM " . $this->table);
                $result = pg_fetch_all($query);
            }
            $this->dbConfig->closeConnection();
            return $result ? $result : [];
        } catch (Exception $e) {
            $this->dbConfig->closeConnection();
            throw new Exception($e->getMessage());
        }
    }

    public function create($constant)
    {
        try {
            $this->dbConfig->openConnection();
            $query = pg_query_params("INSERT INTO " . $this->table .
                "(id,model_name,model_type,model_brand,model_year,model_date_added) VALUES (default, $1,$2, $3,$4,CURRENT_TIMESTAMP) RETURNING id,model_name,model_type,model_brand,model_year,model_date_added, model_date_modified", ((array)$constant));
            return pg_fetch_all($query)[0];
        } catch (Exception $e) {
            $this->dbConfig->closeConnection();
            throw new Exception($e->getMessage());
        }
    }

    public function sync($constant, $id)
    {
        try {
            $this->dbConfig->openConnection();
            $query = pg_query_params("UPDATE " . $this->table .
                " SET model_name=$1,model_type=$2,model_brand=$3,model_year=$4,model_date_modified=CURRENT_TIMESTAMP WHERE id=$id RETURNING id,model_name,model_type,model_brand,model_year,model_date_added, model_date_modified", ((array)$constant));
            return pg_fetch_all($query)[0]??[];
        } catch (Exception $e) {
            $this->dbConfig->closeConnection();
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->dbConfig->openConnection();
            $query = pg_query($this->dbConfig->connection, "DELETE FROM " . $this->table . " where id=" . $id);
            return pg_affected_rows($query);
        } catch (Exception $e) {
            $this->dbConfig->closeConnection();
            throw new Exception($e->getMessage());
        }
    }


}
