@extends('layouts.UD.ud')
@section('content')
    <div class=" container-fluid mt-5">
        <div class="card bg-white">
            <div class=" card-body">
                <div class="d-flex justify-content-center">
                    <div style="background-color: #bde0fe;width:150px;height:150px">image</div>
                </div>
                <hr style="background-color: #8d99ae">
                {{-- {{ $data }} --}}
                <div class="row">
                    <div class="col-3">NAME(TH) : </div>
                    <div class="col-9">{{ $data[0]->pname }} {{ $data[0]->full_name_th }}</div>
                </div>
                <div class="row">
                    <div class="col-3">NAME(EN) : </div>
                    <div class="col-9">{{ $data[0]->full_name_eng }}</div>
                </div>
                <div class="row">
                    <div class="col-3">GENDER : </div>
                    <div class="col-9">{{ $data[0]->pname }} {{ $data[0]->gender }}</div>
                </div>
                <div class="row">
                    <div class="col-3">FACUTY : </div>
                    @if ($data[0]->organization_id == 0)
                        <div class="col-9">บุคคลภายนอก</div>
                    @else
                        <div class="col-9">{{ $data[0]->major }} {{ $data[0]->organizational_name }}</div>
                    @endif

                </div>
                <div class="row">
                    <div class="col-3">EMAIL : </div>
                    <div class="col-9">{{ $data[0]->pname }} {{ $data[0]->email }}</div>
                </div>
                <div class="row">
                    <div class="col-3">PHONE : </div>
                    <div class="col-9">{{ $data[0]->tel }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
