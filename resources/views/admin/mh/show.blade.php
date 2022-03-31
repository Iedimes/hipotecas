@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.mh.actions.show'))

@section('body')


@if ($det)

<div class="card">
    <div class="card-header text-center">
         {{ $mh->adjudicatario}} --- {{ $mh->documento }}<a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/mhs/') }}" role="button"><i class="fa fa-edit"></i>&nbsp; Volver</a>

    </div>


    <div class="card-body">

        <div class="row">

            <div class="form-group col-sm-4">
                <p class="card-text"><strong>DEPARTAMENTO: {{ $det->dpto ? $det->dpto->DptoNom:''}}</strong> </p>
            </div>

            <div class="form-group col-sm-4">
                <p class="card-text"><strong>LOCALIDAD: {{ $det->localidad ? $det->localidad->CiuNom:''}}</strong> </p>
            </div>


            <div class="form-group col-sm-4">
                <p class="card-text"><strong>SUPERFICIE:{{ $det->VivSupTer }} MTS²</strong></p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>NRO CUOTA:{{ $car->CLIUCP }}</strong> </p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>ULTIMO VENCIMIENTO:{{ $car->CliFuv }}</strong> </p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>ULTIMO MOVIMIENTO:{{ $car->Clifum }}</strong></p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>ULTIMA ACTUACION:{{ $jur->CliOFObs }}</strong> </p>
            </div>
            <div class="form-group col-sm-8">
                <p class="card-text"><strong>OBSERVACION:{{ $jur->CliOObs }}</strong> </p>
            </div>

        </div>

    </div>
  </div>
  @else
  <div class="card">
    <div class="card-header text-center">
       <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/mhs/') }}" role="button"><i class="fa fa-edit"></i>&nbsp; Volver</a>
   </div>

    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-4">
                <h2>El adjudicatario no posee datos</h2>
            </div>
        </div>
    </div>
 </div>
  @endif



@endsection
