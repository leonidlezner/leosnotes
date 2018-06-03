<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Http\Request;

trait ResourceCrud
{
    protected $model = '';
    protected $indexRoute = '';
    protected $trashRoute = '';
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
        assert($this->trashRoute != '');
        assert($this->viewIndex != '');
        assert($this->viewCreate != '');
        assert($this->viewShow != '');
        assert($this->viewEdit != '');
    }


    protected function findOrAbort($id, $includeTrashed = false)
    {
        $resource = null;

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

    public function getBackRoute($item = null)
    {
        if($item == null)
        {
            return $this->indexRoute;
        }

        if($item->trashed())
        {
            return $this->trashRoute;
        }
        else
        {
            return $this->indexRoute;
        }
    }

    public function index()
    {
        $items = $this->model::orderBy('id', 'desc')->paginate($this->items_per_page);
        
        return view($this->viewIndex)->with([
            'items' => $items
        ]);
    }


    public function trash()
    {
        $items = $this->model::onlyTrashed()->orderBy('id', 'desc')->paginate($this->items_per_page);

        return view($this->viewIndex)->with([
            'items' => $items
        ]);
    }


    public function create()
    {
        return view($this->viewCreate);
    }


    public function edit($id)
    {
        $item = $this->findOrAbort($id, true);

        return view($this->viewEdit)->with(compact('item'));
    }


    public function show($id)
    {
        $item = $this->findOrAbort($id, true);

        return view($this->viewShow)->with(compact('item'));
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);

        $item = $this->model->create($request->all());
        
        return redirect()->route($this->getBackRoute($item))->with([
            'success' => sprintf('New %s was created!', $item)
        ]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validationRules);

        $item = $this->findOrAbort($id, true);

        $item->update($request->all());

        return redirect()->route($this->getBackRoute($item))->with([
            'success' => sprintf('The %s was updated!', $item)
        ]);
    }


    public function destroy($id)
    {
        $item = $this->findOrAbort($id, true);

        $item->delete();

        return redirect()->route($this->getBackRoute($item))->with([
            'success' => sprintf('The %s was trashed!', $item)
        ]);
    }


    public function restore($id)
    {
        $item = $this->findOrAbort($id, true);

        $item->restore();

        return redirect()->route($this->getBackRoute($item))->with([
            'success' => sprintf('The %s was restored!', $item)
        ]);
    }


    public function forceDelete($id)
    {
        $item = $this->findOrAbort($id, true);

        $item->forceDelete();

        return redirect()->route($this->getBackRoute($item))->with([
            'success' => sprintf('The %s was deleted!', $item)
        ]);
    }
}