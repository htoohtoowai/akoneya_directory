<?php
namespace App\Repositories;

class BaseRepository
{
    public function __construct()
    {
        $this->perPage = config('enums.perPage');
        $this->nextId = null;
    }

    public function getDataByNextId($id, $nextId, $queryInfo)
    {
        if ($nextId != 0) {
            $queryInfo = $queryInfo->where($id, '<=', $nextId);
        }

        $data = $queryInfo->orderBy($id, 'desc')->limit($this->perPage + 1)->get();

        $totalCount = $data->count();

        if ($totalCount > $this->perPage) {
            $this->nextId = $data[$this->perPage]->id;
            unset($data[$totalCount - 1]);
        }
        
        return ["result" => $data, "nextId" => $this->nextId];
    }

    public function getDataOrderedByName($name, $nextId, $model, $queryInfo)
    {
        if ($nextId != 0) {
            $nextData = $model->find($nextId);
            if ($nextData) {
                $data = $queryInfo->where('name', '>=', $nextData->name);
            }
        }
        $data = $queryInfo->orderBy('name')->limit($this->perPage + 1)->get();

        $totalCount = $data->count();

        if ($totalCount > $this->perPage) {
            $this->nextId = $data[$this->perPage]->id;
            unset($data[$totalCount - 1]);
        }
        return ["result" => $data, "nextId" => $this->nextId];
    }

    public function getCategoryByName($categoryName, $nextId, $model, $categoryQuery)
    {
        if ($nextId != 0) {
            $nextData = $model->find($nextId);
         
            if ($nextData) {
                $data = $categoryQuery->where($categoryName, '>=', $nextData->$name);
            }
        }
        $data = $categoryQuery->orderBy($categoryName)->limit($this->perPage + 1)->get();


        $totalCount = $data->count();

        if ($totalCount > $this->perPage) {
            $this->nextId = $data[$this->perPage]->id;
            unset($data[$totalCount - 1]);
        }
        return ["result" => $data, "nextId" => $this->nextId];
    }

    public function getNameByMultiLanguage($request, $enName, $mmName, $zhname)
    {
        $headerLanguage = $request->header('Content-Language');
       
        if ($headerLanguage == 'mm') {
            $name = $mmName;
        } elseif ($headerLanguage == 'zh') {
            $name = $zhname;
        } else {
            $name = $enName;
        }
        return $name;
    }
}
