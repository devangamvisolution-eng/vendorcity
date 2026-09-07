<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\FrontLoginRegister;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class HomeControllerApi extends Controller
{
    public function movingService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|integer',
            'subservice_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $serviceId = $request->service_id;
        $subserviceId = $request->subservice_id;

        $service = DB::table('services')->where('id', $serviceId)->first();

        $subservice = DB::table('subservices')
            ->where('id', $subserviceId)
            ->where('serviceid', $serviceId)
            ->first();

        if (!$service || !$subservice) {
            return response()->json([
                'status' => false,
                'message' => 'Service or Sub-service not found.'
            ], 404);
        }

        // Local Fields Mapping
        $serviceLocalFields = $service->form_fields ?? '';
        $subserviceLocalFields = $subservice->form_fields ?? '';

        $localFieldIdsArray = array_unique(array_merge(
            array_filter(explode(',', $serviceLocalFields)),
            array_filter(explode(',', $subserviceLocalFields))
        ));

        // International Fields Mapping
        $serviceIntlFields = $service->form_fields_two ?? '';
        $subserviceIntlFields = $subservice->form_fields_two ?? '';

        $intlFieldIdsArray = array_unique(array_merge(
            array_filter(explode(',', $serviceIntlFields)),
            array_filter(explode(',', $subserviceIntlFields))
        ));

        // Array of configured pill labels to reuse the existing logic
        $moveTypeLabels = ['Move Type', 'What is the size of your move?', 'What is the size of your home?', 'What is the size of your garden?'];

        // Helper function to fetch and format fields
        $getFormattedFields = function ($fieldIds) use ($moveTypeLabels) {
            if (empty($fieldIds)) {
                return [];
            }

            $fields = DB::table('form_fileds')
                ->whereIn('id', $fieldIds)
                ->orderBy('set_order', 'asc')
                ->get();

            $dynamicFields = [];

            foreach ($fields as $field) {
                $isPill = false;
                foreach ($moveTypeLabels as $moveTypeLabel) {
                    if (stripos($field->lable_name, $moveTypeLabel) !== false) {
                        $isPill = true;
                        break;
                    }
                }

                $fieldData = [
                    'id' => $field->id,
                    'label_name' => $field->lable_name,
                    'type' => $field->type,
                    'is_moveType' => $isPill,
                    'options' => []
                ];

                $attributes = DB::table('form_attributes')
                    ->where('form_id', $field->id)
                    ->get(['id', 'form_option']);

                if ($attributes->isNotEmpty()) {
                    foreach ($attributes as $attr) {
                        $moreAttributes = DB::table('more_form_attributes')
                            ->where('form_id', $field->id)
                            ->where('attr_id', $attr->id)
                            ->get(['id', 'more_form_option']);

                        if ($moreAttributes->isNotEmpty()) {
                            $attr->more_options = $moreAttributes;
                        }
                    }
                    $fieldData['options'] = $attributes;
                }

                $dynamicFields[] = $fieldData;
            }
            return $dynamicFields;
        };

        $localFields = [];
        $internationalFields = [];

        // Apply Sub-Service specific filtering
        if ($subserviceId == 98) {
            $localFields = $getFormattedFields($localFieldIdsArray);
        } elseif ($subserviceId == 99 || $subserviceId == 100) {
            $internationalFields = $getFormattedFields($intlFieldIdsArray);
        } else {
            $localFields = $getFormattedFields($localFieldIdsArray);
            // $internationalFields = $getFormattedFields($intlFieldIdsArray);
        }

        // Dynamically filter which pill labels apply to the currently selected subservice
        $applicablePillLabels = [];
        if ($subserviceId == 98) {
            $applicablePillLabels = ['Move Type', 'What is the size of your home?', 'What is the size of your garden?'];
        } elseif ($subserviceId == 99 || $subserviceId == 100) {
            $applicablePillLabels = ['Move Type', 'What is the size of your move?'];
        } else {
            $applicablePillLabels = $moveTypeLabels;
        }


        if ($subserviceId == 98) {
            return response()->json([
                'status' => true,
                'message' => 'Local Move form fields fetched successfully.',
                'data' => [
                    // 'move_types' => $applicablePillLabels,
                    'form_fields' => $localFields,
                ]
            ], 200);
        } elseif ($subserviceId == 99 || $subserviceId == 100) {
            return response()->json([
                'status' => true,
                'message' => 'International Move form fields fetched successfully.',
                'data' => [
                    // 'form_fields' => $localFields,
                    'form_fields' => $internationalFields
                ]
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Form fields fetched successfully.',
            'data' => [
                // 'move_types' => $applicablePillLabels,
                'form_fields' => $localFields,
            ]
        ], 200);
    }

    public function searchSubservice(Request $request)
    {
        // $query = DB::table('subservices')->select('id as SubserviceId, serviceid, subservicename,page_url')->where('is_active', 0);
        $query = DB::table('subservices')->select(
            'id as SubserviceId',
            'serviceid',
            'subservicename',
            'page_url',
            'app_icon'
        )
            ->where('is_active', 0);

        $countryId = 22;
        $cityId = 17;
        if ($request->has('keyword') && !empty($request->keyword)) {
            $query->where('subservicename', 'like', '%' . $request->keyword . '%');
        }

        $query->whereRaw('FIND_IN_SET(?, country)', [$countryId]);
        $query->whereRaw('FIND_IN_SET(?, city)', [$cityId]);

        // if ($request->has('service_id') && !empty($request->service_id)) {
        //     $query->where('serviceid', $request->service_id);
        // }

        // Support searching by city_id, which is stored as a comma-separated string in the DB
        /* if ($request->has('city_id') && !empty($request->city_id)) {
            $cityId = $request->city_id;
            $query->where(function ($q) use ($cityId) {
                $q->where('city', $cityId)
                    ->orWhere('city', 'like', $cityId . ',%')
                    ->orWhere('city', 'like', '%,' . $cityId . ',%')
                    ->orWhere('city', 'like', '%,' . $cityId);
            });
        } */

        $subservices = $query->orderBy('set_order', 'asc')->get();

        if ($subservices->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No subservices found.',
                'data' => []
            ], 404);
        }

        $subservices->transform(function ($subservice) {
            $subservice->app_image_path = !empty($subservice->app_icon)
                ? asset('public/upload/subservice/app_icon/' . $subservice->app_icon)
                : null;

            unset($subservice->app_icon);

            return $subservice;
        });

        return response()->json([
            'status' => true,
            'message' => 'Subservices fetched successfully.',
            'data' => $subservices
        ], 200);
    }

    public function storeMovingServiceInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|integer',
            'subservice_id' => 'required|integer',
            'fields' => 'nullable|array',
            'fields.*.field_id' => 'required_with:fields|integer',
            'fields.*.field_type' => 'required_with:fields|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $authUser = JWTAuth::parseToken()->authenticate();

        $userdata = auth()->user();

        if (isset($userdata) && $userdata != "" && !empty($userdata)) {
            $data['name'] = $username = $userdata->name;
            $data['email'] = $email = $userdata->email;
            $data['mobile'] = $mobile = $userdata->mobile;
            $data['user_id'] = $userdata->id;
        } else {
            $data['name'] = $username = '';
            $data['email'] = $email = '';
            $data['mobile'] = $mobile = '';
            $data['user_id'] = 0;
        }

        if ($request->pakage_id != '') {
            $data['pakage_id'] = $request->pakage_id;
        }
        if ($request->service_id != '') {
            $data['service_id'] = $request->service_id;
        } elseif ($request->service != '') {
            $data['service_id'] = $request->service;
        }

        if ($request->subservice_id != '') {
            $data['subservice_id'] = $request->subservice_id;
        } elseif ($request->subservice != '') {
            $data['subservice_id'] = $request->subservice;
        }
        if ($request->packagecategory_id != '') {
            $data['packagecategory_id'] = $request->packagecategory_id;
        }

        $data['form_type'] = 'Local Move';
        $data['added_date'] = date('Y-m-d');
        if ((int)$request->subservice_id == 99) {
            $data['form_type'] = 'International Moves';
        }


        if ($request->subservice_id == 94) {
            $data['cron_mail_send'] = 1;
        }

        $package_inquiry = DB::table('packages_enquiry')->insertGetId($data);

        $customerInfo = DB::table('frontloginregisters')->where('id', $data['user_id'])->first();
        if ($customerInfo) {
            // Bypass session checking for API context, directly create the lead for tracking
            $sourceWebsite = DB::table('source_leads')->where('name', 'Website')->first();

            $repeatedSource = DB::table('source_leads')->where('name', 'Repeted Customer')->first();
            $pastOrders = DB::table('ci_orders')->where('user_id', $data['user_id'])->count();
            $sourceWebsiteId = $sourceWebsite ? $sourceWebsite->id : null;
            $repeatedSourceId = $repeatedSource ? $repeatedSource->id : null;
            if ($pastOrders > 0 && $repeatedSourceId) {
                $sourceLeadId = $sourceWebsiteId . ',' . $repeatedSourceId;
            } else {
                $sourceLeadId = $sourceWebsiteId;
            }

            $salespersonId = null;
            if ($pastOrders > 0) {
                $lastOrder = DB::table('ci_orders')
                    ->join('ci_order_item', 'ci_orders.order_id', '=', 'ci_order_item.order_id')
                    ->where('ci_orders.user_id', $data['user_id'])
                    ->whereNotNull('ci_order_item.salesperson_id')
                    ->orderBy('ci_orders.order_id', 'desc')
                    ->select('ci_order_item.salesperson_id')
                    ->first();
                if ($lastOrder) {
                    $salespersonId = $lastOrder->salesperson_id;
                }
            }

            $leadId = DB::table('general_enquiries')->insertGetId([
                'salesperson_id' => $salespersonId,
                'customer_id' => $data['user_id'],
                'customer_name' => $customerInfo->name ?? ($data['name'] ?? null),
                'customer_phone' => $customerInfo->mobile ?? ($data['mobile'] ?? null),
                'customer_email' => $customerInfo->email ?? ($data['email'] ?? null),
                'country_code' => $customerInfo->country_code ?? null,
                'service_id' => $data['service_id'] ?? null,
                'subservice_id' => $data['subservice_id'] ?? null,
                'source_lead_id' => $sourceLeadId,
                'status' => 'Booked',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $package_data_n = DB::table('packages_enquiry')->where('id', $package_inquiry)->first();

        // Ensure \Helper exists or handle Service Name
        $service_name = Helper::servicename($package_data_n->service_id);
        $processed_text = strtoupper(str_replace(' ', '', $service_name));
        $year = date('y');
        $data_u = [];

        if ($request->subservice_id == 23 || $request->subservice_id == 26 || $request->subservice_id == 53 || $request->subservice_id == 94 || $request->subservice_id == 100 || $request->subservice_id == 98) {

            if ($data['form_type'] == 'Local Move') {

                $cityOptionId = null;
                $fields = $request->input('fields', []);

                foreach ($fields as $field) {
                    if (isset($field['field_id']) && $field['field_id'] == 17) {
                        $cityOptionId = is_array($field['value'] ?? null) ? ($field['value'][0] ?? null) : ($field['value'] ?? null);
                        break;
                    }
                }

                $cityOption = DB::table('form_attributes')->where('id', $cityOptionId)->first();
                $CityName = $cityOption->form_option ?? '';

                $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($CityName) . '%'])->first();
                $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

                $subserviceCode = $subserviceData->subservice_code ?? 'OT';
                $cityCode = $cityData->city_code ?? 'DU';

                $year = date('y');
                $lastSequence = DB::table('packages_enquiry')
                    ->where('subservice_code', $subserviceCode)
                    ->where('city_code', $cityCode)
                    ->where('order_year', $year)
                    ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                    ->lockForUpdate()
                    ->value('seq');

                $nextSequence = $lastSequence ? $lastSequence + 1 : 1;
                $formatOrderId = sprintf("%s-%s-%s-%06d", $subserviceCode, $year, $cityCode, $nextSequence);

                $data_u['subservice_code'] = $subserviceCode;
                $data_u['city_code'] = $cityCode;
                $data_u['order_year'] = $year;
                $data_u['sequence_no'] = $nextSequence;
                $data_u['inquiry_id'] = $formatOrderId;
            } else {
                $countryOptionId = null;
                $fields = $request->input('fields', []);

                foreach ($fields as $field) {
                    if (isset($field['field_id']) && $field['field_id'] == 57) {
                        $countryOptionId = is_array($field['value'] ?? null) ? ($field['value'][0] ?? null) : ($field['value'] ?? null);
                        break;
                    }
                }

                $countryOption = DB::table('form_attributes')->where('id', $countryOptionId)->first();
                $CountryName = $countryOption->form_option ?? 'OT';
                $countryCode = mb_strtoupper(mb_substr($CountryName, 0, 3, 'UTF-8'));
                $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = "I" . $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }

                $year = date('y');
                $lastSequence = DB::table('packages_enquiry')
                    ->where('subservice_code', $subserviceCode)
                    ->where('city_code', $countryCode)
                    ->where('order_year', $year)
                    ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                    ->lockForUpdate()
                    ->value('seq');

                $nextSequence = $lastSequence ? $lastSequence + 1 : 1;
                $formatOrderId = sprintf("%s-%s-%s-%06d", $subserviceCode, $year, $countryCode, $nextSequence);

                $data_u['subservice_code'] = $subserviceCode;
                $data_u['city_code'] = $countryCode;
                $data_u['order_year'] = $year;
                $data_u['sequence_no'] = $nextSequence;
                $data_u['inquiry_id'] = $formatOrderId;
            }
        }

        if ($request->subservice_id == 31) {
            // vehicle shipping
            $countryOptionId = null;
            $fields = $request->input('fields', []);

            foreach ($fields as $field) {
                if (isset($field['field_id']) && $field['field_id'] == 39) {
                    $countryOptionId = is_array($field['value'] ?? null) ? ($field['value'][0] ?? null) : ($field['value'] ?? null);
                    break;
                }
            }

            $countryOption = DB::table('form_attributes')->where('id', $countryOptionId)->first();
            $CountryName = $countryOption->form_option ?? '';

            $countriesData = DB::table('countries')->whereRaw('country LIKE ?', ['%' . strtolower($CountryName) . '%'])->first();
            $countryCode = $countriesData->country_code ?? mb_strtoupper(mb_substr($CountryName, 0, 3, 'UTF-8'));
            $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

            $subserviceCode = $subserviceData->subservice_code ?? 'OT';
            $year = date('y');

            $lastSequence = DB::table('packages_enquiry')
                ->where('subservice_code', $subserviceCode)
                ->where('city_code', $countryCode)
                ->where('order_year', $year)
                ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                ->lockForUpdate()
                ->value('seq');

            $nextSequence = $lastSequence ? $lastSequence + 1 : 1;
            $formatOrderId = sprintf("%s-%s-%s-%06d", $subserviceCode, $year, $countryCode, $nextSequence);

            $data_u['subservice_code'] = $subserviceCode;
            $data_u['city_code'] = $countryCode;
            $data_u['order_year'] = $year;
            $data_u['sequence_no'] = $nextSequence;
            $data_u['inquiry_id'] = $formatOrderId;
        }

        if ($request->subservice_id == 61 || $request->subservice_id == 62 || $request->subservice_id == 64 || $request->subservice_id == 66) {
            // storage
            $cityOptionId = null;
            $fields = $request->input('fields', []);

            foreach ($fields as $field) {
                if (isset($field['field_id']) && $field['field_id'] == 69) {
                    $cityOptionId = is_array($field['value'] ?? null) ? ($field['value'][0] ?? null) : ($field['value'] ?? null);
                    break;
                }
            }

            $cityOption = DB::table('form_attributes')->where('id', $cityOptionId)->first();
            $CityName = $cityOption->form_option ?? '';

            $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($CityName) . '%'])->first();
            $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

            $subserviceCode = $subserviceData->subservice_code ?? 'OT';
            $cityCode = $cityData->city_code ?? 'OT';

            $year = date('y');
            $lastSequence = DB::table('packages_enquiry')
                ->where('subservice_code', $subserviceCode)
                ->where('city_code', $cityCode)
                ->where('order_year', $year)
                ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                ->lockForUpdate()
                ->value('seq');

            $nextSequence = $lastSequence ? $lastSequence + 1 : 1;
            $formatOrderId = sprintf("%s-%s-%s-%06d", $subserviceCode, $year, $cityCode, $nextSequence);

            $data_u['subservice_code'] = $subserviceCode;
            $data_u['city_code'] = $cityCode;
            $data_u['order_year'] = $year;
            $data_u['sequence_no'] = $nextSequence;
            $data_u['inquiry_id'] = $formatOrderId;
        }

        if (!empty($data_u)) {
            DB::table('packages_enquiry')->where('id', $package_inquiry)->update($data_u);
        }

        $fields = $request->input('fields', []);

        if (!empty($fields) && is_array($fields)) {
            foreach ($fields as $index => $field) {
                $fieldId = $field['field_id'] ?? null;
                $fieldType = $field['field_type'] ?? 'text';
                $fieldValue = $field['value'] ?? null;

                if (!$fieldId) continue;

                // Handle image uploads
                if ($fieldType === 'image' || $fieldType === 'file') {
                    $uploadedFiles = $request->file("fields.{$index}.value");

                    if ($uploadedFiles) {
                        $files = is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles];

                        foreach ($files as $file) {
                            if ($file && $file->isValid()) {
                                $imageName = time() . '-' . $file->getClientOriginalName();
                                $destinationPath = public_path('upload/enquiry_images');
                                $file->move($destinationPath, $imageName);

                                $data1 = [
                                    'package_inquiry_id' => $package_inquiry,
                                    'form_field_id' => $fieldId,
                                    'formfield_value' => $imageName
                                ];
                                DB::table('more_formfields_details')->insert($data1);
                            }
                        }
                    }
                    continue; // Image fields processed, skip the general insert below
                }

                // Format value based on field type
                if (is_array($fieldValue)) {
                    if ($fieldType == 'radio') {
                        $fieldValue = $fieldValue[0] ?? null;
                    } else {
                        $fieldValue = implode(",", $fieldValue);
                    }
                }

                if ($fieldValue !== null && $fieldValue !== '') {
                    $dataInsert = [
                        'package_inquiry_id' => $package_inquiry,
                        'form_field_id' => $fieldId,
                        'formfield_value' => $fieldValue
                    ];
                    DB::table('more_formfields_details')->insert($dataInsert);
                }

                // Handle additional attributes (e.g. formfield_value_more)
                $moreOptions = $field['more_options'] ?? null;
                if (isset($moreOptions) && is_array($moreOptions)) {
                    foreach ($moreOptions as $option) {
                        if ($option != '') {
                            $data_attr = [
                                'form_id' => $fieldId,
                                'more_form_attributes_id' => $option,
                                'package_inquiry_id' => $package_inquiry
                            ];
                            DB::table('more_formfields_details_att')->insert($data_attr);
                        }
                    }
                }
            }
        }

        // Email Notification Logic from package_inquiry_new
        $message_bodyy = '';

        if ($request->subservice_id == 94) {
            $thankMsg = 'Thank you for reaching out to VendorsCity! We have received your request for free quotes for ';
            $thankMsg1 = 'quotes';
        } else {
            $thankMsg = 'Thank you for reaching out to VendorsCity! We have received your request for up to 5 free quotes for ';
            $thankMsg1 = '5 quotes ';
        }

        $message_bodyy .= '<!doctype html>
        <head>
        <meta charset="utf-8">
        <title>Account Registration:</title>
        <style>
            .logo { border-bottom: 4px solid #FFD413; }
            .logo img{ width: 45%; }
            .wrapper { width: 100%; max-width:500px; margin:auto; font-size:14px; line-height:24px; font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; color:#555; padding:50px 0; }   
            .email_wrapper { width:100%; margin-top: 18px; font-size: 16px; }
            h2 { font-size: 26px; font-weight: bolder; margin: 0; }
            .btnlink { background: #0040E6; color: #fff !important; text-decoration: none; width: 100%; display: block; padding: 9px 0; text-align: center; font-size: 16px; border-radius: 9px; }
            .email_footer { width:100%; margin-top: 20px; }
            h3 { font-size: 20px; font-weight: bolder; margin: 0; border-bottom: 3px solid #6B7177; padding-bottom: 20px; margin-bottom: 15px; }
            .email_footer_div { width:100%; display: flex; }
            .footer_left { width: 100px; float: left; }
            .footer_right { margin-left:10px; float: left; }
            .footer_right p{ margin:0; }
            .footer_links { margin:10px 0; }
            .footer_links a { width: 100%; color: #555; display: inline-block; }
        </style>
    </head>
    <body>
        <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;font-size:14px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
            <div class="logo"style="float: inherit;border-bottom: 4px solid #FFD413;">
            <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="width: 40%;"  >
            </div>
            <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                <p>Dear ' . ($username ?? 'Customer') . ',</p>
                <p>' . $thankMsg . ' ' . Helper::servicename($request->service_id) . '.</p>
                <p><strong>What Happens Next?</strong></p>
                <p>Our trusted vendors will review your request and will contact you within 2 business days. You will receive up to ' . $thankMsg1 . ' tailored to your specific  ' . Helper::servicename($request->service_id) . ' needs.</p>
                <p><strong>How to Choose the Best Vendor:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;">Review the quotes you receive.</li>
                <li style= "list-style-type: disc;margin-bottom: -15px;">Check out the vendor ratings and reviews to make an informed decision.</li>
                <li style= "list-style-type: disc";>Select the vendor that best suits your requirements.</li></ul>  
                <p>We are committed to helping you find the best services quickly and easily. If you have any questions or need further assistance, please don&#39;t hesitate to contact us at support@vendorscity.com.</p> 
                <p>Thank you for choosing VendorsCity!</p>
            </div>
            <div class="email_footer" style="width:100%;margin-top: 20px;">
                <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;border-bottom: 3px solid #6B7177;padding-bottom: 20px;margin-bottom: 15px;">The VendorsCity Team</h3>
                <div class="email_footer_div" style=" width:100%;display: flex; ">
                    <div class="footer_left" style="width: 100px;float: left;">
                        <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '" >
                    </div>
                    <div class="footer_right" style="margin-left:10px;float: left;">
                        <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                        <p style="margin:0;">VendorsCity Portal LLC</p>
                        <div class="footer_links" style=" margin:10px 0;">
                            <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                            <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                            <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>';

        if (!empty($email)) {
            $subject = " Your Request for Free Quotes on " . Helper::servicename($request->service_id) . " is Being Processed!";
            $to = $email;
            $ccRecipients = [];

            try {
                Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $ccRecipients) {
                    $message->to($to);
                    $message->subject($subject);
                    foreach ($ccRecipients as $ccRecipient) {
                        $message->bcc($ccRecipient);
                    }
                    $message->html($message_bodyy);
                });
            } catch (\Exception $e) {
                // Ignore email sending error to not block API response
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Moving Service form data stored successfully.',
            'data' => [
                'package_inquiry_id' => $package_inquiry,
                'inquiry_id' => $data_u['inquiry_id'] ?? null,
                'service_id' => $data['service_id'] ?? null,
                'subservice_id' => $data['subservice_id'] ?? null
            ]
        ], 200);
    }
    public function contactUsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'lname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|max:255',
            'mobile' => ['required', 'string', 'max:25', 'regex:/^[0-9+\-\s()]+$/'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message ?? '',
        ];

        DB::table('contact_us')->insert($data);

        // --- Mail to Customer ---
        $html = '<!doctype html> <html>
            <head>
                <meta charset="utf-8">
                <title>Contact Us Email</title>
                <style>
                    .logo { border-bottom: 4px solid #FFD413; }
                    .logo img{ width: 45%; }
                    .wrapper { width: 100%; max-width:500px; margin:auto; font-size:14px; line-height:24px; font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; color:#555; padding:50px 0; }   
                    .email_wrapper { width:100%; margin-top: 18px; font-size: 16px; }
                    h2 { font-size: 26px; font-weight: bolder; margin: 0; }
                    .btnlink { background: #0040E6; color: #fff !important; text-decoration: none; width: 100%; display: block; padding: 9px 0; text-align: center; font-size: 16px; border-radius: 9px; }
                    .email_footer { width:100%; margin-top: 20px; }
                    h3 { font-size: 20px; font-weight: bolder; margin: 0; border-bottom: 3px solid #6B7177; padding-bottom: 20px; margin-bottom: 15px; }
                    .email_footer_div { width:100%; display: flex; }
                    .footer_left { width: 100px; float: left; }
                    .footer_right { margin-left:10px; float: left; }
                    .footer_right p{ margin:0; }
                    .footer_links { margin:10px 0; }
                    .footer_links a { width: 100%; color: #555; display: inline-block; }
                </style>
            </head>
            <body>
                <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;font-size:14px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
                    <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
                    <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="width: 40%;" >
                    </div>
                    <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                    <h2 style="font-size: 26px;font-weight: bolder;margin: 0;">Contact Us</h2>
                        <p>Dear ' . $data['fname'] . ',</p>                 
                        <p>We love hearing from you! Whether you have a question, feedback, or need assistance, our team is here to help. Visit our <a href="' . url("/contact") . '">Contact Us</a> page for more information.</p>
                        <p>Join the VendorsCity community today and experience the ultimate convenience in home services!</p>
                    </div>
                    <div class="email_footer" style="width:100%;margin-top: 20px;">
                            <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;border-bottom: 3px solid #6B7177;padding-bottom: 20px;margin-bottom: 15px;">The VendorsCity Team</h3>
                            <div class="email_footer_div" style=" width:100%;display: flex; ">
                                <div class="footer_left" style="width: 100px;float: left;">
                                    <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '" >
                                </div>
                                <div class="footer_right" style="margin-left:10px;float: left;">
                                    <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                    <p  style="margin:0;">VendorsCity Portal LLC</p>
                                    <div class="footer_links" style=" margin:10px 0;">
                                <a href="' . url("/terms-of-service") . '"  style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                                <a href="' . url("/privacy-policy") . '"  style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                                <a href="' . url("/contact") . '"  style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                                </div>
                                </div>
                            </div>
                      </div>
                </div>
            </body>
        </html>';

        $subject = "Contact Us";
        $to = $data['email'];
        $ccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

        try {
            Mail::send([], [], function ($message) use ($html, $to, $subject, $ccRecipients) {
                $message->to($to, 'VendorsCity');
                $message->subject($subject);
                $message->from('devang.hnrtechnologies@gmail.com', 'VendorsCity');
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($html);
            });
        } catch (\Exception $e) {
        }

        // --- Mail to Admin ---
        $htmll = '<!doctype html> <html>        
        <head>
            <meta charset="utf-8">
            <title>Contact Us Email</title>
            <style>
                .logo { text-align: center; width: 100%; }
                .wrapper { width: 100%; max-width:500px; margin:auto; font-size:14px; line-height:24px; font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; color:#555; }
                .wrapper div { height: auto; float: left; margin-bottom: 15px; width:100%; }
                .text-center { text-align: center; }
                .email-wrapper { padding:5px; border:1px solid #ccc; width:100%; }
                .big { text-align: center; font-size: 26px; color: #e31e24; font-weight: bold; margin-bottom: 0 !important; text-transform: uppercase; line-height: 34px; }
                .welcome { font-size: 17px; font-weight: bold; }
                .footer { text-align: center; color: #999; font-size: 13px; }
            </style>
        </head>     
        <body>
            <div class="wrapper" >
                <div class="logo">
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="max-width: 150px;" >
                </div>
                <div class="email-wrapper" >
                    <table style="border-collapse:collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">          
                        <tr>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="5">   
                                    <tr><td style="font-size:18px;">Hello ,</td></tr>
                                    <tr><td style="line-height:20px;">Please find the below Contact Us Details</td></tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="border-top:3px solid #333;" bgcolor="#f7f7f7" width="100%" border="0" cellspacing="0" cellpadding="5">   
                                    <tr>
                                        <td width="50%">        
                                            <table width="100%" border="0" cellspacing="0" cellpadding="5"> ';

        if (!empty($data['fname'])) {
            $htmll .= ' <tr><td>First Name: </td><td>' . $data['fname'] . '</td></tr>';
        }
        if (!empty($data["lname"])) {
            $htmll .= ' <tr><td>Last Name: </td><td>' . $data['lname'] . '</td></tr>';
        }
        if (!empty($data["email"])) {
            $htmll .= ' <tr><td>Email: </td><td>' . $data['email'] . '</td></tr>';
        }
        if (!empty($data["mobile"])) {
            $htmll .= '<tr><td>Mobile: </td><td>' . $data['mobile'] . '</td></tr>';
        }
        if (!empty($data["message"])) {
            $htmll .= '<tr><td>Message: </td><td>' . $data['message'] . '</td></tr>';
        }

        $htmll .= '                         </table>
                                        </td>   
                                    </tr>   
                                </table>
                            </td>   
                        </tr>
                    </table>
                </div>
            </div>
        </body>
        </html>';

        $subject_admin = "Contact Us - VendorsCity";
        $admin = "devang.hnrtechnologies@gmail.com";

        try {
            Mail::send([], [], function ($message) use ($htmll, $admin, $subject_admin, $ccRecipients) {
                $message->to($admin);
                $message->subject($subject_admin);
                $message->from('devang.hnrtechnologies@gmail.com', 'VendorsCity');
                foreach ($ccRecipients as $ccRecipient) {
                    $message->bcc($ccRecipient);
                }
                $message->html($htmll);
            });
        } catch (\Exception $e) {
        }

        return response()->json([
            'status' => true,
            'message' => 'Contact Us Added Successfully.',
            'data' => $data
        ], 200);
    }

    public function getFaqs(Request $request)
    {
        $faqs = DB::table('faqs')->select('id', 'question', 'answer')->orderBy('id', 'asc')->get();

        if ($faqs->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No FAQ records found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'FAQ data retrieved successfully',
            'data' => $faqs
        ], 200);
    }
}
