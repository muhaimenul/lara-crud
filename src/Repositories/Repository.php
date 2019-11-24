<?php 

namespace Muhaimenul\Laracrud\Repositories;
abstract class Repository  {
    /**
     * @var $model \Illuminate\Database\Eloquent\Model
     */
	protected $model ;
	/**
	 * Default Operator For Database Queries
	 * @var string
	 */
	private $defaultOperator = '=';
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
	 * 
	 * Magic Methods
	 *
	 */
	/**
	 * To prevent function calls that does not exists
	 * @param  Funcation Name
	 * @param  Arguments,Can be an array or single variable
	 * @return void
	 */
	public function __call($name,$arguments)
    {
    	return;
    }
    /**
     * To prevent overriding values from outside class/object
     * @param Property of Repository ($this) Class
     * @param Value
     */
    public function __set($property, $value) {
    	return;
    }
    /**
     * @return Model instance
     */
	public function instance()
	{
		return $this->model;
	}
    /**
     * Sets the default operator
     * @param Operator
     */
    public function setDefaultOperator(string $operator = '=')
    {
        $this->defaultOperator = $operator;
    }
    /**
     * @param  Attributes Array
     * @return Model instance
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    /**
     * @param  Array of arrays (of attributes)
     * @return Boolean
     */
    public function createMultiple(array $data)
    {
        return $this->model->insert($data);
    }
    /**
     * @param  primaryKey
     * @return Model Instance
     */
    public function find(int $primaryKey)
    {
        return $this->model->find($primaryKey);
    }
    /**
     * @param  $conds Array of conditions,can be an array of array
     * @param  $select is the columns to be selected
     * @return Model instance
     */
    public function findFirst(array $conds = [], $select = ['*'])
    {
        $this->model = $this->_get($conds);
        return $this->model->first($select);
    }
    /**
     * @param  $conds [Array of conditions,can be an array of array]
     * @param  $select [is the columns to be selected]
     * @param  $paginate [Pagination items per page]
     * @return [Model instance]
     */
    public function getWhere(array $conds = [],$select = ['*'],int $paginate = 0)
    {
        $this->model = $this->_get($conds);
        if($paginate > 0) {
            return $this->model->select($select)->paginate($paginate);
        }
        return $this->model->select($select)->get();
    }
    /**
     * Returns the number of rows (count) based on the condition
     * @param  $conditions [Array or array of arrays]
     * @return integer
     */
    public function getWhereCount(array $conds = [])
    {
        $this->model = $this->_get($conds);
        return $this->model->count();
    }
    /**
     * First row of the datatabse table
     * @return Model Instance
     */
    public function first()
    {
        return $this->model->first();
    }
    /**
     * Last row of the datatabse table
     * @return Model Instance
     */
    public function last()
    {
        return $this->model->latest()->first();
    }
    /**
     * Order by descend on column `created at`
     * @return Collection
     */
    public function latest()
    {
        return $this->model->latest();  
    }
	/**
	 * @return Model Collection
	 */
	public function all()
	{
		return $this->model->all();
	}
	/**
	 * @param  Atrributes
	 * @param  primary key
	 * @return Boolean
	 */
	public function update(array $data,int $id)
	{
		$instance = $this->find($id);
		if($instance) {
			return $instance->update($data);
		}
		// throw a generic error
		return false;
	}
	/**
	 * @param  primary key
	 * @return boolean
	 */
	public function delete(int $primaryKey)
	{
		$instance = $this->find($primaryKey);
		if($instance) {
			return $instance->delete();
		}
		return false;
	}
	/**
	 * @param  $conds is an array,can be a multi dimensional array (array of array)
	 * @return Builder
	 */
	private function _get(array $conds) 
	{
		if(empty($conds)) {
    		return false;
    	}
    	//check if $conds is array
    	foreach($conds as $index => $cond ) {
    		if(is_array($cond)) {
	    		$column = $cond[0];
	            if(isset($cond[2])) {
	           		$operator = $cond[1];
	           		$value    = $cond[2];
	           	} else {
	           		$operator = $this->defaultOperator; // default 
	           		$value    = $cond[1];
	           	}
    		} else {
    			$column = $conds[0];
    			if(isset($conds[2])) {
	           		$operator = $conds[1];
	           		$value    = $conds[2];
	           	} else {
	           		$operator = $this->defaultOperator; // default
	           		$value    = $conds[1];
	           	}
           	}
           	$instance = $this->model->where($column, $operator, $value);
    	}
    	return $instance;
	}
	
    /**
     * @param  $relation [string or array of relationshop]
     * @return Builder
     */
    public function with($relation)
    {
    	if(!is_array($relation)) {
    		$relation = [$relation];
    	}
    	// callbackable relation
    	return $this->model->with($relation);
    }
    
    // needs testing
    /**
     * @param  $conds [Array of conditions]
     * @param  $callback [Callback function]
     * @param  $select [columns to be selected]
     * @param  $paginate [Pagination items per page]
     * @return Collection
     */	
    public function getFiltered(array $conds = [],$callback,$select = ['*'],int $paginate = 0)
    {
    	$collection = $this->getWhere($conds,$select);
    	$filtered = $collection->filter($callback);
    	if($paginate > 0) {
    		return $filtered->paginate($paginate);
    	}
    	return $filtered->all();
    }
    /**
     * @param  $conds [Array or array of array,conditions]
     * @param  $list [Array or single list item to be checked]
     * @param  $select [Columns to be selected]
     * @return Collection
     */
    public function whereHas(array $conds = [],$list,$select =['*'])
    {
    	$collection = $this->getWhere($conds,$select);
    	return $collection->has($list);
     }
     /**
      * @param  $conds [Array or array of array,conditions]
      * @param  $place [Position of the elemnet to be picked]
      * @param  $select [Columns to be selected]
      * @return Model instance
      */
    public function whereNth(array $conds = [],$place,$select = ['*'])
    {
    	$collection = $this->getWhere($conds,$select);
    	return $collection->nth($place);
    }
    /**
     * @param  $conds [Array or array of array,conditions]
     * @param  $list [Array or single list item to be checked]
     * @param  $select [Columns to be selected]
     * @param  $paginate [Pagination items per page]
     * @return A filtered collection
     */
    public function getWhereOnly(array $conds,$list,$select = ['*'],$paginate = 0)
    {
    	$collection = $this->getWhere($conds,$select);
    	$filtered = $collection->only($list);
    	if($paginate > 0) {
    		return $filtered->paginate($paginate);
    	}
    	return $filtered->all();
    }
    /**
     * @param  $column [Sorting Column]
     * @param  $oder [Order by]
     * @param  $paginate [Pagination items per page]
     * @return Collection
     */
    public function getFormatted($column = 'created_at',$order = 'ASC',$paginate = 0)
    {
    	$instance = $this->model->orderBy($column,$order);
    	
    	if($paginate > 0) {
    		return $instance->paginate($paginate);
    	} else {
    		return $instance->get();
    	}
    }
}