<?php

namespace App\Http\Requests\Product;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $categoriesRepository = app(CategoryRepositoryInterface::class);

        return [
            'eid' => 'integer|required',
            'title' => 'string|min:5|max:244',
            'price' => 'numeric|min:1|max:20000',
            'categories_ids' => 'required|array',
            'categories_ids.*' => 'integer|exists:'.$categoriesRepository->getClassName().',id'
        ];
    }
}
