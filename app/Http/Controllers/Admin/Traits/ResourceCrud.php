<?php

namespace App\Http\Controllers\Admin\Traits;

trait ResourceCrud
{
    protected $model = '';
    protected $indexRoute = '';
    protected $authExcept = ['index', 'show'];
    protected $viewFolder = '';
    protected $viewIndex = '';
    protected $viewCreate = '';
    protected $viewShow = '';
    protected $viewEdit = '';
    protected $validationRules = [];
    protected $items_per_page = 10;

    public function setupCrud()
    {
        if($this->viewFolder)
        {
            if(!$this->viewIndex)
            {
                $this->viewIndex = sprintf('%s.index', $this->viewFolder);
            }

            if(!$this->viewCreate)
            {    
                $this->viewCreate = sprintf('%s.create', $this->viewFolder);
            }

            if(!$this->viewShow)
            {
                $this->viewShow = sprintf('%s.show', $this->viewFolder);
            }
            
            if(!$this->viewEdit)
            {
                $this->viewEdit = sprintf('%s.edit', $this->viewFolder);
            }
        }

        assert($this->model != '');
        assert($this->indexRoute != '');
        assert($this->viewIndex != '');
        assert($this->viewCreate != '');
        assert($this->viewShow != '');
        assert($this->viewEdit != '');
    }


    protected function findOrAbort($id, $includeTrashed = false)
    {
        if($includeTrashed)
        {
            $resource = $this->model::withTrashed()->find($id);
        }
        else
        {
            $resource = $this->model::find($id);
        }
        
        if(!$resource)
        {
            abort(404, 'Resource not found');
        }

        return $resource;
    }


    public function index()
    {
        $items = $this->model::orderBy('id', 'desc')->paginate($this->items_per_page);
        
        return view($this->viewIndex)->with([
            'items' => $items
        ]);
    }

    public function trashed()
    {
        $items = $this->model::onlyTrashed()->orderBy('id', 'desc')->get();

        return view($this->viewIndex)->with([
            'items' => $items
        ]);
    }
}