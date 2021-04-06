<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Libraries\ResponseStd;
use App\Models\Category;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            $search_term = $request->input('search');
            $filterStatus = $request->has('status') ? $request->input('status') : 'all';
            $limit = $request->has('limit') ? $request->input('limit') : 10;
            $sort = $request->has('sort') ? $request->input('sort') : 'updated_at';
            $order = $request->has('order') ? $request->input('order') : 'DESC';
            $status = $request->has('status') ? $request->input('status') : null;
            $conditions = '1 = 1';
            if (!empty($search_term)) {
                $conditions .= " AND category_name LIKE LOWER('%$search_term%')";
            }
            if ($filterStatus != 'all') {
                $conditions .= " AND category_status = $filterStatus";
            }
            $paged = Category::sql()
                ->whereRaw($conditions);

            if ($status) {
                if ($status == 1 || $status == true || $status == 'true' || $status == 'active') {
                    $status = 1;
                }
                $paged = $paged->where('category_status', $status);
            }

            $paged = $paged
                ->orderBy($sort, $order)
                ->paginate($limit);
            return ResponseStd::paginated($paged, Category::count());
        } catch (\Exception $e) {
            return ResponseStd::fail($e->getMessage());
        }
    }

    /**
     * Creating a new category.
     *
     * @param CreateRequest $request
     * @return array
     * @throws \Exception
     */
    public function create(CreateRequest $request)
    {
        \DB::beginTransaction();
        try {
            $item = Category::create([
                'id' => Uuid::generate(4)->string,
                'category_name' => $request->category_name,
                'category_status' => !$request->category_status ? false : true,
                'last_modified_by' => auth('api')->user()->id
            ]);
            \DB::commit();
            return ResponseStd::okSingle($item, $messages = 'Success create category.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return ResponseStd::fail($e->getMessage());
        }
    }

    /**
     * Update a category.
     *
     * @param $id
     * @param UpdateRequest $request
     * @return array
     */
    public function update($id, UpdateRequest $request)
    {
        \DB::beginTransaction();
        try {
            $item = Category::findOrFail($id);
            $item->update([
                'category_name' => $request->category_name,
                'category_status' => !$request->category_status ? false : true,
                'last_modified_by' => auth('api')->user()->id
            ]);
            \DB::commit();
            return ResponseStd::okSingle($item, $messages = 'Success update category.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return ResponseStd::fail($e->getMessage());
        }
    }

    /**
     * Show a category.
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function show($id, Request $request)
    {
        try {
            $item = Category::findOrFail($id);
            return ResponseStd::okSingle($item, $messages = 'Success show a category.');
        } catch (\Exception $e) {
            return ResponseStd::fail($e->getMessage());
        }
    }

    /**
     * Remove specified a category.
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function destroy($id, Request $request)
    {
        \DB::beginTransaction();
        try {
            $item = Category::findOrFail($id);
            $item->update([
                'last_modified_by' => auth('api')->user()->id,
                'deleted_by' => auth('api')->user()->id
            ]);
            $item->delete();
            \DB::commit();
            return ResponseStd::okNoOutput($messages = 'Success delete a category.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return ResponseStd::fail($e->getMessage());
        }
    }
}
