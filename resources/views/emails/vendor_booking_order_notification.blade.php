
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>Account Registration:</title>
 <style>
     .logo {
         border-bottom: 4px solid #FFD413;
     }
     .logo img{
         width: 45%;
     }
     .wrapper {
         width: 100%;
         max-width:500px;
         margin:auto;
         font-size:14px;
         line-height:24px;
         font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
         color:#555;
         padding:50px 0;
     }   
     .email_wrapper {
         width:100%;
         margin-top: 18px;
         font-size: 16px;
     }
     h2 {
         font-size: 26px;
         font-weight: bolder;
         margin: 0;
     }
     .btnlink {
         background: #0040E6;
         color: #fff !important;
         text-decoration: none;
         width: 100%;
         display: block;
         padding: 9px 0;
         text-align: center;
         font-size: 16px;
         border-radius: 9px;
     }
     .email_footer {
         width:100%;
         margin-top: 20px;
     }
     h3 {
         font-size: 20px;
         font-weight: bolder;
         margin: 0;
         border-bottom: 3px solid #6B7177;
         padding-bottom: 20px;
         margin-bottom: 15px;
     }
     .email_footer_div {
         width:100%;
         display: flex; 
     }
     .footer_left {
         width: 100px;
         float: left;
     }
     .footer_right {
         margin-left:10px;
         float: left;
     }
     .footer_right p{
         margin:0;
     }
     .footer_links {
         margin:10px 0;
     }
     .footer_links a {
         width: 100%;
         color: #555;
         display: inline-block;
     }

     .custom_col_2{
        width: 18%;
    display: inline-block;
    }

    .custom_col_8{
        width: 75%;
    display: inline-block;
    }

    .custom_col_2_payment{
        width: 29%;
    display: inline-block;
    }

    .custom_col_8_payment{
        width: 70%;
        text-align: right;
    display: inline-block;
    }
        .main_row{margin:10px 0;}
    .custom_col_2 h5{font-size: 17px;margin: 0;}
    .custom_col_8 p{margin: 0;}

    .custom_col_2_payment h5{font-size: 17px;margin: 0;}
    .custom_col_8_payment p{margin: 0;}
 </style>
</head>
<body>
    @php
        $firstItem = $orders->flatMap->items->first();
    @endphp
    <div class="wrapper" style="width: 100%;max-width:500px;margin:auto;
                            font-size:14px;line-height:24px;
                            font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color:#555;padding:50px 0;">
    <div class="logo" style="float: inherit;border-bottom: 4px solid #FFD413;">
    <img src="{{asset("public/site/images/VC-FULL-COLOR.png")}}" style="width: 40%;" >
    </div>

     <div class="email_wrapper" style="width:100%;margin-top: 18px;font-size: 16px;" >

                        <p> <strong> Dear </strong>{{ $vendor->name ?? 'Vendor' }}</p>
                        <p>We are excited to inform you that a new customer has requested a Booking for {{ \Helper::servicename($firstItem->service_id)}} on VendorsCity!</p>

                       <p><strong>Request Details:</strong></p>
                        <ul><li style= "list-style-type: disc;margin-bottom: -15px;"> Service Requested : {{ \Helper::subservicename($firstItem->subservice_id)}}</li>
                                                   
                        <li style= "list-style-type: disc;margin-bottom: -15px;"> Customer Name : {{ $user['name'] ?? 'Customer' }}</li>
                        {{-- <li style= "list-style-type: disc";> Request Date : '.$Date.'</li> --}}
                    </ul>                  
                       <hr>

                       <p><a class="btnlink" href="{{route("vendor.login")}}" style=" background: #0040E6;color: #fff !important;text-decoration: none;width: 100%;display: block;padding: 9px 0;text-align: center;
                    font-size: 16px;border-radius: 9px;">View Request</a></p>

                <p><strong>What You Need to Do:</strong></p>
                <ul><li style= "list-style-type: disc;margin-bottom: -15px;"> Log in to your : <a href="{{ route("vendor.login")}}">Vendor Portal</a></li>
                <li style= "list-style-type: disc";> View the full request details and customer information.</li></ul>
                       <div class="main">
                        

                    <div class="heading" style="font-weight: bold;font-size: 20px;
                        <div class="email_footer" style="width:100%;margin-top: 20px;">
                        <h3 style=" font-size: 20px;font-weight: bolder;margin: 0;
                        border-bottom: 3px solid #6B7177;padding-bottom: 20px;
                        margin-bottom: 15px;">The VendorsCity Team</h3>
                        <div class="email_footer_div" style=" width:100%;
                        display: flex; ">
                            <div class="footer_left" style="width: 100px;
                        float: left;">
                                <img style="width:70%;" src="{{asset("public/site/images/vcfaviconwap.png")}}" >
                            </div>
                            <div class="footer_right" style="margin-left:10px;
                            float: left;">
                                <p style="margin:0;">Questions? Email <a style="color: #555;" href="mailto:support@vendorscity.com">support@vendorscity.com</a></p>
                                <p style="margin:0;">VendorsCity Portal LLC</p>
                                <div class="footer_links" style=" margin:10px 0;">
                            <a href="" style="width: 100%;color: #555;display: inline-block;">Terms of Use</a>
                            <a href="" style="width: 100%;color: #555;display: inline-block;">Privacy Policy</a>
                            <a href="" style="width: 100%;color: #555;display: inline-block;">Contact Us</a>
                            </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </body>

 
     
 
 </html>
