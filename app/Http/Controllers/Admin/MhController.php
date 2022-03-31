<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MhExport;
use App\Exports\MhsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Mh\BulkDestroyMh;
use App\Http\Requests\Admin\Mh\DestroyMh;
use App\Http\Requests\Admin\Mh\IndexMh;
use App\Http\Requests\Admin\Mh\StoreMh;
use App\Http\Requests\Admin\Mh\UpdateMh;
use App\Models\Cartera;
use App\Models\Mh;
use App\Models\DetalleMh;
use App\Models\Juridico;
use App\Models\Localidad;
use App\Models\Dpto;
use App\Models\User;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class MhController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexMh $request
     * @return array|Factory|View
     */
    public function index(IndexMh $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Mh::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'codigo', 'proyecto', 'documento', 'adjudicatario', 'fecha_ins', 'institucion_acreedora', 'obs', 'fecha_reins'],

            // set columns to searchIn
            ['codigo', 'proyecto', 'documento', 'adjudicatario', 'fecha_ins', 'institucion_acreedora', 'obs', 'fecha_reins']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.mh.index', ['data' => $data]);

    }

    /**e
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.mh.create');

        return view('admin.mh.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMh $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMh $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Mh
        $mh = Mh::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/mhs'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }


        return redirect('admin/mhs');
    }

    public function export()
    {
       //return Excel::download(new UsersExport, 'users.xlsx');
       //return 'Hasta acá llega sin problema';
    }

    public function exportar()
    {
       //return Excel::download(new MhsExport, 'hipotecas.xlsx');
       //return 'Hasta acá llega sin problema';
    }


    public function exportExcel()
    {
        //return Mh::find(1886);
        return Excel::download(new MhExport, 'hipotecas.xlsx');
    }


    /**
     * Display the specified resource.
     *
     * @param Mh $mh
     * @throws AuthorizationException
     * @return void
     */
    public function show(Mh $mh)
    {

        //return $mh;
        $det = DetalleMh::where('VivPer', $mh->documento)->first();
        //return $det;



        if ($det) {
            $detalle = Mh::where('documento', $det->VivPer)->get();

        }else {
            $detalle = [];

        }
        $car = Cartera::where('PerCod', $mh->documento)->first();

        $jur = Juridico::where('PerCod', $mh->documento)->first();




        return view('admin.mh.show', compact('mh','det','car','jur'));


        // TODO your code goes here
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Mh $mh
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Mh $mh)
    {
        $this->authorize('admin.mh.edit', $mh);


        return view('admin.mh.edit', [
            'mh' => $mh,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMh $request
     * @param Mh $mh
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateMh $request, Mh $mh)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Mh
        $mh->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/mhs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/mhs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyMh $request
     * @param Mh $mh
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyMh $request, Mh $mh)
    {
        $mh->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }




    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyMh $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyMh $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Mh::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }



}




