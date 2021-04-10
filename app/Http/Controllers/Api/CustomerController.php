<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Libraries\ResponseStd;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
                $conditions .= " AND name ILIKE '%$search_term%'";
            }
            if ($filterStatus != 'all') {
                $conditions .= " AND status = $filterStatus";
            }
            $paged = Customer::sql()
                ->whereRaw($conditions);

            if ($status) {
                if ($status == 1 || $status == true || $status == 'true' || $status == 'active') {
                    $status = 1;
                }
                $paged = $paged->where('status', $status);
            }

            $paged = $paged
                ->orderBy($sort, $order)
                ->paginate($limit);
            $items = [];
            foreach ($paged as $item) {
                $items[] = [
                    'id' => $item->id,
                    'username' => $item->username,
                    'name' => $item->name,
                    'photo_id' => $item->photo,
                    'photo' => $item->photo ? asset($item->image->getImageUrlAttribute()) : '',
                    'trx_count' => (int)$item->trx_count,
                    'trx_amount' => (float)$item->trx_amount
                ];
            }
            return ResponseStd::pagedFrom($items, $paged, Customer::query()->count());
        } catch (\Exception $e) {
            return ResponseStd::fail($e->getMessage());
        }
    }

//    /**
//     * Creating a new Customer.
//     *
//     * @param CreateRequest $request
//     * @return \Illuminate\Http\JsonResponse
//     * @throws \Exception
//     */
//    public function create(CreateRequest $request)
//    {
//        DB::beginTransaction();
//        try {
//            $item = Customer::query()->create([
//                'id' => Uuid::generate(4)->string,
//                'name' => $request->name,
//                'username' => $request->username,
//                'status' => !$request->status ? 0 : 1,
//            ]);
//            DB::commit();
//            return ResponseStd::okSingle($item, $messages = 'Success create customer.');
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return ResponseStd::fail($e->getMessage());
//        }
//    }
//
//    /**
//     * Update a category.
//     *
//     * @param $id
//     * @param UpdateRequest $request
//     * @return array
//     */
//    public function update($id, UpdateRequest $request)
//    {
//        \DB::beginTransaction();
//        try {
//            $item = Category::findOrFail($id);
//            $item->update([
//                'category_name' => $request->category_name,
//                'category_status' => !$request->category_status ? false : true,
//                'last_modified_by' => auth('api')->user()->id
//            ]);
//            \DB::commit();
//            return ResponseStd::okSingle($item, $messages = 'Success update category.');
//        } catch (\Exception $e) {
//            \DB::rollBack();
//            return ResponseStd::fail($e->getMessage());
//        }
//    }
//
//    /**
//     * Show a category.
//     *
//     * @param $id
//     * @param Request $request
//     * @return array
//     */
//    public function show($id, Request $request)
//    {
//        try {
//            $item = Category::findOrFail($id);
//            return ResponseStd::okSingle($item, $messages = 'Success show a category.');
//        } catch (\Exception $e) {
//            return ResponseStd::fail($e->getMessage());
//        }
//    }
//
//    /**
//     * Remove specified a category.
//     *
//     * @param $id
//     * @param Request $request
//     * @return array
//     */
//    public function destroy($id, Request $request)
//    {
//        \DB::beginTransaction();
//        try {
//            $item = Category::findOrFail($id);
//            $item->update([
//                'last_modified_by' => auth('api')->user()->id,
//                'deleted_by' => auth('api')->user()->id
//            ]);
//            $item->delete();
//            \DB::commit();
//            return ResponseStd::okNoOutput($messages = 'Success delete a category.');
//        } catch (\Exception $e) {
//            \DB::rollBack();
//            return ResponseStd::fail($e->getMessage());
//        }
//    }
}
