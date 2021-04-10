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
            $sum_txr_amount = (float)Customer::query()->sum('trx_amount');
            foreach ($paged as $item) {
                $items[] = [
                    'id' => $item->id,
                    'username' => $item->username,
                    'name' => $item->name,
                    'photo_id' => $item->photo,
                    'photo' => $item->photo ? asset($item->image->getImageUrlAttribute()) : '',
                    'status' => $item->status,
                    'trx_count' => (int)$item->trx_count,
                    'trx_amount' => (float)$item->trx_amount,
                    'percentage' => (float)number_format(((float)$item->trx_amount * 100) / $sum_txr_amount, 2, '.', '')
                ];
            }
            return ResponseStd::pagedFrom($items, $paged, Customer::query()->count());
        } catch (\Exception $e) {
            return ResponseStd::fail($e->getMessage());
        }
    }
}
