<?php
namespace App\Services;

use App\Repository\CategoryRepository;
use Illuminate\Support\Facades\Config;
use App\Repository\CategoryRepositoryRepository;

class CategoryService
{
    private  $categoryRepository;

    /**
     * CmsService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct( CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * get category info
     * @param $data
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getCategoryInfo($request){

        return $this->categoryRepository->getCategoryInfo($request);
    }

    public function createCategory($request)
    {
        $data['name'] = $request['name'];
        $data['description'] = $request['description'];
        return $this->categoryRepository->saveCategory ( $data );
    }

    public function editCategory($request)
    {
        $data['id'] = $request['id'];
        $data['name'] = $request['name'];
        $data['description'] = $request['description'];
        return $this->categoryRepository->updateCategory ( $data );
    }

    public function deleteCategory($id)
    {

        return $this->categoryRepository->deleteCategory($id);
    }

}
