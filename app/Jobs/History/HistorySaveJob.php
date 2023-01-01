<?php

namespace App\Jobs\History;

use App\Enums\HistoryTypes;
use Illuminate\Support\Facades\Storage;

class HistorySaveJob
{
    const FILE_NAME = 'history.json';
    protected HistoryTypes $operationKey;

    protected $value;

    public function save()
    {
        $oldData = collect(json_decode(Storage::get(self::FILE_NAME) ?? '{}', true));
        $oldData[$this->operationKey->value()] = $this->value;
        Storage::put(self::FILE_NAME, json_encode($oldData, JSON_THROW_ON_ERROR));

    }


    public function getOperationKey(): HistoryTypes
    {
        return $this->operationKey;
    }


    public function setOperationKey(HistoryTypes $operationKey): self
    {
        $this->operationKey = $operationKey;
        return $this;
    }


    public function getValue()
    {
        return $this->value;
    }


    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getCurrent(HistoryTypes $type)
    {
        return json_decode(Storage::get(self::FILE_NAME), 1)[$type->value()];
    }


}
