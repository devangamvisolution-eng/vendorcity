   @extends('admin.includes.Template')

   @section('content')




       @php
           $vendor_data = Auth::user();
       @endphp
       {{-- @php
           echo '<pre>';
           print_r($vendor_data);
           echo '</pre>';
           exit();
       @endphp --}}


       <!-- Page Wrapper -->
       <!-- <div class="page-wrapper"> -->
       <div class="content container-fluid">

           @if ($message = Session::get('success'))
               <div class="alert alert-success alert-dismissible fade show">

                   <strong>Success!</strong> {{ $message }}

                   <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

               </div>
           @endif



           <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">

               <strong>Success! </strong><span id="success_message"></span>

               <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->

           </div>

           <div class="row justify-content-lg-center">
               <div class="col-lg-10">

                   <!-- Page Header -->
                   <div class="page-header">
                       <div class="row">
                           <div class="col">
                               <h3 class="page-title">Profile</h3>
                               <ul class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="{{ url('/vendors') }}">Dashboard</a></li>
                                   <li class="breadcrumb-item active">Profile</li>
                               </ul>
                           </div>
                       </div>
                   </div>
                   <!-- /Page Header -->



                   <div class="profile-cover"
                       style="padding: 1.75rem 2rem;position:none;border-radius: 0rem;height:0rem
                   ">

                   </div>

                   <div class="text-center mb-5">
                       <label class="avatar avatar-xxl profile-cover-avatar" for="avatar_upload">
                           @if ($vendor_data->image != '')
                               <img class="avatar-img"
                                   src="{{ asset('public/upload/vendors/small/' . $vendor_data->image) }}"
                                   alt="Profile Image">
                           @else
                               <img class="avatar-img" src="{{ asset('public/upload/avatar.jpg') }}" alt="Profile Image">
                           @endif


                       </label>
                       <h2>{{ $vendor_data->name }} <i class="fas fa-certificate text-primary small" data-toggle="tooltip"
                               data-placement="top" title="" data-original-title="Verified"></i></h2>
                       <ul class="list-inline">

                           @if ($vendor_data->companywebsite != '')
                               <li class="list-inline-item">
                                   <i class="far fa-building"></i> <span>{{ $vendor_data->companywebsite }}</span>
                               </li>
                           @endif

                           @if ($vendor_data->mobile != '')
                               <li class="list-inline-item">
                                   <i class="ion-ipod"></i> <span>{{ $vendor_data->mobile }}</span>
                               </li>
                           @endif

                       </ul>
                   </div>

                   <div class="row">
                       <div class="col-lg-12">


                           @php
                               $addmore_data = DB::table('vendors_attribute')
                                   ->where('pid', $vendor_data->id)
                                   ->get();
                           @endphp

                           <div class="card">
                               <div class="card-header">
                                   <h5 class="card-title d-flex justify-content-between">
                                       <span>Profile</span>
                                       <a class="btn btn-sm btn-white"
                                           href="{{ route('vendorsprofile.edit', $vendor_data->id) }}">Edit</a>
                                   </h5>
                               </div>
                               <div class="card-body">
                                   @php
                                        $vendors_services = explode(',',$vendor_data->serviceList);
                                        $services_names = [];
                                        foreach ($vendors_services as $city_id) {
                                            $services_names[] =  \Helper::servicename(trim($city_id)); 
                                        }
                                        $services_names = implode(', ',$services_names);

                                        $vendors_city = explode(',',$vendor_data->city);
                                        $city_names = [];
                                        foreach ($vendors_city as $city_id) {
                                            $city_names[] =  \Helper::cityname(trim($city_id)); 
                                        }
                                        $city_names = implode(', ',$city_names);
                                   @endphp
                                   <!-- Company Overview -->
                                   <h6 class="card-title text-primary mb-3"><i class="fas fa-building me-2"></i> Company Overview</h6>
                                   <div class="row mb-4">
                                       <div class="col-md-4 mb-3">
                                           <p class="text-muted mb-1 small">Company Name</p>
                                           <h6 class="mb-0">{{ $vendor_data->name ?: '-' }}</h6>
                                       </div>
                                       <div class="col-md-4 mb-3">
                                           <p class="text-muted mb-1 small">Company Website</p>
                                           <h6 class="mb-0">{{ $vendor_data->companywebsite ?: '-' }}</h6>
                                       </div>
                                       <div class="col-md-4 mb-3">
                                           <p class="text-muted mb-1 small">Company City</p>
                                           <h6 class="mb-0">{{ $city_names ?: '-' }}</h6>
                                       </div>
                                       <div class="col-md-8 mb-3">
                                           <p class="text-muted mb-1 small">Services Offered</p>
                                           <h6 class="mb-0">{{ $services_names ?: '-' }}</h6>
                                       </div>
                                       <div class="col-md-4 mb-3">
                                           <p class="text-muted mb-1 small">Number of Staff</p>
                                           <h6 class="mb-0">{{ $vendor_data->staff ?: '-' }}</h6>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <p class="text-muted mb-1 small">Remarks</p>
                                           <h6 class="mb-0">{{ $vendor_data->remarks ?: '-' }}</h6>
                                       </div>
                                   </div>
                               
                                   <hr>
                                   <!-- Points of Contact -->
                                   <h6 class="card-title text-primary mb-3"><i class="fas fa-users me-2"></i> Points of Contact</h6>
                                   @if(count($addmore_data) > 0)
                                       <div class="table-responsive mb-4">
                                           <table class="table table-bordered table-sm">
                                               <thead class="table-light">
                                                   <tr>
                                                       <th>POC Full</th>
                                                       <th>Title</th>
                                                       <th>Email</th>
                                                       <th>Phone</th>
                                                   </tr>
                                               </thead>
                                               <tbody>
                                                   @foreach ($addmore_data as $addmore)
                                                   <tr>
                                                       <td>{{ $addmore->poc ?: '-' }}</td>
                                                       <td>{{ $addmore->poctitle ?: '-' }}</td>
                                                       <td>{{ $addmore->c_email ?: '-' }}</td>
                                                       <td>
                                                           @if ($addmore->telephone)
                                                               {{ isset($addmore->country_code) ? '+' . $addmore->country_code . ' ' : '' }}{{ $addmore->telephone }}
                                                           @else
                                                               -
                                                           @endif
                                                       </td>
                                                   </tr>
                                                   @endforeach
                                               </tbody>
                                           </table>
                                       </div>
                                   @else
                                       <p class="text-muted mb-4 small">No Points of Contact added.</p>
                                   @endif
                               
                                   <hr>
                                   <!-- Contact Details -->
                                   <h6 class="card-title text-primary mb-3"><i class="fas fa-address-book me-2"></i> Contact Details</h6>
                                   <div class="row mb-4">
                                       <div class="col-md-6 mb-3">
                                           <p class="text-muted mb-1 small">Email for Login</p>
                                           <h6 class="mb-0">{{ $vendor_data->email ?: '-' }}</h6>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <p class="text-muted mb-1 small">Company Mobile No</p>
                                           <h6 class="mb-0">
                                               @if ($vendor_data->mobile)
                                                   {{ isset($vendor_data->country_code) ? '+' . $vendor_data->country_code . ' ' : '' }}{{ $vendor_data->mobile }}
                                               @else
                                                   -
                                               @endif
                                           </h6>
                                       </div>
                                   </div>
                               
                                   <hr>
                                   <!-- Legal & Documents -->
                                   <h6 class="card-title text-primary mb-3"><i class="fas fa-file-contract me-2"></i> Legal & Documents</h6>
                                   <div class="row">
                                       <!-- TRN / VAT -->
                                       <div class="col-md-6 mb-3">
                                           <div class="p-3 border rounded h-100 bg-light">
                                               <p class="text-muted mb-1 small">TRN Certificate Number</p>
                                               <h6 class="mb-3">{{ $vendor_data->trn_certificate_number ?: '-' }}</h6>
                                               <p class="text-muted mb-1 small">VAT Certificate</p>
                                               @if ($vendor_data->vatcertificate)
                                                   <a href="{{ asset('public/upload/vendors/' . $vendor_data->vatcertificate) }}" class="btn btn-sm btn-outline-primary" download><i class="fas fa-download"></i> Download</a>
                                               @else
                                                   <h6>-</h6>
                                               @endif
                                           </div>
                                       </div>
                                       
                                       <!-- Trade License -->
                                       <div class="col-md-6 mb-3">
                                           <div class="p-3 border rounded h-100 bg-light">
                                               <p class="text-muted mb-1 small">Trade License Number</p>
                                               <h6 class="mb-3">{{ $vendor_data->trade_license_number ?: '-' }}</h6>
                                               
                                               <p class="text-muted mb-1 small">TL Expiry Date</p>
                                               <h6 class="mb-3">
                                                   @if ($vendor_data->tlexpiry && $vendor_data->tlexpiry != '0000-00-00')
                                                       {{ \Carbon\Carbon::parse($vendor_data->tlexpiry)->format('d-m-Y') }}
                                                       @php
                                                           $tlDate = \Carbon\Carbon::parse($vendor_data->tlexpiry);
                                                           $daysUntil = \Carbon\Carbon::now()->diffInDays($tlDate, false);
                                                       @endphp
                                                       @if ($tlDate->isPast())
                                                           <span class="badge bg-danger ms-2">Expired</span>
                                                           <a href="{{ url('vendor/vendorsprofile/' . $vendor_data->id . '/edit#document_section') }}" class="btn btn-sm btn-primary ms-2" style="padding: 2px 8px; font-size: 12px;">Update</a>
                                                       @elseif ($daysUntil <= 60)
                                                           <span class="badge bg-warning text-dark ms-2">Expires soon</span>
                                                           <a href="{{ url('vendor/vendorsprofile/' . $vendor_data->id . '/edit#document_section') }}" class="btn btn-sm btn-primary ms-2" style="padding: 2px 8px; font-size: 12px;">Update</a>
                                                       @endif
                                                   @else
                                                       -
                                                   @endif
                                               </h6>
                               
                                               <p class="text-muted mb-1 small">Trade License File</p>
                                               @if ($vendor_data->tradelicense)
                                                   <a href="{{ asset('public/upload/vendors/' . $vendor_data->tradelicense) }}" class="btn btn-sm btn-outline-primary" download><i class="fas fa-download"></i> Download</a>
                                               @else
                                                   <h6>-</h6>
                                               @endif
                                           </div>
                                       </div>
                                       
                                       <!-- Passport -->
                                       <div class="col-md-6 mb-3">
                                           <div class="p-3 border rounded h-100 bg-light">
                                               <p class="text-muted mb-1 small">Passport Number</p>
                                               <h6 class="mb-3">{{ $vendor_data->passport_number ?: '-' }}</h6>
                                               
                                               <p class="text-muted mb-1 small">Passport Expiry Date</p>
                                               <h6 class="mb-3">
                                                   @if ($vendor_data->passport_expiry && $vendor_data->passport_expiry != '0000-00-00')
                                                       {{ \Carbon\Carbon::parse($vendor_data->passport_expiry)->format('d-m-Y') }}
                                                       @php
                                                           $passDate = \Carbon\Carbon::parse($vendor_data->passport_expiry);
                                                           $daysUntilPass = \Carbon\Carbon::now()->diffInDays($passDate, false);
                                                       @endphp
                                                       @if ($passDate->isPast())
                                                           <span class="badge bg-danger ms-2">Expired</span>
                                                           <a href="{{ url('vendor/vendorsprofile/' . $vendor_data->id . '/edit#document_section') }}" class="btn btn-sm btn-primary ms-2" style="padding: 2px 8px; font-size: 12px;">Update</a>
                                                       @elseif ($daysUntilPass <= 60)
                                                           <span class="badge bg-warning text-dark ms-2">Expires soon</span>
                                                           <a href="{{ url('vendor/vendorsprofile/' . $vendor_data->id . '/edit#document_section') }}" class="btn btn-sm btn-primary ms-2" style="padding: 2px 8px; font-size: 12px;">Update</a>
                                                       @endif
                                                   @else
                                                       -
                                                   @endif
                                               </h6>
                               
                                               <p class="text-muted mb-1 small">Passport File</p>
                                               @if ($vendor_data->passport)
                                                   <a href="{{ asset('public/upload/vendors/' . $vendor_data->passport) }}" class="btn btn-sm btn-outline-primary" download><i class="fas fa-download"></i> Download</a>
                                               @else
                                                   <h6>-</h6>
                                               @endif
                                           </div>
                                       </div>
                                       
                                       <!-- Emirates ID -->
                                       <div class="col-md-6 mb-3">
                                           <div class="p-3 border rounded h-100 bg-light">
                                               <p class="text-muted mb-1 small">Emirates ID Number</p>
                                               <h6 class="mb-3">{{ $vendor_data->emirates_id_number ?: '-' }}</h6>
                                               
                                               <p class="text-muted mb-1 small">Emirates ID Expiry Date</p>
                                               <h6 class="mb-3">
                                                   @if ($vendor_data->emirates_id_expiry && $vendor_data->emirates_id_expiry != '0000-00-00')
                                                       {{ \Carbon\Carbon::parse($vendor_data->emirates_id_expiry)->format('d-m-Y') }}
                                                       @php
                                                           $emDate = \Carbon\Carbon::parse($vendor_data->emirates_id_expiry);
                                                           $daysUntilEm = \Carbon\Carbon::now()->diffInDays($emDate, false);
                                                       @endphp
                                                       @if ($emDate->isPast())
                                                           <span class="badge bg-danger ms-2">Expired</span>
                                                           <a href="{{ url('vendor/vendorsprofile/' . $vendor_data->id . '/edit#document_section') }}" class="btn btn-sm btn-primary ms-2" style="padding: 2px 8px; font-size: 12px;">Update</a>
                                                       @elseif ($daysUntilEm <= 60)
                                                           <span class="badge bg-warning text-dark ms-2">Expires soon</span>
                                                           <a href="{{ url('vendor/vendorsprofile/' . $vendor_data->id . '/edit#document_section') }}" class="btn btn-sm btn-primary ms-2" style="padding: 2px 8px; font-size: 12px;">Update</a>
                                                       @endif
                                                   @else
                                                       -
                                                   @endif
                                               </h6>
                               
                                               <p class="text-muted mb-1 small">Emirates ID File</p>
                                               @if ($vendor_data->emirates_id)
                                                   <a href="{{ asset('public/upload/vendors/' . $vendor_data->emirates_id) }}" class="btn btn-sm btn-outline-primary" download><i class="fas fa-download"></i> Download</a>
                                               @else
                                                   <h6>-</h6>
                                               @endif
                                           </div>
                                       </div>
                                       
                                       <!-- Company Logo -->
                                       <div class="col-md-6 mb-3">
                                           <div class="p-3 border rounded h-100 bg-light">
                                               <p class="text-muted mb-1 small">Company Logo</p>
                                               @if ($vendor_data->company_logo)
                                                   <div class="mb-3">
                                                       <img src="{{ asset('public/upload/vendors/' . $vendor_data->company_logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 80px;">
                                                   </div>
                                                   <a href="{{ asset('public/upload/vendors/' . $vendor_data->company_logo) }}" class="btn btn-sm btn-outline-primary" download><i class="fas fa-download"></i> Download</a>
                                               @else
                                                   <h6>-</h6>
                                               @endif
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>

                       </div>


                   </div>
               </div>
           </div>
       </div>

       <!-- </div> -->
       <!-- /Page Wrapper -->

       </div>
       <!--  /Main Wrapper -->

       <!-- jQuery -->
       <script src="assets/js/jquery-3.6.0.min.js"></script>

       <!-- Bootstrap Core JS -->
       <script src="assets/js/bootstrap.bundle.min.js"></script>

       <!-- Feather Icon JS -->
       <script src="assets/js/feather.min.js"></script>

       <!-- Slimscroll JS -->
       <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

       <!-- Custom JS -->
       <script src="assets/js/script.js"></script>

       </body>

       </html> -->
       {{-- 
       <div class="col">

           <h2 class="page-title">Dashboard</h2>

       </div> --}}

       </div>

       </div>
       {{-- @php

           Now you can access user data

              echo '<pre>';
              print_r(Auth::user()->vendor);
              echo '</pre>';
       @endphp -->
       <h4>Welcome To Auth::user()->name</h4>

       </div> --}}

   @stop
