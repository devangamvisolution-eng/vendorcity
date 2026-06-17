<!doctype html>
<html>
<head>
    <title>Vendorscity-Quotation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .accept-success-msg {
        text-align: center;
        background: green;
        color: #fff;
        padding: 10px;
    }
    </style>
    <style>
        table,th,td {
            border: inherit;
            border-collapse: collapse;
        }
        p,
        ol {
            margin: 0
        }

        .color-blue{
            color:#1F6EEC;
        }

        .header_section{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .incl2 ul{padding-left: 1rem !important;}
        .currency_dhiram {
    display: inline-block;
        width: 18px;
    height: 18px;

    background-color: currentColor;

    -webkit-mask: url('{{ asset("public/site/icons/dirham.svg") }}') no-repeat center;
    mask: url('{{ asset("public/site/icons/dirham.svg") }}') no-repeat center;

    -webkit-mask-size: contain;
    mask-size: contain;
}
    </style>
</head>

@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show accept-success-msg" style="">
    <strong>Success!</strong> {{ $message }}
</div>
@endif

<body>

  @if($forPdf)
   <!-- Footer for Page 1 -->
<htmlpagefooter name="firstpagefooter">
  <table style="width:100%; border-collapse:collapse; margin-top:20px; font-family:Arial, sans-serif; font-size:14px; color:#333;font-family: Helvetica;">
  <tr style="background: #f2f2f2;">
    <!-- Contact Us -->
    <td style="width:50%; vertical-align:top; padding:15px; border:1px solid #f1f1f1; border-radius:8px;font-family: Helvetica;">
      <h3 style="margin:0; font-size:18px; font-weight:bold;font-family: Helvetica;">Contact <span style="font-weight:normal;font-family: Helvetica;">Us</span></h3>
      <p style="margin:10px 0 5px 0; font-size:12px;font-family: Helvetica;">
        <span style="display:inline-block; width:20px; color:#1E66F5;font-family: Helvetica;">&#9742;</span> +971 56 <strong>VENDORS</strong><br>
        <span style="display:inline-block; width:20px; color:#1E66F5;font-family: Helvetica;">&#9742;</span> 
        (+971 56 <strong>836 3677</strong>)
      </p>
      <p style="margin-top: 12px font-size:12px;">
        <span style="display:inline-block; width:20px; color:#1E66F5;font-family: Helvetica;">&#127760;</span>
        www.vendorscity.com<br>
        <span style="display:inline-block; width:20px; color:#1E66F5;font-family: Helvetica;">&#9993;</span>
        accounts@vendorscity.com
      </p>
    </td>

    <!-- Bank Details -->
    <td style="width:50%; vertical-align:top; padding:15px; border:1px solid #f1f1f1; border-radius:8px;font-family: Helvetica;">
      <h3 style="margin:0; font-size:18px; font-weight:bold;">Bank <span style="font-weight:normal;">Details</span></h3>
      <p style=" font-size:12px;"><strong>Account Name:</strong> VendorsCity Portal LLC</p>
      <p style=" font-size:12px;"><strong>Account No:</strong> 13450800920001</p>
      <p style=" font-size:12px;"><strong>Swift Code:</strong> ADCBAEAA</p>
      <p style=" font-size:12px;"><strong>IBAN:</strong> AE060030013450800920001</p>
      <p style="font-size:12px;"><strong>Bank:</strong> Abu Dhabi Commercial Bank</p>
      <p style=" font-size:12px;"><strong>Branch:</strong> 251 - Al Riggah Road</p>
    </td>
  </tr>
</table>
  <p style="text-align:center; font-size:14px; color:#777; margin-top:15px; font-family: Helvetica;">
    The Validity of this Quotation is <strong>30 Days</strong><br>
    <span style="color:#555; font-family: Helvetica;">
      Prepared by: <span style="color:#1E66F5; font-family: Helvetica;">{{$followup_data->prepared_by ?? ''}}</span>
    </span>
  </p>
</htmlpagefooter>



<!-- Footer for Page 2 -->
<htmlpagefooter name="secondpagefooter">
  <table width="100%">
    <tr>
      <td colspan="4" style="text-align:center; padding:15px 10px 0 10px; font-size:12px; font-family: Helvetica; color:#6c757d; line-height:1.6;">
        Please confirm your acceptance of the above quote by either sending us an email or<br>
        providing a scanned copy of the signed quote.
      </td>
    </tr>
  </table>
</htmlpagefooter>
@endif
<!-- Activate them on specific pages -->




    <div class="" style="">

      <div class="quote" style="width: 100%;display: inline-block; text-align:right">

            @if($followup_data->accepted_quotation == 0)
                <a href="{{ route('request.accept', ['enquiry_id' => $followup_data->id, 'format_type' => 1]) }}" style="text-decoration: none;{{ $acceptQuoteStyle }}">
                    <button type="button"
                            style="background-color: #f39739;
                                color: #fff;
                                padding: 10px 20px;
                                border: none;
                                border-radius: 5px;
                                cursor: pointer;
                                font-size: 16px;
                                margin-right:45%;">
                        Accept Quotation
                    </button>
                </a>
            @else
                <a href="javascript:void(0);" style="text-decoration: none;{{ $acceptQuoteStyle }}">
                    <button type="button"
                            style="background-color: #f39739;
                                color: #fff;
                                padding: 10px 20px;
                                border: none;
                                border-radius: 5px;
                                cursor: pointer;
                                font-size: 16px;
                                margin-right:45%;">
                        Quotation Accepted
                    </button>
                </a>
            @endif
            
        </div>

      <sethtmlpagefooter name="firstpagefooter" value="on" page="1" />
        <!-- Header -->
        <table style="width:100%; border-collapse: collapse; margin-bottom:20px;margin-top:50px;">
            <tr>
            <td style="width: 60%;">
                <h2 style="margin:0;font-size:18px;font-family: Helvetica;font-weight:bold;color:#635B5B;">Proforma Quotation</h2>
                {{-- <h1 style="margin:5px 0;font-size:34px;color:#000;font-family:'CircularStd', sans-serif; font-weight: revert-layer;letter-spacing: 2px;font-weight:bold;">VendorsCity</h1> --}}
                
                <span><img src="{{ asset('public/admin/assets/img/VC-FULL-BLACK.png') }}" 
         alt="Cleaning Icon" width="240" /></span>

                <p style="margin:0; font-weight:bold;font-family: Helvetica;font-size: 14px;color:#635B5B;">VendorsCity Portal LLC</p>
                <p style="margin:0;font-family: Helvetica;color:#635B5B;font-size: 14px;">Dubai, United Arab Emirates</p>
                <p style="margin:0;font-family: Helvetica;color:#635B5B;font-size: 14px;"><a href="http://www.vendorscity.com" style="color:#635B5B;font-size: 14px; text-decoration:none;">www.vendorscity.com</a></p>
            </td>
            <td style="width: 40%;background-color: #eee;text-align:center;line-height: 28px;letter-spacing: 0.5px;">
                <div style="padding:10px 20px;border-radius:6px;">
                    <p style="margin:0; font-weight:bold;text-align:center;font-family:'CircularStd', sans-serif;font-size:18px;">Quotation 
					<span style="color:#0056b3;font-family: Helvetica;font-size:18px;">Number</span></p>
                    <p style="margin:0;text-align: center;font-family: Helvetica;font-size:15px;">{{$followup_data->quote_id ?? ''}}</p>
                    <p style="margin:10px 0 0; font-weight:bold;text-align: center;font-family: Helvetica;font-size:18px;">Quotation <span style="color:#0056b3;">Date</span></p>
                    <p style="margin:0;text-align: center;font-family: Helvetica;font-size:18px;">{{ $followup_data->quotation_date ? \Carbon\Carbon::parse($followup_data->quotation_date)->format('d/m/Y') : '' }}</p>
                </div>
            </td>
            </tr>
        </table>

        <table style="width:100%; border-collapse: collapse; margin-bottom:20px;">
            <tr>
            <td style="width: 60%;">
                <div style="margin-top:20px;">
                    <p style="margin:0; font-weight:bold;font-size: 16px;color:#A0A0A0;font-family: Helvetica;">Quoted To:</p>
                    <p style="padding-bottom:20px;font-weight:bold; color:#0056b3;font-size: 18px;font-family: Helvetica;">{{$followup_data->client_name ?? ''}}</p>
                    <p style="margin-top:20px;font-size: 12px;color:#A0A0A0;font-family: Helvetica;"><b>P:</b> {{$followup_data->client_mobile ?? ''}} &nbsp;&nbsp; <b>E:</b> {{$followup_data->client_email ?? ''}}</p>
                    <p style="font-size: 12px;color:#A0A0A0;font-family: Helvetica;"><b>A:</b> {{$followup_data->address ?? ''}}</p>
                </div>
            </td>
            <td style="width: 40%;text-align: center;">
                <div style="margin-top:40px;">
                    <p style="margin:0; font-weight:bold;font-size:26px;font-family: Helvetica;">Quoted Amount</p>
                    <p style="margin:0; font-size:28px; font-weight:600; color:#0040E6;font-family: Helvetica;"><img src="{{asset("public/site/images/automobile/DirhamBlue.png")}}" style="width: 3%;" > {{$followup_data->grand_total ?? ''}}</p>
                </div>
            </td>
            </tr>
        </table>

        @if(isset($costing_attribute) && count($costing_attribute) > 0)
         <table style="width:100%; border-collapse:collapse; ">
            <thead>
            <tr style="background:#f2f2f2; text-align:center;">
                <th style="padding:8px; border:1px solid #fff;font-family: Helvetica;">SI No. </th>
                <th style="padding:8px; border:1px solid #fff;font-family: Helvetica;">Job Description</th>
                <th style="padding:8px; border:1px solid #fff;font-family: Helvetica;">QTY.</th>
                <th style="padding:8px; border:1px solid #fff;font-family: Helvetica;display:flex;align-items: center;">Price(<img src="{{asset("public/site/images/automobile/DirhamBlack.png")}}" style="width: 2%;" >)</th>
                <th style="padding:8px; border:1px solid #fff;font-family: Helvetica;display:flex;align-items: center;">Total(<img src="{{asset("public/site/images/automobile/DirhamBlack.png")}}" style="width: 2%;" >)</th>
            </tr>
            </thead>
            <tbody>
            @php
                $subtotal = 0;
                
            @endphp
            @foreach($costing_attribute as $key => $attribute)

            @php

               if(isset($followup_data->margin_percent) && $followup_data->margin_percent > 0){
                $price = $attribute->prov + ($attribute->prov * $followup_data->margin_percent / 100);
               }else{
                $price = $attribute->prov;
               }

               $total = $price * $attribute->qty;

            @endphp
            <tr>
                <td style="padding:8px; border:1px solid #fff;text-align: center;font-family: Helvetica;">{{$key + 1}}</td>
                <td style="padding:8px; border:1px solid #fff;text-align: center;font-family: Helvetica;">{{$attribute->description ?? ''}}</td>
                <td style="padding:8px; border:1px solid #fff;text-align: center;font-family: Helvetica;">{{$attribute->qty ?? ''}}</td>
                <td style="padding:8px; border:1px solid #fff;text-align: center;font-family: Helvetica;">{{ isset($price) ? number_format(($price), 2) : '' }}</td>
                <td style="padding:8px; border:1px solid #fff;text-align: center;font-family: Helvetica;">{{ isset($total) ? number_format(($total), 2) : '' }}</td>
            </tr>
            @php
                $subtotal += $total;
                
            @endphp
            @endforeach

            @php
                if($followup_data->vat_charge == 1){
                    $vat = 0.05 * $subtotal;
                }else{
                    $vat = 0;
                }

            @endphp
            <tr>
                <td colspan="3"></td>
                <td style="text-align: right;font-family: Helvetica;color:#635B5B;"><b>Subtotal:<b></td>
                <td style="text-align: center;font-family: Helvetica;color:#635B5B;"><b>{{ isset($subtotal) ? number_format(($subtotal), 2) : '' }}</b></td>
            </tr>
            @if($followup_data->vat_charge == 1)
            <tr>
                <td colspan="3"></td>
                <td style="text-align: right;font-family: Helvetica;">VAT:</td>
                <td style="text-align: center;font-family: Helvetica;color:#635B5B;"><b>{{ isset($vat) ? number_format(($vat), 2) : '' }}</b></td>
            </tr>
            @endif
            <tr>
                <td colspan="3"></td>
                <td style="text-align: right;font-family: Helvetica;color:#635B5B;"><b>Total Amount:</b><br><b style="display:flex;align-items: center;">(<img src="{{asset("public/site/images/automobile/DirhamBlack.png")}}" style="width: 2%;" >)</b></td>
                <td style="text-align: center;font-family: Helvetica;color:#635B5B;"><b>{{$followup_data->grand_total ?? ''}}</b></td>
            </tr>
            </tbody>
        </table>
        @endif
        <div style="">
            <p style="margin:0; font-weight:bold;font-family: Helvetica;font-size: 14px;color:#635B5B;">Job Completion ETA: <span style="font-weight:normal;font-family: Helvetica;font-size:14px;color:#635B5B;">{{$followup_data->est_time_to_complete}}</span></p>
        </div>

        <div style="margin:40px auto;">

      @if($followup_data->service == 30)    
      <p style="font-size:20px;margin-bottom:12px ">
        <span style="font-weight:bold;font-family: Helvetica;color:#635B5B;">Shipment</span> 
      <span style="font-family: Helvetica;color:#635B5B;">Details </span>
        <span style="display:inline-block; width:60%; border-top:2px solid #000; vertical-align:middle; margin-left:10px;font-family: Helvetica;"></span>
      </p>

    <table style="width:100%; border-collapse:separate; border-spacing:10px; font-size:15px; font-family: Helvetica;">
      @if(isset($followup_data->desc_of_goods) && $followup_data->desc_of_goods != '')
      <tr>
        <td style="background:#f2f2f2; padding:10px; font-weight:bold; width:30%; text-align:center; font-size:12px;">
          Description of Goods
        </td>
        <td style="padding:10px; width:70%; text-align:center; font-size:13px;">
          {{$followup_data->desc_of_goods ?? ''}}
        </td>
      </tr>
      @endif
      @if(isset($followup_data->service_required) && $followup_data->service_required != '')
      <tr>
        <td style="background:#f2f2f2; padding:10px; font-weight:bold; width:30%; text-align:center; font-size:12px;">
          Service Required
        </td>
        <td style="padding:10px; width:70%; text-align:center; font-size:13px;">
          {{$followup_data->service_required ?? ''}}
        </td>
      </tr>
      @endif

      @if(isset($followup_data->mode_of_transport) && $followup_data->mode_of_transport != '')
      <tr>
        <td style="background:#f2f2f2; padding:10px; font-weight:bold; width:30%; text-align:center; font-size:12px;">
          Mode of Transport
        </td>
        <td style="padding:10px; width:70%; text-align:center; font-size:13px;">
          {{$followup_data->mode_of_transport ?? ''}}
        </td>
      </tr>
      @endif
      @if(isset($followup_data->estimated_volume) && $followup_data->estimated_volume != '')
      <tr>
        <td style="background:#f2f2f2; padding:10px; font-weight:bold; width:30%; text-align:center; font-size:12px;">
          Estimated Volume (CBM)
        </td>
        <td style="padding:10px; width:70%; text-align:center; font-size:13px;">
          {{$followup_data->estimated_volume ?? ''}}
        </td>
      </tr>
      @endif

      @php
		
		if(isset($followup_data->origin_country)){
			$countryname = Helper::countryname($followup_data->origin_country);
		}else{
			$countryname ='';
		}
        

        $originParts = [
              $followup_data->origin_add ?? '',
              $followup_data->origin_location ?? '',
              $followup_data->origin_city ?? '',
              $followup_data->origin_state ?? '',
              $countryname ?? '',
              $followup_data->origin_zip_post ?? '',
          ];
          // Remove empty values and join with comma
          $fullOriginAddress = implode(', ', array_filter($originParts));
        

      @endphp
      @if(isset($fullOriginAddress) && $fullOriginAddress != '')
      <tr>
        <td style="background:#f2f2f2; padding:10px; font-weight:bold; width:30%; text-align:center; font-size:12px;">
          Origin Address
        </td>
        <td style="padding:10px; width:70%; text-align:center; font-size:13px;">
          {{ $fullOriginAddress ?? '' }}
        </td>
      </tr>
      @endif

      @php

        //$countrynamedesti = Helper::countryname($followup_data->desti_country);
		
		if(isset($followup_data->desti_country)){
			$countrynamedesti = Helper::countryname($followup_data->desti_country);
		}else{
			$countrynamedesti ='';
		}

        $originPartsDesti = [
              $followup_data->desti_add ?? '',
              $followup_data->desti_location ?? '',
              $followup_data->desti_city ?? '',
              $followup_data->desti_state ?? '',
              $countrynamedesti ?? '',
              $followup_data->desti_zip_post ?? '',
          ];
          // Remove empty values and join with comma
          $fullDestiAddress = implode(', ', array_filter($originPartsDesti));
        

      @endphp
      @if(isset($fullDestiAddress) && $fullDestiAddress != '')
      <tr>
        <td style="background:#f2f2f2; padding:10px; font-weight:bold; width:30%; text-align:center; font-size:12px;">
          Destination Address
        </td>
        <td style="padding:10px; width:70%; text-align:center; font-size:13px;">
          {{ $fullDestiAddress ?? '' }}
        </td>
      </tr>

      @endif
      <!-- Repeat rows -->
    </table>

@endif
@php
    // Merge logic: Prefer followup_data, fallback to servicedata
    $ScopeOfJob  = $followup_data->scope_of_job    ?? $servicedata->scope_of_job  ?? '';
   
@endphp

<!-- ScopeOfJob -->
@if(!empty($ScopeOfJob))
  <p style="color:#000; font-size:18px; font-family: Helvetica;"><b>Scope</b> Of Job</p>
  <div class="incl2" style="font-family: Helvetica; font-size:11px; color:#777;">
      {!! html_entity_decode($ScopeOfJob) !!}
  </div>
@endif

    

    @unless($forPdf)

    <table style="width:100%; border-collapse:collapse; margin-top:20px; font-family:Arial, sans-serif; font-size:14px; color:#333;font-family: Helvetica;">
  <tr style="background: #f2f2f2;">
    <!-- Contact Us -->
    <td style="width:50%; vertical-align:top; padding:15px; border:1px solid #f1f1f1; border-radius:8px;font-family: Helvetica;">
      <h3 style="margin:0; font-size:18px; font-weight:bold;font-family: Helvetica;">Contact <span style="font-weight:normal;font-family: Helvetica;">Us</span></h3>
      <p style="margin:10px 0 5px 0; font-size:12px;font-family: Helvetica;">
        <span style="display:inline-block; width:20px; color:#1E66F5;font-family: Helvetica;">&#9742;</span> +971 56 <strong>VENDORS</strong><br>
        <span style="display:inline-block; width:20px; color:#1E66F5;font-family: Helvetica;">&#9742;</span> 
        (+971 56 <strong>836 3677</strong>)
      </p>
      <p style="margin-top: 12px font-size:12px;">
        <span style="display:inline-block; width:20px; color:#1E66F5;font-family: Helvetica;">&#127760;</span>
        www.vendorscity.com<br>
        <span style="display:inline-block; width:20px; color:#1E66F5;font-family: Helvetica;">&#9993;</span>
        accounts@vendorscity.com
      </p>
    </td>

    <!-- Bank Details -->
    <td style="width:50%; vertical-align:top; padding:15px; border:1px solid #f1f1f1; border-radius:8px;font-family: Helvetica;">
      <h3 style="margin:0; font-size:18px; font-weight:bold;">Bank <span style="font-weight:normal;">Details</span></h3>
      <p style=" font-size:12px;"><strong>Account Name:</strong> VendorsCity Portal LLC</p>
      <p style=" font-size:12px;"><strong>Account No:</strong> 13450800920001</p>
      <p style=" font-size:12px;"><strong>Swift Code:</strong> ADCBAEAA</p>
      <p style=" font-size:12px;"><strong>IBAN:</strong> AE060030013450800920001</p>
      <p style="font-size:12px;"><strong>Bank:</strong> Abu Dhabi Commercial Bank</p>
      <p style=" font-size:12px;"><strong>Branch:</strong> 251 - Al Riggah Road</p>
    </td>
  </tr>
</table>

    <!-- Footer Note -->
    <p style="text-align:center; font-size:14px; color:#777;margin-top:15px;font-family: Helvetica;">
      The Validity of this Quotation is <strong>30 Days</strong><br>
      <span style="color:#555;font-family: Helvetica;">Prepared by: <span style="color:#1E66F5;font-family: Helvetica;">{{$followup_data->prepared_by ?? ''}}</span></span>
    </p>
    @endunless

  </div>
        
<div style="page-break-after: always;"></div>

<sethtmlpagefooter name="secondpagefooter" value="on" page="2" />

   <!-- Logo -->
  <div style="text-align:right; font-size:28px; font-weight:bold; margin-bottom:20px;">
   <img src="{{ asset('public/admin/assets/img/VC-BLACK-SHORT.png') }}" 
         alt="Cleaning Icon" 
         width="60" 
         
         style="display:block; margin:0 auto; border-radius:20px;">
  </div>

 @php
    // Merge logic: Prefer followup_data, fallback to servicedata
    $ScopeOfJob  = $followup_data->scope_of_job    ?? $servicedata->scope_of_job  ?? '';
    $priceIncludes  = $followup_data->price_includes  ?? $servicedata->price_includes  ?? '';
    $priceExcludes  = $followup_data->price_excludes  ?? $servicedata->price_excludes  ?? '';
    $disclaimer     = $followup_data->disclaimer      ?? $servicedata->disclaimer      ?? '';
    $insurance      = $followup_data->insurance       ?? $servicedata->insurance       ?? '';
    $paymentTerms   = $followup_data->payment_terms   ?? $servicedata->payment_terms   ?? '';
@endphp



<!-- Price Includes -->
@if(!empty($priceIncludes))
  <p style="color:#000; font-size:18px; font-family: Helvetica;"><b>Price</b> Includes</p>
  <div class="incl2" style="font-family: Helvetica; font-size:11px; color:#777;">
      {!! html_entity_decode($priceIncludes) !!}
  </div>
@endif

<!-- Price Excludes -->
@if(!empty($priceExcludes))
  <p style="color:#000; font-size:18px; font-family: Helvetica;"><b>Price</b> Excludes</p>
  <div class="incl2" style="font-family: Helvetica; font-size:11px; color:#777;">
      {!! html_entity_decode($priceExcludes) !!}
  </div>
@endif

<!-- Disclaimer -->
@if(!empty($disclaimer))
  <p style="color:#000; font-size:18px; font-family: Helvetica;"><b>Disclaimer</b></p>
  <div class="incl2" style="font-family: Helvetica; font-size:11px; color:#777;">
      {!! html_entity_decode($disclaimer) !!}
  </div>
@endif

<!-- Insurance -->
@if(!empty($insurance))
  <p style="color:#000; font-size:18px; font-family: Helvetica;"><b>Insurance</b></p>
  <div class="incl2" style="font-family: Helvetica; font-size:11px; color:#777;">
      {!! html_entity_decode($insurance) !!}
  </div>
@endif

<!-- Payment Terms -->
@if(!empty($paymentTerms))
  <p style="color:#000; font-size:18px; font-family: Helvetica;"><b>Payment</b> Terms</p>
  <div class="incl2" style="font-family: Helvetica; font-size:11px; color:#777;">
      {!! html_entity_decode($paymentTerms) !!}
  </div>
@endif

  <!-- Additional Services -->
  <h2 style="color:#000; font-size:18px; font-family: Helvetica;"><b>Additional Services</b></h2>

  <table style="width:100%; text-align:center; border-collapse:collapse;">
    <tr>
      <td style="width:25%; padding:0px;">
        <img src="{{ asset('public/site/images/Homepage/subservice_logo/cleaning_icon.png') }}" 
         alt="Cleaning Icon" 
         width="40" 
         height="40" 
         style="display:block; margin:0 auto; border-radius:20px;">
        <p style="margin:5px 0; font-weight:bold;font-family: Helvetica;font-size:10px;color:#555;">Cleaning </p>
        <p style="margin:0; font-size:10px; color:#555;font-family: Helvetica;">Deep cleaning,regular cleaning,and specialized cleaning services</p>
      </td>

      <td style="width:25%; padding:0px;">
        <img src="{{ asset('public/site/images/Homepage/subservice_logo/moving_icon.png') }}" 
         alt="Cleaning Icon" 
         width="40" 
         height="40" 
         style="display:block; margin:0 auto; border-radius:20px;">
        <p style="margin:5px 0; font-weight:bold;font-family: Helvetica;font-size:10px;color:#555;">Moving & Storage </p>
        <p style="margin:0; font-size:10px; color:#555;font-family: Helvetica;">Efficient moving solutions and secure storage options.</p>
      </td>
      <td style="width:25%; padding:0px;">
        <img src="{{ asset('public/site/images/Homepage/subservice_logo/dry_cleaning.png') }}" 
         alt="Cleaning Icon" 
         width="40" 
         height="40" 
         style="display:block; margin:0 auto; border-radius:20px;">
        <p style="margin:5px 0; font-weight:bold;font-family: Helvetica;font-size:10px;color:#555;">Laundry & Dry Cleaning</p>
        <p style="margin:0; font-size:10px; color:#555;font-family: Helvetica;">Professional washing, dry cleaning, and secure storage for your garments.</p>
      </td>

      <td style="width:25%; padding:0px;">
        <img src="{{ asset('public/site/images/Homepage/subservice_logo/ac_cleaning.png') }}" 
         alt="Cleaning Icon" 
         width="40" 
         height="40" 
         style="display:block; margin:0 auto; border-radius:20px;">
        <p style="margin:5px 0; font-weight:bold;font-family: Helvetica;font-size:10px;color:#555;">AC Services</p>
        <p style="margin:0; font-size:10px; color:#555;font-family: Helvetica;">Installation, repair, and maintenance of air conditioning systems.</p>
      </td>
      
      
    </tr>
    <tr>
     

      <td style="width:25%; padding:0px;">
        <img src="{{ asset('public/site/images/Homepage/subservice_logo/spa_salon_icon.png') }}" 
         alt="Cleaning Icon" 
         width="40" 
         height="40" 
         style="display:block; margin:0 auto; border-radius:20px;">
        <p style="margin:5px 0; font-weight:bold;font-family: Helvetica;font-size:10px;color:#555;">Salon & Spa</p>
        <p style="margin:0; font-size:10px; color:#555;font-family: Helvetica;">Relaxation, grooming, and beauty treatments for your well-being.</p>
      </td>

      <td style="width:25%; padding:0px;">
        <img src="{{ asset('public/site/images/Homepage/subservice_logo/car.png') }}" 
         alt="Cleaning Icon" 
         width="40" 
         height="40" 
         style="display:block; margin:0 auto; border-radius:20px;">
        <p style="margin:5px 0; font-weight:bold;font-family: Helvetica;font-size:10px;color:#555;">Automobile</p>
        <p style="margin:0; font-size:10px; color:#555;font-family: Helvetica;">Comprehensive car care, detailing, and maintenance solutions.</p>
      </td>

      <td style="width:25%; padding:0px;">
        <img src="{{ asset('public/site/images/Homepage/subservice_logo/handyman_icon.png') }}" 
         alt="Cleaning Icon" 
         width="40" 
         height="40" 
         style="display:block; margin:0 auto; border-radius:20px;">
        <p style="margin:5px 0; font-weight:bold;font-family: Helvetica;font-size:10px;color:#555;">Handyman & Maintenance</p>
        <p style="margin:0; font-size:10px; color:#555;font-family: Helvetica;">Reliable repairs, installations, and home maintenance support.</p>
      </td>
      <td style="width:25%; padding:0px;">
        <img src="{{ asset('public/site/images/Homepage/subservice_logo/pest_control_icon.png') }}" 
         alt="Cleaning Icon" 
         width="40" 
         height="40" 
         style="display:block; margin:0 auto; border-radius:20px;">
        <p style="margin:5px 0; font-weight:bold;font-family: Helvetica;font-size:10px;color:#555;">Pest Control & Gardening </p>
        <p style="margin:0; font-size:10px; color:#555;font-family: Helvetica;">Effective pest management and professional garden care.</p>
      </td>
      

       
      
    </tr>

     @unless($forPdf)
        <tr>
      <td colspan="4" style="text-align:center; padding:15px 10px 0 10px; font-size:12px; font-family: Helvetica; color:#6c757d; line-height:1.6;">
        Please confirm your acceptance of the above quote by either sending us an email or<br>
        providing a scanned copy of the signed quote.
      </td>
    </tr>
    @endunless


  </table>


    </div>

   
   
</body>

</html>
