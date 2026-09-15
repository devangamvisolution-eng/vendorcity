<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FrontLoginRegister;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class MyAccountApiController extends Controller
{
    public function walletAmountCheck(Request $request)
    {
        try {

            $authUser = JWTAuth::parseToken()->authenticate();

            $userId = $request->userId;

            $user = FrontLoginRegister::find($userId);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => []
                ], 404);
            }

            $wallet_plus_amount = DB::table('front_user_wallet')
                ->where('refer_id', $user->id)
                ->where('added_from', 0)
                ->sum('wallet_amount');

            $wallet_minus_amount = DB::table('front_user_wallet')
                ->where('refer_id', $user->id)
                ->where('added_from', 1)
                ->sum('wallet_amount');

            $plusAmountWallet = $wallet_plus_amount ?? 0;
            $minusAmountWallet = $wallet_minus_amount ?? 0;

            $totalAmountWallet = max($plusAmountWallet - $minusAmountWallet, 0);

            $userWalletAmount = $totalAmountWallet;
            $requestAmount = $request->amount ?? 0;

            if ($requestAmount > $userWalletAmount) {

                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient wallet balance.',
                    'data' => [
                        'current_wallet_amount' => $userWalletAmount,
                    ]
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Sufficient wallet balance.',
                'data' => [
                    'current_wallet_amount' => $userWalletAmount,
                ]
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function ratingOrder(Request $request)
    {
        try {

            $authUser = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
                'order_id'       => 'required',
                'rating'         => 'required|integer|min:1|max:5',
                'comments'       => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ], 422);
            }

            $order_data = DB::table('ci_order_item')->where('order_id', $request->order_id)->first();

            if (!$order_data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Order not found.',
                    'data' => []
                ], 404);
            }
            // Check if user already reviewed this service/order
            $alreadyReviewed = DB::table('ci_service_review')
                ->where('user_id', $request->userId)
                ->where('order_id', $request->order_id)
                ->exists();

            if ($alreadyReviewed) {
                return response()->json([
                    'status' => false,
                    'message' => 'Review already given.',
                    'data' => []
                ], 409);
            }

            $reviewId = DB::table('ci_service_review')->insertGetId([
                'order_id'        => $request->order_id,
                'user_id'        => $request->userId,
                'service_id'     => $order_data->service_id,
                'subservice_id' => $order_data->subservice_id,
                'rating'         => $request->rating,
                'comments'       => $request->comments,
                'created_at'     => now(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Review submitted successfully.',
                'data' => [
                    'id' => $reviewId
                ]
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function walletTransactions(Request $request)
    {
        try {
            // Uncomment if JWT auth is strictly enforced for this endpoint
            // $authUser = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
                'userId' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ], 422);
            }

            $userId = $request->userId;
            $searchTerm = $request->search ?? '';

            // Fetch wallet transactions for the user
            $query = DB::table('front_user_wallet')
                ->leftJoin('ci_orders', 'front_user_wallet.order_id', '=', 'ci_orders.order_id')
                ->leftJoin('ci_order_item', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
                ->leftJoin('subservices', 'ci_order_item.subservice_id', '=', 'subservices.id')
                ->select(
                    'front_user_wallet.id',
                    'front_user_wallet.wallet_amount',
                    'front_user_wallet.order_total',
                    'front_user_wallet.added_from',
                    'front_user_wallet.added_date',
                    'ci_orders.order_status',
                    'ci_orders.created_at as booking_date',
                    'subservices.subservicename',
                    'subservices.app_icon as app_icon'
                )
                ->where('front_user_wallet.refer_id', $userId)
                ->orderBy('front_user_wallet.id', 'desc');

            $transactions = $query->get();

            $formattedTransactions = [];

            foreach ($transactions as $txn) {

                // Determine Title (Subservice name)
                $title = "Wallet Top-up";
                if (!empty($txn->subservicename)) {
                    $title = $txn->subservicename;
                }

                // If a search term is provided, filter by title
                if (!empty($searchTerm) && stripos($title, $searchTerm) === false) {
                    continue;
                }

                // Format Date and Time (using booking_date if available, otherwise added_date)
                $targetDate = !empty($txn->booking_date) ? $txn->booking_date : $txn->added_date;
                $dateObj = \Carbon\Carbon::parse($targetDate);
                $formattedDate = $dateObj->format('Y-m-d');

                // Format Amount (wallet amount)
                $sign = ($txn->added_from == 1) ? '-' : '+';
                $amountString = $sign . '' . number_format($txn->wallet_amount, 2);

                // Format Order Total
                $orderTotalString = '' . number_format($txn->order_total ?? 0, 2);

                // Format Status and Color
                $status = "Completed";
                $statusColor = "green";

                if ($txn->added_from == 1 && !empty($txn->order_status)) {
                    $orderStatusLower = strtolower($txn->order_status);
                    if (in_array($orderStatusLower, ['pending', 'in progress', 'new'])) {
                        $status = "In Progress";
                        $statusColor = "blue";
                    } else if (in_array($orderStatusLower, ['cancelled', 'failed'])) {
                        $status = ucfirst($txn->order_status);
                        $statusColor = "red";
                    } else {
                        $status = ucfirst($txn->order_status);
                        $statusColor = "green";
                    }
                }

                // Build App Icon URL
                $appIconUrl = null;
                if (!empty($txn->app_icon)) {
                    $appIconUrl = url('public/upload/subservice/app_icon/' . $txn->app_icon);
                }

                $formattedTransactions[] = [
                    'id' => $txn->id,
                    'title' => $title,
                    'subservice_name' => $txn->subservicename ?? null,
                    'app_icon' => $appIconUrl,
                    // 'date_time' => $formattedDate,
                    'booking_date' => $formattedDate,
                    'wallet_amount' => $amountString,
                    'order_total' => $orderTotalString,
                    'is_deduction' => ($txn->added_from == 1),
                    'order_status' => $txn->order_status,
                ];
            }

            return response()->json([
                'status' => true,
                'message' => 'Transactions fetched successfully.',
                'data' => array_values($formattedTransactions)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function myQuotes(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => []
                ], 404);
            }

            $email = $user->email ?? '';
            $mobile = $user->mobile ?? '';

            if (empty($email) && empty($mobile)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Quotes fetched successfully.',
                    'data' => [
                        'current_page' => 1,
                        'data' => [],
                        'total' => 0
                    ]
                ], 200);
            }

            // Base queries for all tables
            $packages = DB::table('packages_enquiry')
                ->select(
                    'id',
                    'name',
                    'email',
                    'mobile',
                    'service_id',
                    'subservice_id',
                    'inquiry_id',
                    DB::raw("'packages' as type"),
                    'added_date'
                )
                ->where('email', $email)
                ->where('mobile', $mobile)
                ->where('service_id', '!=', 47);

            $wooden = DB::table('wooden_floor_enquiry')
                ->select(
                    'id',
                    'name',
                    'email',
                    'mobile',
                    'service_id',
                    'subservice_id',
                    'inquiry_id',
                    DB::raw("'wooden' as type"),
                    'added_date'
                )
                ->where('email', $email)
                ->where('mobile', $mobile);

            $painting = DB::table('painting_enquiry')
                ->select(
                    'id',
                    'name',
                    'email',
                    'mobile',
                    'service_id',
                    'subservice_id',
                    'inquiry_id',
                    DB::raw("'painting' as type"),
                    'added_date'
                )
                ->where('email', $email)
                ->where('mobile', $mobile);

            $pcgarden = DB::table('packages_enquiry')
                ->select(
                    'id',
                    'name',
                    'email',
                    'mobile',
                    'service_id',
                    'subservice_id',
                    'inquiry_id',
                    DB::raw("'pcgarden' as type"),
                    'added_date'
                )
                ->where('email', $email)
                ->where('mobile', $mobile)
                ->where('service_id', '=', 47);

            // Combine all using unionAll
            $unionQuery = $packages
                ->unionAll($wooden)
                ->unionAll($painting)
                ->unionAll($pcgarden);

            // Fetch and Paginate all quotes ordered by date DESC
            $quotes = DB::query()
                ->fromSub($unionQuery, 'all_enquiries')
                ->orderByDesc('added_date')
                ->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Quotes fetched successfully.',
                'data' => $quotes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function myQuoteDetail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'userId' => 'required',
                'quote_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => []
                ], 422);
            }

            $user = FrontLoginRegister::find($request->userId);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => []
                ], 404);
            }

            $email = $user->email ?? '';
            $mobile = $user->mobile ?? '';
            $quote_id = $request->quote_id;

            $lead = null;
            $type = '';

            // Search in packages_enquiry first
            $lead = DB::table('packages_enquiry')->where('id', $quote_id)->where('email', $email)->where('mobile', $mobile)->first();
            if ($lead) {
                $type = 'packages'; // Note: This handles both general packages and pcgarden since they use the same table
            }

            // If not found, search in wooden_floor_enquiry
            if (!$lead) {
                $lead = DB::table('wooden_floor_enquiry')->where('id', $quote_id)->where('email', $email)->where('mobile', $mobile)->first();
                if ($lead) {
                    $type = 'wooden';
                }
            }

            // If not found, search in painting_enquiry
            if (!$lead) {
                $lead = DB::table('painting_enquiry')->where('id', $quote_id)->where('email', $email)->where('mobile', $mobile)->first();
                if ($lead) {
                    $type = 'painting';
                }
            }

            if (!$lead) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quote not found',
                    'data' => []
                ], 404);
            }

            // Fetch and format accepted vendors
            $acceptedVendorsRaw = DB::table('package_inquiry_accepted')
                ->where('packages_inquiry_id', $quote_id)
                ->get();

            $acceptedVendors = [];
            if ($acceptedVendorsRaw->isNotEmpty()) {
                foreach ($acceptedVendorsRaw as $vendorRaw) {
                    $vendorData = DB::table('users')->where('id', $vendorRaw->vendor_id)->first();
                    $latestQuote = DB::table('qoute_includes')
                        ->where('vendor_id', $vendorRaw->vendor_id)
                        ->where('packages_inquiry_id', $vendorRaw->packages_inquiry_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($vendorData) {
                        $acceptedVendors[] = [
                            'name' => $vendorData->name ?? '',
                            'email' => $vendorData->email ?? '',
                            'mobile' => $vendorData->mobile ?? '',
                            'quote_amount' => $latestQuote->qoute ?? '0'
                        ];
                    }
                }
            }

            // Compile Dynamic Fields for the Mobile App
            $dynamic_fields = [];

            // Add Global Headers that match the web view
            $dynamic_fields[] = ['label' => 'Reference Code', 'value' => $lead->inquiry_id ?? ''];
            $dynamic_fields[] = ['label' => 'Service', 'value' => strip_tags(html_entity_decode(\Helper::servicename($lead->service_id ?? '0')))];
            $dynamic_fields[] = ['label' => 'Sub Service', 'value' => strip_tags(html_entity_decode(\Helper::subservicename($lead->subservice_id ?? '0')))];

            if ($type == 'packages') {
                $packages_enquiry = DB::table('more_formfields_details')->where('package_inquiry_id', $lead->id ?? '0')->get();

                if ($packages_enquiry->isNotEmpty()) {
                    foreach ($packages_enquiry as $packages_enquiry_data) {
                        if ($packages_enquiry_data->formfield_value != '') {
                            $value = $packages_enquiry_data->formfield_value;
                            $isNumeric = is_numeric($value) && $packages_enquiry_data->form_field_id != 30;
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
                            $extension = pathinfo($value, PATHINFO_EXTENSION);

                            $label = \Helper::form_fields($packages_enquiry_data->form_field_id);

                            $final_value = $value;
                            if ($isNumeric) {
                                $final_value = \Helper::form_fields_attr($value);
                            } elseif (in_array(strtolower($extension), $imageExtensions)) {
                                $final_value = url('admin/download/' . $value);
                            }

                            // Extra form fields (e.g. Type of Home: 2 BR)
                            $get_more_id = DB::table('more_formfields_details_att')
                                ->where('form_id', '=', $packages_enquiry_data->form_field_id)
                                ->where('package_inquiry_id', '=', $packages_enquiry_data->package_inquiry_id)
                                ->get();

                            $extra_values = [];
                            if ($get_more_id->isNotEmpty()) {
                                foreach ($get_more_id as $get_more_id_data) {
                                    $extra_values[] = \Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id);
                                }
                            }

                            if (!empty($extra_values)) {
                                $final_value = implode(', ', $extra_values);
                            }

                            $dynamic_fields[] = [
                                'label' => strip_tags(html_entity_decode($label)),
                                'value' => strip_tags(html_entity_decode($final_value))
                            ];
                        }
                    }
                }
            } elseif ($type == 'wooden') {
                $dynamic_fields[] = ['label' => 'Type of Property', 'value' => $lead->property_type ?? ''];
                $dynamic_fields[] = ['label' => 'Area Of Floor', 'value' => $lead->area_of_floor ?? ''];
                $dynamic_fields[] = ['label' => 'Condition Of Floor', 'value' => $lead->condition_of_floor ?? ''];
                $dynamic_fields[] = ['label' => 'Required Service', 'value' => $lead->service_required ?? ''];

                $survey = ($lead->schedule_site_survey === 'yes') ? 'Yes Surveyor will visit the site' : 'Floor Video Uploaded';
                $dynamic_fields[] = ['label' => 'Scheduling Site Survey', 'value' => $survey];

                $address = collect([$lead->city ?? '', $lead->area ?? '', $lead->building_street_no ?? ''])->filter()->implode(', ');
                $dynamic_fields[] = ['label' => 'Address', 'value' => $address];

                $date = collect([$lead->enquiry_month ?? '', $lead->enquiry_date ?? '', $lead->enquiry_year ?? ''])->filter()->implode(', ');
                $dynamic_fields[] = ['label' => 'Date', 'value' => $date];

                $dynamic_fields[] = ['label' => 'Time', 'value' => strip_tags(html_entity_decode(\Helper::timeslotname(strval($lead->time_slot ?? ''))))];
                $dynamic_fields[] = ['label' => 'Describe Wooden Floor Polishing Service', 'value' => $lead->describe_your_requirements ?? ''];
            } elseif ($type == 'painting') {
                $dynamic_fields[] = ['label' => 'Type of Painting', 'value' => $lead->type_of_painting ?? ''];

                $address = collect([$lead->city ?? '', $lead->area ?? '', $lead->building_street_no ?? ''])->filter()->implode(', ');
                $dynamic_fields[] = ['label' => 'Address', 'value' => $address];

                $date = collect([$lead->enquiry_month ?? '', $lead->enquiry_date ?? '', $lead->enquiry_year ?? ''])->filter()->implode(', ');
                $dynamic_fields[] = ['label' => 'Date', 'value' => $date];

                $dynamic_fields[] = ['label' => 'Time', 'value' => strip_tags(html_entity_decode(\Helper::timeslotname(strval($lead->time_slot ?? ''))))];
                $dynamic_fields[] = ['label' => 'Describe Painting Service', 'value' => $lead->describe_painting_service ?? ''];

                if (!empty($lead->no_of_rooms_painted)) {
                    $dynamic_fields[] = ['label' => 'No.of Rooms', 'value' => $lead->no_of_rooms_painted];
                }
                if (!empty($lead->no_of_walls_painted)) {
                    $dynamic_fields[] = ['label' => 'No.of Walls', 'value' => $lead->no_of_walls_painted];
                }
            } elseif ($type == 'pcgarden') {
                $pcgardenData = DB::table('garden_enquiry')->where('inquiry_id', $lead->id)->first();
                if ($pcgardenData) {
                    if (!empty($pcgardenData->service_type)) {
                        $dynamic_fields[] = ['label' => 'Which service do you need quotes for', 'value' => $pcgardenData->service_type];
                    }
                    if (!empty($pcgardenData->service_date)) {
                        $dynamic_fields[] = ['label' => 'When do you need the service', 'value' => $pcgardenData->service_date];
                    }
                    if (!empty($pcgardenData->city)) {
                        $dynamic_fields[] = ['label' => 'Which city do you need the service', 'value' => strip_tags(html_entity_decode(\Helper::cityname(strval($pcgardenData->city))))];
                    }
                    if (!empty($pcgardenData->address)) {
                        $dynamic_fields[] = ['label' => 'Where do you need the service', 'value' => $pcgardenData->address];
                    }
                    if (!empty($pcgardenData->type_of_home)) {
                        $dynamic_fields[] = ['label' => 'What is the type of the unit you live in', 'value' => $pcgardenData->type_of_home];
                    }
                    if (!empty($pcgardenData->size_of_home)) {
                        $dynamic_fields[] = ['label' => 'What is the size of your home', 'value' => $pcgardenData->size_of_home];
                    }
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Quote details fetched successfully.',
                'data' => [
                    'type' => $type,
                    'lead' => $lead,
                    'dynamic_fields' => $dynamic_fields,
                    'acceptedVendors' => $acceptedVendors
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
