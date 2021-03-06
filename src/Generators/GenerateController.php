<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-03-07
 * Time: 13:47
 */

namespace Devslane\Generator\Generators;


use Carbon\Carbon;
use Devslane\Generator\Services\FileSystemService;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;


/**
 * Class GenerateController
 * @package Devslane\Generator\Generators
 */
class GenerateController extends Generator
{

    /**
     * GenerateController constructor.
     * @param Table $table
     * @throws \Exception
     */
    public function __construct(Table $table) {
        parent::__construct($table, 'controller');
    }

    public function setClassName($prefix = null, $suffix = "Controller") {
        $this->className = $this->model;
        if ($prefix) {
            $this->className = "$prefix$this->className";
        }
        if ($suffix) {
            $this->className = "$this->className$suffix";
        }
    }


    public function fillTemplate() {
        $this->template = str_replace('{{user}}', $this->user, $this->template);
        $this->template = str_replace('{{date}}', Carbon::now()->toRssString(), $this->template);
        $this->template = str_replace('{{namespace}}', $this->namespace, $this->template);
        $this->template = str_replace('{{model}}', $this->model, $this->template);
        $this->template = str_replace('{{class}}', $this->className, $this->template);
        $this->template = str_replace('{{body}}', $this->body, $this->template);
        $this->template = str_replace('{{Model}}', $this->model, $this->template);
        $this->template = str_replace('{{_model}}', strtolower($this->model), $this->template);
        $this->template = str_replace('{{var_service}}', $this->getServiceVariableName(), $this->template);
    }

    private function getServiceVariableName() {
        $var = strtolower($this->model) . 'Service';
        return Str::length($var) > 20 ? 'service' : $var;
    }

    function setBody() {
        $this->body = "";
    }
}