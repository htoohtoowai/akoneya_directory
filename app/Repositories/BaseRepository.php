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
                $data = $queryInfo->where($name, '>=', $nextData->$name);
            }
        }
        $data = $queryInfo->orderBy($name)->limit($this->perPage + 1)->get();

        $totalCount = $data->count();

        if ($totalCount > $this->perPage) {
            $this->nextId = $data[$this->perPage]->id;
            unset($data[$totalCount - 1]);
        }
        return ["result" => $data, "nextId" => $this->nextId];
    }
}
