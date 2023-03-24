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
                                        <button class="btn btn-sm btn-info" onclick="view2({{ $item->research_id }})">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-info" onclick="view3({{ $item->research_id }})">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td align="center">

                                        <button class="btn btn-sm btn-default"
                                            onclick="addSumfeed({{ $item->research_id }})">สรุปข้อเสนอแนะ</button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--view feed Modal -->
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

    <!--add sum feed Modal -->
    <div class="modal fade" id="addsumFeed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addsumFeedLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addsumFeedLabel">สรุปข้อเสนอแนะ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.add-sumFeed') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id_r">
                        <div class="row mb-3">
                            <strong class="col-md-3">ชื่อโครงร่างงานวิจัยภาษาไทย</strong>
                            <div class="col-md-9">
                                <label for="" id="nm_th"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-md-3">ชื่อโครงร่างงานวิจัยอังกฤษ</strong>
                            <div class="col-md-9">
                                <label for="" id="nm_en"></label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">ผลการประเมิน</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="AssessmentResults"
                                        id="AssessmentResults1" value="ไม่ผ่าน" checked>
                                    <label class="form-check-label" for="AssessmentResults1">ไม่ผ่าน</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="AssessmentResults"
                                        id="AssessmentResults2" value="ผ่าน">
                                    <label class="form-check-label" for="AssessmentResults2">ผ่าน</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row"id="checkFile">
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input onclick="sugges()" class="form-check-input" type="checkbox" id="mustAddFile"
                                        name="mustAddFile" value="mustAddFile">
                                    <label class="form-check-label text-danger"
                                        for="mustAddFile">ต้องการเพิ่มไฟล์ข้อเสนอแนะ</label>
                                </div>
                            </div>
                        </div>
                        <div class=" row " id="suggestion">
                            <label class="col-sm-3 col-form-label fw-bold">ข้อเสนอแนะ</label>
                            <div class=" px-3">
                                <textarea {{-- onkeyup="sugges()" --}} class="form-control" name="suggestion" {{-- id="suggestion" --}}
                                    placeholder="ระบุข้อเสนอแนะ" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="row" id="suggestionFile">
                            <label class="col-sm-3 col-form-label fw-bold">ไฟล์ข้อเสนอแนะ</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="suggestionFile" id="suggestionFile"
                                    rows="20">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" id="save" name="save"
                            {{-- onclick="saveFeed()" --}} value="บันทึก" />
                        <input type="submit" class="btn btn-primary" name="save" id="comfirm"
                            value="ส่งการประเมิน" />
                    </div>
                </form>

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
            document.getElementById("suggestionFile").style.display = "none";
        });
    </script>
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
                    $('#name_director').html(data.pname + ' ' + data.full_name_th);
                    $('#result').html(result);
                    $('#Assessment_result').html(comment);
                }
            })

        }

        function view2(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/admin/view-feed/director/' + id,
                dataType: 'JSON',
                success: function(res) {
                    //console.log(res.data_fe);
                    var data = res.data_fe[1];
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
                    $('#name_director').html(data.pname + ' ' + data.full_name_th);
                    $('#result').html(result);
                    $('#Assessment_result').html(comment);
                }
            })

        }

        function view3(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/admin/view-feed/director/' + id,
                dataType: 'JSON',
                success: function(res) {
                    //console.log(res.data_fe);
                    var data = res.data_fe[2];
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
                    $('#name_director').html(data.pname + ' ' + data.full_name_th);
                    $('#result').html(result);
                    $('#Assessment_result').html(comment);
                }
            })

        }

        function addSumfeed(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/view/research/' + id,
                dataType: 'JSON',
                success: function(res) {
                    moment.locale('th');
                    //console.log(res.data_re);
                    var data = res.data_re[0];
                    console.log(data);
                    $('#id_r').val(data.research_id);
                    $('#nm_th').html(data.research_th);
                    $('#nm_en').html(data.research_en);
                    $('#addsumFeed').modal('toggle');
                }
            });

        }

        $('#AssessmentResults2').on('click', function() {
            $('#checkFile').css('display', 'none');
            $('#suggestionFile').css('display', 'none');
            $('#suggestion').css('display', 'none');
            $('#save').css('display', 'none');
        });
        $('#AssessmentResults1').on('click', function() {
            $('#checkFile').css('display', 'block');
            $('#suggestionFile').css('display', 'block');
            $('#suggestion').css('display', 'block');
            $('#save').css('display', 'block');
            sugges();
        });

        function sugges() {
            var rb = document.getElementById('AssessmentResults2');
            //var rb = document.querySelector('input[id="refers2"]:checked').value;
            var ck = document.getElementById('mustAddFile');
            var cf = document.getElementById('checkFile');
            var x = document.getElementById("suggestionFile");
            var z = document.getElementById("suggestion");
            var bs = document.getElementById("save");
            var bc = document.getElementById("comfirm");

            //x.value = x.value.toUpperCase();

            // console.log('false');
            if (ck.checked == true) {
                console.log('true');
                Swal.fire({
                    text: "คุณต้องการเพิ่มไฟล์ข้อเสนอแนะ ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่',
                    cancelButtonText: 'ไม่',
                }).then((result) => {
                    if (result.isConfirmed) {
                        x.style.display = "";
                        z.style.display = "none";
                        bs.style.display = "none";
                    }
                    if (result.dismiss) {
                        //console.log('false');
                        ck.checked = false;
                        x.style.display = "none";
                        z.style.display = "";
                        bs.style.display = "";
                    }
                })

            } else {
                //console.log('false');
                ck.style.display = "";
                x.style.display = "none";
                z.style.display = "";
            }

        }
    </script>
@endpush
