@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.mh.actions.edit', ['name' => $mh->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <mh-form
                :action="'{{ $mh->resource_url }}'"
                :data="{{ $mh->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">

                        <h3 ><i class="fa fa-pencil-square-o" aria-hidden="true"style="margin: 5px;"></i>Editar Datos Hipotecas<h3>  {{ trans('', ['name' => $mh->id]) }}

                    </div>

                    <div class="card-body">
                        @include('admin.mh.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>

                        <a class="btn btn-danger":disabled="submiting" href="{{ url()->previous() }}" role="button"><i class="fa fa-undo"></i>&nbsp; Cancelar</a>




                    </div>

                </form>

        </mh-form>

        </div>

</div>

@endsection
