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

                                   <ul class="list-unstyled mb-0">
                                       <div class="row">
                                           <div class="col-lg-12">
                                               <li class="py-0">
                                                   <small class="text-dark">Company Name</small>
                                               </li>
                                               <li>
                                                   @if ($vendor_data->name != '')
                                                       {{ $vendor_data->name }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>
                                           @if ($addmore_data != '')

                                               <div class="row mt-2 mb-2">

                                                   @foreach ($addmore_data as $addmore)
                                                       <div class="col-lg-3">
                                                           <li class="pt-2 pb-0">
                                                               <small class="text-dark">POC Full</small>
                                                           </li>
                                                           <li class="pb-2">
                                                               @if ($addmore && $addmore->poc !== null)
                                                                   {{ $addmore->poc }}
                                                               @else
                                                                   {{ '-' }}
                                                               @endif

                                                           </li>
                                                       </div>
                                                       <div class="col-lg-3">
                                                           <li class="pt-2 pb-0">
                                                               <small class="text-dark">POC Title</small>
                                                           </li>
                                                           <li class="pb-2">
                                                               @if ($addmore && $addmore->poctitle !== null)
                                                                   {{ $addmore->poctitle }}
                                                               @else
                                                                   {{ '-' }}
                                                               @endif
                                                           </li>
                                                       </div>
                                                       <div class="col-lg-3">
                                                           <li class="pt-2 pb-0">
                                                               <small class="text-dark">Company
                                                                   Email</small>
                                                           </li>
                                                           <li class="pb-2">
                                                               @if ($addmore && $addmore->c_email !== null)
                                                                   {{ $addmore->c_email }}
                                                               @else
                                                                   {{ '-' }}
                                                               @endif
                                                           </li>
                                                       </div>
                                                       <div class="col-lg-3">
                                                           <li class="pt-2 pb-0">
                                                               <small class="text-dark">Phone</small>
                                                           </li>
                                                           <li class="pb-2">
                                                               @if ($addmore && $addmore->telephone !== null)
                                                                    @if(isset($addmore->country_code))
                                                                   +{{ $addmore->country_code }} 
                                                                   @endif
                                                                   
                                                                   {{ $addmore->telephone }}
                                                               @else
                                                                   {{ '-' }}
                                                               @endif
                                                           </li>
                                                       </div>
                                                   @endforeach
                                               </div>
                                           @endif
                                           @php
                                                $vendors_services = explode(',',$vendor_data->serviceList);
                                                $services_names = [];
                                                foreach ($vendors_services as $city_id) {
                                                    // Assuming getCityNameById is your helper function
                                                    $services_names[] =  \Helper::servicename(trim($city_id)); // trim to remove any extra whitespace
                                                }
                                                $services_names = implode(',',$services_names);

                                                $vendors_city = explode(',',$vendor_data->city);
                                                $city_names = [];
                                                foreach ($vendors_city as $city_id) {
                                                    // Assuming getCityNameById is your helper function
                                                    $city_names[] =  \Helper::cityname(trim($city_id)); // trim to remove any extra whitespace
                                                }
                                                $city_names = implode(',',$city_names);
                                           @endphp

                                           <div class="col-lg-12">
                                            <li class="py-0">
                                                <small class="text-dark">What services do you offer</small>
                                            </li>
                                            <li>
                                                @if ($services_names != '')
                                                    {{ $services_names }}
                                                @else
                                                    {{ '-' }}
                                                @endif

                                            </li>
                                        </div>


                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Company Website</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->companywebsite != '')
                                                       {{ $vendor_data->companywebsite }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>


                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Company City</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($city_names)
                                                       {{ $city_names }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Company Role</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->crole != '')
                                                       {{ $vendor_data->crole }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif
                                               </li>
                                           </div>

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Parent Company Name</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->parentcname != '')
                                                       {{ $vendor_data->parentcname }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Establishment Date</small>
                                               </li>
                                               <li class="pb-2">
                                                   @php
                                                       $establishment_Date = $vendor_data->establishment_date;
                                                   @endphp
                                                   @if ($establishment_Date != '' && $establishment_Date != '0000-00-00')
                                                       {{ \Carbon\Carbon::parse($establishment_Date)->format('d-m-Y') }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>

                                           <div class="col-lg-6">
                                            <li class="pt-2 pb-0">
                                                <small class="text-dark">Company Logo</small>
                                            </li>
                                            <li class="pb-2">
                                                @if ($vendor_data->company_logo != '')
                                                    <a href="{{ asset('public/upload/vendors/' . $vendor_data->company_logo) }}"
                                                        download>
                                                        <button class="btn btn-primary">Download</button>
                                                    </a>
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </li>
                                        </div>

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">VAT Certificate</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->vatcertificate != '')
                                                       <a href="{{ asset('public/upload/vendors/' . $vendor_data->vatcertificate) }}"
                                                           download>
                                                           <button class="btn btn-primary">Download</button>
                                                       </a>
                                                   @else
                                                       {{ '-' }}
                                                   @endif
                                               </li>
                                           </div>

                                           {{-- <div class="col-lg-2">
                                               <li class="pt-2 pb-0">
                                               </li>
                                               <li class="pt-4">

                                               </li>
                                           </div> --}}


                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">TRN Certificate</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->trncertificate != '')
                                                       <a href="{{ asset('public/upload/vendors/' . $vendor_data->trncertificate) }}"
                                                           download>
                                                           <button class="btn btn-primary">Download</button>
                                                       </a>
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>
                                           {{-- <div class="col-lg-2">
                                               <li class="pt-2 pb-0">
                                               </li>
                                               <li class="pt-4">
                                                   <a href="{{ asset('public/upload/vendors/' . $vendor_data->trncertificate) }}"
                                                       download>
                                                       <button class="btn btn-primary">Download</button>
                                                   </a>
                                               </li>
                                           </div> --}}


                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Trade License</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->tradelicense != '')
                                                       <a href="{{ asset('public/upload/vendors/' . $vendor_data->tradelicense) }}"
                                                           download>
                                                           <button class="btn btn-primary">Download</button>
                                                       </a>
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>
                                           {{-- <div class="col-lg-2">
                                               <li class="pt-2 pb-0">
                                               </li>
                                               <li class="pt-4">
                                                   <a href="{{ asset('public/upload/vendors/' . $vendor_data->tradelicense) }}"
                                                       download>
                                                       <button class="btn btn-primary">Download</button>
                                                   </a>
                                               </li>
                                           </div> --}}

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">TL expiry date</small>
                                               </li>
                                               <li class="pb-2">
                                                   @php
                                                       $Tl_Date = $vendor_data->tlexpiry;
                                                   @endphp
                                                   @if ($Tl_Date != '' && $Tl_Date != '0000-00-00')
                                                       {{ \Carbon\Carbon::parse($Tl_Date)->format('d-m-Y') }}
                                                   @else
                                                       {{ \Carbon\Carbon::parse()->format('-') }}
                                                   @endif
                                               </li>
                                           </div>


                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">No Of Staff</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->staff != '')
                                                       {{ $vendor_data->staff }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Remarks</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->remarks != '')
                                                       {{ $vendor_data->remarks }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Social Media</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->socialmedai != '')
                                                       {{ $vendor_data->socialmedai }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif

                                               </li>
                                           </div>

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Email For Login</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->email != '')
                                                       {{ $vendor_data->email }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif
                                               </li>
                                           </div>

                                           <div class="col-lg-6">
                                               <li class="pt-2 pb-0">
                                                   <small class="text-dark">Company Mobile No</small>
                                               </li>
                                               <li class="pb-2">
                                                   @if ($vendor_data->mobile != '')
                                                   @if(isset($vendor_data->country_code))
                                                                   +{{ $vendor_data->country_code }} 
                                                                   @endif

                                                       {{ $vendor_data->mobile }}
                                                   @else
                                                       {{ '-' }}
                                                   @endif
                                               </li>
                                           </div>
                                       </div>
                                   </ul>
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
