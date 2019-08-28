<?php

namespace App\Support\Filters;

use ReflectionClass;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Filter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get all the available filter methods.
     *
     * @return array
     */
    protected function getFilterMethods()
    {
        $class  = new ReflectionClass(static::class);

        $methods = array_map(function($method) use ($class) {
            if ($method->class === $class->getName()) {
                return snake_case($method->name);
            }
            return null;
        }, $class->getMethods());

        return array_filter($methods);
    }

    /**
     * Get all the filters that can be applied.
     *
     * @return array
     */
    protected function getFilters()
    {
        return array_filter($this->request->only($this->getFilterMethods()));
    }

    /**
     * Apply all the requested filters if available.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $name => $value) {
            $method = camel_case($name);
            if (method_exists($this, $method)) {
                if ($value) {
                    $this->$method($value);
                } else {
                    $this->$method();
                }
            }
        }

        return $this->builder;
    }
}
