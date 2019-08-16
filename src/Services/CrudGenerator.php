<?php

/**
 * Created by PhpStorm.
 * User: Muhaimenul Islam
 * Date: 8/16/2019
 * Time: 6:49 PM
 */
namespace Muhaimenul\Laracrud\Services;

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
     */

    public function generate() {

    }

    /**
     * get type related stubs
     * @param $type
     * @return string
     */
    public function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
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
        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
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

    protected function request()
    {

    }

    protected function migration()
    {

    }

    protected function view(){

    }

}