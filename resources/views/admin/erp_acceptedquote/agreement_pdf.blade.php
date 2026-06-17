<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VendorsCity Agreement Form Inline</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px 25px;
            color: #000;
        }

        header {
            text-align: center;
            margin-bottom: 8px;
        }

        .logo {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 900;
            font-style: italic;
            font-size: 26px;
            color: #7aaadc;
            letter-spacing: 2px;
            margin-bottom: 0;
            line-height: 1;
        }

        .logo small {
            font-size: 13px;
            display: block;
            font-weight: normal;
            color: gray;
            letter-spacing: 1px;
        }

        .title {
            font-weight: bold;
            font-size: 9px;
            margin: 3px 0 15px 0;
            text-transform: uppercase;
        }

        /* Form top line inline rows */
        .inline-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            gap: 10px;
        }

        .inline-row label {
            display: inline-block;
            white-space: nowrap;
            font-weight: bold;
            font-size: 9px;
            width: 110px;
        }

        .inline-row input[type="text"],
        .inline-row input[type="email"],
        .inline-row input[type="tel"],
        .inline-row input[type="number"] {
            border-bottom: 1.5px solid black;
            border-top: none;
            border-left: none;
            border-right: none;
            outline: none;
            width: 170px;
            font-size: 11px;
            padding: 0 2px 2px 2px;
            background: transparent;
        }

        /* wider fields for addresses */
        .address-line {
            width: 370px;
        }

        /* For smaller inline label + fields */
        .small-inline-label {
            width: 40px;
            font-weight: normal;
            font-size: 9px;
        }

        /* Two column container for Store & Payment details side by side */
        .columns2 {
            display: flex;
            gap: 50px;
            margin-top: 5px;
        }

        /* Store Details Left Side */
        .store-details {
            flex: 1;
        }

        .store-details label {
            font-weight: bold;
            font-size: 9px;
            vertical-align: middle;
        }

        .store-details textarea {
            width: 100%;
            height: 60px;
            font-size: 11px;
            resize: none;
            border: 1px solid #333;
            padding: 2px 4px;
        }

        /* Payment Method inline checkboxes */
        .payment-method {
            display: flex;
            gap: 12px;
            margin-top: 12px;
        }

        .payment-method label {
            font-weight: normal;
            font-size: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .payment-method input[type="checkbox"] {
            transform: scale(1.1);
            cursor: pointer;
        }

        /* Storage Costs Table */
        .storage-costs {
            margin-top: 10px;
            font-size: 9px;
            border-collapse: collapse;
            width: 100%;
        }

        .storage-costs th,
        .storage-costs td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        .storage-costs th {
            background: #ddd;
            font-weight: bold;
        }

        /* Conditions table rows */
        .conditions-header {
            font-weight: bold;
            text-align: center;
            background: #eee;
        }

        /* Right side main points */
        .main-points {
            flex: 1;
            font-size: 9px;
            line-height: 1.3;
        }

        .main-points strong {
            font-weight: 700;
        }

        .main-points ul {
            margin: 6px 0 0 16px;
            padding: 0;
            list-style: disc outside;
        }

        .main-points ul li {
            margin-bottom: 5px;
        }

        .main-points .important {
            color: #990000;
            font-weight: 700;
        }

        /* Footer signatures and stamps */
        .sign-stamp-container {
            margin-top: 0px;
            font-size: 9px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .sign-stamp-container .signature {
            flex: 1;
        }

        .sign-stamp-container .stamp {
            width: 100px;
            height: 100px;
            border: 2px solid #000;
            border-radius: 50%;
            padding: 6px;
            font-size: 8px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.1;
            color: #003366;
            font-weight: 700;
        }

        /* Footer bottom center small text */
        footer {
            margin-top: 35px;
            font-size: 9px;
            color: #444;
            text-align: center;
            font-weight: 600;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Underlined lines for text input placeholders */
        .underline {
            border-bottom: 1.5px solid black;
            display: inline-block;
            min-width: 150px;
            margin-left: 6px;
            height: 1.2em;
        }

        /* mPDF Specific Header/Footer */
        @page {
            header: html_myHeader;
            footer: html_myFooter;
            margin-top: 30mm;
            margin-bottom: 20mm;
        }
    </style>
</head>

<body>
    <htmlpageheader name="myHeader">
        <div style="text-align: right; padding-right: 15px; margin-top: 10px;">
            <img src="{{ asset('public/admin/assets/img/logo.png') }}" style="height: 45px;">
        </div>
    </htmlpageheader>

    <htmlpagefooter name="myFooter">
        <div
            style="border-top: 1px solid #e5e7eb; padding-top: 10px; font-size: 10px; text-align: center; color: #64748b;">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="text-align: left; border: none;">Email: support@vendorscity.com</td>
                    <td style="text-align: center; border: none;">Page {PAGENO} of {nbpg}</td>
                    <td style="text-align: right; border: none;">Website: www.vendorscity.com</td>
                </tr>
            </table>
        </div>
    </htmlpagefooter>

    <body style="font-family: Arial, sans-serif;">
        <div class="row" style="">
            <div style="flex: 0 0 auto;">
                <p class="title" style="font-size: 15px;text-align:center">(AGREEMENT & Terms & Condition)</p>
            </div>
        </div>
        <table style="width: 100%; margin-top: 0px; ">
            <tr>
                <td style="width: 15%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-size: 13px;"><strong>Date:</strong></td>
                            <td style="border-bottom: 1px solid #000;font-size: 13px;">
                                {{ isset($warehouseData->agreement_date) ? date('d-m-Y', strtotime($warehouseData->agreement_date)) : date('d-m-Y') }}
                            </td>
                        </tr>
                    </table>
                </td>

                @php

                @endphp

                <td style="width: 30%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>

                        </tr>

                    </table>
                </td>

                {{-- <td style="width: 30%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-size: 13px;"><strong>Client Name:</strong></td>

                            <td style="border-bottom: 1px solid #000;font-size: 13px;">
                                {{ $enquiryData->client_name ?? '' }}
                            </td>
                        </tr>

                    </table>
                </td> --}}
                @if (isset($warehouseData->trade_license))
                    <td style="width: 30%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="font-size: 13px;"><strong>Company Trade License No:</strong></td>
                                <td style="border-bottom: 1px solid #000;font-size: 13px;">
                                    {{ $warehouseData->trade_license ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                @endif
                @if (isset($warehouseData->emirate_id))
                    <td style="width: 30%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="font-size: 13px;"><strong>Emirates Id No:</strong></td>
                                <td style="border-bottom: 1px solid #000;font-size: 13px;">
                                    {{ $warehouseData->emirate_id ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                @endif




            </tr>
        </table>

        <table style="width:100%; margin-top: 0px; ">

            <tr>
                <td style="width: 50%; vertical-align: top;">

                    <table>
                        <tr>
                            <td style="font-size: 13px;"><strong>Warehouse :</strong></td>
                            <td style="border-bottom: 1px solid #000;font-size: 13px;">
                                {{ $warehouseData->warehouse_name ?? '' }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table>
                        <tr>
                            <td style="font-size: 13px;"><strong>Unit No.:</strong></td>
                            <td style="border-bottom: 1px solid #000;font-size: 13px;">
                                {{ $warehouseData->unit_no ?? '' }}
                            </td>
                        </tr>
                    </table>
                </td>





            </tr>

        </table>


        <table style="width: 100%;">
            <tr>
                <td style="width: 15%;font-size: 10px;"><strong>CUSTOMER DETAILS</strong></td>
            </tr>
        </table>


        <table style="width: 100%; margin-top: 0px; ">


            <tr>
                <td style="width: 10%;font-size: 13px;"><strong>Name of the Person:</strong></td>
                <td style="width: 70%; border-bottom: 1px solid #000;font-size: 13px;">
                    {{ $enquiryData->client_name ?? '' }}
                </td>
            </tr>
        </table>
        <table style="width: 100%; margin-top: 0px; ">
            <tr>
                <td style="width: 15%;font-size: 13px;"><strong>Home /Business Address:</strong></td>
                <td style="width: 70%; border-bottom: 1px solid #000;font-size: 13px;">
                    {{ $enquiryData->client_address ?? '' }}
                </td>
            </tr>
        </table>
        <table style="width: 100%; margin-top: 0px; ">
            <tr>
                <td style="width: 15%;font-size: 13px;"><strong>Mobile:</strong></td>
                <td style="width: 70%; border-bottom: 1px solid #000;font-size: 13px;">
                    {{ $enquiryData->client_mobile ?? '' }}
                </td>
            </tr>
        </table>
        <table style="width: 100%; margin-top: 0px; ">
            <tr>
                <td style="width: 15%;font-size: 13px;"><strong>Email:</strong></td>
                <td style="width: 70%; border-bottom: 1px solid #000;font-size: 13px;">
                    {{ $enquiryData->client_email ?? '' }}
                </td>
            </tr>
        </table>



        <table style="width: 100%; margin-top: 0px; ">

            <tr>
                <td style="width: 20%;font-size: 13px;"><strong>Home Address:</strong></td>
                <td style="width: 70%; border-bottom: 1px solid #000;font-size: 13px;">-</td>
            </tr>

        </table>



        <table style="width: 100%; margin-top: 0px; ">

            <tr>
                <td style="width: 100%;font-size: 12px;text-align:center;"><strong>(Please advise us immediately if your
                        address or contact numbers or those of your alternate person change)</strong></td>
            </tr>

        </table>

        <table border="0" cellpadding="5" cellspacing="0"
            style="width:100%; font-family:Arial, sans-serif; font-size:12px;">
            <tr>
                <!-- Left Side -->
                <td style="width:70%; vertical-align:top; border-right:1px solid #000;">
                    <div style="margin-bottom:8px;">

                        @if ($storageAmount > 0)
                            <strong>Storage Rate:</strong>
                            <u>
                                <strong>AED {{ number_format($storageFinal, 2) }}</strong>

                                @if ($vatEnabled == 1)
                                    <strong>(VAT 5% included)</strong>
                                @endif

                                for Volume In CBM: {{ $enquiryData->volume_in_cbm ?? '' }}
                            </u>
                        @endif





                    </div>


                    <div style="margin-bottom:8px;">
                        <strong>Agreement from:</strong> <span
                            style="border-bottom: 1px solid #000;">{{ isset($warehouseData->agreement_date) ? date('d-m-Y', strtotime($warehouseData->agreement_date)) : '' }}</span>
                    </div>

                    <div style="margin-bottom:8px;">
                        <strong>Payments Terms Period:</strong>



                    </div>

                    <div>
                        <strong>Payment Method:</strong>
                        Cash <input type="checkbox">
                        Cheque <input type="checkbox">
                        Bank Debit <input type="checkbox">
                        Card <input type="checkbox">
                    </div>
                </td>

                <!-- Right Side -->
                <td style="width:30%; vertical-align:top; padding-left:10px;">
                    <strong>Space Access:</strong><br>
                    Access to the stored goods will be:<br>
                    - Business Hours (Mon – Sat 8:00am to 05:00pm)<br>
                    - On Request: Before 24 hour(s) notice required
                </td>
            </tr>
        </table>

        <table border="1" cellpadding="5" cellspacing="0"
            style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:12px;">
            <tr>
                <!-- Left Side -->
                <td style="width:65%; vertical-align:top;">
                    <strong>STORAGE COSTS:</strong> <span style="font-size:12px;">(Payable on the date of
                        <u>agreement</u>)</span><br><br>
                    @if ($hasSecurity && $securityAmount > 0)
                        Deposit: AED {{ number_format($securityAmount, 2) }}<br><br>
                    @endif

                    Late Payment Fee AED 250/- applied after due Date<br><br>


                    <table border="1" cellpadding="5" cellspacing="0"
                        style="width:100%; border-collapse:collapse; text-align:center;">
                        <tr>
                            <th style="width:20%;">Storage Type</th>
                            <th>
                                Business ☐
                            </th>
                            <th>
                                Personal ☐
                            </th>
                            <th>(CONDITION)</th>
                            <th>
                                New ☐
                            </th>
                            <th>
                                Used ☐
                            </th>
                        </tr>
                    </table>


                    <br>

                    <div style="margin-bottom:8px;">
                        <strong>List of Items : As per packing list / Tally Sheet:</strong>
                    </div>

                    <br>
                    <div
                        style="font-size:12px; text-align:center; font-weight:bold; border-top:1px solid #000; padding-top:5px;">
                        PLEASE READ CONDITIONS OVERLEAF CAREFULLY AS BY SIGNING THIS AGREEMENT YOU WILL BE BOUND BY
                        THEM
                    </div>
                    <p style="font-size:12px;">
                        I/We agree to be bound by the conditions of this Agreement as shown overleaf.
                    </p>

                    Customer Signature: -<br><br>
                    Date of this Agreement: -<br><br>

                    <strong>Accepted by VendorsCity</strong><br>
                    Signature & Stamp<br><br>
                    <img src="{{ asset('public/admin/assets/img/vc-sign.jpeg') }}" alt="Stamp" style="width:100px;">
                </td>

                <!-- Right Side -->
                <td style="width:35%; vertical-align:top; padding-left:10px;">
                    <strong>MAIN POINTS (SEE OVER)</strong>
                    <ul style="margin-top:5px; padding-left:20px; font-size:12px;">
                        <li>All payments are to be made in advance by you (the Customer).</li>
                        <li>Storage invoice will generate for every 30 days (monthly) or as agreed.</li>
                        <li>The Space will only be accessible during set access hours.</li>
                        <li>1-month notice must be given for termination of this agreement if
                            your agreement is for 6 month or 1year.</li>
                        <li>The Customer must notify the Owner of all changes of address and contact telephone numbers.
                        </li>
                        <li>If you fail to comply with the conditions of this agreement the VendorsCity will
                            have certain rights which include forfeiture of your Deposit and the right to seize and sell
                            and/or dispose of your goods.</li>
                        <li>Goods that are of all sorts hazardous, illegal, stolen, inflammable, explosive,
                            environmentally harmful, liquid, batteries, gas and perishable or that are a risk to the
                            property of any person should not be stored.</li>
                        <li>The customer must not store items which are irreplaceable, such as currency, jewelry, furs,
                            deeds, paintings, and antiques, curios, artifacts of art and items of personal sentimental
                            value.</li>
                        <li>If you are self-storage customer, please put your own padlock to avoid any inconvenience /
                            you’re responsible for your inventory.</li>
                        <li>15 days’ notice must be given for termination of this agreement if your agreement is monthly
                            basis.</li>
                        <li>This is monthly agreement. If you break the monthly agreement and if you extend the storage
                            on daily/weekly basis, then there will be minimum charges applicable based on number of days
                            you stored and based on volume of your shipment.</li>
                    </ul>
                    <p style="font-weight:bold; font-size:12px;">
                        I/we acknowledge that these main points have been drawn to my/our attention
                    </p><br><br>
                    <p style="font-size:12px;">
                        Customer’s Signature & Stamp]....................................................
                    </p>
                </td>
            </tr>
        </table>

        <table border="1" cellpadding="5" cellspacing="0"
            style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:12px; line-height:1.4;margin-top:10px">

        </table>
        <table border="1" cellpadding="5" cellspacing="0"
            style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:12px; line-height:1.4;">
            <tr>
                <!-- Left Column -->
                <td style="width:50%; vertical-align:top;font-size:12px;">
                    <p style="font-size:12px;">
                        <strong>1. Acceptance</strong><br>
                        1.1 Upon execution of this Storage Contract (the “Agreement”) by both VendorsCity
                        LLC (“VendorsCity”) and the Customer, the Agreement becomes a binding contract between the
                        Customer and VendorsCity. This will include provision of services outlined in the agreement
                        which include storage, transportation, freight, and inventory control, sale of packaging
                        materials and any other related service or product (the Services”). The Customer’s execution of
                        the Agreement and / or acceptance of any service and / or products details shall constitute the
                        Customer’s acceptance of the terms and conditions herein, and the exclusion of any terms and
                        conditions otherwise stated by the Customer, or contained within the Customer’s purchase
                        documents, or correspondences which conflict with or limit the terms and conditions fixed
                        herein. <br><br>

                        <strong>2.0 Prices</strong><br>
                        2.1 Quoted prices are subject to change by VendorsCity prior to VendorsCity’s execution and
                        acceptance of the Agreement, on the Agreement becoming binding on both parties, prices are
                        subject to change for any service or sale of items(s) yet to be provided / delivered, such
                        change shall be notified to the Customer in writing. The Customer agrees to pay any taxes and /
                        or duties arising under the Agreement. <br><br>

                        <strong>3.0 Service Provision</strong><br>
                        3.1 VendorsCity will provide the services on receipts of the first month’s payment and a
                        security deposit equivalent to a one-month storage fee. This security deposit will be refunded
                        within 7 working days after checkout. This Agreement does not construe a lease or rental
                        agreement. The monthly renewal fee will be applied automatically if there is no written
                        confirmation 14 days prior to the renewal date or expiration date and all dues are cleared. The
                        security deposit cannot be used towards payment for any services and will be held as security
                        until the Customer vacates the storage unit. The Customer agrees that the Fee is being paid for
                        the use of the space only and VendorsCity assume no responsibility or risk for any item that may
                        be stored in the Storage Space.<br><br>

                        <strong>4.0 Payment </strong><br>
                        4.1 The payment structure will be outlined in the Agreement and may take the form of a single
                        payment for the entire duration of the Agreement, or monthly payments made at the time of
                        commencement of the Agreement. One month’s storage fee will be payable as a security deposit at
                        the time of commencement of the Agreement, along with payment of the first month of storage.
                        Payments are required at the commencement of each month of storage. For Credit Card payments,
                        there will be an additional processing fee of 2.5%. Charges and penalties are applicable to any
                        returned cheques or declined credit card payment, which will be AED 300.00 per transaction to
                        any bank charges.<br><br>

                        <strong>5.0 Non-Payment </strong><br>
                        5.1 Failure to pay for your storage for a period of 30 days will result in ownership of the
                        property stored in the storage unit being transferred to VendorsCity for disposal or to recover
                        any outstanding balance from the Customer. VendorsCity will have no obligation whatsoever to
                        disclose information concerning action taken, if any. Any such action shall not affect
                        VendorsCity’s
                        right to take necessary legal measures to obtain payment for services provided to the
                        Customer. Customer Pledge: In the event of non-payment, I, the customer authorizes VendorsCity
                        to overlock my storage unit. At thirty (30) days overdue, I authorize VendorsCity to dispose of
                        my items that are stored under this agreement. I, as the customer, will be fully responsible for
                        settling all dues with VendorsCity and won't be entitled to submit any claim legally as I fully
                        understand the consequences of non-payment.<br><br>

                        <strong>6.0 Default of Prompt Payment</strong><br>
                        In default of prompt payment from the Customer’s debt, the Customer
                        authorizes VendorsCity to: <br>
                        6.1 At seven (7) days overdue, charge AED 100.00 late fee (payable in cash).<br>
                        6.2 On the fourteenth (14th) day after the renewal date, charge AED 300.00 late fee (payable in
                        cash).<br>
                        6.3 Charge a minimum fee of AED 100.00 for clearance of the unit and any extra charges for the
                        removal and transfer of any items left behind by the Customer.<br>
                        6.4 For any returned cheques, the bounce charge of AED 250 per cheque (payable in cash only)
                        shall be due immediately to VendorsCity.<br>
                        6.5 For any changed cheque, a fee of AED 150 (payable in cash only) shall be due immediately to
                        VendorsCity.<br>
                        6.6 Refuse the customer and his agents access to the goods, the unit and the site.<br>
                        6.7 In the event that your debt is not paid promptly or you fail to collect the goods after we
                        have required you to collect them or upon expiry or termination of this Agreement, VendorsCity
                        may, at its discretion and without your consent or application to a court, sell the goods and
                        use the proceeds of sale to pay first the costs incurred by VendorsCity in the sale and removal,
                        and secondly in paying the Customer’s debt, and holds Customer still liable for the balance
                        left.<br>
                        6.8 VendorsCity hereby exercises its right of lien over the goods currently stored
                        in our facility until all dues are cleared in full.<br>

                    </p>
                </td>

                <!-- Right Column -->
                <td style="width:50%; vertical-align:top;font-size:12px;">
                    <strong>7.0 Contents of Storage</strong><br>
                    7.1 The Customer undertakes that they are the legal owner of the items being stored or is otherwise
                    authorized to execute the Agreement on behalf of the lawful owner. The Customer is responsible for
                    ensuring that descriptions of the items being stored are provided and the total value is accurate
                    and up to date as this may be required by relevant authorities. Items being stored must be packaged
                    suitably for storage purposes and must not be prone to fire, leakage, moisture, foul smell,
                    contamination or explosion. Food or perishable items and animals or live creatures may not be
                    stored. Hazardous goods as described within VendorsCity’s insurance coverage are expressly
                    forbidden.<br><br>
                    7.2 The Customer undertakes not to store items directly or indirectly in violation of the laws of
                    the United Arab Emirates. VendorsCity will not be liable or responsible for any violation of this
                    clause by the Customer and may, if necessary, remove items from storage if deemed as high risk, or
                    if requested to do so by the local authorities.<br><br>

                    <strong>8.0 Storage Access</strong><br>
                    8.1 If the Customer wishes to authorize a third-party access to the storage facility, they may do so
                    by providing an authorization letter attaching the emirates ID copy of the person they wish to have
                    the access. This letter will be considered valid until the VendorsCity doesn’t receive a written
                    letter to revoke the authorization letter and will be held 0 responsibility of the items in case of
                    mutual disputes between the Storer and the authorized third party. Individual storage units are
                    locked by a padlock belonging to the Customer. The Customer may request that VendorsCity maintain a
                    duplicate padlock key for provision of transportation or inventory control services defined in the
                    Agreement where applicable. Although the Customer has access to the storage facility 8am – 5pm
                    Monday to Saturday, VendorsCity will not accept any liability for inability to access the facility
                    for any reason whatsoever. No access on public holidays (additional AED 100 will be applicable)<br>
                    8.2 The Customer may request VendorsCity to manage the items as described in the Agreement. This
                    request should be put in writing and signed by both parties. VendorsCity will not accept any
                    liability whatsoever for the storage, managing, handling and in-transit of these items.<br><br>

                    <strong>9.0 Insurance</strong><br>
                    9.1 Our standard full replacement insurance is 2.5% of the declared value. You are strongly
                    recommended to insure goods against all insurable risks during the storage. The value should be
                    based on your replacement values. Minimum premium AED 500.00. A detailed inventory with values of
                    pieces needs to be submitted.<br>
                    9.2 Insurance covers only if there is any theft or fire. Notification of any loss of the goods must
                    be reported to VendorsCity in writing, within 24 hours of the incident.<br><br>

                    <strong>10.0 Termination</strong><br>
                    10.1 The Customer or VendorsCity may terminate the Agreement on giving fourteen (14) days’ notice
                    (the “Notice Period”), in writing, to the other party. In the event that the Customer terminates the
                    Agreement, the Customer will be liable for the payment for the current month as set out in Clause 4.
                    The current month will be defined as the payment month occurring on the fourteenth (14th) day of the
                    Notice Period. Any discount granted by the customer for long-term agreements will be forfeited and
                    the refund, if any, will be based on actual rate. If VendorsCity terminates the Agreement and the
                    Customer does not claim the items being stored within one week after the Notice Period, VendorsCity
                    will act as set out in Clause 5.<br><br>

                    <strong>11.0 Miscellaneous</strong><br>
                    11.01 Governing Law
                    These Terms and Conditions (together with all documents referred to herein) shall be governed by and
                    construed in accordance with the laws of the United Arab Emirates. Each party irrevocably agrees
                    that the courts of the United Arab Emirates shall have exclusive jurisdiction in relation to any
                    claim, dispute or difference concerning these Terms and Conditions and any matter arising
                    therefrom.<br>

                    <strong>11.02 Force Majeure.</strong><br>
                    The Parties to this Agreement shall be released from liability for failure to perform any of the
                    obligations hereunder where such failure to perform occurs by reason of any act of God, fire,
                    pandemic, cyclone, storm, earthquake, tidal wave, communication failure, sabotage, war, military
                    operation, national emergency, mechanical or electrical breakdown, malfunction of any communications
                    media, insurrection, riot, civil commotion, governmental proclamation, regulation or priority
                    failure or interruption (whether partial or total) of power supplies or other utility service,
                    strike or other stoppage (whether similar or dissimilar to any of the foregoing) of labour, any law,
                    decree, regulation, order, requisition, request or recommendation of any government, governmental
                    body, governmental agencies or acting governmental authority (including any court or tribunal),
                    either party’s compliance therewith, or any other cause beyond either party’s reasonable control,
                    whether similar or dissimilar to such causes<br>
                    <strong>11.03 Notices.</strong><br>
                    All notices and other communications required by this Agreement to be in writing must be sent to the
                    recipient by hand, pre-paid post, courier (at the address as set forth in the Cover Letter) or email
                    (at the address as set out below) or to such other address or email address as a party may notify
                    the other party in writing.<br>

                </td>
            </tr>
        </table>



        <table border="1" cellpadding="5" cellspacing="0"
            style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:12px; line-height:1.4;">
            <tr>
                <!-- Left Column -->
                <td style="width:50%; vertical-align:top;font-size:12px;">
                    <span
                        style="font-size:14px; color:red; font-weight:bold; text-decoration:underline;width:100%; text-align:center; display:block; margin-bottom:10px;">
                        PROHIBITED GOODS
                    </span>
                    <p style="font-size:12px;">
                        <strong>You are prohibited from storing the following:</strong><br>
                    </p>
                    <ul style="margin-top:5px; padding-left:20px; font-size:12px;font-weight:bold;">
                        <li>Explosives</li>
                        <li>Firearms</li>
                        <li>Ammunitions</li>
                        <li>Toxic materials</li>
                        <li>Hazardous goods</li>
                        <li>Radioactive goods</li>
                        <li>Pornography materials</li>
                        <li>Lithium batteries</li>
                        <li>Chemicals</li>
                        <li>Illegal goods</li>
                        <li>Alcohol</li>
                        <li>Pollutants</li>
                        <li>Contaminant goods</li>
                        <li>Cash, Jewellery & securities</li>
                        <li>Live animals, Skin, stuffed species</li>
                        <li>Living plants</li>
                        <li>Perishable goods</li>
                        <li>Waste</li>
                    </ul>
                    <p style="font-size:12px;font-weight:bold;">
                        If in doubt, ask a member of staff for help.<br>
                    </p>




                </td>

                <!-- Right Column -->
                <td style="width:50%; vertical-align:top;font-size:12px;">
                    <p
                        style="font-size:14px;color:red;font-weight:bold; text-align:center; margin:5px 0; text-decoration:underline;">
                        TIPS FOR SAFE STORAGE</p>
                    <p style="font-size:12px;">
                        <strong>Check the following prior to storing:</strong><br>
                    </p>

                    <ul style="margin-top:5px; padding-left:20px; font-size:12px;font-weight:bold;">
                        <li>Refrigerators/Freezers
                            Before storing, allow to dry and wedge door open
                        </li>
                        <li>Washing Machines
                            Drain fully of all water residue
                        </li>
                        <li>Cookers and Cooking Equipment
                            Ensure they are clean and free of grease.
                        </li>
                        <li>Clothing and Bedding
                            Store flat in boxes and do not place in plastic bags.
                            Use wardrobe boxes if possible.
                        </li>
                        <li>Books and Documents
                            Store flat in boxes and do not place on floor.
                        </li>
                        <li>Machines with Fuel Tanks
                            Any machines, e.g. lawnmowers or go-karts, must be completely drained of fuel.
                        </li>
                        <li>Stacking- Carefully stack items to prevent toppling and leave an air gap between items and
                            walls.</li>
                    </ul>


                </td>
            </tr>
        </table>
        <p style="font-weight:bold; font-size:12px;">
            To assist you in the safe packing of your goods an extensive rage of packing materials can be provided by
            QSR at reasonable rates.
        </p>
        <p style="font-weight:bold;font-size:12px;">
            Our staff will be happy to discuss your requirements with you.
        </p>
        <p style="font-weight:bold;font-size:12px;">
            NB: Partition walls are not load-bearing – do not lean heavy items against them.
        </p><br><br>
        <table style="width: 100%; margin-top: 0px; ">

            <tr>
                <td style="width: 100%;font-size: 14px;"><strong>I accept the above terms and conditions of this
                        agreement.</strong></td>
            </tr>

        </table><br><br><br><br>

        <table style="width: 100%; margin-top: 0px; ">

            <tr>
                <td style="width: 20%;font-size: 14px;"><strong>Customer’s Signature & Stamp] </strong></td>
                <br><br><br>
                <td style="width: 20%;font-size: 14px;"><strong>....................................................
                    </strong></td>
            </tr>

        </table>


    </body>



</html>
