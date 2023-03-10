@extends('layouts.UD.ud')
<script type="text/javascript">
    var siteUrl = "{{ url('/') }}";
</script>
@section('content')
    @if ($errors->any())
        <!-- ตรวจสอบว่ามี Error ของ validation ขึ้นมาหรือเปล่า -->

        <div class="alert alert-danger" id="ERROR_COPY" style="display:none;">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <!-- ทำการ วน Loop เพื่อแสดง Error ของ validation ขึ้นมาทั้งหมด -->
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <!-- ref - https://laravel.com/docs/7.x/validation#DisplayingTheValidationErrors  -->
    @endif

    <div class=" container-fluid mt-3">
        <div class=" d-flex justify-content-end align-content-end">
            <button class=" btn btn-primary" id="btnAddResearch" onclick="AddModal()">
                เพิ่มโครงร่าง
            </button>
        </div>

        <div class="row mb-3 mt-3">
            <div class="col-xl-12">
                <div class="bg-white rounded shadow-xl m-dash p-2">
                    <div class="table-responsive">
                        <table class="table fw-bold w-100" id="research_table">
                            <thead class="table-dark table-hover table align-middle">
                                <tr align="center">
                                    <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                    <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัยภาษาไทย</th>
                                    <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</th>
                                    <th class="fw-bolder" style="font-size: 15px">รายละเอียด</th>
                                    <th class="fw-bolder" style="font-size: 15px">สถานะ</th>
                                    <th class="fw-bolder" style="font-size: 15px">จัดการ</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($data_research as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->research_th }}</td>
                                        <td>{{ $item->research_en }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" type="button"
                                                onclick="viewDetail({{ $item->research_id }})">
                                                รายละเอียด
                                            </button>
                                        </td>
                                        <td>
                                            @if ($item->research_status == 0)
                                                <button class="btn btn-yellow disabled btn-sm">
                                                    รอตรวจสอบ
                                                </button>
                                            @else
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                <button class="btn btn-yellow me-md-2 btn-sm" type="button"
                                                    onclick="edit({{ $item->research_id }})">แก้ไข</button>
                                                <button class="btn btn-danger btn-sm" type="button"
                                                    onclick="cancel_resesrch({{ $item->research_id }})">ยกเลิก</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal insert --}}
    <div class="modal fade" id="addResearch" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addResearchLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="addResearchLabel">เพิ่มโครงร่างงานวิจัย</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add_research" method="POST" enctype="multipart/form-data" action="{{ route('research.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-end align-content-end">
                            <label style="font-size: 10px">
                                @php
                                    echo thaidate('วันlที่ j F พ.ศ.Y เวลา H:i:s');
                                @endphp
                            </label>

                        </div>
                        <div class="row mb-3">
                            <input type="hidden" name="id_users" id="id_users" value="{{ $id }}" />
                            <label for="year_research" class="col-sm-2 col-form-label" align="right">ปีงบประมาณ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="year_research" value="{{ date('Y') + 544 }}"
                                    name="year_research">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="research_nameTH" class="col-sm-2 col-form-label "
                                align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาไทย</label>
                            <div class=" col-sm-10">
                                <textarea class="form-control" id="research_nameTH" name="research_nameTH" required></textarea>

                            </div>

                        </div>
                        <div class="row mb-3">
                            <label for="research_nameEN" class="col-sm-2 col-form-label"
                                align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</label>
                            <div class=" col-sm-10">
                                <textarea class="form-control" id="research_nameEN" name="research_nameEN" required></textarea>

                            </div>

                        </div>
                        <div class="mb-3">
                            <label
                                for="message-text"style="text-align:left;font-weight:600;font-size:18px;background:#fff;border:none"
                                class="pt-3 py-0 card-header">รายชื่อนักวิจัย</label>
                            <div class="card-body pt-0">
                                <table class="table table-responsive" id="tableTap" name="tableTap">
                                    <thead align="center">
                                        <tr>
                                            <th width="600px" style="font-size: 14px">ชื่อ-นามสกุล</th>
                                            <th width="600px" style="font-size: 14px">สังกัด/คณะ</th>
                                            <th width="300px" style="font-size: 14px">บทบาทในการวิจัย</th>
                                            <th width="300px" style="font-size: 14px">ร้อยละบทบาทในการวิจัย</th>
                                            <th width="">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody align="center" id="roleResearch">
                                        <tr id="row[]">
                                            <td>
                                                <input type="text" name="researcher[]" id="researcher"
                                                    value="{{ $data[0]->full_name_th }}" class="form-control" required>
                                            </td>
                                            <td>
                                                <select class="form-select" id="faculty" name="faculty[]">
                                                    <option value="">
                                                        เลือกสังกัด/คณะ
                                                        {{-- {{ $data[0]->organizational }}&nbsp;&nbsp;{{ $data[0]->major }} --}}
                                                    </option>
                                                    @foreach ($list_fac as $row)
                                                        @if ($row->major == '0')
                                                            <option value="{{ $row->id }} ">
                                                                {{ $row->organizational }}</option>
                                                        @else
                                                            <option value="{{ $row->id }}">
                                                                {{ $row->organizational }}&nbsp;&nbsp;{{ $row->major }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select " name="role-research[]" id="role-research">
                                                    <option value="หัวหน้าโครงการวิจัย" selected readonly>
                                                        หัวหน้าโครงการวิจัย</option>
                                                    <option value="ผู้ร่วมวิจัย">ผู้ร่วมวิจัย</option>
                                                </select>

                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="pc[]" id="pc"
                                                    required placeholder="0.00"{{--   onchange="Vpc()"onKeyUp="Vpc();" --}} />
                                                <input type="hidden" name="sum[]" id="sum">
                                            </td>
                                            <td>
                                                <button type="button" name="addBtn" class="btn btn-info"
                                                    id="addBtn">+</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>

                        <div class="row mb-3">
                            <label for="message-text" class="col-sm-2 col-form-label"
                                align="right">แหล่งทุนวิจัย</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="source_id" name="source_id">
                                    <option value="">--เลือกแหล่งทุน--</option>
                                    @foreach ($list_source as $row)
                                        <option value="{{ $row->research_sources_id }}">
                                            {{ $row->research_source_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0" align="right">ประเภทงานวิจัย</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="type"
                                        value="ชุมชนท้องถิ่น">
                                    <label class="form-check-label" for="type">
                                        ชุมชนท้องถิ่น
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="type"
                                        value="ศิลปวัฒนธรรม">
                                    <label class="form-check-label" for="gridRadios2">
                                        ศิลปวัฒนธรรม
                                    </label>
                                </div>

                            </div>

                        </fieldset>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label" align="right">คำสำคัญ</label>
                            <div class="col-sm-10">
                                <textarea name="keyword" id="keyword" placeholder="คำสำคัญในการวิจัย" class="form-control" required></textarea>
                                <span class="text-danger">โปรดใช้เครื่องหมาย , ในการคั่นคำ</span>

                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"
                                align="right">พื้นที่ในการวิจัย</label>
                            <div class="row col-sm-10">
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" placeholder="ที่อยู่" name="address"
                                        required aria-label="ที่อยู่">

                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="จังหวัด" name="city"
                                        aria-label="จังหวัด" required>

                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="รหัสไปรษณีย์" name="zipcode"
                                        aria-label="รหัสไปรษณีย์" required>

                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"
                                align="right">วันที่เริ่มต้นการวิจัย</label>
                            <div class="row col-sm-10">
                                <div class="col-sm">
                                    <input class="form-control" id="sdate" name="sdate" placeholder="MM/DD/YYY"
                                        type="date" required />

                                </div>
                                <label for="inputEmail3" class="col-sm-2 col-form-label "
                                    align="right">วันที่สิ้นสุดการวิจัย</label>
                                <div class="col-sm">
                                    <div class="col-sm">
                                        <input class="form-control" id="edate" name="edate"
                                            placeholder="MM/DD/YYY" type="date" required />

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"
                                align="right">งบประมาณการวิจัย</label>
                            <div class="col-sm-10">
                                <input name="budage" id="budage" type="number" placeholder="0.00"
                                    class="form-control" required>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label " align="right">ไฟล์ Word</label>
                            <div class=" col-sm-10">
                                <input type="file" name="word" id="word" class=" form-control" required>
                                <span class="text-danger">*ไฟล์ .doc และ .docx เท่านั้น</span>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" align="right">ไฟล์ PDF</label>
                            <div class=" col-sm-10">
                                <input type="file" name="pdf" id="pdf" class=" form-control" required>
                                <span class="text-danger">*ไฟล์ .pdf เท่านั้น</span>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save_research" name="save">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>

                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- modal view detail --}}
    <div class="modal fade" id="viewdetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewdetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewdetailLabel">รายละเอียดโครงร่างงานวิจัย</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <strong for="year" class="col-sm-2 col-form-label" align="right">ปีงบประมาณ</strong>
                        <div class="col-sm-10">
                            <input type="text" class=" form-control-plaintext" id="year" name="year">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="nameTH" class="col-sm-2 col-form-label "
                            align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาไทย</strong>
                        <div class=" col-sm-10">
                            <label class="form-control-plaintext" id="nameTH" name="nameTH"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong for="nameEN" class="col-sm-3 col-form-label"
                            align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</strong>
                        <div class=" col-sm-9">
                            <label class="form-control-plaintext" id="nameEN" name="nameEN"></label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong
                            for="message-text"style="text-align:left;font-weight:600;font-size:18px;background:#fff;border:none"
                            class="pt-3 py-0 card-header">รายชื่อนักวิจัย</strong>
                        <div class="card-body pt-0">
                            <table class="table table-responsive" id="detail_researcher" name="detail_researcher">
                                <thead align="center">
                                    <tr>
                                        <th width="600px" style="font-size: 14px">ลำดับ</th>
                                        <th width="600px" style="font-size: 14px">ชื่อ-นามสกุล</th>
                                        <th width="600px" style="font-size: 14px">สังกัด/คณะ</th>
                                        <th width="300px" style="font-size: 14px">ร้อยละบทบาทในการวิจัย</th>
                                    </tr>
                                </thead>
                                <tbody align="center" id="roleResearch">

                                </tbody>
                            </table>
                        </div>


                    </div>

                    <div class="row mb-3">
                        <strong for="message-text" class="col-sm-3 col-form-label" align="right">แหล่งทุนวิจัย</strong>
                        <div class="col-sm-9">
                            <label class="form-control-plaintext" id="source" name="source_id">
                            </label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-form-label col-sm-3 pt-0" align="right">ประเภทงานวิจัย</strong>
                        <div class="col-sm-9">
                            <label name="type" id="type_re" class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="inputEmail3" class="col-sm-3 col-form-label" align="right">คำสำคัญ</strong>
                        <div class="col-sm-9">
                            <label name="keyword" id="key" placeholder="คำสำคัญในการวิจัย"
                                class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="inputEmail3" class="col-sm-3 col-form-label"
                            align="right">พื้นที่ในการวิจัย</strong>
                        <div class="row col-sm-9">
                            <label id="area" class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="inputEmail3" class="col-sm-3 col-form-label"
                            align="right">วันที่เริ่มต้นการวิจัย</strong>
                        <div class="row col-sm-9">
                            <div class="col-sm">
                                <label class="form-control-plaintext" id="start" name="sdate"></label>
                            </div>
                            <strong for="inputEmail3" class="col-sm-4 col-form-label "
                                align="right">วันที่สิ้นสุดการวิจัย</strong>
                            <div class="col-sm">
                                <div class="col-sm">
                                    <label class="form-control-plaintext" id="end" name="edate"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="inputEmail3" class="col-sm-3 col-form-label"
                            align="right">งบประมาณการวิจัย</strong>
                        <div class="col-sm-9">
                            <label name="budage" id="bud" type="number" class="form-control-plaintext"></label>

                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex mx-5">
                        <a href="{{ route('view.word', ['id' => $item->research_id]) }}" class="btn btn-warning"
                            id="view_word" target="_blank">
                            WORD FILE
                        </a>
                        <a href="{{ route('view.pdf', ['id' => $item->research_id]) }}" class="btn btn-warning"
                            id="view_pdf" target="_blank">
                            PDF FILE
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div class="modal fade" id="editResearch" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editResearchLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="editResearchLabel">แก้ไขโครงร่างงานวิจัย</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add_research" method="POST" enctype="multipart/form-data"
                    action="{{ route('research.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-end align-content-end">
                            <label style="font-size: 10px">
                                @php
                                    echo thaidate('วันlที่ j F พ.ศ.Y เวลา H:i:s');
                                @endphp
                            </label>

                        </div>
                        <div class="row mb-3">
                            <input type="hidden" name="id_users" id="id_users" value="{{ $id }}" />
                            <label for="" id="id"></label>
                            <label for="year_research" class="col-sm-2 col-form-label" align="right">ปีงบประมาณ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="year_research"
                                    value="{{ date('Y') + 544 }}" name="year_research">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="research_nameTH" class="col-sm-2 col-form-label "
                                align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาไทย</label>
                            <div class=" col-sm-10">
                                <textarea class="form-control" id="research_nameTH" name="research_nameTH" required></textarea>

                            </div>

                        </div>
                        <div class="row mb-3">
                            <label for="research_nameEN" class="col-sm-2 col-form-label"
                                align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</label>
                            <div class=" col-sm-10">
                                <textarea class="form-control" id="research_nameEN" name="research_nameEN" required></textarea>

                            </div>

                        </div>
                        <div class="mb-3">
                            <label
                                for="message-text"style="text-align:left;font-weight:600;font-size:18px;background:#fff;border:none"
                                class="pt-3 py-0 card-header">รายชื่อนักวิจัย</label>
                            <div class="card-body pt-0">
                                <table class="table table-responsive" id="tableTap" name="tableTap">
                                    <thead align="center">
                                        <tr>
                                            <th width="600px" style="font-size: 14px">ชื่อ-นามสกุล</th>
                                            <th width="600px" style="font-size: 14px">สังกัด/คณะ</th>
                                            <th width="300px" style="font-size: 14px">บทบาทในการวิจัย</th>
                                            <th width="300px" style="font-size: 14px">ร้อยละบทบาทในการวิจัย</th>
                                            <th width="">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody align="center" id="roleResearch">
                                        <tr id="row[]">
                                            <td>
                                                <input type="text" name="researcher[]" id="researcher"
                                                    value="{{ $data[0]->full_name_th }}" class="form-control" required>
                                            </td>
                                            <td>
                                                <select class="form-select" id="faculty" name="faculty[]">
                                                    <option value="">
                                                        เลือกสังกัด/คณะ
                                                        {{-- {{ $data[0]->organizational }}&nbsp;&nbsp;{{ $data[0]->major }} --}}
                                                    </option>
                                                    @foreach ($list_fac as $row)
                                                        @if ($row->major == '0')
                                                            <option value="{{ $row->id }} ">
                                                                {{ $row->organizational }}</option>
                                                        @else
                                                            <option value="{{ $row->id }}">
                                                                {{ $row->organizational }}&nbsp;&nbsp;{{ $row->major }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select " name="role-research[]" id="role-research">
                                                    <option value="หัวหน้าโครงการวิจัย" selected readonly>
                                                        หัวหน้าโครงการวิจัย</option>
                                                    <option value="ผู้ร่วมวิจัย">ผู้ร่วมวิจัย</option>
                                                </select>

                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="pc[]" id="pc"
                                                    required placeholder="0.00"{{--   onchange="Vpc()"onKeyUp="Vpc();" --}} />
                                                <input type="hidden" name="sum[]" id="sum">
                                            </td>
                                            <td>
                                                <button type="button" name="addBtn" class="btn btn-info"
                                                    id="addBtn">+</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>

                        <div class="row mb-3">
                            <label for="message-text" class="col-sm-2 col-form-label"
                                align="right">แหล่งทุนวิจัย</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="source_id" name="source_id">
                                    <option value="">--เลือกแหล่งทุน--</option>
                                    @foreach ($list_source as $row)
                                        <option value="{{ $row->research_sources_id }}">
                                            {{ $row->research_source_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0" align="right">ประเภทงานวิจัย</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="type"
                                        value="ชุมชนท้องถิ่น">
                                    <label class="form-check-label" for="type">
                                        ชุมชนท้องถิ่น
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="type"
                                        value="ศิลปวัฒนธรรม">
                                    <label class="form-check-label" for="gridRadios2">
                                        ศิลปวัฒนธรรม
                                    </label>
                                </div>

                            </div>

                        </fieldset>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label" align="right">คำสำคัญ</label>
                            <div class="col-sm-10">
                                <textarea name="keyword" id="keyword" placeholder="คำสำคัญในการวิจัย" class="form-control" required></textarea>
                                <span class="text-danger">โปรดใช้เครื่องหมาย , ในการคั่นคำ</span>

                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"
                                align="right">พื้นที่ในการวิจัย</label>
                            <div class="row col-sm-10">
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" placeholder="ที่อยู่" name="address"
                                        required aria-label="ที่อยู่">

                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="จังหวัด" name="city"
                                        aria-label="จังหวัด" required>

                                </div>
                                <div class="col-sm">
                                    <input type="text" class="form-control" placeholder="รหัสไปรษณีย์" name="zipcode"
                                        aria-label="รหัสไปรษณีย์" required>

                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"
                                align="right">วันที่เริ่มต้นการวิจัย</label>
                            <div class="row col-sm-10">
                                <div class="col-sm">
                                    <input class="form-control" id="sdate" name="sdate" placeholder="MM/DD/YYY"
                                        type="date" required />

                                </div>
                                <label for="inputEmail3" class="col-sm-2 col-form-label "
                                    align="right">วันที่สิ้นสุดการวิจัย</label>
                                <div class="col-sm">
                                    <div class="col-sm">
                                        <input class="form-control" id="edate" name="edate"
                                            placeholder="MM/DD/YYY" type="date" required />

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"
                                align="right">งบประมาณการวิจัย</label>
                            <div class="col-sm-10">
                                <input name="budage" id="budage" type="number" placeholder="0.00"
                                    class="form-control" required>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label " align="right">ไฟล์ Word</label>
                            <div class=" col-sm-10">
                                <input type="file" name="word" id="word" class=" form-control" required>
                                <span class="text-danger">*ไฟล์ .doc และ .docx เท่านั้น</span>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" align="right">ไฟล์ PDF</label>
                            <div class=" col-sm-10">
                                <input type="file" name="pdf" id="pdf" class=" form-control" required>
                                <span class="text-danger">*ไฟล์ .pdf เท่านั้น</span>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save_research" name="save">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>

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
        var has_error = {{ $errors->count() > 0 ? 'true' : 'false' }};
        if (has_error) {
            Swal.fire({
                title: 'Error',
                icon: 'error',
                type: 'error',
                html: jQuery("#ERROR_COPY").html(),
                showCloseButton: true,
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#research_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 3
                    },
                    {
                        responsivePriority: 3,
                        targets: 5
                    },
                ],
                lengthMenu: [10, 20, 50, 100, ],
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

            var i = 1;
            $('#addBtn').click(function() {
                i++;
                var tr = '<tr id="row' + i + '">' +
                    '<td><input type="text" name="researcher[]" id="researcher" class="form-control"></td>' +
                    '<td><select class="form-select" id="faculty" name="faculty[]"><option value="">--เลือกสังกัด/คณะ--</option> ' +
                    '@foreach ($list_fac as $row)' +
                    '@if ($row->major == '0')' +
                    '<option value = "{{ $row->id }}" >{{ $row->organizational }} </option>' +
                    '@else' +
                    '<option value = "{{ $row->id }}" >{{ $row->organizational }} &nbsp;&nbsp;{{ $row->major }}</option>' +
                    '@endif' +
                    '@endforeach' +
                    /* tr = tr + select_option(); */
                    +
                    '</td>' +
                    '<td><select class="form-select" name="role-research[]" id="role-research"><option value="หัวหน้าโครงการวิจัย">หัวหน้าโครงการวิจัย</option><option value="ผู้ร่วมวิจัย" selected readonly>ผู้ร่วมวิจัย</option></select></td>' +
                    '<td><input type="number" class="form-control" name="pc[]" id="pc"placeholder="0.00" onchange="Vpc()" /></td>' +
                    '<td><button type="button" id="btnDel" class="btn btn-danger" >-</button></td>' +
                    '</tr>';
                $('#roleResearch').append(tr);
                //alert('id:'.$id.'name:'.$name.'major:'.$major);
            });
        });
        $(document).on('click', '#btnDel', function() {
            $(this).closest('tr').remove();
        });
        $(document).ready(function() {
            var date_input = $('input[name="date"]'); //our date input has the name "date"
            var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
            var options = {
                format: 'dd/mm/yyyy',
                container: container,
                todayHighlight: true,
                autoclose: true,
            };
            date_input.datepicker(options);
        });

        function AddModal() {
            $('#addResearch').modal('toggle');
        }

        function viewDetail(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/view/research/' + id,
                dataType: 'JSON',
                success: function(res) {
                    moment.locale('th');
                    console.log(res.data_re);
                    var data = res.data_re;
                    createRows(res);
                    $('#viewdetail').modal('toggle');
                    //console.log(html);
                    var type_re = data[0].type_research_id;
                    var type = type_re.split('_');
                    //console.log(type);
                    var area_re = data[0].research_area;
                    var area = area_re.split('_');
                    var start = moment(data[0].date_research_start).add(543, 'year').format('Do MMMM YYYY');
                    var end = moment(data[0].date_research_end).add(543, 'year').format('Do MMMM YYYY');
                    // console.log(start);
                    //console.log(area);
                    $('#year').val(data[0].year_research);
                    $('#nameTH').html(data[0].research_th);
                    $('#nameEN').html(data[0].research_en);
                    $('#source').html(data[0].research_source_name);
                    $('#type_re').html(type[0] + ', ' + type[1]);
                    $('#key').html(data[0].keyword);
                    $('#area').html(area[0] + ' ' + area[1] + ' ' + area[2]);
                    $('#start').html(start);
                    $('#end').html(end);
                    $('#bud').html(data[0].budage_research + '.00 บาท');
                }
            })

        }

        function createRows(res) {
            var len = 0;
            $('#detail_researcher tbody').empty(); // Empty <tbody>
            if (res['data_re'] != null) {
                len = res['data_re'].length;

            }
            console.log(len);
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    //var id = response['data_re'][i].full_name_th;
                    var nameth = res['data_re'][i].full_name_th;
                    var major = res['data_re'][i].major;
                    var pc = res['data_re'][i].pc;

                    var tr_str = "<tr>" +
                        "<td align='center'>" + (i + 1) + "</td>" +
                        "<td align='center'>" + nameth + "</td>" +
                        "<td align='center'>" + major + "</td>" +
                        "<td align='center'>" + pc + "</td>" +
                        "</tr>";

                    $("#detail_researcher tbody").append(tr_str);
                }
            } else {
                var tr_str = "<tr>" +
                    "<td align='center' colspan='4'>No record found.</td>" +
                    "</tr>";

                $("#detail_researcher tbody").append(tr_str);
            }
        }

        function cancel_resesrch(id) {
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/view/research/' + id,
                success: function(res) {
                    var data = res.data_re;
                    Swal.fire({
                        title: 'คุณต้องการยกเลิกโครงร่างงานวิจัย?',
                        text: 'ชื่อโครงร่างงานวิจัย : ' + data[0].research_th,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    })
                }
            })

        }

        function edit(id) {
            $('#editResearch').modal('toggle');
            $('#id').html(id);
        }
    </script>
@endpush
