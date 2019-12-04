<?php
namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

trait CategoryValidator
{
    protected function rule($method, $data) {
        switch ($method) {
            case 'Get':
            case 'Post': {
                return [
                    'name' => ['required','unique:category'],
                    'description' => 'required',
                ];
            }
            case 'Put': {

                if(!isset($data['id']) || !is_numeric($data['id'])) {
                    return [
                        'id' => 'required|integer',
                    ];
                }
                return [
                    'name' => 'required|unique:category,name,'.Category::find($data['id'])->id,
                    'description' => 'required',
                ];
            }
            case 'Delete': {
                return [
                    'id' => 'required|integer',
                ];
            }
            default:
                break;
        }
    }
    protected function categoryValidate(array $data, $method = "Post") {

        $messages = [
            'id.required' => 'Please add Id',
            'name.required' => 'Please add Name',
            'description.required' => 'Please add Description',
        ];

            $validator = Validator::make($data, $this->rule($method, $data), $messages);
        return $validator;
    }
}
