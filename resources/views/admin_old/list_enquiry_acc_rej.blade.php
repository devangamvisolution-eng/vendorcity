@extends('admin.includes.Template')
@section('content')
    <style>
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --bg-light: #f8fafc;
        }

        .detail-card {
            background: #fff;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .detail-header {
            background: #4c7aef;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-classic);
        }

        .detail-header h4 {
            color: #ffffff;
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .info-item {
            padding: 1rem;
            background: var(--bg-light);
            border-radius: 8px;
            border: 1px solid var(--border-classic);
            transition: all 0.2s ease;
        }

        .info-item:hover {
            border-color: var(--action-blue);
            background: #fff;
        }

        .info-label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .info-value {
            display: block;
            font-size: 1rem;
            color: var(--text-dark);
            font-weight: 500;
            word-break: break-word;
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: var(--action-blue);
            color: white !important;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .download-btn:hover {
            opacity: 0.9;
        }

        .download-btn i {
            margin-right: 0.5rem;
        }

        .badge-home-type {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #e0e7ff;
            color: #4338ca;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-top: 0.5rem;
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leads Enquiry Detail</h3>
                    <ul class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('enquiry.index') }}">Enquiry List</a></li>
                        <li class="breadcrumb-item active">View Details</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a href="{{ route('enquiry.index') }}" class="btn btn-outline-secondary shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="detail-card">
            <div class="detail-header">
                <h4><i class="fas fa-info-circle me-2"></i>Enquiry Information</h4>
            </div>

            <div class="card-body p-0">
                <div class="info-grid">
                    @if ($packages_enquiry != '' && count($packages_enquiry) > 0)
                        @foreach ($packages_enquiry as $packages_enquiry_data)
                            @if ($packages_enquiry_data->formfield_value != '')
                                <div class="info-item shadow-sm">
                                    <span class="info-label">{!! Helper::form_fields($packages_enquiry_data->form_field_id) !!}</span>
                                    <span class="info-value">
                                        @if (is_numeric($packages_enquiry_data->formfield_value) && $packages_enquiry_data->form_field_id != 30)
                                            {!! Helper::form_fields_attr($packages_enquiry_data->formfield_value) !!}
                                        @else
                                            @php
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
                                                $extension = pathinfo(
                                                    $packages_enquiry_data->formfield_value,
                                                    PATHINFO_EXTENSION,
                                                );
                                            @endphp
                                            @if (in_array(strtolower($extension), $imageExtensions))
                                                <a class="download-btn"
                                                    href="{{ url('admin/download/' . $packages_enquiry_data->formfield_value) }}">
                                                    <i class="fas fa-download"></i> Download Attachment
                                                </a>
                                            @else
                                                {{ $packages_enquiry_data->formfield_value }}
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            @endif

                            {{-- Handle "More" attributes / Type of Home --}}
                            @php
                                $get_more_id = DB::table('more_formfields_details_att')
                                    ->where('form_id', '=', $packages_enquiry_data->form_field_id)
                                    ->where('package_inquiry_id', '=', $packages_enquiry_data->package_inquiry_id)
                                    ->get();
                            @endphp

                            @if (isset($get_more_id) && count($get_more_id) > 0)
                                <div class="info-item shadow-sm w-100" style="grid-column: 1 / -1;">
                                    <span class="info-label">Type of Home / Additional Details</span>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($get_more_id as $get_more_id_data)
                                            <span class="badge-home-type">
                                                {!! Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id) !!}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center p-5 w-100">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No inquiry data found for this record.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
