<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">

        @php
            $userId = Auth::id();

            $get_user_data = Helper::get_user_data($userId);

            $roleIds = explode(',', $get_user_data->role_id);

            $permission1 = [];

            foreach ($roleIds as $roleId) {
                $roleId = trim($roleId); // Remove any spaces
                $get_permission_data = Helper::get_permission_data($roleId);

                if (
                    is_object($get_permission_data) &&
                    property_exists($get_permission_data, 'permission') &&
                    $get_permission_data->permission !== ''
                ) {
                    $perms = explode(',', $get_permission_data->permission);
                    $permission1 = array_merge($permission1, $perms); // Merge permissions
                }
            }

            // Optional: remove duplicate permissions
            $permission1 = array_unique($permission1);
            // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

            // $permission1 = [];

            // if (
            //     is_object($get_permission_data) &&
            //     property_exists($get_permission_data, 'permission') &&
            //     $get_permission_data->permission !== ''
            // ) {
            //     $permission1 = $get_permission_data->permission;
            //     $permission1 = explode(',', $permission1);
            // } else {
            //     echo '';
            //     // Handle the case where $get_permission_data is not an object or 'permission' property is empty.
            // }
        @endphp

        <ul>
            <li class="menu-title"><span>Main</span></li>
            <li
                class="{{ (request()->segment(1) == 'admin' && request()->segment(2) == '') || request()->segment(1) == 'vendors' || (request()->segment(1) == 'vendor' && request()->segment(2) == 'dashboard') ? 'active' : '' }}">
                @if (Auth::user()->vendor != 1)
                    <a href="{{ url('/admin') }}"><i data-feather="home"></i> <span>Dashboard</span></a>
                @else
                    <a href="{{ url('vendor/dashboard') }}"><i data-feather="home"></i> <span>Dashboard</span></a>
                @endif
            </li>
            @if (Auth::user()->vendor == 1)
                <li class="{{ request()->segment(2) == 'vendorsprofile' ? 'active' : '' }}"><a
                        href="{{ route('vendorsprofile.index') }}"
                        class="{{ request()->segment(2) == 'vendorsprofile' ? 'active' : '' }}">
                        <i class="fa fa-user-plus"></i><span>Profile</span></a>
                </li>

                <li
                    class="{{ request()->segment(2) == 'subscription-details' || request()->segment(2) == 'vendor-invoice' ? 'active' : '' }}">
                    <a href="{{ route('subscription-details.index') }}"
                        class="{{ request()->segment(2) == 'subscription-details' || request()->segment(2) == 'vendor-invoice' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Subscription Details</span></a>
                </li>

                <li class="{{ request()->segment(2) == 'wallet' ? 'active' : '' }}"><a
                        href="{{ route('wallet.index') }}"
                        class="{{ request()->segment(2) == 'wallet' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Wallet</span></a>
                </li>


                {{-- <li
                    class="{{ request()->segment(2) == 'vendorinquiry' || request()->segment(1) == 'enquiry_detail' || request()->segment(1) == 'accpet_form' ? 'active' : '' }}">
                    <a href="{{ route('vendorinquiry.index') }}"
                        class="{{ request()->segment(1) == 'vendorinquiry'  ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Inquiry</span></a>
                </li>


                <li
                    class="{{ request()->segment(2) == 'acceptleads' || request()->segment(1) == 'enquiry_details' ? 'active' : '' }}">
                    <a href="{{ route('acceptleads.index') }}"
                        class="{{ request()->segment(1) == 'acceptleads' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Accepted Leads</span></a>
                </li>
                <li class="{{ request()->segment(2) == 'rejectleads' ? 'active' : '' }}"><a
                        href="{{ route('rejectleads.index') }}"
                        class="{{ request()->segment(1) == 'rejectleads' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Rejected Leads</span></a>
                </li>

                <li
                    class="{{ (request()->segment(2) == 'painting-inquiry' || request()->segment(1) == 'painting-enquiry-detail') ? 'active' : '' }}">
                    <a href="{{ route('painting-inquiry.index') }}"
                        class="{{ (request()->segment(2) == 'painting-inquiry' || request()->segment(1) == 'painting-enquiry-detail') ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Painting Inquiry</span>
                    </a>
                </li>

                <li
                    class="{{ (request()->segment(2) == 'wooden-inquiry' || request()->segment(1) == 'wooden-enquiry-detail') ? 'active' : '' }}">
                    <a href="{{ route('wooden-inquiry.index') }}"
                        class="{{ (request()->segment(2) == 'wooden-inquiry' || request()->segment(1) == 'wooden-enquiry-detail') ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Wooden Floor Polishing </br>Inquiry</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="#"
                        class="{{ (request()->segment(2) == 'garden-inquiry' || request()->segment(1) == 'garden-enquiry-detail') || (request()->segment(2) == 'garden_acceptleads' || request()->segment(1) == 'garden-enquiry-view') || (request()->segment(1) == 'garden_reject_leads') || request()->segment(1) == 'garden_accpet_form' ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i> <span>Garden & Mouse Inquiry</span> <span
                            class="menu-arrow"></span></a>
                    <ul>

                        <li
                            class="{{ (request()->segment(2) == 'garden-inquiry' || request()->segment(1) == 'garden-enquiry-detail') || request()->segment(1) == 'garden_accpet_form' ? 'active' : '' }}">
                            <a href="{{ route('garden-inquiry.index') }}">Inquiry
                            </a>
                        </li>
                        <li
                            class="{{ (request()->segment(2) == 'garden_acceptleads' || request()->segment(1) == 'garden-enquiry-view') ? 'active' : '' }}">
                            <a href="{{ route('garden_acceptleads.index') }}">Accepted Inquiry
                            </a>
                        </li>
                        <li class="{{ (request()->segment(1) == 'garden_reject_leads') ? 'active' : '' }}">
                            <a href="{{ route('garden_reject_leads') }}">Rejected Inquiry
                            </a>
                        </li>

                    </ul>
                </li>

                <li
                    class="{{ request()->segment(2) == 'vendor-commission-report' || request()->segment(1) == 'vendors-filter' ? 'active' : '' }}">
                    <a href="{{ route('vendor-commission-report') }}">
                        <i data-feather="clipboard"></i>
                        <span>Vendor Commission Report</span>
                    </a>
                </li>


                <li class="{{ request()->segment(1) == 'wallet' ? 'active' : '' }}"><a href="{{ route('wallet.index') }}"
                        class="{{ request()->segment(1) == 'wallet' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Wallet</span></a>
                </li>


                <li class="{{ request()->segment(2) == 'driver' ? 'active' : '' }}">
                    <a href="{{ route('driver.index') }}"><i data-feather="truck"></i><span>Driver
                        </span></a>
                </li>


                <li class="{{ request()->segment(2) == 'cleaners' ? 'active' : '' }}">
                    <a href="{{ route('cleaners.index') }}"><i data-feather="users"></i><span>Crew</span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'vendororder' || request()->segment(3) == 'vendor-moving-detail' || request()->segment(2) == 'cleaning-listing' || request()->segment(3) == 'vendor-cleaning-detail'  || request()->segment(2) == 'painting-listing' || request()->segment(3) == 'vendor-painting-detail' || request()->segment(2) == 'salon-spa-listing' || request()->segment(3) == 'vendor-salon-spa-detail' || request()->segment(2) == 'pest-control-listing' || request()->segment(3) == 'vendor-pest-control-detail' ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i> <span>Package Orders</span> <span class="menu-arrow"></span></a>
                    <ul>

                        <li
                            class="{{  request()->segment(2) == 'vendororder' || request()->segment(3) == 'vendor-moving-detail' ? 'active' : '' }}">
                            <a href="{{ route('vendororder.index') }}">Moving Order</a>
                        </li>

                        <li
                            class="{{ Route::currentRouteName() === 'cleaning-listing' || Route::currentRouteName() === 'vendor-cleaning-detail' ? 'active' : '' }}">
                            <a href="{{ route('cleaning-listing') }}">Cleaning Order</a>
                        </li>

                        <li
                            class="{{ Route::currentRouteName() === 'painting-listing' || Route::currentRouteName() === 'vendor-painting-detail' ? 'active' : '' }}">
                            <a href="{{ route('painting-listing') }}">Painting Order</a>
                        </li>

                        <li
                            class="{{ Route::currentRouteName() === 'salon-spa-listing' || Route::currentRouteName() === 'vendor-salon-spa-detail' ? 'active' : '' }}">
                            <a href="{{ route('salon-spa-listing') }}">Salon & Spa Order</a>
                        </li>

                        <li
                            class="{{ Route::currentRouteName() === 'pest-control-listing' || Route::currentRouteName() === 'vendor-pest-control-detail' ? 'active' : '' }}">
                            <a href="{{ route('pest-control-listing') }}">Pest Control Order</a>
                        </li>
                    </ul>
                </li> --}}
            @endif
            {{-- @if (Auth::user()->vendor != 1) --}}
            @if (in_array('1', $permission1) ||
                    in_array('2', $permission1) ||
                    in_array('3', $permission1) ||
                    in_array('4', $permission1) ||
                    in_array('5', $permission1) ||
                    in_array('34', $permission1) ||
                    in_array('35', $permission1) ||
                    in_array('43', $permission1) ||
                    in_array('70', $permission1) ||
                    in_array('71', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'country' || request()->segment(2) == 'state' || request()->segment(2) == 'city' || request()->segment(2) == 'service' || request()->segment(2) == 'subservice' || request()->segment(2) == 'bulk_upload_city' || request()->segment(2) == 'company-employees' || request()->segment(2) == 'company-profile' ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i> <span> Master</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if (in_array('43', $permission1))
                            <li class="{{ request()->segment(2) == 'continent' ? 'active' : '' }}"><a
                                    href="{{ route('continent.index') }}"
                                    class="{{ request()->segment(2) == 'continent' ? 'active' : '' }}">Continent</a>
                            </li>
                        @endif
                        @if (in_array('1', $permission1))
                            <li class="{{ request()->segment(2) == 'country' ? 'active' : '' }}"><a
                                    href="{{ route('country.index') }}"
                                    class="{{ request()->segment(2) == 'country' ? 'active' : '' }}">Country</a>
                            </li>
                        @endif
                        @if (in_array('2', $permission1))
                            <li class="{{ request()->segment(2) == 'state' ? 'active' : '' }}"><a
                                    href="{{ route('state.index') }}"
                                    class="{{ request()->segment(2) == 'state' ? 'active' : '' }}">State</a>
                            </li>
                        @endif
                        @if (in_array('3', $permission1))
                            <li class="{{ request()->segment(2) == 'city' ? 'active' : '' }}"><a
                                    href="{{ route('city.index') }}"
                                    class="{{ request()->segment(2) == 'city' || request()->segment(2) == 'bulk_upload_city' ? 'active' : '' }}">City</a>
                            </li>
                        @endif
                        @if (in_array('4', $permission1))
                            <li class="{{ request()->segment(2) == 'service' ? 'active' : '' }}"><a
                                    href="{{ route('service.index') }}"
                                    class="{{ request()->segment(2) == 'service' ? 'active' : '' }}">Service</a>
                            </li>
                        @endif
                        @if (in_array('5', $permission1))
                            <li class="{{ request()->segment(2) == 'subservice' ? 'active' : '' }}"><a
                                    href="{{ route('subservice.index') }}"
                                    class="{{ request()->segment(2) == 'subservice' ? 'active' : '' }}">Sub
                                    Service</a>
                            </li>
                        @endif

                        @if (in_array('35', $permission1))
                            <li class="{{ request()->segment(2) == 'coupan' ? 'active' : '' }}">
                                <a href="{{ route('coupan.index') }}"
                                    class="{{ request()->segment(2) == 'coupan' ? 'active' : '' }}">Coupon</a>
                            </li>
                        @endif

                        @if (in_array('70', $permission1))
                            <li class="{{ request()->segment(2) == 'company-profile' ? 'active' : '' }}">
                                <a href="{{ route('company-profile.edit', 1) }}"
                                    class="{{ request()->segment(2) == 'company-profile' ? 'active' : '' }}">Company
                                    Profile</a>
                            </li>
                        @endif

                        @if (in_array('71', $permission1))
                            <li class="{{ request()->segment(2) == 'company-employees' ? 'active' : '' }}">
                                <a href="{{ route('company-employees.index') }}"
                                    class="{{ request()->segment(2) == 'comapny-employees' ? 'active' : '' }}">Company
                                    Employees</a>
                            </li>
                        @endif

                    </ul>
                </li>

            @endif
            {{-- @endif --}}

            {{-- @if (Auth::user()->vendor != 1) --}}

            @if (in_array('8', $permission1))
                <li class="{{ request()->segment(2) == 'vendors' ? 'active' : '' }}"><a
                        href="{{ route('vendors.index') }}"
                        class="{{ request()->segment(2) == 'vendors' ? 'active' : '' }}">
                        <i class="fa fa-users"></i><span>Vendors</span></a>
                </li>
            @endif

            @if (in_array('66', $permission1))
                <li class="{{ request()->segment(2) == 'vendorbookedtimeslot' ? 'active' : '' }}"><a
                        href="{{ route('vendorbookedtimeslot.lists') }}"
                        class="{{ request()->segment(2) == 'vendorbookedtimeslot' ? 'active' : '' }}">
                        <i class="fa fa fa-calendar-alt"></i><span>Vendors Booked Timeslot</span></a>
                </li>
            @endif

            @if (in_array('9', $permission1))
                <li class="{{ request()->segment(2) == 'price' ? 'active' : '' }}"><a
                        href="{{ route('price.edit', 1) }}"
                        class="{{ request()->segment(2) == 'price' ? 'active' : '' }}">
                        <i data-feather="credit-card"></i><span>Vendor Listing Price</span></a>
                </li>
            @endif

            @if (in_array('15', $permission1))
                <li class="{{ request()->segment(2) == 'faq' ? 'active' : '' }}"><a href="{{ route('faq.index') }}"
                        class="{{ request()->segment(2) == 'faq' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>FAQ</span></a>
                </li>
            @endif
            @if (in_array('54', $permission1))
                <li class="{{ request()->segment(2) == 'help' ? 'active' : '' }}"><a href="{{ route('help.index') }}"
                        class="{{ request()->segment(2) == 'help' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Help</span></a>
                </li>
            @endif
            @if (in_array('10', $permission1))
                <li class="{{ request()->segment(2) == 'cms' ? 'active' : '' }}"><a href="{{ route('cms.index') }}"
                        class="{{ request()->segment(2) == 'cms' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>CMS</span></a>
                </li>
            @endif

            @if (in_array('24', $permission1))
                <li class="{{ request()->segment(1) == 'system' ? 'active' : '' }}"><a
                        href="{{ route('system.edit', '1') }}">
                        <i class="fa fa-file"></i><span>System</span></a>
                </li>
            @endif

            @if (in_array('18', $permission1))
                <li class="{{ request()->segment(2) == 'form_field' ? 'active' : '' }}"><a
                        href="{{ route('form_field.index') }}"
                        class="{{ request()->segment(2) == 'form_field' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Form Field</span></a>
                </li>
            @endif

            @if (in_array('16', $permission1))
                <li class="{{ request()->segment(2) == 'frontuser' ? 'active' : '' }}"><a
                        href="{{ route('frontuser.index') }}"
                        class="{{ request()->segment(2) == 'frontuser' ? 'active' : '' }}">
                        <i data-feather="clipboard"></i><span>Customer Users</span></a>
                </li>
            @endif

            <!-- Survey Orders moved to Package Orders submenu -->

            @if (in_array('31', $permission1))
                <li class="{{ request()->segment(2) == 'enquiry-users' ? 'active' : '' }}">
                    <a href="{{ route('enquiry-users.index') }}"><i data-feather="clipboard"></i>
                        <span>Enquiry Users</span></a>
                </li>
            @endif

            @if (in_array('51', $permission1))

                @if (Auth::user()->vendor == 1)
                    <li class="{{ request()->segment(2) == 'calendar' ? 'active' : '' }}">
                        <a href="{{ route('vendor.calander_lists') }}"><i data-feather="calendar"></i>
                            <span>Calender</span></a>
                    </li>
                @else
                    <li class="{{ request()->segment(2) == 'calendar' ? 'active' : '' }}">
                        <a href="{{ route('calendar.index') }}"><i data-feather="calendar"></i>
                            <span>Calender</span></a>
                    </li>
                @endif

            @endif

            @if (in_array('65', $permission1))
                @if (Auth::user()->vendor == 1)
                    <li class="{{ request()->segment(2) == 'vendorquote' ? 'active' : '' }}">
                        <a href="{{ route('vendorquote.lists') }}"><i class="fas fa-file-alt"></i>
                            <span>Quotation</span></a>
                    </li>
                @endif
            @endif


            @if (in_array('60', $permission1) ||
                    in_array('61', $permission1) ||
                    in_array('62', $permission1) ||
                    in_array('63', $permission1) ||
                    in_array('64', $permission1) ||
                    in_array('72', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'erp_enquiry' || request()->segment(2) == 'erp_survey' || request()->segment(2) == 'erp_quote' || request()->segment(2) == 'erp_acceptedquote' || request()->segment(2) == 'erp_dog' || request()->segment(2) == 'erp_rejectedquote' ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i> <span> ERP Quotation</span> <span
                            class="menu-arrow"></span></a>
                    <ul>

                        @if (in_array('72', $permission1))
                            <li><a href="{{ route('erp_dog.lists') }}"
                                    class="{{ request()->segment(2) == 'erp_dog' ? 'active' : '' }}">Description
                                    Of Goods</a>
                            </li>
                        @endif

                        @if (in_array('60', $permission1))
                            <li><a href="{{ route('erp_enquiry.lists') }}"
                                    class="{{ request()->segment(2) == 'erp_enquiry' ? 'active' : '' }}">Enquiry</a>
                            </li>
                        @endif

                        @if (in_array('61', $permission1))
                            <li><a href="{{ route('erp_survey.lists') }}"
                                    class="{{ request()->segment(2) == 'erp_survey' ? 'active' : '' }}">Survey</a>
                            </li>
                        @endif


                        @if (in_array('62', $permission1))
                            <li><a href="{{ route('erp_quote.lists') }}"
                                    class="{{ request()->segment(2) == 'erp_quote' ? 'active' : '' }}">Quotation</a>
                            </li>
                        @endif

                        @if (in_array('63', $permission1))
                            <li><a href="{{ route('erp_acceptedquote.lists') }}"
                                    class="{{ request()->segment(2) == 'erp_acceptedquote' ? 'active' : '' }}">Accepted
                                    Quotation</a>
                            </li>
                        @endif

                        @if (in_array('64', $permission1))
                            <li><a href="{{ route('erp_rejectedquote.lists') }}"
                                    class="{{ request()->segment(2) == 'erp_rejectedquote' ? 'active' : '' }}">Rejected
                                    Quotation</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (in_array('28', $permission1) || in_array('29', $permission1) || in_array('30', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(1) == 'cleaning_price' || request()->segment(1) == 'time_slot_price' ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i> <span> Prices</span> <span class="menu-arrow"></span></a>
                    <ul>

                        @if (in_array('28', $permission1))
                            <li><a href="{{ route('cleaning_price.edit', '1') }}"
                                    class="{{ request()->segment(1) == 'cleaning_price' ? 'active' : '' }}">Cleaning
                                    Price</a>
                            </li>
                        @endif

                        @if (in_array('29', $permission1))
                            <li><a href="{{ route('time_slot_price.index') }}"
                                    class="{{ request()->segment(1) == 'time_slot_price' ? 'active' : '' }}">Time
                                    Slot Price</a>
                            </li>
                        @endif

                        @if (in_array('30', $permission1))
                            <li><a href="{{ route('painting-price.edit', '1') }}"
                                    class="{{ request()->segment(1) == 'painting-price' ? 'active' : '' }}">Painting
                                    Price</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->vendor == 0 &&
                    (in_array('77', $permission1) ||
                        in_array('78', $permission1) ||
                        in_array('79', $permission1) ||
                        in_array('80', $permission1)))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'cleaning-subscription-durations' || request()->segment(2) == 'cleaning-subscription-packages' || request()->segment(2) == 'cleaning-subscription-frequencies' || request()->segment(2) == 'cleaning-subscription-pricing' ? 'active' : '' }}">
                        <i data-feather="settings"></i> <span> Cleaning Subscription</span> <span
                            class="menu-arrow"></span>
                    </a>
                    <ul
                        style="display: {{ request()->segment(2) == 'cleaning-subscription-durations' || request()->segment(2) == 'cleaning-subscription-packages' || request()->segment(2) == 'cleaning-subscription-frequencies' || request()->segment(2) == 'cleaning-subscription-pricing' ? 'block' : 'none' }};">
                        @if (in_array('77', $permission1))
                            <li><a href="{{ route('cleaning-subscription-durations.index') }}"
                                    class="{{ request()->segment(2) == 'cleaning-subscription-durations' ? 'active' : '' }}">Manage
                                    Durations</a></li>
                        @endif
                        @if (in_array('78', $permission1))
                            <li><a href="{{ route('cleaning-subscription-frequencies.index') }}"
                                    class="{{ request()->segment(2) == 'cleaning-subscription-frequencies' ? 'active' : '' }}">Manage
                                    Frequencies</a></li>
                        @endif
                        @if (in_array('79', $permission1))
                            <li><a href="{{ route('cleaning-subscription-packages.index') }}"
                                    class="{{ request()->segment(2) == 'cleaning-subscription-packages' ? 'active' : '' }}">Manage
                                    Packages</a></li>
                        @endif
                        @if (in_array('80', $permission1))
                            <li><a href="{{ route('cleaning-subscription-pricing.index') }}"
                                    class="{{ request()->segment(2) == 'cleaning-subscription-pricing' ? 'active' : '' }}">Manage
                                    Pricing Rule</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (in_array('21', $permission1) || in_array('25', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'blog' || request()->segment(2) == 'blog_category' ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i> <span> Blog Management</span> <span
                            class="menu-arrow"></span></a>
                    <ul>

                        @if (in_array('21', $permission1))
                            <li class="{{ request()->segment(2) == 'blog' ? 'active' : '' }}"><a
                                    href="{{ route('blog.index') }}">Blogs</a>
                            </li>
                        @endif
                        @if (in_array('25', $permission1))
                            <li class="{{ request()->segment(2) == 'blog_category' ? 'active' : '' }}"><a
                                    href="{{ route('blog_category.index') }}">Blog Category</a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            @if (in_array('11', $permission1) || in_array('12', $permission1) || in_array('69', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'packagecategory' || request()->segment(2) == 'packages' || request()->segment(2) == 'addons' ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i> <span> Package Management</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        @if (in_array('11', $permission1))
                            <li class="{{ request()->segment(2) == 'packagecategory' ? 'active' : '' }}"><a
                                    href="{{ route('packagecategory.index') }}">Package Category</a>
                            </li>
                        @endif
                        @if (in_array('12', $permission1))
                            <li class="{{ request()->segment(2) == 'packages' ? 'active' : '' }}"><a
                                    href="{{ route('packages.index') }}"> Packages</a>
                            </li>
                        @endif
                        @if (in_array('69', $permission1))
                            <li class="{{ request()->segment(2) == 'addons' ? 'active' : '' }}"><a
                                    href="{{ route('addons.lists') }}"> Add Ons</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (in_array('76', $permission1))
                <li class="{{ request()->segment(2) == 'general-enquiries' ? 'active' : '' }}">
                    <a href="{{ route('general-enquiries.index') }}">
                        <i class="fa fa-envelope"></i><span> Enquiry</span>
                    </a>
                </li>
            @endif

            @if (in_array('17', $permission1) || in_array('26', $permission1) || in_array('27', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(1) == 'enquiry' || request()->segment(1) == 'enquiry_page' || request()->segment(1) == 'enquiry_accept' || request()->segment(1) == 'enquiry_reject' || request()->segment(1) == 'enquiry-filter' || request()->segment(2) == 'vendorinquiry' || request()->segment(1) == 'vendor-enquiry-filter' || request()->segment(2) == 'acceptleads' || request()->segment(2) == 'rejectleads' || request()->segment(2) == 'add-enquiry' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Moving & Storage Enquiry</span><span
                            class="menu-arrow"></span></a>
                    <ul>

                        @if (in_array('17', $permission1))
                            @if (Auth::user()->vendor == 1)
                                <li
                                    class="{{ request()->segment(2) == 'vendorinquiry' || request()->segment(1) == 'vendor-enquiry-filter' || request()->segment(1) == 'enquiry_detail' || request()->segment(1) == 'accpet_form' ? 'active' : '' }}">
                                    <a href="{{ route('vendorinquiry.index') }}"
                                        class="{{ request()->segment(1) == 'vendorinquiry' ? 'active' : '' }}">
                                        Leads Enquiry</a>
                                </li>
                            @endif

                            @if (Auth::user()->vendor == 0)
                                <li
                                    class="{{ request()->segment(1) == 'enquiry' || request()->segment(1) == 'enquiry_page' || request()->segment(1) == 'enquiry-filter' || request()->segment(2) == 'add-enquiry' ? 'active' : '' }}">
                                    <a href="{{ route('enquiry.index') }}">
                                        Leads Enquiry</a>
                                </li>
                            @endif
                        @endif

                        @if (in_array('26', $permission1))
                            @if (Auth::user()->vendor == 1)
                                <li
                                    class="{{ request()->segment(2) == 'acceptleads' || request()->segment(1) == 'enquiry_details' ? 'active' : '' }}">
                                    <a href="{{ route('acceptleads.index') }}"
                                        class="{{ request()->segment(1) == 'acceptleads' ? 'active' : '' }}">
                                        Accepted Leads Enquiry</a>
                                </li>
                            @endif
                            @if (Auth::user()->vendor == 0)
                                <li class="{{ request()->segment(1) == 'enquiry_accept' ? 'active' : '' }}">
                                    <a href="{{ route('enquiry_accept') }}">Accepted Leads Enquiry</a>
                                </li>
                            @endif
                        @endif

                        @if (in_array('27', $permission1))
                            @if (Auth::user()->vendor == 1)
                                <li class="{{ request()->segment(2) == 'rejectleads' ? 'active' : '' }}"><a
                                        href="{{ route('rejectleads.index') }}"
                                        class="{{ request()->segment(1) == 'rejectleads' ? 'active' : '' }}">
                                        Rejected Leads Enquiry</a>
                                </li>
                            @endif

                            @if (Auth::user()->vendor == 0)
                                <li class="{{ request()->segment(1) == 'enquiry_reject' ? 'active' : '' }}">
                                    <a href="{{ route('enquiry_reject') }}">Rejected Leads Enquiry</a>
                                </li>
                            @endif
                        @endif

                    </ul>
                </li>
            @endif

            @if (in_array('38', $permission1) || in_array('46', $permission1) || in_array('47', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(1) == 'garden-enquiry' || request()->segment(1) == 'garden-enquiry-view' || request()->segment(1) == 'garden_accept' || request()->segment(1) == 'garden_reject' || request()->segment(1) == 'garden-enquiry-filter' || request()->segment(2) == 'garden-inquiry' || request()->segment(1) == 'garden-enquiry-detail' || request()->segment(1) == 'garden_accpet_form' || request()->segment(2) == 'garden_acceptleads' || request()->segment(1) == 'garden-enquiry-view' || request()->segment(1) == 'garden_reject_leads' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Garden & Mouse Enquiry</span><span
                            class="menu-arrow"></span></a>
                    <ul>

                        @if (in_array('38', $permission1))
                            @if (Auth::user()->vendor == 1)
                                <li
                                    class="{{ request()->segment(2) == 'garden-inquiry' || request()->segment(1) == 'garden-enquiry-detail' || request()->segment(1) == 'garden_accpet_form' ? 'active' : '' }}">
                                    <a href="{{ route('garden-inquiry.index') }}"> Leads Enquiry
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->vendor == 0)
                                <li
                                    class="{{ request()->segment(1) == 'garden-enquiry' || request()->segment(1) == 'garden-enquiry-view' || request()->segment(1) == 'garden-enquiry-filter' ? 'active' : '' }}">
                                    <a href="{{ route('garden-enquiry') }}"> Leads Enquiry</a>
                                </li>
                            @endif
                        @endif

                        @if (in_array('46', $permission1))
                            @if (Auth::user()->vendor == 1)
                                <li
                                    class="{{ request()->segment(2) == 'garden_acceptleads' || request()->segment(1) == 'garden-enquiry-view' ? 'active' : '' }}">
                                    <a href="{{ route('garden_acceptleads.index') }}">Accepted Leads Enquiry
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->vendor == 0)
                                <li class="{{ request()->segment(1) == 'garden_accept' ? 'active' : '' }}"><a
                                        href="{{ route('garden_accept') }}"> Accepted Leads Enquiry</a>
                                </li>
                            @endif
                        @endif

                        @if (in_array('47', $permission1))
                            @if (Auth::user()->vendor == 1)
                                <li class="{{ request()->segment(1) == 'garden_reject_leads' ? 'active' : '' }}">
                                    <a href="{{ route('garden_reject_leads') }}">Rejected Leads Enquiry
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->vendor == 0)
                                <li class="{{ request()->segment(1) == 'garden_reject' ? 'active' : '' }}"><a
                                        href="{{ route('garden_reject') }}"> Rejected Leads Enquiry</a>
                                </li>
                            @endif
                        @endif

                    </ul>
                </li>

            @endif

            @if (in_array('32', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(1) == 'painting-enquiry' || request()->segment(1) == 'painting-lead-detail' || request()->segment(2) == 'painting-inquiry' || request()->segment(1) == 'painting-enquiry-detail' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Painting Leads Enquiry</span><span
                            class="menu-arrow"></span></a>
                    <ul>

                        @if (in_array('32', $permission1))
                            @if (Auth::user()->vendor == 1)
                                <li
                                    class="{{ request()->segment(2) == 'painting-inquiry' || request()->segment(1) == 'painting-enquiry-detail' ? 'active' : '' }}">
                                    <a href="{{ route('painting-inquiry.index') }}">
                                        Painting Inquiry
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->vendor == 0)
                                <li
                                    class="{{ request()->segment(1) == 'painting-enquiry' || request()->segment(1) == 'painting-lead-detail' ? 'active' : '' }}">
                                    <a href="{{ route('painting-enquiry') }}">Leads Enquiry</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </li>
            @endif

            @if (in_array('49', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(1) == 'wooden-floor-enquiry' || request()->segment(1) == 'wooden-floor-lead-detail' || request()->segment(2) == 'wooden-inquiry' || request()->segment(1) == 'wooden-enquiry-detail' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Wooden Floor Polishing </br>Leads Enquiry</span><span
                            class="menu-arrow"></span></a>
                    <ul>

                        @if (in_array('32', $permission1))

                            @if (Auth::user()->vendor == 1)
                                <li
                                    class="{{ request()->segment(2) == 'wooden-inquiry' || request()->segment(1) == 'wooden-enquiry-detail' ? 'active' : '' }}">
                                    <a href="{{ route('wooden-inquiry.index') }}">
                                        Leads Enquiry
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->vendor == 0)
                                <li
                                    class="{{ request()->segment(1) == 'wooden-floor-enquiry' || request()->segment(1) == 'wooden-floor-lead-detail' ? 'active' : '' }}">
                                    <a href="{{ route('wooden-floor-enquiry') }}">Leads Enquiry</a>
                                </li>
                            @endif


                        @endif
                    </ul>
                </li>
            @endif

            @if (in_array('74', $permission1))
                <li class="submenu">
                    <a href="#" class="{{ request()->segment(2) == 'evchargingleads' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>EV Charger Installation</span><span
                            class="menu-arrow"></span></a>
                    <ul>

                        @if (in_array('74', $permission1))
                            @if (Auth::user()->vendor == 0)
                                <li class="{{ request()->segment(2) == 'evchargingleads' ? 'active' : '' }}">
                                    <a href="{{ route('evchargingleads.lists') }}">
                                        Leads Enquiry</a>
                                </li>
                            @endif
                        @endif

                    </ul>
                </li>
            @endif

            @if (Auth::user()->vendor == 1)
                @if (in_array('67', $permission1))
                    <li
                        class="{{ Route::is('vendor-all-order') || Route::is('vendor-all-order-detail') ? 'active' : '' }}">
                        <a href="{{ route('vendor-all-order') }}"
                            class="{{ Route::is('vendor-all-order') || Route::is('vendor-all-order-detail') ? 'active' : '' }}">
                            <i class="fa fa-file"></i><span>New Bookings</span></a>
                    </li>
                @endif

            @endif


            @php
                // Get or Create Permission ID for Manpower Order dynamically
                $manpower_perm = \Illuminate\Support\Facades\DB::table('permissions')
                    ->where('pname', 'Manpower Order')
                    ->first();
                if (!$manpower_perm) {
                    $manpower_perm_id = \Illuminate\Support\Facades\DB::table('permissions')->insertGetId([
                        'pname' => 'Manpower Order',
                    ]);
                } else {
                    $manpower_perm_id = $manpower_perm->id;
                }

                // Also dynamically add is_manpower_order column if missing
                if (!\Illuminate\Support\Facades\Schema::hasColumn('ci_orders', 'is_manpower_order')) {
                    \Illuminate\Support\Facades\Schema::table('ci_orders', function ($table) {
                        $table->tinyInteger('is_manpower_order')->default(0)->after('is_survey_order');
                    });
                }

                // 1. Centralized Module Configuration
                $packageOrderModules = [
                    [
                        'id' => '19',
                        'label' => 'Moving',
                        'vendor_route' => 'vendororder.index',
                        'admin_route' => 'order.index',
                        'extra_active' => [
                            'moving_package_order_edit',
                            'moving-detail',
                            'moving-admin-order',
                            'vendor-moving-detail',
                        ],
                    ],
                    [
                        'id' => '40',
                        'label' => 'Cleaning',
                        'vendor_route' => 'cleaning-listing',
                        'admin_route' => 'cleaning_package_order',
                        'extra_active' => [
                            'cleaning_package_order_edit',
                            'cleaning-detail',
                            'cleaning-admin-order',
                            'vendor-cleaning-detail',
                        ],
                    ],
                    /* [
                        'id' => '41',
                        'label' => 'Painting',
                        'vendor_route' => 'painting-listing',
                        'admin_route' => 'painting-service-order',
                        'extra_active' => [
                            'painting-detail',
                            'painting-service-admin-order',
                            'vendor-painting-detail',
                        ],
                    ], */
                    [
                        'id' => '44',
                        'label' => 'Salon & Spa',
                        'vendor_route' => 'salon-spa-listing',
                        'admin_route' => 'salon-spa-order',
                        'extra_active' => [
                            'salon-spa-detail',
                            'salon-spa-admin-order',
                            'vendor-salon-spa-detail',
                            'salon_spa_order_edit',
                        ],
                    ],
                    [
                        'id' => '45',
                        'label' => 'Pest Control',
                        'vendor_route' => 'pest-control-listing',
                        'admin_route' => 'pest-control-order',
                        'extra_active' => [
                            'pest-control-detail',
                            'pest-control-admin-order',
                            'vendor-pest-control-detail',
                            'pest_control_order_edit',
                        ],
                    ],
                    [
                        'id' => '42',
                        'label' => 'Handyman & Service',
                        'vendor_route' => 'handyman-and-service-listing',
                        'admin_route' => 'handyman-service-order',
                        'extra_active' => ['handyman-detail', 'handyman-service-admin-order', 'handyman_order_edit'],
                    ],
                    [
                        'id' => '58',
                        'label' => 'Car Inspection',
                        'vendor_route' => 'car-inspection-order-listing',
                        'admin_route' => 'car-inspection-order',
                        'extra_active' => [
                            'car_inspection_order_edit',
                            'car-inspection-admin-order',
                            'vendor-car-inspection-detail',
                            'car-inspection-order-edit',
                        ],
                    ],
                    [
                        'id' => '59',
                        'label' => 'Automobile',
                        'vendor_route' => 'automobile-vendor-order',
                        'admin_route' => 'automobile-order',
                        'extra_active' => [
                            'vendor-automobile-detail',
                            'automobile_order_edit',
                            'automobile-admin-order',
                        ],
                    ],
                    [
                        'id' => '19',
                        'label' => 'Storage',
                        'vendor_route' => 'storage-vendor-listing',
                        'admin_route' => 'storage_package_order',
                        'extra_active' => ['storage-detail', 'vendor-storage-detail'],
                    ],
                    [
                        'id' => '75',
                        'label' => 'Healthcare At Home',
                        'vendor_route' => 'healthcare_at_home_listing',
                        'admin_route' => 'healthcare_at_home_package_order',
                        'extra_active' => ['vendor-healthcare-at-home-detail', 'healthcare_at_home_detail'],
                    ],
                    [
                        'id' => '81', // Same permission ID as before for Survey Orders
                        'label' => 'Survey Order',
                        'vendor_route' => 'survey-orders.index', // Vendor doesn't have a separate route right now, so use same
        'admin_route' => 'survey-orders.index',
        'extra_active' => [
            'survey-order-detail',
            'survey-orders.edit',
            'survey-orders.create',
            'survey-orders.show',
        ],
    ],
    [
        'id' => $manpower_perm_id ?? '81',
        'label' => 'Manpower Order',
        'vendor_route' => 'manpower-orders.index',
        'admin_route' => 'manpower-orders.index',
        'extra_active' => [
            'manpower-order-detail',
            'manpower-orders.edit',
            'manpower-orders.create',
            'manpower-orders.show',
        ],
    ],
];

$isVendor = Auth::user()->vendor == 1;

// Check if current route is any "Order" related page to activate the parent menu
// We use a wildcard check on the URL path for maximum reliability
$parentActive =
    request()->is('*order*') ||
    request()->is('*listing*') ||
    request()->is('*detail*') ||
    request()->routeIs('moving_package_order_edit')
        ? 'active'
        : '';
            @endphp

            @if (array_intersect(array_column($packageOrderModules, 'id'), $permission1))
                <li class="submenu">
                    <a href="javascript:void(0);" class="{{ $parentActive }}">
                        <i data-feather="pie-chart"></i>
                        <span>{{ $isVendor ? 'Accepted Bookings' : 'Package Orders' }}</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul>
                        @foreach ($packageOrderModules as $module)
                            @if (in_array($module['id'], $permission1))
                                @php
                                    $mainRoute = $isVendor ? $module['vendor_route'] : $module['admin_route'];

                                    // Check if current route matches the main route OR any of the extra detail/edit routes
                                    $isActive =
                                        request()->routeIs($mainRoute) ||
                                        (isset($module['extra_active']) && request()->routeIs($module['extra_active']));
                                @endphp

                                <li class="{{ $isActive ? 'active' : '' }}">
                                    <a href="{{ route($mainRoute) }}">
                                        Order - {{ $module['label'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif
            @if (Auth::user()->vendor == 1)
                @if (in_array('68', $permission1))
                    <li
                        class="{{ Route::is('vendor.rejected_bookings') || Route::is('vendor.rejected_booking_details') ? 'active' : '' }}">
                        <a href="{{ route('vendor.rejected_bookings') }}"
                            class="{{ Route::is('vendor.rejected_bookings') || Route::is('vendor.rejected_booking_details') ? 'active' : '' }}">
                            <i class="fa fa-file"></i><span>Rejected Bookings</span></a>
                    </li>
                @endif
            @endif

            @if (in_array('55', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'vehicle' || request()->segment(2) == 'model' || request()->segment(2) == 'verifybuy-packages' ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i> <span>Inspection Package</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        @if (in_array('56', $permission1))
                            <li class="{{ request()->segment(2) == 'vehicle' ? 'active' : '' }}">
                                <a href="{{ route('vehicle.index') }}">Vehicle</a>
                            </li>
                        @endif
                        @if (in_array('57', $permission1))
                            <li class="{{ request()->segment(2) == 'model' ? 'active' : '' }}">
                                <a href="{{ route('model.index') }}">Model</a>
                            </li>
                        @endif
                        @if (in_array('55', $permission1))
                            <li class="{{ request()->segment(2) == 'verifybuy-packages' ? 'active' : '' }}">
                                <a href="{{ route('verifybuy-packages.index') }}">Package</a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif
            @if (in_array('22', $permission1) ||
                    in_array('33', $permission1) ||
                    in_array('36', $permission1) ||
                    in_array('37', $permission1) ||
                    in_array('73', $permission1) ||
                    in_array('50', $permission1))

                <li class="submenu">
                    <a href="#"
                        class="{{ in_array(request()->segment(2), ['reports-dashboard', 'salesreport', 'sales-report', 'day-report', 'day-report-filter', 'vendor-commission-report', 'cleaner-report', 'salesperson-report']) || in_array(request()->segment(1), ['vendorsubscriptionreport', 'vendors-filter']) ? 'active' : '' }}">
                        <i data-feather="bar-chart-2"></i><span>Reports</span><span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li class="{{ request()->segment(2) == 'reports-dashboard' ? 'active' : '' }}">
                            <a href="{{ route('reports_dashboard') }}">Reports Dashboard</a>
                        </li>
                        @if (in_array('50', $permission1))
                            <li
                                class="{{ request()->segment(2) == 'day-report' || request()->segment(2) == 'day-report-filter' ? 'active' : '' }}">
                                <a href="{{ route('day-report.index') }}">Day Report</a>
                            </li>
                        @endif
                        @if (in_array('22', $permission1))
                            <li
                                class="{{ request()->segment(2) == 'salesreport' || request()->segment(2) == 'sales-report' ? 'active' : '' }}">
                                <a href="{{ route('salesreport.index') }}">Sales Report</a>
                            </li>
                        @endif
                        @if (in_array('33', $permission1))
                            <li
                                class="{{ request()->segment(2) == 'vendor-commission-report' || request()->segment(1) == 'vendors-filter' ? 'active' : '' }}">
                                <a href="{{ route('vendor-commission-report') }}">Vendor Commission</a>
                            </li>
                        @endif
                        @if (in_array('36', $permission1))
                            <li
                                class="{{ request()->segment(1) == 'vendorsubscriptionreport' || request()->segment(1) == 'vendors-filter' ? 'active' : '' }}">
                                <a href="{{ route('vendorsubscriptionreport') }}">Vendor Subscription</a>
                            </li>
                        @endif
                        @if (in_array('37', $permission1))
                            <li class="{{ request()->segment(2) == 'cleaner-report' ? 'active' : '' }}">
                                <a href="{{ route('cleaner-report') }}">Crew Report</a>
                            </li>
                        @endif
                        @if (in_array('73', $permission1))
                            <li class="{{ request()->segment(2) == 'salesperson-report' ? 'active' : '' }}">
                                <a href="{{ route('salesperson_report') }}">Sales Person Report</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


            @if (in_array('14', $permission1))
                <li class="{{ request()->segment(2) == 'adminwallet' ? 'active' : '' }}"><a
                        href="{{ route('adminwallet.index') }}"
                        class="{{ request()->segment(2) == 'adminwallet' ? 'active' : '' }}">
                        <i class="fa fa-file"></i><span>Admin Wallet</span></a>
                </li>
            @endif





            @if (in_array('20', $permission1))
                <li class="{{ request()->segment(2) == 'subscribe' ? 'active' : '' }}">

                    <a href="{{ route('subscribe.index') }}"><i class="fa fa-bell" aria-hidden="true"></i>

                        <span>Subscribe</span></a>

                </li>
            @endif


            @if (in_array('23', $permission1))
                <li class="{{ request()->segment(2) == 'google_review' ? 'active' : '' }}">

                    <a href="{{ route('google_review.index') }}"><i class="fa fa-star" aria-hidden="true"></i>

                        <span>Google Review</span></a>

                </li>
            @endif


            @if (in_array('6', $permission1) ||
                    in_array('7', $permission1) ||
                    in_array('52', $permission1) ||
                    in_array('34', $permission1))
                <li class="submenu">
                    <a href="#"
                        class="{{ request()->segment(2) == 'userpermission' || request()->segment(2) == 'adminuser' || request()->segment(2) == 'driver' || request()->segment(2) == 'cleaners' ? 'active' : '' }}"><i
                            data-feather="user"></i> <span> User Management</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if (in_array('6', $permission1))
                            <li class="{{ request()->segment(2) == 'userpermission' ? 'active' : '' }}">
                                <a href="{{ route('userpermission.index') }}">
                                    <i class="fa fa-hand-o-up"></i> User Permission
                                </a>
                            </li>
                        @endif
                        @if (in_array('7', $permission1))
                            <li class="{{ request()->segment(2) == 'adminuser' ? 'active' : '' }}">
                                <a href="{{ route('adminuser.index') }}"><i data-feather="lock"></i> Admin
                                    User
                                </a>
                            </li>
                        @endif
                        @if (in_array('52', $permission1))
                            <li class="{{ request()->segment(2) == 'driver' ? 'active' : '' }}">
                                <a href="{{ route('driver.index') }}"><i data-feather="truck"></i> Driver
                                </a>
                            </li>
                        @endif
                        @if (in_array('34', $permission1))
                            <li class="{{ request()->segment(2) == 'cleaners' ? 'active' : '' }}">
                                <a href="{{ route('cleaners.index') }}"><i data-feather="users"></i> Crew
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif



            {{-- @endif --}}




        </ul>
    </div>

</div>
