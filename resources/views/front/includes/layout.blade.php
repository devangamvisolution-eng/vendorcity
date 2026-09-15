<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VendorsCity - Home Services')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fcfcfc;
        }

        .logo {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -1px;
            display: inline-block;
            text-decoration: none;
        }

        .logo-vendors {
            color: #4338ca;
            text-shadow: 0 2px 10px rgba(30, 17, 209, 0.2);
        }

        .logo-city {
            color: #ffc107;
            text-shadow: 0 2px 10px rgba(255, 193, 7, 0.2);
        }

        /* Custom Styles for Categories (Fixing the cut-off yellow tag) */
        .category-scroll {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
            padding-top: 1.5rem;
            /* This padding provides space for the yellow tag */
            padding-bottom: 1rem;
        }

        .category-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-item {
            text-align: center;
            min-width: 80px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background-color: #eef2ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem auto;
            position: relative;
            transition: background-color 0.3s;
        }

        .category-item:hover .icon-box {
            background-color: #e0e7ff;
        }

        .yellow-tag {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ffc107;
            color: #212529;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            white-space: nowrap;
        }

        /* Service Cards */
        .service-card {
            border: none;
            border-radius: 12px;
            background: transparent;
            cursor: pointer;
            transition: transform 0.3s;
            margin-bottom: 1.5rem;
        }

        .service-card .img-wrapper {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            height: 180px;
            margin-bottom: 0.75rem;
        }

        .service-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .service-card:hover img {
            transform: scale(1.05);
        }

        .card-tag {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: #ffc107;
            color: #212529;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .service-card h3 {
            font-size: 14px;
            font-weight: 700;
            color: #212529;
            transition: color 0.3s;
            margin: 0;
        }

        .service-card:hover h3 {
            color: #4338ca;
        }

        /* Header Search */
        .header-search {
            border-radius: 50px;
            padding-left: 2.5rem;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        /* Mega Menu */
        .mega-menu {
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
            pointer-events: none;
            display: block !important;
        }

        .mega-menu.show {
            opacity: 1;
            pointer-events: auto;
        }

        .hover-primary:hover {
            color: #4338ca !important;
        }
    </style>
</head>

<body class="antialiased">

    @php
        $megaMenuData = [
            'Moving & Storage' => ['Local moving', 'International moving', 'Storage', 'Car shipping'],
            'Cleaning Services' => [
                'Home cleaning services',
                'Deep cleaning',
                'Laundry services',
                'Shoe cleaning',
                'Sofa cleaning',
                'Carpet cleaning',
                'Curtain cleaning',
                'Mattress cleaning',
                'Office cleaning services',
                'Water tank cleaning',
                'Window cleaning for villas',
                'Pool cleaning',
            ],
            'Maintenance & Handyman' => [
                'Handyman',
                'Carpentry',
                'Electrician',
                'Furniture assembly',
                'Locksmiths',
                'Plumber',
                'TV Mounting',
                'Painting',
            ],
            'AC Services' => ['AC Cleaning', 'AC duct cleaning', 'AC installation', 'AC maintenance', 'AC repair'],
            'Salon at Home' => [
                'Women\'s Salon At Home',
                'Spa at Home',
                'Men\'s Salon at Home',
                'Luxury Salon at Home',
                'Lashes and Brows at Home',
                'Henna Services At Home in Dubai',
            ],
            'Pet Services' => ['Pet grooming', 'Mobile Vet'],
            'Pest Control and Gardening' => [
                'Pest control',
                'Cockroach pest control',
                'Ants pest control',
                'Mosquitoes pest control',
                'Bed bugs pest control',
                'Rats and mice pest control',
                'Gardening',
            ],
            'Health at Home' => [
                'Blood Tests at Home',
                'Doctor on Call',
                'Nurse at Home',
                'Flu Vaccination at Home',
                'Physiotherapy at Home',
                'IV Drip at Home',
            ],
            'Nannies and Maids' => ['Babysitters and nannies', 'Full-time maids', 'Part-time maids'],
            'Car Services at Home' => ['Car Wash at Home', 'Car Service at Home', 'Car Window Tinting at Home'],
        ];
    @endphp

    <!-- Header -->
    <!-- Header -->
    <header class="bg-white sticky-top shadow-sm border-bottom py-3">
        <div class="container position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Left side -->
                <div class="d-flex align-items-center gap-3 gap-md-4">
                    <a href="/" class="logo">
                        <span class="logo-vendors">Vendors</span><span class="logo-city">City</span>
                    </a>
                    <button id="btnAllServices" class="btn btn-sm d-none d-md-flex align-items-center fw-bold"
                        style="background-color: #f8f9fa; border: 1px solid #dee2e6; color: #4338ca; border-radius: 8px;">
                        <i class="bi bi-grid-fill me-2"></i>
                        All Services
                    </button>
                </div>

                <!-- Middle: Search -->
                <div class="flex-grow-1 mx-4 d-none d-lg-block position-relative" style="max-width: 600px;">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="form-control header-search shadow-sm"
                        placeholder='Search for "Car Wash"'>
                </div>

                <!-- Right side -->
                <div class="d-flex align-items-center gap-3 gap-md-4">
                    <div class="d-none d-sm-flex align-items-center gap-2" style="cursor: pointer;">
                        <span class="fw-bold small text-dark">العربية</span>
                        <div
                            style="width: 24px; height: 16px; display:flex; border-radius: 2px; overflow: hidden; border: 1px solid #dee2e6;">
                            <div style="width: 33.33%; background: #FF0000;"></div>
                            <div style="width: 66.67%; display: flex; flex-direction: column;">
                                <div style="height: 33.33%; background: #00732F;"></div>
                                <div style="height: 33.33%; background: #FFFFFF;"></div>
                                <div style="height: 33.33%; background: #000000;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center px-3 py-1 border rounded-pill shadow-sm bg-white"
                        style="cursor: pointer;">
                        <span class="fw-bold small me-2 text-dark">Suhaan M.</span>
                        <i class="bi bi-list fs-5 text-dark"></i>
                    </div>
                </div>
            </div>

            <!-- Mobile Search Bar (shows only on small screens) -->
            <div class="d-block d-lg-none mt-3 position-relative">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control header-search shadow-sm" placeholder='Search for "Car Wash"'>
            </div>

            <!-- Mega Menu Dropdown -->
            <div id="megaMenu" class="mega-menu position-absolute w-100 bg-white shadow-lg border rounded-bottom"
                style="left: 0; top: 100%; z-index: 1050; max-height: 80vh; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; margin-top: 1rem;">
                <style>
                    #megaMenu::-webkit-scrollbar {
                        display: none;
                    }
                </style>
                <div class="p-4 position-relative">
                    <button id="closeMegaMenu"
                        class="btn btn-sm position-absolute rounded-circle d-flex align-items-center justify-content-center p-0 shadow-sm"
                        style="background-color: #f15922; right: 15px; top: 15px; width: 28px; height: 28px; border: none; z-index: 10;">
                        <i class="bi bi-x text-white fs-5"></i>
                    </button>

                    <!-- Use a masonry-like CSS column layout or flex for the dense list -->
                    <div class="row" style="column-count: 4; column-gap: 2rem; display: block;">
                        @foreach ($megaMenuData as $category => $items)
                            <div class="mb-4 d-inline-block w-100" style="break-inside: avoid;">
                                <h5 class="fw-bold mb-3 text-dark" style="font-size: 15px;">{{ $category }}</h5>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($items as $item)
                                        <li class="mb-2"><a href="#"
                                                class="text-decoration-none text-secondary hover-primary"
                                                style="font-size: 14px;">{{ $item }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </header>

    <main class="min-vh-100 pb-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-white pt-5 pb-4" style="background-color: #222;">
        <div class="container">

            @php
                $footerServices = [
                    'Maid Service',
                    'Carpet Cleaning',
                    'Mattress Cleaning',
                    'Sofa Cleaning',
                    'Curtain Cleaning',
                    'Deep Cleaning',
                    'Move In & Out Cleaning Services',
                    'House Cleaning',
                    'Laundry & Dry Cleaning',
                    'AC Cleaning Service',
                    'Disinfection Service',
                    'Covid-19 PCR Test at Home',
                    'Women\'s Salon',
                    'Women\'s Spa',
                    'Furniture Cleaning',
                    'Men\'s Salon',
                    'Lab Tests at Home',
                    'Pest Control Service',
                    'Men\'s Spa',
                    'Men\'s Grooming',
                    'Hair Salon',
                    'Pet Grooming',
                    'IV Therapy',
                    'Babysitting At Home',
                    'Car Wash At Home',
                    'Plumber Services',
                    'Handyman Services',
                    'Electrician Services',
                    'Home Painting',
                    'Personal Trainer',
                    'Packers and Movers',
                    'Physiotherapy at Home',
                    'Body Adjustment',
                    'Part Time Maid Services',
                    'Psychotherapy & Counselling',
                    'Nurse Care at Home',
                    'Vaccines at Home',
                    'Commercial Cleaning',
                    'Office Cleaning',
                    'Villa Cleaning',
                    'Henna Service',
                    'Housekeeping Services',
                    'Floor Cleaning',
                    'Waxing Service',
                    'Doctor on Call',
                    'Facial Treatment Service',
                    'Eyebrow Threading',
                    'Flu Vaccine',
                    'Apartment Cleaning',
                    'Oxygen Therapy',
                    'GLP-1 Weight Loss',
                    'Pet Healthcare',
                ];

                $footerLocations = [
                    'United Arab Emirates' => ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman'],
                    'Saudi Arabia' => ['Jeddah', 'Riyadh'],
                ];
            @endphp

            <div class="row mb-5 pb-5 border-bottom border-secondary">
                <div class="col-12 mb-5">
                    <h5 class="fw-bold text-white mb-3" style="font-size: 16px;">Service Areas</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($footerServices as $service)
                            <a href="#" class="text-decoration-none text-white hover-opacity"
                                style="background-color: #000; padding: 6px 14px; border-radius: 50px; font-weight: 600; font-size: 12px; transition: opacity 0.2s;">{{ $service }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="col-12 d-flex flex-column flex-md-row gap-5">
                    @foreach ($footerLocations as $country => $cities)
                        <div>
                            <h5 class="fw-bold text-white mb-3" style="font-size: 16px;">{{ $country }}</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($cities as $city)
                                    <a href="#" class="text-decoration-none text-white hover-opacity"
                                        style="background-color: #000; padding: 6px 14px; border-radius: 50px; font-weight: 600; font-size: 12px; transition: opacity 0.2s;">{{ $city }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3 mb-4">
                    <span class="logo mb-3 d-block">
                        <span class="logo-vendors" style="text-shadow:none;">Vendors</span><span class="logo-city"
                            style="text-shadow:none;">City</span>
                    </span>
                    <p class="text-secondary small">Your one-stop destination for home services. We provide professional
                        cleaning, maintenance, and salon services right at your doorstep.</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Services</h5>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Home
                                Cleaning</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Deep
                                Cleaning</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Salon & Spa
                                at Home</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">AC Cleaning
                                &
                                Repair</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Company</h5>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">About Us</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Careers</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Terms &
                                Conditions</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Privacy
                                Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3">Contact Us</h5>
                    <ul class="list-unstyled text-secondary small">
                        <li class="mb-2">Support: 800 5878</li>
                        <li class="mb-3">Email: wecare@vendorscity.com</li>
                        <li>
                            <div class="d-flex gap-2">
                                <a href="#"
                                    class="btn btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 bg-secondary bg-opacity-25"
                                    style="width:35px; height:35px;"><i class="bi bi-facebook"></i></a>
                                <a href="#"
                                    class="btn btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 bg-secondary bg-opacity-25"
                                    style="width:35px; height:35px;"><i class="bi bi-twitter"></i></a>
                                <a href="#"
                                    class="btn btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 bg-secondary bg-opacity-25"
                                    style="width:35px; height:35px;"><i class="bi bi-instagram"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="border-top border-secondary pt-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="text-secondary small mb-0">&copy; {{ date('Y') }} VendorsCity. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnAllServices = document.getElementById('btnAllServices');
            const megaMenu = document.getElementById('megaMenu');
            const closeMegaMenu = document.getElementById('closeMegaMenu');

            if (btnAllServices && megaMenu) {
                btnAllServices.addEventListener('click', function(e) {
                    e.stopPropagation();
                    megaMenu.classList.toggle('show');
                });

                if (closeMegaMenu) {
                    closeMegaMenu.addEventListener('click', function() {
                        megaMenu.classList.remove('show');
                    });
                }

                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!megaMenu.contains(e.target) && !btnAllServices.contains(e.target)) {
                        megaMenu.classList.remove('show');
                    }
                });

                // Prevent closing when clicking inside the menu
                megaMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>

</html>
