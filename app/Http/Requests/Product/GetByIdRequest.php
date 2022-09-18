<?php

namespace App\Http\Requests\Product;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class GetByIdRequest extends FormRequest
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

    public function all($keys = null)
    {
        $data = parent::all();
        $data['id'] = $this->route('product');

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $productRepository = app(ProductRepositoryInterface::class);

        return [
            'id' => 'integer|required|exists:'.$productRepository->getClassName().',id',
        ];
    }
}
