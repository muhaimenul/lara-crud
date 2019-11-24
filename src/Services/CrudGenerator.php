<?php

/**
 * Created by PhpStorm.
 * User: Muhaimenul Islam
 * Date: 8/16/2019
 * Time: 6:49 PM
 */
namespace Muhaimenul\Laracrud\Services;

use File;

class CrudGenerator
{
    protected $name;

    /**
     * CrudGenerator constructor.
     * @param string $name
     */

    public function __construct($name)
    {
        $this->name = $name;
    }

    
    /**
     * generate crud related files
     * generate all
     */

    public function generate() {
//        $name = $this->name;
        $this->model();
        $this->controller();
        $this->request();
        $this->routes();
        $this->migration();
        $this->service();
        $this->repository();
    }

    /**
     * get type related stubs
     * @param $type
     * @return string
     */
    public function getStub($type)
    {
        $path = __DIR__ . '/../stubs/' . "$type.stub";
//        return file_get_contents(resource_path("stubs/$type.stub"));
        return file_get_contents($path);
    }

    /**
     * generate model
     */

    protected function model() {
        $name = $this->name;
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );

        if (!file_exists(app_path('/Models'))) {
            mkdir(app_path('/Models'), 0777, true);
        }
        
        file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
    }

    /**
     * generate controller
     */

    protected function controller() {
        $name = $this->name;
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );
        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    /**
     * generate request
     */
    protected function request()
    {
        $name = $this->name;
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );
        if(!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);
        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    /**
     * generate web and api resource routes
     */
    protected function routes(){
        $name = $this->name;
        File::append(base_path('routes/api.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');\n");
        File::append(base_path('routes/web.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');\n");
    }

    /**
     * generate migration
     */
    protected function migration()
    {
        $name = $this->name;
        $migrationName = str_plural(snake_case($name));
        $tableName = $migrationName;

        $className = ucwords(str_plural($name));
//        $className = 'Create' . str_replace(' ', '', ucwords(str_replace('_', ' ', $tableName))) . 'Table';

        $migrationTemplate = str_replace(
            [
                '{{tableName}}',
                '{{className}}'
            ],
            [
                $tableName,
                $className
            ],
            $this->getStub('Migration')
        );

//        $name = str_replace($this->laravel->getNamespace(), '', $name);
        $datePrefix = date('Y_m_d_His');
//        database_path('/migrations/') . $datePrefix . '_create_' . $name . '_table.php';
        file_put_contents(database_path("/migrations/{$datePrefix}_create_{$tableName}_table.php"), $migrationTemplate);
    }

    /**
     * generate service
     */

    protected function service() {
        $name = $this->name;
        $serviceTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Service')
        );

        if (!file_exists(app_path('/Services'))) {
            mkdir(app_path('/Services'), 0777, true);
        }

        file_put_contents(app_path("/Services/{$name}Service.php"), $serviceTemplate);
    }

    protected function repository() {
        $name = $this->name;
        $repositoryTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Repository')
        );

        if (!file_exists(app_path('/Repositories'))) {
            mkdir(app_path('/Repositories'), 0777, true);
        }

        file_put_contents(app_path("/Repositories/{$name}Repository.php"), $repositoryTemplate);
    }

    protected function view(){

    }

}