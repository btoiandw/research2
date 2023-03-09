@extends('layouts.admin.admin')
@section('content')
    <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="table-responsive pt-3">
                    <table class="table fw-bold w-100" id="admin_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัย</th>
                                <th class=" fw-bolder" style="font-size: 15px">กรรมการคนที่ 1</th>
                                <th class=" fw-bolder" style="font-size: 15px">กรรมการคนที่ 2</th>
                                <th class=" fw-bolder" style="font-size: 15px">กรรมการคนที่ 3</th>
                                <th class=" fw-bolder" style="font-size: 15px">สรุปผล</th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_re as $item)
                                <tr>
                                    <td align="center">{{ $i++ }}</td>
                                    <td>{{ $item->research_th }}</td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-info" onclick="view1({{ $item->research_id }})">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-default">สรุปข้อเสนอแนะ</button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewLabel">รายละเอียดข้อเสนอแนะ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <strong class="col-md-3">ชื่อโครงร่างงานวิจัยภาษาไทย</strong>
                        <div class="col-md-9">
                            <label for="" id="name_th"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-md-3">ชื่อโครงร่างงานวิจัยอังกฤษ</strong>
                        <div class="col-md-9">
                            <label for="" id="name_en"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-md-3">ชื่อกรรมการ</strong>
                        <div class="col-md-9">
                            <label for="" id="name_director"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-md-3">ผลการประเมิน</strong>
                        <div class="col-md-9">
                            <label for="" id="result"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-md-3">ข้อเสนอแนะ</strong>
                        <div class="col-md-9">
                            <label for="" id="Assessment_result"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#admin_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,

                language: {
                    lengthMenu: "แสดง _MENU_ รายการ",
                    search: "ค้นหาข้อมูลในตาราง",
                    info: "แสดงข้อมูล _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        previous: "ก่อนหน้า",
                        next: "ถัดไป",

                    },
                },

            });
        })

        function view1(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/admin/view-feed/director/' + id,
                dataType: 'JSON',
                success: function(res) {
                    //console.log(res.data_fe);
                    var data = res.data_fe[0];
                    console.log(data);
                    var result = '';
                    var comment = '';
                    if (data.feedback == null) {
                        result = '-';
                    } else {
                        result = data.feedback;
                    }
                    if (data.Assessment_result == null && data.suggestionFile == null) {
                        comment = '-';
                    } else if (data.Assessment_result != null && data.suggestionFile == null) {
                        comment = data.Assessment_result;
                    } else {
                        comment = data.suggestionFile;
                    }
                    $('#view').modal('toggle');
                    $('#name_th').html(data.research_th);
                    $('#name_en').html(data.research_en);
                    $('#name_director').html(data.full_name_th);
                    $('#result').html(result);
                    $('#Assessment_result').html(comment);
                }
            })

        }
    </script>
@endpush
