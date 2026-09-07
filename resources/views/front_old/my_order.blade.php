@include('front.includes.header')

<style type="text/css">
    .myaccount-tab-list {
        display: block;
        margin-right: 30px;
        border: 1px solid #EEEEEE;
    }

    .nav {

        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .myaccount-tab-list a {
        font-weight: 500;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 14px 20px;

        border-bottom: 1px solid #EEEEEE;
    }

    .my_purchases_box_section .my_purchases_box_inner {
        display: table;
        width: 100%;
    }

    .my_purchases_box_section .custom-back-g-white {
        background: #fafafa;
        padding: 40px 15px;
        margin-bottom: 30px;
    }

    .my_purchases_box_section .my_purchases_box_inner .purchases_top_part {
        display: table;
        width: 100%;
        padding-bottom: 30px;
        border-bottom: 1px solid #cecece;
    }

    .my_purchases_box_section .track_order {
        text-align: right;
    }

    .my_purchases_box_section .track_order a {
        text-decoration: none;
        display: inline-block;
        font-weight: 700;
        font-size: 14px;
        color: #282828;
        border: 1px solid #cecece;
        padding: 10px 20px;
        vertical-align: middle;
    }


    .purchases_item_box .puchases_item_inner ul.purchaseul li.purchaseli.purchaseli_mob_left {
        width: 30%;
        float: left;
    }

    .purchases_item_box .puchases_item_inner ul.purchaseul li.purchaseli {
        margin: 0;
        padding: 0;
        list-style: none;
        vertical-align: top;
        margin-right: 17px;
        margin-bottom: 40px;
    }

    .my_purchases_box_section .my_purchases_box_inner .purchases_bottom_part {
        display: table;
        width: 100%;
        padding-top: 30px;
    }

    .tab-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        /* max-width: 600px; */
        margin: 0 auto;
        /* padding: 1rem; */
    }

    .nav-tabs {
        width: 100%;

    }

    .nav-item {
        width: 50%;
    }

    .nav-tabs .nav-link {
        font-weight: 600;
        color: #212529;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        width: 100%;
    }

    .nav-tabs .nav-link.active {
        color: #0040E6;
        border-color: #0040E6;
    }

    .appointment-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 1rem 1.25rem;
        margin-top: 1rem;
    }

    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #000;
    }

    .appointment-time {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .appointment-user {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        color: #000;
    }

    .appointment-user svg {
        width: 20px;
        height: 20px;
        color: #0040E6;
    }

    .star-rating {
        color: #f0ad4e;
        font-weight: 600;
        margin-left: 0.25rem;
        user-select: none;
    }

    .status-completed {
        background-color: #ecfdf5;
        color: #059669;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 6px;
        user-select: none;
        white-space: nowrap;
        border: 1px solid #d1fae5;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .upcoming {
        background-image: url(https://deax38zvkau9d.cloudfront.net/prod/assets/static/group-2.jpg?f=webp);
        background-size: contain;
        height: 400px;
        background-repeat: no-repeat;
    }

    .upcoming p {
        color: #000;
        text-align: center;
    }

    .badge-style {
        display: inline-flex;
        align-items: center;
        background-color: #e8f8ff;
        color: #0040E6;
        font-weight: 500;
        font-size: 14px;
        padding: 4px 10px;
        border-radius: 6px;
        margin-top: 5px;
    }

    .verified-user {
        display: flex;
        align-items: center;
        font-weight: 500;
        color: #333;
        font-size: 14px;
        margin-top: 8px;
    }

    .verified-user i {
        font-size: 18px;
        color: #0040E6;
        background-color: #e8f8ff;
        border-radius: 50%;
        padding: 4px;
    }

    /* --- PREMIUM PAGINATION STYLES --- */
    .custom-pagination {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
        width: 100%;
        clear: both;
    }

    .custom-pagination nav {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 1.25rem !important;
        width: 100% !important;
    }

    /* Hide mobile-only defaults */
    .custom-pagination .flex.justify-between.flex-1.sm\:hidden {
        display: none !important;
    }

    /* Container for info and links */
    .custom-pagination .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 1rem !important;
        width: 100% !important;
    }

    /* "Showing X to Y of Z" results */
    .custom-pagination .text-sm.text-gray-700 {
        color: #94a3b8 !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        margin: 0 !important;
        order: 2;
    }

    /* New Premium Pagination Design */
    .custom-new-pagination {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-top: 30px !important;
        margin-bottom: 30px !important;
    }

    .pagination-info {
        color: #64748b !important;
        font-weight: 500 !important;
        font-size: 15px !important;
    }

    .pagination-links {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
    }

    .pagination-link,
    .pagination-active,
    .pagination-ellipsis {
        font-weight: 600 !important;
        font-size: 15px !important;
        text-decoration: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 36px !important;
        height: 36px !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .pagination-link {
        color: #475569 !important;
    }

    .pagination-link:hover {
        color: #0040E6 !important;
        transform: scale(1.1) !important;
    }

    .pagination-active {
        background-color: #0040E6 !important;
        color: #fff !important;
        border-radius: 50% !important;
        box-shadow: 0 4px 10px rgba(0, 64, 230, 0.3) !important;
    }

    .pagination-next {
        color: #0040E6 !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        margin-left: 15px !important;
        font-size: 14px !important;
        letter-spacing: 0.5px !important;
        transition: all 0.2s !important;
    }

    .pagination-next:hover {
        color: #002db3 !important;
        transform: translateX(3px) !important;
    }

    .pagination-next.disabled {
        color: #cbd5e1 !important;
        cursor: not-allowed !important;
    }

    @media (max-width: 640px) {
        .custom-new-pagination {
            flex-direction: column !important;
            gap: 20px !important;
        }
    }


    .mar-btn {
        margin-bottom: 60px;
    }

    section {
        padding: 0px 0px;
        !important;
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        .sidebar-left {
            display: none !important;
        }
    }

    .tip-btn {
        background-color: #0040E6;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s;
    }

    .tip-btn:hover {
        background-color: #0030b3;
    }

    .tip-info {
        font-size: 13px;
        color: #28a745;
        font-weight: 600;
        margin-top: 5px;
    }

    /* Modal Styles */
    .tip-modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .tip-option {
        border: 1px solid #dee2e6;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 10px;
    }

    .tip-option:hover,
    .tip-option.active {
        border-color: #0040E6;
        background-color: #e8f8ff;
        color: #0040E6;
    }

    .custom-tip-input {
        margin-top: 10px;
    }
</style>

<div class="body_content">
    <!-- Our LogIn Area -->
    <section class="our-login mt120">
        <div class="container mar-btn">
            <div class="row">
                <div class="col-lg-4 sidebar-left">
                    @include('front.account_sidebar')
                </div>

                <div class="col-lg-8">

                    <x-my-profile-back-button />

                    <div class="tab-container">
                        <ul class="nav nav-tabs" role="tablist" id="appointmentTabs">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $activeTab == 'upcoming' ? 'active' : '' }}" id="upcoming-tab"
                                    href="?tab=upcoming" role="tab">Upcoming</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $activeTab == 'past' ? 'active' : '' }}" id="past-tab"
                                    href="?tab=past" role="tab">Past</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3" id="appointmentTabsContent">
                            {{-- Upcoming Tab --}}
                            <div class="tab-pane fade {{ $activeTab == 'upcoming' ? 'show active' : '' }}"
                                id="upcoming" role="tabpanel">
                                @if (count($upcomingOrders))
                                    @foreach ($upcomingOrders as $orders)
                                        <a href="{{ route('order-detail', ['id' => $orders->order_id, 'visit_date' => $orders->visit_date]) }}"
                                            class="appointment-card-link">
                                            <div class="appointment-card">
                                                <div class="appointment-header">
                                                    <div>
                                                        <div style="font-size: 16px; font-weight: 700;">
                                                            {!! Helper::subservicename($orders->items[0]->subservice_id) !!}</div>
                                                        <div style="margin-top: 4px;">
                                                            <span class="ref-badge"
                                                                style="background: #eef2ff; color: #0040E6; padding: 4px 15px; border-radius: 30px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block;">
                                                                REF: #{{ $orders->format_order_id }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    @if ($orders->items[0]->service_id != 50)
                                                        <span class="status-completed">Confirmed</span>
                                                    @else
                                                        <span class="status-completed"
                                                            style="background-color: #fef3c7; color: #92400e; border-color: #fde68a;">Awaiting
                                                            Confirmation</span>
                                                    @endif
                                                </div>
                                                @if (!empty($orders->items[0]->how_often_do_you_need_cleaning))
                                                    <div class="order-type badge-style">
                                                        <i class="fas fa-retweet me-1"></i>
                                                        {{ $orders->items[0]->how_often_do_you_need_cleaning }}
                                                    </div>
                                                @endif

                                                <div class="appointment-time mt-2"
                                                    style="font-weight: 600; color: #1e293b;">
                                                    <i class="bi bi-calendar-check me-1"></i>
                                                    {{ date('M d, Y', strtotime($orders->visit_date)) }},
                                                    {!! Helper::timeslotname($orders->items[0]->time_slot) !!}
                                                </div>

                                                @if ($orders->items[0]->service_id == 50 && $orders->items[0]->subservice_id == 92)
                                                    <div class="appointment-user verified-user">
                                                        <i class="fa-regular fa-car"></i>
                                                        <span>{!! Helper::vehiclename($orders->items[0]->verifybuy_vehicle) !!},
                                                            {{ $orders->items[0]->verifybuy_model }}</span>
                                                    </div>
                                                @else
                                                    <div class="appointment-user verified-user">
                                                        <i class="fas fa-user-circle me-2"></i>
                                                        <span>{!! Helper::cleanername_new($orders->items[0]->cleaner_id) !!}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach

                                    <div class="mt-3 mb-4">
                                        {{ $upcomingOrders->appends(['tab' => 'upcoming'])->links('front.pagination') }}
                                    </div>
                                @else
                                    <div class="no-upcoming-wrapper text-center">
                                        <img src="{{ asset('public/images/no-upcoming.png') }}"
                                            alt="No Upcoming Appointments" style="max-width: 300px; margin-top: 20px;">
                                        <p class="mt-3">You don't have any upcoming appointments.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Past Tab --}}
                            <div class="tab-pane fade {{ $activeTab == 'past' ? 'show active' : '' }}" id="past"
                                role="tabpanel">
                                @if (count($pastOrders))
                                    @foreach ($pastOrders as $orders)
                                        <a href="{{ route('order-detail', ['id' => $orders->order_id, 'visit_date' => $orders->visit_date]) }}"
                                            class="appointment-card-link">
                                            <div class="appointment-card">
                                                <div class="appointment-header">
                                                    <div>
                                                        <div style="font-size: 16px; font-weight: 700;">
                                                            {!! Helper::subservicename($orders->items[0]->subservice_id) !!}</div>
                                                        <div style="margin-top: 4px;">
                                                            <span class="ref-badge"
                                                                style="background: #eef2ff; color: #0040E6; padding: 4px 15px; border-radius: 30px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block;">
                                                                REF: #{{ $orders->format_order_id }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <span class="status-completed">Past Visit</span>
                                                </div>

                                                <div class="appointment-time mt-2"
                                                    style="font-weight: 600; color: #1e293b;">
                                                    <i class="bi bi-calendar-check me-1"></i>
                                                    {{ date('M d, Y', strtotime($orders->visit_date)) }},
                                                    {!! Helper::timeslotname($orders->items[0]->time_slot) !!}
                                                </div>

                                                @if (!empty($orders->items[0]->how_often_do_you_need_cleaning))
                                                    <div class="order-type badge-style">
                                                        <i class="fas fa-retweet me-1"></i>
                                                        {{ $orders->items[0]->how_often_do_you_need_cleaning }}
                                                    </div>
                                                @endif

                                                @if ($orders->items[0]->service_id == 50 && $orders->items[0]->subservice_id == 92)
                                                    <div class="appointment-user verified-user">
                                                        <i class="fa-regular fa-car"></i>
                                                        <span>{!! Helper::vehiclename($orders->items[0]->verifybuy_vehicle) !!},
                                                            {{ $orders->items[0]->verifybuy_model }}</span>
                                                    </div>
                                                @else
                                                    <div class="appointment-user verified-user">
                                                        <i class="fas fa-user-circle me-2"></i>
                                                        <span>{!! Helper::cleanername_new($orders->items[0]->cleaner_id) !!}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach

                                    <div class="mt-3 mb-4">
                                        {{ $pastOrders->appends(['tab' => 'past'])->links('front.pagination') }}
                                    </div>
                                @else
                                    <div class="no-upcoming-wrapper text-center">
                                        <img src="{{ asset('public/images/no-upcoming.png') }}"
                                            alt="No past appointments available"
                                            style="max-width: 300px; margin-top: 20px;">
                                        <p class="mt-3">No past appointments available.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('front.includes.footer')

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const tab = urlParams.get('tab') || 'upcoming';
                const triggerEl = document.querySelector(`#${tab}-tab`);
                if (triggerEl) {
                    new bootstrap.Tab(triggerEl).show();
                }
            });
        </script>

        <script>
            function category_validation() {

                var email = jQuery("#email").val();
                if (email == '') {
                    jQuery('#email_error').html("Please Enter Email");
                    jQuery('#email_error').show().delay(0).fadeIn('show');
                    jQuery('#email_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#email').offset().top - 150
                    }, 1000);
                    return false;
                }

                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                if (!filter.test(email)) {

                    jQuery('#email_error').html("Please Enter Valid Email");
                    jQuery('#email_error').show().delay(0).fadeIn('show');
                    jQuery('#email_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#email').offset().top - 150
                    }, 1000);
                    return false;

                }
                var password = jQuery("#password").val();
                if (password == '') {

                    jQuery('#password_error').html("Please Enter Password");
                    jQuery('#password_error').show().delay(0).fadeIn('show');
                    jQuery('#password_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#password').offset().top - 150
                    }, 1000);
                    return false;

                }

                $.ajax({
                    type: "post",
                    url: "{{ url('check_login') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "email": email,
                        "password": password,

                    },
                    success: function(returndata) {
                        if (returndata == 1) {

                            $('#spinner_button').show();

                            $('#submit_button').hide();

                            $('#category_form').submit();

                        } else if (returndata == 2) {
                            // Code for status not equal to 1
                            $('#contact_error_login').html("Account is not active.");
                            $('#contact_error_login').show().delay(2000).fadeOut('show');
                            return false;
                        } else {
                            jQuery('#contact_error_login').html(" Email OR Password Not Valid ");
                            jQuery('#contact_error_login').show().delay(0).fadeIn('show');
                            jQuery('#contact_error_login').show().delay(2000).fadeOut('show');
                            return false;

                        }



                    }
                });




            }
            $(document).ready(function() {
                // Lock both modals on load
                $('#otp_popup_Modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: false // Don't show initially
                });

                $('#email_otp_popup_Modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: false
                });

                // Show if user not logged in
                @if (Session::get('user') == '')
                    $('#otp_popup_Modal').modal('show');
                @endif
            });
        </script>

        <!-- Tip Modal -->
        <div class="modal fade" id="tipModal" tabindex="-1" aria-labelledby="tipModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header tip-modal-header">
                        <h5 class="modal-title" id="tipModalLabel">Add Tip for Order #<span
                                id="tipOrderDisplayId"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('order-add-tip') }}" method="POST" id="tipForm">
                        @csrf
                        <input type="hidden" name="order_id" id="tipOrderId">
                        <input type="hidden" name="visit_date" id="tipVisitDate">
                        <div class="modal-body">
                            <p class="text-muted mb-3">Show your appreciation for the cleaner's great work!</p>
                            <div class="row px-2">
                                <div class="col-4">
                                    <div class="tip-option" onclick="selectTip(5)">Ð5</div>
                                </div>
                                <div class="col-4">
                                    <div class="tip-option" onclick="selectTip(10)">Ð10</div>
                                </div>
                                <div class="col-4">
                                    <div class="tip-option" onclick="selectTip(20)">Ð20</div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="custom_tip" class="form-label font-weight-bold">Custom Amount (Ð)</label>
                                <input type="number" class="form-control" name="tip_amount" id="tip_amount"
                                    min="1" placeholder="Enter amount">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary bg-primary text-white border-0 px-4">Pay
                                Tip</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openTipModal(orderId, displayId, visitDate) {
                document.getElementById('tipOrderId').value = orderId;
                document.getElementById('tipOrderDisplayId').innerText = displayId;
                document.getElementById('tipVisitDate').value = visitDate || '';
                if (visitDate) {
                    document.getElementById('tipOrderDisplayId').innerText += ' (' + visitDate + ')';
                }
                $('#tipModal').modal('show');
            }

            function selectTip(amount) {
                document.getElementById('tip_amount').value = amount;
                // Highlight selection
                document.querySelectorAll('.tip-option').forEach(opt => {
                    opt.classList.remove('active');
                    if (opt.innerText.includes(amount)) {
                        opt.classList.add('active');
                    }
                });
            }
        </script>
