@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.mh.actions.index'))

@section('body')

    <mh-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/mhs') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 ><i class="fa fa-list-alt" aria-hidden="true"style="margin: 5px;"></i>Listados de Hipotecas<h3>
                      <div class="col"> <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/mhs/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.mh.actions.create') }}</a></div>

                      <span class="pull-right pr-2">
                       <a class="btn btn-success btn-sm pull-right m-b-0" alt="para descargar en formato excel"href="{{ url('exportarExcel/') }}" role="button"><i class="fa fa-plus"></i>&nbsp;  EXPORTAR A EXCEL</a>
                     </span>

                   </div>



                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Buscar por Nº Documentos, Codigos u otros....." v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp;</button>
                                            </span>
                                        </div>


                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                       {{--}} <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>--}}

                                        {{--<th is='sortable' :column="'id'">{{ trans('admin.mh.columns.id') }}</th>--}}
                                        <th is='sortable' :column="'codigo'">{{ trans('admin.mh.columns.codigo') }}</th>
                                        <th is='sortable' :column="'proyecto'">{{ trans('admin.mh.columns.proyecto') }}</th>
                                        <th is='sortable' :column="'documento'">{{ trans('admin.mh.columns.documento') }}</th>
                                        <th is='sortable' :column="'adjudicatario'">{{ trans('admin.mh.columns.adjudicatario') }}</th>
                                        <th is='sortable' :column="'fecha_ins'">{{ trans('admin.mh.columns.fecha_inscripcion') }}</th>
                                        <th is='sortable' :column="'institucion_acreedora'">{{ trans('admin.mh.columns.institucion_acreedora') }}</th>
                                        <th is='sortable' :column="'obs'">{{ trans('admin.mh.columns.obs') }}</th>
                                        <th is='sortable' :column="'fecha_reins'">{{ trans('admin.mh.columns.fecha_reins') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="11">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/mhs')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/mhs/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.documento" :class="bulkItems[item.documento] ? 'bg-bulk' : ''">
                                        {{--<td class="bulk-checkbox" >
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>--}}

                                    {{--<td>@{{ item.id }}</td>--}}
                                        <td>@{{ item.codigo }}</td>
                                        <td>@{{ item.proyecto }}</td>
                                        <td>@{{ item.documento }}</td>
                                        <td>@{{ item.adjudicatario }}</td>
                                        <td>@{{ item.fecha_ins | date }}</td>
                                        <td>@{{ item.institucion_acreedora }}</td>
                                        <td>@{{ item.obs }}</td>
                                        <td>@{{ item.fecha_reins | date }}</td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/show'" title="{{ trans('brackets/admin-ui::admin.btn.show') }}" role="button"><i class="fa fa-search"></i></a>
                                                </div>
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>

                                                {{--<form class="col" @submit.prevent="pickeitor()">
                                                    <button type="submit" class="btn btn-sm btn-success" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>--}}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/mhs/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.mh.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </mh-listing>

@endsection
