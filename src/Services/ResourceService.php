<?php
/**
 * Created by Muhaimenul.
 * User: Muhaimenul
 * Date: 5/12/2021
 * Time: 2:07 AM
 */
namespace Muhaimenul\Laracrud\Services;


use Illuminate\Database\Eloquent\Model;

abstract class ResourceService
{
    /**
     * @var Model $model
     */
    public $model;

    public function __construct()
    {
        $this->setModel();
//        $model = $this->setModel();
//        $this->model = new $model;
    }

    /**
     * set related model
     * @return mixed
     */
    abstract public function setModel();

    /**
     * @param  $data [Array of attributes]
     * @return Model Instance
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $data array of arrays (of attributes)
     * @return Boolean
     */
    public function createMultiple(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * @param int $primary_key
     * @param array $select
     * @return Model Instance
     */
    public function find($primary_key, array $select = ['*'])
    {
        return $this->model->select($select)->find($primary_key);
    }
    /**
     * First row of the database table
     * @return Model Instance
     */
    public function first()
    {
        return $this->model->first();
    }

    /**
     * Last row of the database table
     * @return Model Instance
     */
    public function last()
    {
        return $this->model->last();
    }

    /**
     * Order by descend on column `created_at`
     * @return mixed
     */
    public function latest()
    {
        return $this->model->latest();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param  $data array
     * @param $value
     * @param string $column
     * @return Boolean
     */
    public function update(array $data, $value, $column = 'id')
    {
        return $this->model->where($column, $value)->update($data);
    }
    /**
     * @param $id int
     * @return boolean
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function updateByModel($model,array $data)
    {
        return $model->update($data);
    }

    /**
     * Order by column
     *
     * @param string $column
     * @param string $order
     * @return mixed
     */
    public function orderBy($column = 'created_at', $order = 'ASC')
    {
        return $this->model->orderBy($column,$order);
    }

    public function orderByDesc($column = 'created_at')
    {
        return $this->model->orderBy($column,'DESC');
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function paginate($paginate = 20)
    {
        return $this->model->paginate($paginate);
    }
}