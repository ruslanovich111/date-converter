<?php

namespace Ruslanovich\DateConverter\Models;

class DateCollection
{
    /**
     * @var DateModel[]
     */
    private array $dateModels = [];

    /**
     * @param DateModel $dateModel
     * @return void
     */
    public function addDateModel(DateModel $dateModel): void
    {
        $this->dateModels[] = $dateModel;
    }

    /**
     * @return DateModel[]
     */
    public function getAll(): array
    {
        return $this->dateModels;
    }
}