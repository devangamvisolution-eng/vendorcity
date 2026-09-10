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


        if ($serviceId == 47 && in_array($subserviceId, [77, 78])) {
            $gardenOnlineFields = [];

            if ($subserviceId == 78) {
                $gardenOnlineFields[] = [
                    'id' => 'service_type',
                    'label_name' => 'Which service do you need quotes for?',
                    'type' => 'select',
                    'is_moveType' => false,
                    'options' => [
                        (object)['id' => 'General gardening and maintenance', 'form_option' => 'General gardening and maintenance'],
                        (object)['id' => 'Annual gardening contract', 'form_option' => 'Annual gardening contract'],
                        (object)['id' => 'Gazebos, decks and porches', 'form_option' => 'Gazebos, decks and porches'],
                        (object)['id' => 'Grass and artificial lawns', 'form_option' => 'Grass and artificial lawns'],
                        (object)['id' => 'Landscaping', 'form_option' => 'Landscaping']
                    ]
                ];
            }

            $gardenOnlineFields[] = [
                'id' => 'service_date',
                'label_name' => 'When do you need the service?',
                'type' => 'date',
                'is_moveType' => false,
                'options' => []
            ];

            $cities = DB::table('cities')->get();
            $cityOptions = [];
            foreach ($cities as $city) {
                $cityOptions[] = (object)['id' => (string)$city->id, 'form_option' => $city->name];
            }

            $gardenOnlineFields[] = [
                'id' => 'city',
                'label_name' => 'Which city do you need the service?',
                'type' => 'select',
                'is_moveType' => false,
                'options' => $cityOptions
            ];

            $gardenOnlineFields[] = [
                'id' => 'address',
                'label_name' => 'Where do you need the service?',
                'type' => 'text',
                'is_moveType' => false,
                'options' => []
            ];

            $dynamicFields = $getFormattedFields([70]);

            if ($subserviceId == 78 && isset($dynamicFields[0])) {
                $filteredOptions = [];
                foreach ($dynamicFields[0]['options'] as $opt) {
                    if ($opt->form_option !== 'Warehouse') {
                        $filteredOptions[] = $opt;
                    }
                }
                $dynamicFields[0]['options'] = $filteredOptions;
            }

            $gardenOnlineFields = array_merge($gardenOnlineFields, $dynamicFields);

            $gardenOnlineFields[] = [
                'id' => 'describe_your_requirements',
                'label_name' => 'Please describe the job in as much detail as possible (Optional)',
                'type' => 'textarea',
                'is_moveType' => false,
                'options' => []
            ];

            return response()->json([
                'status' => true,
                'message' => 'Garden form fields fetched successfully.',
                'data' => [
                    'garden_online_fields' => $gardenOnlineFields
                ]
            ], 200);
        }

        if ($serviceId == 34 && $subserviceId == 89) {
            $bookOnlineFields = [
                [
                    'id' => 'property_type',
                    'label_name' => 'Type of Property ?',
                    'type' => 'select',
                    'is_moveType' => false,
                    'options' => [
                        (object)['id' => 'Apartment', 'form_option' => 'Apartment'],
                        (object)['id' => 'Villa', 'form_option' => 'Villa'],
                        (object)['id' => 'Office', 'form_option' => 'Office'],
                        (object)['id' => 'Commercial Space', 'form_option' => 'Commercial Space']
                    ]
                ],
                [
                    'id' => 'area_of_floor',
                    'label_name' => 'Approximate Area of Wooden Flooring (sq. ft.)',
                    'type' => 'select',
                    'is_moveType' => false,
                    'options' => [
                        (object)['id' => 'Less than 200 sq. ft.', 'form_option' => 'Less than 200 sq. ft.'],
                        (object)['id' => '200 – 500 sq. ft.', 'form_option' => '200 – 500 sq. ft.'],
                        (object)['id' => '500 – 1000 sq. ft.', 'form_option' => '500 – 1000 sq. ft.'],
                        (object)['id' => 'More than 1000 sq. ft.', 'form_option' => 'More than 1000 sq. ft.'],
                        (object)['id' => 'Not Sure', 'form_option' => 'Not Sure']
                    ]
                ],
                [
                    'id' => 'condition_of_floor',
                    'label_name' => 'Current Condition of the Floor',
                    'type' => 'select',
                    'is_moveType' => false,
                    'options' => [
                        (object)['id' => 'Current Condition of the Floor', 'form_option' => 'Current Condition of the Floor'],
                        (object)['id' => 'Slight wear / dullness', 'form_option' => 'Slight wear / dullness'],
                        (object)['id' => 'Deep scratches / stains', 'form_option' => 'Deep scratches / stains'],
                        (object)['id' => 'Water damage', 'form_option' => 'Water damage'],
                        (object)['id' => 'Just maintenance polish', 'form_option' => 'Just maintenance polish'],
                        (object)['id' => 'Not sure', 'form_option' => 'Not sure']
                    ]
                ],
                [
                    'id' => 'service_required',
                    'label_name' => 'Service Required',
                    'type' => 'select',
                    'is_moveType' => false,
                    'options' => [
                        (object)['id' => 'Floor polishing only', 'form_option' => 'Floor polishing only'],
                        (object)['id' => 'Scratch/stain removal + polishing', 'form_option' => 'Scratch/stain removal + polishing'],
                        (object)['id' => 'Full restoration (sanding & finishing)', 'form_option' => 'Full restoration (sanding & finishing)'],
                        (object)['id' => 'Need expert advice', 'form_option' => 'Need expert advice']
                    ]
                ],
                [
                    'id' => 'schedule_site_survey',
                    'label_name' => 'Would you like to schedule a site survey?',
                    'type' => 'select',
                    'is_moveType' => false,
                    'options' => [
                        (object)['id' => 'yes', 'form_option' => 'Yes, please schedule a free survey'],
                        (object)['id' => 'no', 'form_option' => 'No, I’ll upload floor video below']
                    ]
                ],
                [
                    'id' => 'upload_video',
                    'label_name' => 'Upload Video of the Wooden Floor',
                    'type' => 'file',
                    'is_moveType' => false,
                    'options' => []
                ]
            ];

            return response()->json([
                'status' => true,
                'message' => 'Book online form fields fetched successfully.',
                'data' => [
                    'book_online_fields' => $bookOnlineFields
                ]
            ], 200);
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
            'fields.*.field_type' => 'required_with:fields',
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

        if ($request->subservice_id == 23 || $request->subservice_id == 26 || $request->subservice_id == 53 || $request->subservice_id == 94 || $request->subservice_id == 100 || $request->subservice_id == 98 || $request->subservice_id == 99) {

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

                // Handle image uploads (Type 8 is Image in DB)
                if ($fieldType === 'image' || $fieldType === 'file' || (string)$fieldType === '8') {
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
                    if ($fieldType === 'radio' || (string)$fieldType === '3') {
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
        $faqs = DB::table('faqs')
            ->join('services', 'services.id', '=', 'faqs.services')
            ->select(
                'faqs.id',
                'faqs.services as service_id',
                'services.servicename as service_name',
                'faqs.question',
                'faqs.answer'
            )
            ->whereNotNull('faqs.services')
            ->orderBy('faqs.services', 'asc')
            ->orderBy('faqs.id', 'asc')
            ->get();

        if ($faqs->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No FAQ records found.',
                'data' => []
            ], 404);
        }

        $data = [];

        foreach ($faqs as $faq) {

            if (!isset($data[$faq->service_id])) {
                $data[$faq->service_id] = [
                    'service_id' => $faq->service_id,
                    'service_name' => $faq->service_name,
                    'faqs' => []
                ];
            }

            $data[$faq->service_id]['faqs'][] = [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'FAQ data retrieved successfully',
            'data' => array_values($data)
        ], 200);
    }
    public function storeGardenPestControlInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|integer',
            'subservice_id' => 'required|integer',
            'city_id' => 'required|integer',
            'service_type' => 'nullable|string',
            'service_date' => 'required|date',
            'address' => 'required|string',
            'type_of_home' => 'nullable|string',
            'size_of_home_1' => 'nullable|string',
            'size_of_home_id' => 'nullable|integer',
            'describe_your_requirements' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->subservice_id == 77 || $request->subservice_id == 78) {

            $authUser = JWTAuth::parseToken()->authenticate();
            $userdata = auth()->user();

            $data = [];
            if (isset($userdata) && $userdata != "" && !empty($userdata)) {
                $data['name'] = $userdata->name;
                $data['email'] = $userdata->email;
                $data['mobile'] = $userdata->mobile;
                $data['user_id'] = $userdata->id;
            } else {
                $data['name'] = '';
                $data['email'] = '';
                $data['mobile'] = '';
                $data['user_id'] = 0;
            }

            if ($request->pakage_id != '') {
                $data['pakage_id'] = $request->pakage_id;
            }
            if ($request->service_id != '') {
                $data['service_id'] = $request->service_id;
            }
            if ($request->subservice_id != '') {
                $data['subservice_id'] = $request->subservice_id;
            }
            if ($request->packagecategory_id != '') {
                $data['packagecategory_id'] = $request->packagecategory_id;
            }

            $data['added_date'] = date('Y-m-d');
            $data['form_type'] = "Local Move";

            $cityData = DB::table('cities')->where('id', $request->city_id)->first();
            $subserviceData = DB::table('subservices')->where('id', $request->subservice_id)->first();

            if (isset($subserviceData)) {
                if (isset($subserviceData->subservice_code)) {
                    $subserviceCode = $subserviceData->subservice_code;
                } else {
                    $subserviceCode = 'OT';
                }
            } else {
                $subserviceCode = 'OT';
            }

            $cityCode = 'DU';
            if (isset($cityData)) {
                if (isset($cityData->city_code)) {
                    $cityCode = $cityData->city_code;
                } else {
                    $cityCode = 'OT';
                }
            }

            $year = date('y');

            $lastSequence = DB::table('packages_enquiry')
                ->where('subservice_code', $subserviceCode)
                ->where('city_code', $cityCode)
                ->where('order_year', $year)
                ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
                ->lockForUpdate()
                ->value('seq');

            $nextSequence = $lastSequence ? $lastSequence + 1 : 1;

            $formatOrderId = sprintf(
                "%s-%s-%s-%06d",
                $subserviceCode,
                $year,
                $cityCode,
                $nextSequence
            );

            $data['subservice_code'] = $subserviceCode;
            $data['city_code'] = $cityCode;
            $data['order_year'] = $year;
            $data['sequence_no'] = $nextSequence;
            $data['inquiry_id'] = $formatOrderId;

            $package_inquiry = DB::table('packages_enquiry')->insertGetId($data);

            if (isset($request->service_type) && !empty($request->service_type) || $request->subservice_id == 77) {

                $arrayOfGardenEnquiry = array(
                    'inquiry_id' => $package_inquiry,
                    'user_name' => $data['name'],
                    'user_email' => $data['email'],
                    'user_mobile' => $data['mobile'],
                    'service' => $request->service_id,
                    'subservice' => $request->subservice_id,
                    'service_type' => $request->service_type,
                    'service_date' => date('Y-m-d', strtotime($request->service_date)),
                    'city' => $request->city_id,
                    'address' => $request->address,
                    'type_of_home' => $request->type_of_home,
                    'size_of_home_id' => $request->size_of_home_id,
                    'size_of_home' => $request->size_of_home_1,
                    'describe_your_requirements' => $request->describe_your_requirements,
                    'subservice_code' => $subserviceCode,
                    'city_code' => $cityCode,
                    'order_year' => $year,
                    'sequence_no' => $nextSequence,
                    'added_date' => date("Y-m-d"),
                );

                $enquiryInsertId = DB::table('garden_enquiry')->insertGetId($arrayOfGardenEnquiry);

                // Call the email function
                $this->vendorMailForGardenApi($package_inquiry);

                return response()->json([
                    'status' => true,
                    'message' => 'Inquiry submitted successfully.',
                    'data' => [
                        'packages_enquiry_id' => $package_inquiry,
                        'garden_enquiry_id' => $enquiryInsertId,
                        'inquiry_id_format' => $formatOrderId
                    ]
                ], 200);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid subservice ID for Garden/Pest Control.',
            'data' => null
        ], 400);
    }

    private function vendorMailForGardenApi($package_inquiry_id)
    {
        $package_data = DB::table('packages_enquiry')->where('id', $package_inquiry_id)->first();
        $currentDate = date('Y-m-d');
        $garden_data = DB::table('garden_enquiry')->where('inquiry_id', $package_inquiry_id)->first();

        if (!$package_data || !$garden_data) return;

        $subscription_vendor_data = [];
        if ($package_data->subservice_id != 0) {
            $subscription_vendor_data = DB::table('subscription')
                ->whereRaw("FIND_IN_SET(?, services)", [$package_data->service_id])
                ->whereRaw("FIND_IN_SET(?, sub_service)", [$package_data->subservice_id])
                ->where('is_deleted', '=', '0')
                ->whereRaw("FIND_IN_SET(?, city)", [$garden_data->city])
                ->where('enddate', '>=', $currentDate)
                ->get();
        }

        $vendor_id_array = [];
        if (!empty($subscription_vendor_data)) {
            foreach ($subscription_vendor_data as $subscription_vendor_val) {
                $vendor_id_array[] = $subscription_vendor_val->vendor_id;
            }
        }
        $vendor_id_array_dataunique = array_unique($vendor_id_array);

        foreach ($vendor_id_array_dataunique as $vendor_id_array_data) {
            $vendor_data = DB::table('users')->where('id', $vendor_id_array_data)->where('is_active', 0)->first();

            if (!empty($vendor_data)) {
                $vendor_att_email = [];
                $vendor_data_attr = DB::table('vendors_attribute')->where('pid', $vendor_data->id)->get()->toArray();

                foreach ($vendor_data_attr as $attr_data) {
                    if (!empty($attr_data->c_email)) {
                        $vendor_att_email[] = $attr_data->c_email;
                    }
                }

                $user_name = $garden_data->user_name; // Safely get from garden data instead of Session
                $Date = date('d-m-Y');

                $html = '<!doctype html> <html>
        <head>
            <meta charset="utf-8">
            <title>New Customer Request</title>
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
            <div class="wrapper">
                <div class="logo">
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="width: 40%;">
                </div>
                <div class="email_wrapper">
                    <p>Dear ' . ucfirst($vendor_data->name) . ',</p>                 
                    <p>We are excited to inform you that a new customer has requested a quote for ' . Helper::servicename($package_data->service_id) . ' on VendorsCity!</p>
                    <p><strong>Request Details:</strong></p>
                    <ul>
                        <li style="list-style-type: disc;margin-bottom: -15px;"> Service Requested : ' . Helper::servicename($package_data->service_id) . '</li>                       
                        <li style="list-style-type: disc;margin-bottom: -15px;"> Customer Name : ' . $user_name . '</li>
                        <li style="list-style-type: disc;"> Request Date : ' . $Date . '</li>
                    </ul>                        
                    <p><a class="btnlink" href="' . route("vendor.login") . '">View Request</a></p>
                    <p>To view the full details of this request and provide a quote, please log in to your vendor dashboard by clicking the link above.</p>
                    <p>Don\'t miss out on this opportunity to win a new customer! If you have any questions or need assistance, feel free to contact our support team at <a href="mailto:support@vendorscity.com">support@vendorscity.com</a>.</p>
                    <p>Thank you for being a valued partner on VendorsCity!</p>
                </div>
                <div class="email_footer">
                    <h3>VendorsCity</h3>
                    <div class="email_footer_div">
                        <div class="footer_left">
                            <img style="width:100%;" src="' . asset("public/site/images/vcfavicon.png") . '">
                        </div>
                        <div class="footer_right">
                            <p>Phone: <a href="tel:+971 56 836 3677">+971 56 836 3677</a></p>
                            <p>Email: <a href="mailto:info@vendorscity.com">info@vendorscity.com</a></p>
                            <div class="footer_links">
                                <a href="https://vendorscity.com/beta/dubai/about">About Us</a>
                                <a href="https://vendorscity.com/beta/dubai/contact">Contact Us</a>
                                <a href="https://vendorscity.com/beta/dubai/privacy-policy">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';

                $subject = "You have received a new request - " . $package_data->inquiry_id;

                try {
                    Mail::send([], [], function ($message) use ($html, $vendor_data, $subject, $vendor_att_email) {
                        $message->to($vendor_data->email);
                        $message->subject($subject);
                        $message->from('hello@vendorscity.com', 'VendorsCity');
                        if (!empty($vendor_att_email)) {
                            foreach ($vendor_att_email as $cc) {
                                $message->cc($cc);
                            }
                        }
                        $message->html($html);
                    });
                } catch (\Exception $e) {
                    // Log or handle exception if needed
                }
            }
        }
    }

    public function storeWoodenFloorPolishingInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|integer',
            'subservice_id' => 'required|integer|in:89',
            'property_type' => 'required|string',
            'area_of_floor' => 'required|string',
            'condition_of_floor' => 'required|string',
            'service_required' => 'required|string',
            'schedule_site_survey' => 'required|string',
            'describe_your_requirements' => 'nullable|string',
            'date' => 'required|string',
            'month' => 'required|string',
            'time_slot' => 'required|string',
            'address_type' => 'required|string',
            'city' => 'required|string',
            'area' => 'required|string',
            'building_street_no' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $authUser = JWTAuth::parseToken()->authenticate();
            $userdata = auth()->user();

            $name = $userdata->name ?? '';
            $email = $userdata->email ?? '';
            $mobile = $userdata->mobile ?? '';
        } catch (\Exception $e) {
            $name = '';
            $email = '';
            $mobile = '';
        }

        $service_id = $request->service_id;
        $subservice_id = $request->subservice_id;

        $cityData = DB::table('cities')->whereRaw('name LIKE ?', ['%' . strtolower($request->city) . '%'])->first();
        $subserviceData = DB::table('subservices')->where('id', $subservice_id)->first();

        $subserviceCode = $subserviceData->subservice_code ?? 'OT';
        $cityCode = $cityData->city_code ?? 'OT';
        $year = date('y');

        $lastSequence = DB::table('wooden_floor_enquiry')
            ->where('subservice_code', $subserviceCode)
            ->where('city_code', $cityCode)
            ->where('order_year', $year)
            ->selectRaw('MAX(CAST(sequence_no AS UNSIGNED)) as seq')
            ->lockForUpdate()
            ->value('seq');

        $nextSequence = $lastSequence ? $lastSequence + 1 : 1;
        $formatOrderId = sprintf("%s-%s-%s-%06d", $subserviceCode, $year, $cityCode, $nextSequence);

        $arrayOfWoodenEnquiry = array(
            'service_id' => $service_id,
            'subservice_id' => $subservice_id,
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'property_type' => $request->property_type,
            'area_of_floor' => $request->area_of_floor,
            'condition_of_floor' => $request->condition_of_floor,
            'service_required' => $request->service_required,
            'schedule_site_survey' => $request->schedule_site_survey,
            'describe_your_requirements' => $request->describe_your_requirements ?? "",
            'video' => "",
            'enquiry_date' => $request->date,
            'enquiry_month' => $request->month,
            'enquiry_year' => date('Y'),
            'time_slot' => $request->time_slot,
            'addressType' => $request->address_type,
            'city' => $request->city,
            'area' => $request->area,
            'building_street_no' => $request->building_street_no,
            'added_date' => date("Y-m-d"),
            'subservice_code' => $subserviceCode,
            'city_code' => $cityCode,
            'order_year' => $year,
            'sequence_no' => $nextSequence,
            'inquiry_id' => $formatOrderId,
        );

        $enquiryInsertId = DB::table('wooden_floor_enquiry')->insertGetId($arrayOfWoodenEnquiry);

        $this->vendorMailForWoodenFloorApi($enquiryInsertId);

        return response()->json([
            'status' => true,
            'message' => 'Wooden Floor Polishing inquiry submitted successfully.',
            'data' => [
                'wooden_floor_enquiry_id' => $enquiryInsertId,
                'inquiry_id_format' => $formatOrderId
            ]
        ], 200);
    }

    private function vendorMailForWoodenFloorApi($enquiryId)
    {
        $enquiry_data = DB::table('wooden_floor_enquiry')->where('id', $enquiryId)->first();
        if (!$enquiry_data) return false;

        $user_email = $enquiry_data->email;
        $user_name = $enquiry_data->name;
        $woodenfloorServiceName = "Wooden Floor Polishing Service";

        $message_bodyy = "";
        $message_bodyy .= '<!doctype html>
        <head>
        <meta charset="utf-8">
        <title>Painting Enquiry:</title>
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
            <div class="wrapper" style="width: 100%;max-width:500px;margin:auto; font-size:14px;line-height:24px;font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
                <div class="logo"style="float: inherit;border-bottom: 4px solid #FFD413;">
                <img src="' . asset("public/site/images/VC-FULL-COLOR.png") . '" style="width: 40%;"  >
                </div>
                <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >
                    <p>Dear ' . $user_name . ',</p>
                    <p>Thank you for reaching out to VendorsCity! We have received your request for up to 5 free quotes for ' . $woodenfloorServiceName . '.</p>
                    <p><strong>What Happens Next?</strong></p>
                    <p>Our trusted vendors will review your request and will contact you within 2 business days. You will receive up to 5 quotes tailored to your specific wooden floor polishing needs.</p>
                    <p><strong>How to Choose the Best Vendor:</strong></p>
                    <ul><li style= "list-style-type: disc;margin-bottom: -15px;">Review the quotes you receive.</li>
                    <li style= "list-style-type: disc;margin-bottom: -15px;">Check out the vendor ratings and reviews to make an informed decision.</li>
                    <li style= "list-style-type: disc";>Select the vendor that best suits your requirements.</li></ul>  
                    <p>We are committed to helping you find the best services quickly and easily. If you have any questions or need further assistance, please don&#39;t hesitate to contact us at <a href="mailto:support@vendorscity.com">support@vendorscity.com</a>.</p> 
                    <p>Thank you for choosing VendorsCity!</p>
                </div>
                <div class="email_footer" style="width:100%;margin-top: 20px;">
                    <h3 style=" font-size: 20px;font-weight: bolder;margin: 0; border-bottom: 3px solid #6B7177;padding-bottom: 20px; margin-bottom: 15px;">The VendorsCity Team</h3>
                    <div class="email_footer_div" style=" width:100%; display: flex; ">
                        <div class="footer_left" style="width: 100px; float: left;">
                            <img style="width:70%;" src="' . asset("public/site/images/vcfaviconwap.png") . '" >
                        </div>
                        <div class="footer_right" style="margin-left:10px; float: left;">
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

        $subject = " Your Request for Free Quotes on Wooden Floor Polishing is being Processed!";
        $to = $user_email;
        $bccRecipients = ['hello@vendorscity.com', 'zafar@quickserverelo.com'];

        if (!empty($to)) {
            try {
                Mail::send([], [], function ($message) use ($message_bodyy, $to, $subject, $bccRecipients) {
                    $message->to($to);
                    $message->subject($subject);
                    foreach ($bccRecipients as $bccRecipient) {
                        $message->bcc($bccRecipient);
                    }
                    $message->html($message_bodyy);
                });
            } catch (\Exception $e) {
                // Ignore email sending error to not block API response
            }
        }
    }

    public function getHomeBanners(Request $request)
    {
        $system = DB::table('system')->where('id', 1)->first();

        $data = [
            'web' => [],
            'app' => []
        ];

        // --- Weather Icons ---
        if ($system) {
            // Check Web Icon
            if ($system->weather_is_web_active == 1 && !empty($system->weather_web_icon)) {
                $data['web'] = [
                    'status' => true,
                    'weather_icon' => asset('public/upload/weather/' . $system->weather_web_icon),
                    'weather_alt_tag' => $system->weather_alt_tag,
                    'weather_title' => $system->weather_title,
                    'weather_short_description' => $system->weather_short_description
                ];
            } else {
                $data['web'] = [
                    'status' => false,
                    'message' => 'Web Icon is not selected or not uploaded.'
                ];
            }

            // Check App Icon
            if ($system->weather_is_app_active == 1 && !empty($system->weather_app_icon)) {
                $data['app'] = [
                    'status' => true,
                    'weather_icon' => asset('public/upload/weather/' . $system->weather_app_icon),
                    'weather_alt_tag' => $system->weather_alt_tag,
                    'weather_title' => $system->weather_title,
                    'weather_short_description' => $system->weather_short_description
                ];
            } else {
                $data['app'] = [
                    'status' => false,
                    'message' => 'App Icon is not selected or not uploaded.'
                ];
            }
        } else {
            $data['web'] = ['status' => false, 'message' => 'System settings not found.'];
            $data['app'] = ['status' => false, 'message' => 'System settings not found.'];
        }

        // --- Horizontal Banners ---
        $web_horizontal_banners = DB::table('coupans')
            ->where('is_active', 0)
            ->where('display_image', 'Horizontal')
            ->where('active_for_web', 1)
            ->whereNotNull('horizontal_image')
            ->where('horizontal_image', '!=', '')
            ->get();

        $app_horizontal_banners = DB::table('coupans')
            ->where('is_active', 0)
            ->where('display_image', 'Horizontal')
            ->where('active_for_app', 1)
            ->whereNotNull('horizontal_image')
            ->where('horizontal_image', '!=', '')
            ->get();


        $web_horizontal_banners->transform(function ($item) {
            $item->image_url = asset('public/upload/coupans/' . $item->horizontal_image);

            return $item;
        });

        $data['web']['horizontal_banners'] = $web_horizontal_banners;

        /* $data['web']['horizontal_banners'] = $web_horizontal_banners->map(function ($item) {
            return ['image_url' => asset('public/upload/coupans/' . $item->horizontal_image)];
        }); */

        $app_horizontal_banners->transform(function ($item) {
            $item->image_url = asset('public/upload/coupans/' . $item->horizontal_image);

            return $item;
        });

        $data['app']['horizontal_banners'] = $app_horizontal_banners;

        /* $data['app']['horizontal_banners'] = $app_horizontal_banners->map(function ($item) {
            return ['image_url' => asset('public/upload/coupans/' . $item->horizontal_image)];
        }); */

        // --- Vertical Banners ---
        $web_vertical_banners = DB::table('coupans')
            ->where('is_active', 0)
            ->where('display_image', 'Vertical')
            ->where('active_for_web', 1)
            ->whereNotNull('vertical_image')
            ->where('vertical_image', '!=', '')
            ->get();

        $app_vertical_banners = DB::table('coupans')
            ->where('is_active', 0)
            ->where('display_image', 'Vertical')
            ->where('active_for_app', 1)
            ->whereNotNull('vertical_image')
            ->where('vertical_image', '!=', '')
            ->get();

        $web_vertical_banners->transform(function ($item) {
            $item->image_url = asset('public/upload/coupans/' . $item->vertical_image);

            return $item;
        });

        $data['web']['vertical_banners'] = $web_vertical_banners;

        /* $data['web']['vertical_banners'] = $web_vertical_banners->map(function ($item) {
            return ['image_url' => asset('public/upload/coupans/' . $item->vertical_image)];
        }); */

        $app_vertical_banners->transform(function ($item) {
            $item->image_url = asset('public/upload/coupans/' . $item->vertical_image);

            return $item;
        });

        $data['app']['vertical_banners'] = $app_vertical_banners;

        /* $data['app']['vertical_banners'] = $app_vertical_banners->map(function ($item) {
            return ['image_url' => asset('public/upload/coupans/' . $item->vertical_image)];
        }); */

        /* $data['web']['vertical_banners'] = $web_vertical_banners->map(function ($item) {
            return ['image_url' => asset('public/upload/coupans/' . $item->vertical_image)];
        });

        $data['app']['vertical_banners'] = $app_vertical_banners->map(function ($item) {
            return ['image_url' => asset('public/upload/coupans/' . $item->vertical_image)];
        }); */

        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully.',
            'data' => $data
        ], 200);
    }
}
