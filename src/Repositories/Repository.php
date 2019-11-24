<?php 

namespace Muhaimenul\Laracrud\Repositories;

abstract class Repository  {

    /**
     * @var $model \Illuminate\Database\Eloquent\Model
     */
	protected $model ;

	/**
	 * Abstract Method To Set The Model of Each Repository
	 */
    abstract protected function setModel() : string ;
    
	/**
	 * Takes setModel() Function And Crafts A New Model Instance
	 */
	public function __construct()
	{
		$model = $this->setModel();
		$this->model = new $model();
	}


    /**
     * @return mixed
     */
    public function all()
    {   $this->newInstance();
        return $this->model->all();
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->model->first();
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return $this->model->latest()->first();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createMultiple(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * @param array $condition
     * @param array $data
     * @return mixed
     * @author Muhaimenul
     */
    public function createOrUpdate(array $condition, array $data)
    {
        return $this->model->updateOrCreate($condition, $data);
    }

    /**
     * @return mixed
     */
    public function getTrashed()
    {
        return $this->model->withTrashed();
    }

    /**
     * @param $primaryKey
     * @return mixed
     */
    public function find($primaryKey)
    {   $this->newInstance();
        return $this->model->find($primaryKey);
    }

    /**
     * @param array $conditions
     * @param array $select
     * @return mixed
     */
    public function findWhere(array $conditions, $select = ['*'])
    {
        $this->newInstance();
        foreach ($conditions as $key => $value ) {
            if (is_array($value)) {
                $this->model = $this->model->where($value[0], $value[1], $value[2]);
            }else{
                $this->model = $this->model->where($key, $value);
            }
        }
        return $this->model->select($select);
    }

    public function findWhereFirst(array $data)
    {
        return $this->model->where($data)->first();
    }

    /**
     * @param array $data
     * @param int $primaryKey
     * @return mixed
     */
    public function update(int $primaryKey,array $data)
    {
        return $this->model->find($primaryKey)->update($data);
    }

    /**
     * @param array $data
     * @param array $conditions
     * @return mixed
     */
    public function updateByFields(array $conditions, array $data)
    {
        foreach($conditions as $key => $value) {
            $this->model = $this->model->where($key, $value);
        }
        return $this->model->update($data);
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function where($column, $value)
    {
        if(is_array($column)) {
            return $this->model->where($column[0],$column[1],$value)->get();
        }
        return $this->model->where($column,$value)->get();
    }

    /**
     * @param array $conds
     * @param array $select
     * @return mixed
     */
    public function getWhere($conds = [], $select = ['*'])
    {
        foreach ($conds as $key=>$val) {
            if (is_array($val)) {
                $data = $this->model->where($val[0], $val[1], $val[2]);
            }else{
                $data = $this->model->where($key, $val);
            }
        }
        $data = $this->model->get($select);
        return $data;
    }

    /**
     * @param $relationship
     * @return $this
     */
    public function with($relationship)
    {
        $this->model = $this->model->with($relationship);
        return $this;
    }
    public function withQuery($relation)
    {
        $this->model = $this->model->with($relation);
        return $this;
    }

    /**
     * @param $primaryKey
     * @return mixed
     */
    public function delete($primaryKey)
    {
        return $this->model->delete($primaryKey);
    }

    /**
     * @param array $conditions
     * @return mixed
     */
    public function findFirst(array $conditions)
    {
        $data = $this->model->where($conditions)->first();
        return $data;
    }

    /**
     * @param array $conditions
     * @return $this
     */
    public function deleteWhere(array $conditions)
    {
        $this->findWhere($conditions)->delete();
        return $this;
    }

    /**
     * @param $primaryKey
     * @return $this
     */
    public function exists($primaryKey)
    {
        $this->find($primaryKey)->exists();
        return $this;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getInsertedId(array $data)
    {
        return $this->model->insertGetId($data);
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        return $this->model;
    }

    /**
     * @param int $itemPerPage
     * @return mixed
     */
    public function paginate(int $itemPerPage = 20)
    {
        return $this->model
            ->paginate($itemPerPage);
    }

    /**
     * @param string $column
     * @param string $value
     * @return mixed
     */
    public function searchByColumn(string $column, string $value)
    {
        return $this->model
            ->where($column ,'LIKE','%' . $value . '%')
            ->get();
    }

    /**
     * @param string $column
     * @param string $value
     * @return mixed
     */
    public function searchWhere(string $column, string $value)
    {
        return $this->model
            ->where($column , $value )
            ->first();
    }

    /**
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->model->getKeyName();
    }

    /**
     * The method utilizes laravel's ->where([[array1],[array2]..[arrayn]])
     * where clause as laravel does not ship with and where in this version
     * 5.7.x
     * $multipleConditions is an array or array
     * The function returns the Where instance,so the developer should chain
     * ->first(),last(),get() ..etc laravel eloquent's methods.
     *
     * @return $model instance
     */
    public function whereWithMultiple(array $multipleConditions)
    {
        return $this->model->where($multipleConditions)->get();
    }
    
    public function newInstance()
    {
        $model = $this->setModel();
        return $this->model =  new $model();
    }
}