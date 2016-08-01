<?php namespace app;
/**
 * Author: MurDaD
 * Author URL: https://github.com/MurDaD
 *
 * Description: Model
 * Use: Extend this class in your model
 * Example: /app/Users class
 */
use includes\DB;

abstract class Model {
    protected $_db;
    protected $_table;
    protected $_entityClass;

    public function __construct() {
        $this->_db = DB::getInstance();
        $this-$this->setEntityClass(get_called_class());
    }

    /**
     * Set the entity class
     *
     * @param $entityClass
     * @return $this
     * @throws \Exception
     */
    public function setEntityClass($entityClass)
    {
        $this->_entityClass = $entityClass;
        return $this;
    }

    /**
     * Set table name
     *
     * @param $table
     * @return $this
     * @throws \Exception
     */
    public function setTable($table)
    {
        if (!is_string($table) || empty($table)) {
            throw new \Exception('The entity table is invalid.');
        }
        $this->_table = $table;
        return $this;
    }

    /**
     * Find Model row by id
     *
     * @param $id
     * @return null
     */
    public function find($id)
    {
        $this->_db->select($this->_table, 'id = '.$id);
        if ($data = $this->_db->fetch()) {
            return $this->createEntitry($data);
        }
        return null;
    }

    /**
     * Creates Model entity from DB result
     *
     * @param $data
     */
    private function createEntitry($data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }

    /**
     * Update model
     *
     * @param $entity
     * @return int
     * @throws \Exception
     */
    public function update($entity)
    {
        if (!$entity instanceof $this->_entityClass) {
            throw new \Exception('The entity to be updated must be an instance of ' . $this->_entityClass . '.');
        }
        $id = $entity->id;
        $data = get_object_vars($entity);
        unset($data['id']);
        foreach ($data as $key => $value) {
            if(strpos($key, '_') === 0) {
                unset($data[$key]);
            }
        }
        return $this->_db->update($this->_table, $data, 'id = '.$id);
    }

    /**
     * Save Model to DB
     */
    public function save()
    {
        $this->update($this);
    }

    /**
     * Checks if entity exist
     */
    private function checkEntity() {
        if($this == null) {
            throw \Exception($this->_entityClass.' object not found.');
        }
    }

}
