<?php namespace App\Repository;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Models\Category;
use App\Dtech\Helper;
use Illuminate\Support\Facades\Auth;
use  App\Dtech\DtechException;

class CategoryRepository extends Repository {

    protected $perPage;
    protected $sort;
    protected $sortColumn;

    public function model() {
        return 'App\Models\Category';
    }

    /**
     * save category
     * @param $request
     * @return bool
     */
    public function saveCategory($request){

        $name = !empty( $request[ 'name' ] ) ? $request[ 'name' ] : '';
        $description = !empty( $request[ 'description' ] ) ? $request[ 'description' ] : '';

        $objCategory = new Category();
        $objCategory->name = $name;
        $objCategory->description = $description;

        if ($objCategory->save()) {
            return true;
        }
        return false;
    }

    /**
     * update category
     * @param $request
     * @return bool
     */
    public function updateCategory($request){

        $name = !empty( $request[ 'name' ] ) ? $request[ 'name' ] : '';
        $description = !empty( $request[ 'description' ] ) ? $request[ 'description' ] : '';
        $objCategory = Category::find($request['id']);
        $objCategory->name = $name;
        $objCategory->description = $description;

            if ($objCategory->save()) {
                return true;
            }

        return false;
    }

    /**get user info
     * @param $request
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getCategoryInfo($request){

        $this->perPage = env('PAGINATE_PER_PAGE', 15);
        $this->sort = (!empty($request['sort'])) ? ($request['sort']) : 'desc';
        $this->sortColumn = (!empty($request['sortType'])) ? ($request['sortType']) : 'category.created_at';

        if (!empty($request['perPage'])) {
            $this->perPage = $request['perPage'];
        }
        $request = Helper::arrayUnset($request, ['sortType', 'perPage', 'sort', 'page']);

        return $this->findWhere($request);

    }

    /**
     * @param array $where
     * @param array $columns
     * @param bool $or
     * @param bool $elect
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhere($where, $columns = ['*'], $or = false, $elect = false)
    {
        $this->applyCriteria();
        $model = $this->model;

        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $model = (!$or)
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, 'like', '%' . $value . '%')
                        : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = (!$or)
                    ? $model->where($field, 'like', '%' . $value . '%')
                    : $model->orWhere($field, '=', $value);
            }
        }
        return $model
            ->orderBy($this->sortColumn, $this->sort)
            ->paginate($this->perPage);
    }

    /**
     * delete category
     * @param $request
     * @return bool
     */
    public function deleteCategory($id){


        $objCategory = Category::find($id);

        if(!empty($objCategory)){
            $objCategory->delete();
            return true;
        }
        return false;
    }
}
