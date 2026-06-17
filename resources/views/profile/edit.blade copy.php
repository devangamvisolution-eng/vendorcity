   @extends('admin.includes.Template')
   @section('content')
       <style>
           .card .card-header {
               padding: 12px 15px 12px 19px !important;
           }
           .profile-cover {
               height: 0px !important;
           }
           .profile-cover-avatar {
               border: 2px solid #03659e !important;
           }
           .card-table .table td,
           .card-table {
               padding: 0.50rem 0.75rem !important;
           }
           .card-table .table th {
               color: #03659e !important;
           }
           .btn-outline-primary {
               color: white !important;
               border: none !important;
               background: #f59f49 !important;
           }
       </style>
       <div class="content container-fluid">
           <div class="success">
               @if ($message = Session::get('login_success'))
                   <div class="alert alert-success alert-dismissible fade show" style="text-align: center;">
                       {{ $message }}
                       <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                   </div>
               @endif
           </div>
           <!-- Page Header -->
           <div class="content container-fluid">
               <div class="row justify-content-lg-center">
                   <div class="col-lg-10">
                       <!-- Page Header -->
                       <div class="page-header">
                           <div class="row">
                               <div class="col">
                                   <h3 class="page-title">Profile</h3>
                                   <ul class="breadcrumb">
                                       <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                       <li class="breadcrumb-item active">Profile</li>
                                   </ul>
                               </div>
                           </div>
                       </div>
                       <!-- /Page Header -->
                       <div class="profile-cover">
                       </div>
                       <div class="text-center mb-5">
                           <label class="avatar avatar-xxl profile-cover-avatar" for="avatar_upload">
                               <img src="{{ asset('public/admin/assets/img/logo.png') }}"
                                   style="object-fit: scale-down !important;" alt="Logo">
                               <input type="file" id="avatar_upload">
                               <!-- <span class="avatar-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 avatar-uploader-icon shadow-soft"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                </span> -->
                           </label>
                           @php
                               $user = Auth::user();
                           @endphp
                           <h2>{{ $user->name }}
                               <!-- <i class="fas fa-certificate text-primary small" data-toggle="tooltip" data-placement="top" title="" data-original-title="Verified"></i> -->
                           </h2>
                           <ul class="list-inline">
                               <li class="list-inline-item">
                                   <i class="fa fa-phone"></i> <span>{{ $user->mobile }}</span>
                               </li>
                               <li class="list-inline-item">
                                   <i class="fas fa-envelope"></i> <span>{{ $user->email }}
                                   </span>
                               </li>
                           </ul>
                       </div>
                       <div class="row">
                           <div class="col-lg-6">
                               <div class="card card-table">
                                   <div class="card-header" style="background: #03659e;">
                                       <h5 class="card-title d-flex justify-content-between">
                                           <span style="color: #fff;">Company Details</span>
                                       </h5>
                                   </div>
                                   <div class="card-body ">
                                       <ul class="list-unstyled mt-3">
                                           @if (isset($comapny_profile->name))
                                               <li>{{ $comapny_profile->name }}
                                               </li><br>
                                           @endif
                                           @if (isset($comapny_profile->website))
                                               <li>
                                                   Website: <a href="{{ $comapny_profile->website }}"
                                                       target="_blank">{{ $comapny_profile->website }}</a>
                                               </li></br>
                                           @endif
                                           @if (isset($comapny_profile->mobile))
                                               <li>
                                                   Tel: {{ $comapny_profile->mobile }}
                                               </li></br>
                                           @endif
                                           @if (isset($comapny_profile->address))
                                               <li>
                                                   Address: {!! html_entity_decode($comapny_profile->address) !!}
                                               </li></br>
                                           @endif
                                           @if (isset($comapny_profile->gmap))
                                               <li>
                                                   G-Map: <a href="{{ $comapny_profile->gmap }}"
                                                       target="_blank">{{ $comapny_profile->gmap }}</a>
                                               </li>
                                           @endif
                                       </ul>
                                   </div>
                               </div>
                           </div>
                           <div class="col-lg-6">
                               <div class="card card-table">
                                   <div class="card-header" style="background: #03659e;">
                                       <div class="row">
                                           <div class="col">
                                               <h5 class="card-title" style="color: #fff;">Company Documents</h5>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="card-body">
                                       <div class="table-responsive">
                                           <table class="table table-hover mb-0">
                                               <thead class="thead-light">
                                                   <tr>
                                                       <th>Title</th>
                                                       <th class="text-right">Action</th>
                                                   </tr>
                                               </thead>
                                               <tbody>
                                                   @if (isset($company_document) && !empty($company_document))
                                                       @foreach ($company_document as $doc)
                                                           <tr>
                                                               <td>{{ $doc->title }}</td>
                                                               <td class="text-right">
                                                                   @if (!empty($doc->document))
                                                                       <a
                                                                           href="{{ route('profile.document_download', $doc->id) }}"class="btn btn-sm btn-white text-success me-2"><i
                                                                               class="fa fa-arrow-down"></i> Download</a>
                                                                   @endif
                                                               </td>
                                                           </tr>
                                                       @endforeach
                                                   @endif
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-xl-12 col-md-8">
                               <div class="card card-table">
                                   <div class="card-header" style="background: #03659e;">
                                       <div class="row">
                                           <div class="col">
                                               <h5 class="card-title" style="color: #fff;">Company Drivers with Document:
                                               </h5>
                                           </div>
                                           <div class="col-auto">
                                               <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm"
                                                   onclick="driver_document_download();">Download</a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="card-body">
                                       <div class="table-responsive">
                                           <form id="driver_form"
                                               action="{{ route('profile.driver_document_download') }}"
                                               enctype="multipart/form-data" method="post">
                                               @csrf
                                               <table class="table table-hover mb-0">
                                                   <thead class="thead-light">
                                                       <tr>
                                                           <th>Select</th>
                                                           <th>Driver Name</th>
                                                           <th>Expiry Date</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       @if (isset($companydrivers) && !empty($companydrivers))
                                                           @foreach ($companydrivers as $driver)
                                                               <tr>
                                                                   <td><input name="selected[]" id="selected[]"
                                                                           value="{{ $driver->id }}" type="checkbox"
                                                                           class="minimal-red"
                                                                           style="height: 15px;width: 15px;border-radius: 0px;color: red;">
                                                                   </td>
                                                                   <td>{{ $driver->name }}</td>
                                                                   <td>{{ $driver->expiry_date_eid }}</td>
                                                               </tr>
                                                           @endforeach
                                                       @endif
                                                   </tbody>
                                               </table>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-xl-12 col-md-8">
                               <div class="card card-table">
                                   <div class="card-header" style="background: #03659e;">
                                       <div class="row">
                                           <div class="col">
                                               <h5 class="card-title" style="color: #fff;">Company Packers with Document:
                                               </h5>
                                           </div>
                                           <div class="col-auto">
                                               <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm"
                                                   onclick="packers_document_download();">Download</a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="card-body">
                                       <div class="table-responsive">
                                           <form id="packers_form"
                                               action="{{ route('profile.packer_document_download') }}" method="post"
                                               enctype="multipart/form-data">
                                               @csrf
                                               <table class="table table-hover mb-0">
                                                   <thead class="thead-light">
                                                       <tr>
                                                           <th>Select</th>
                                                           <th>Packers Name</th>
                                                           <th>Expiry Date</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       @if (isset($companypackers) && !empty($companypackers))
                                                           @foreach ($companypackers as $packer)
                                                               <tr>
                                                                   <td><input name="selected[]" id="selected[]"
                                                                           value="{{ $packer->id }}" type="checkbox"
                                                                           class="minimal-red"
                                                                           style="height: 15px;width: 15px;border-radius: 0px;color: red;">
                                                                   </td>
                                                                   <td>{{ $packer->name }}</td>
                                                                   <td>{{ $packer->expiry_date_eid }}</td>
                                                               </tr>
                                                           @endforeach
                                                       @endif
                                                   </tbody>
                                               </table>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-xl-12 col-md-8">
                               <div class="card card-table">
                                   <div class="card-header" style="background: #03659e;">
                                       <div class="row">
                                           <div class="col">
                                               <h5 class="card-title" style="color: #fff;">Company Office Staff With
                                                   Document:
                                               </h5>
                                           </div>
                                           <div class="col-auto">
                                               <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm"
                                                   onclick="office_staff_document_download();">Download</a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="card-body">
                                       <div class="table-responsive">
                                           <form id="office_staff_form"
                                               action="{{ route('profile.office_staff_document_download') }}"
                                               method="post" enctype="multipart/form-data">
                                               @csrf
                                               <table class="table table-hover mb-0">
                                                   <thead class="thead-light">
                                                       <tr>
                                                           <th>Select</th>
                                                           <th>Office Staff Name</th>
                                                           <th>Expiry Date</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       @if (isset($companyofficestaffs) && !empty($companyofficestaffs))
                                                           @foreach ($companyofficestaffs as $companyofficestaff)
                                                               <tr>
                                                                   <td><input name="selected[]" id="selected[]"
                                                                           value="{{ $companyofficestaff->id }}"
                                                                           type="checkbox" class="minimal-red"
                                                                           style="height: 15px;width: 15px;border-radius: 0px;color: red;">
                                                                   </td>
                                                                   <td>{{ $companyofficestaff->name }}</td>
                                                                   <td>{{ $companyofficestaff->expiry_date_eid }}</td>
                                                               </tr>
                                                           @endforeach
                                                       @endif
                                                   </tbody>
                                               </table>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   @stop
   @section('footer_js')
       <div class="modal custom-modal fade" id="select_one_record" role="dialog">
           <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                   <div class="modal-body">
                       <div class="modal-text text-center">
                           <h3>Please select at least one record to Download</h3>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <script>
           function driver_document_download() {
               var checked = $("#driver_form input:checked").length > 0;
               if (!checked) {
                   $('#select_one_record').modal('show');
               } else {
                   $('#driver_form').submit();
               }
           }
           function packers_document_download() {
               var checked = $("#packers_form input:checked").length > 0;
               if (!checked) {
                   $('#select_one_record').modal('show');
               } else {
                   $('#packers_form').submit();
               }
           }
           function office_staff_document_download() {
               var checked = $("#office_staff_form input:checked").length > 0;
               if (!checked) {
                   $('#select_one_record').modal('show');
               } else {
                   $('#office_staff_form').submit();
               }
           }
       </script>
   @stop
