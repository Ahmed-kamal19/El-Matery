<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class ExistButDeleted implements Rule
{
    private $model;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $itemDoesntExist = $this->model->onlyTrashed()->where($attribute, $value)->doesntExist();

        if (!$itemDoesntExist)
            $this->model = $this->model->onlyTrashed()->where($attribute, $value)->first();

        return $itemDoesntExist;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $modelName = class_basename($this->model);

        return __("There is ") . __(strtolower($modelName)) . __(" with the same ") . __(":attribute"). __(" but in the trash ") . "<a href='" . route('dashboard.trash.restore', [$modelName, $this->model->id]) . "' class='restore-item' style='text-decoration:underline;'>" . __('do you want to restore ?') . "</a>";
    }
}
