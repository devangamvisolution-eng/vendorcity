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

        /* Responsive full-width for long text */
        .full-width {
            grid-column: 1 / -1;
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Painting Leads Enquiry Detail</h3>
                    <ul class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Painting Leads Enquiry Detail</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary shadow-sm">
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
                <h4><i class="fas fa-info-circle me-2"></i>Painting Enquiry Information</h4>
            </div>

            <div class="card-body p-0">
                <form id="form" action="" enctype="multipart/form-data">
                    <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                    @csrf

                    <div class="info-grid">
                        @if ($painting_enquiry_data != '')

                            {{-- Inquiry No --}}
                            <div class="info-item shadow-sm">
                                <span class="info-label">Inquiry No</span>
                                <span class="info-value">{{ $painting_enquiry_data->inquiry_id }}</span>
                            </div>

                            {{-- Type of Painting --}}
                            <div class="info-item shadow-sm">
                                <span class="info-label">Type of Painting</span>
                                <span class="info-value">{{ $painting_enquiry_data->type_of_painting }}</span>
                            </div>

                            {{-- Service --}}
                            <div class="info-item shadow-sm">
                                <span class="info-label">Service</span>
                                <span class="info-value">{!! Helper::servicename(strval($painting_enquiry_data->service_id)) !!}</span>
                            </div>

                            {{-- Sub Service --}}
                            <div class="info-item shadow-sm">
                                <span class="info-label">Sub Service</span>
                                <span class="info-value">{!! Helper::subservicename(strval($painting_enquiry_data->subservice_id)) !!}</span>
                            </div>

                            {{-- Address --}}
                            <div class="info-item shadow-sm full-width">
                                <span class="info-label">Address</span>
                                <span class="info-value">
                                    {{ $painting_enquiry_data->city . ', ' . $painting_enquiry_data->area . ', ' . $painting_enquiry_data->building_street_no . ', ' }}
                                </span>
                            </div>

                            {{-- Date --}}
                            <div class="info-item shadow-sm">
                                <span class="info-label">Date</span>
                                <span class="info-value">
                                    {{ $painting_enquiry_data->enquiry_month . ' ' . $painting_enquiry_data->enquiry_date . ', ' . $painting_enquiry_data->enquiry_year }}
                                </span>
                            </div>

                            {{-- Time --}}
                            <div class="info-item shadow-sm">
                                <span class="info-label">Time</span>
                                <span class="info-value">{!! Helper::timeslotname(strval($painting_enquiry_data->time_slot)) !!}</span>
                            </div>

                            {{-- Rooms/Walls (Conditional) --}}
                            @if ($painting_enquiry_data->no_of_rooms_painted != 0)
                                <div class="info-item shadow-sm">
                                    <span class="info-label">No. of Rooms</span>
                                    <span class="info-value">{{ $painting_enquiry_data->no_of_rooms_painted }}</span>
                                </div>
                            @endif

                            @if ($painting_enquiry_data->no_of_walls_painted != 0)
                                <div class="info-item shadow-sm">
                                    <span class="info-label">No. of Walls</span>
                                    <span class="info-value">{{ $painting_enquiry_data->no_of_walls_painted }}</span>
                                </div>
                            @endif

                            {{-- Describe Painting Service --}}
                            @if ($painting_enquiry_data->describe_painting_service != '')
                                <div class="info-item shadow-sm full-width">
                                    <span class="info-label">Describe Painting Service</span>
                                    <span
                                        class="info-value">{{ $painting_enquiry_data->describe_painting_service ?? '' }}</span>
                                </div>
                            @endif
                        @else
                            <div class="text-center p-5 w-100">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No inquiry data found for this record.</p>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
