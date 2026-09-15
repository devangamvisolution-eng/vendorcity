@extends('front.includes.layout')

@section('title', 'VendorsCity - General Cleaning')

@section('content')

    <!-- Hero Section -->
    <div class="position-relative overflow-hidden mb-5" style="min-height: 350px;">
        <!-- Background Image with Overlay -->
        <div class="position-absolute w-100 h-100" style="top: 0; left: 0; z-index: 0;">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1600&h=700&fit=crop"
                alt="Hero Background" class="w-100 h-100" style="object-fit: cover; object-position: center;">
            <div class="position-absolute w-100 h-100"
                style="top: 0; left: 0; background: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.6));">
            </div>
        </div>

        <div class="container position-relative" style="z-index: 1; padding-top: 80px; padding-bottom: 100px;">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10 col-xl-8">
                    <!-- Headline -->
                    <h1 class="display-4 fw-bolder text-white mb-3" style="letter-spacing: -1px;">
                        Everything You Need,<br><span style="color: #ffc107;">All In One Place.</span>
                    </h1>
                    <p class="lead text-light mb-4 opacity-75">Book trusted professionals for all your home and lifestyle
                        needs.</p>
                </div>
            </div>
        </div>

        <!-- Trust Badges Bar (Glassmorphism at bottom) -->
        <div class="position-absolute bottom-0 w-100 py-3"
            style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(12px); border-top: 1px solid rgba(255,255,255,0.1); z-index: 1;">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-3 gap-md-5 text-white">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 20px; height: 20px;">
                            <i class="bi bi-check text-dark" style="font-size: 16px;"></i>
                        </div>
                        <span class="fw-medium" style="font-size: 14px; letter-spacing: 0.5px;">Verified Vendors</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 20px; height: 20px;">
                            <i class="bi bi-tag-fill text-dark" style="font-size: 12px;"></i>
                        </div>
                        <span class="fw-medium" style="font-size: 14px; letter-spacing: 0.5px;">Get up to 5 free
                            quotes</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 20px; height: 20px;">
                            <i class="bi bi-headset text-dark" style="font-size: 12px;"></i>
                        </div>
                        <span class="fw-medium" style="font-size: 14px; letter-spacing: 0.5px;">Live Customer Support</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Row -->
    <div class="container mt-4 position-relative">
        <div class="category-scroll pb-2" id="categoryScroll">
            @php
                $mainCategories = [
                    [
                        'title' => 'General<br>Cleaning',
                        'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=100&h=100&fit=crop',
                        'tag' => '<i class="bi bi-lightning-fill"></i> 30 mins',
                    ],
                    [
                        'title' => 'Cleaning<br>Subscription',
                        'img' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=100&h=100&fit=crop',
                        'tag' => '40% OFF',
                    ],
                    [
                        'title' => 'Salon & Spa<br>at Home',
                        'img' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=100&h=100&fit=crop',
                        'tag' => '<i class="bi bi-lightning-fill"></i> 40 mins',
                    ],
                    [
                        'title' => 'Moving',
                        'img' => 'https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=100&h=100&fit=crop',
                    ],
                    [
                        'title' => 'Storage',
                        'img' => 'https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=100&h=100&fit=crop',
                    ],
                    [
                        'title' => 'Healthcare<br>at Home',
                        'img' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=100&h=100&fit=crop',
                        'tag' => '<i class="bi bi-lightning-fill"></i> 30 mins',
                    ],
                    [
                        'title' => 'Handyman &<br>Maintenance',
                        'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=100&h=100&fit=crop',
                        'tag' => '<i class="bi bi-lightning-fill"></i> 60 mins',
                    ],
                    [
                        'title' => 'Laundry &<br>Dry Cleaning',
                        'img' => 'https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?w=100&h=100&fit=crop',
                    ],
                    [
                        'title' => 'AC Cleaning<br>at Home',
                        'img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=100&h=100&fit=crop',
                        'tag' => '<i class="bi bi-lightning-fill"></i> 60 mins',
                    ],
                    [
                        'title' => 'Deep<br>Cleaning',
                        'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=100&h=100&fit=crop',
                    ],
                    [
                        'title' => 'Pest<br>Control',
                        'img' => 'https://images.unsplash.com/photo-1594818379496-da1e345b0ded?w=100&h=100&fit=crop',
                    ],
                ];
            @endphp

            @foreach ($mainCategories as $category)
                <div class="category-item">
                    <div class="icon-box" style="padding: 0; background-color: transparent;">
                        @if (isset($category['tag']))
                            <div class="yellow-tag">{!! $category['tag'] !!}</div>
                        @endif
                        <img src="{{ $category['img'] }}" alt="{!! strip_tags($category['title']) !!}"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
                    </div>
                    <div style="font-size: 12px; font-weight: 600; color: #495057; line-height: 1.2;">
                        {!! $category['title'] !!}
                    </div>
                </div>
            @endforeach

        </div>
        <!-- Prev Button overlay for categories -->
        <div id="leftArrowContainer" class="position-absolute d-none align-items-center justify-content-start ps-3"
            style="left: 0; top: 1.5rem; bottom: 0; width: 100px; background: linear-gradient(to right, #fcfcfc, rgba(252,252,252,0)); pointer-events: none; z-index: 5;">
            <button id="btnScrollLeft"
                class="btn btn-light rounded-circle shadow-sm border border-light-subtle d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; pointer-events: auto; transition: background-color 0.2s;">
                <i class="bi bi-chevron-left text-secondary"></i>
            </button>
        </div>

        <!-- Next Button overlay for categories -->
        <div id="rightArrowContainer" class="position-absolute d-none align-items-center justify-content-end pe-3"
            style="right: 0; top: 1.5rem; bottom: 0; width: 100px; background: linear-gradient(to left, #fcfcfc, rgba(252,252,252,0)); pointer-events: none; z-index: 5;">
            <button id="btnScrollRight"
                class="btn btn-light rounded-circle shadow-sm border border-light-subtle d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; pointer-events: auto; transition: background-color 0.2s;">
                <i class="bi bi-chevron-right text-secondary"></i>
            </button>
        </div>
    </div>

    @php
        // Simulated array of services. In a real app, this would come from the controller.
        $generalCleaningServices = [
            [
                'title' => 'Home Cleaning',
                'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 30 mins',
            ],
            [
                'title' => 'Home & Baby Care',
                'img' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=500&h=300&fit=crop',
                'tag' => 'NEW',
                'tagColor' => '#ffc107',
            ],
            [
                'title' => 'AC Cleaning & Repair',
                'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 60 mins',
            ],
            [
                'title' => 'Furniture Cleaning',
                'img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 60 mins',
            ],
            [
                'title' => 'Deep Cleaning',
                'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 4 hrs',
            ],
            [
                'title' => 'Move-in Cleaning',
                'img' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=500&h=300&fit=crop',
                'tag' => 'POPULAR',
                'tagColor' => '#ffc107',
            ],
            [
                'title' => 'Carpet Cleaning',
                'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 45 mins',
            ],
            [
                'title' => 'Mattress Cleaning',
                'img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 40 mins',
            ],
        ];
    @endphp

    <!-- Section: General Cleaning -->
    <div class="container mt-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold fs-4 m-0">Cleaning</h2>

            <!-- Blade Logic: Only show 'See all' and arrows if items are greater than 4 -->
            @if (count($generalCleaningServices) > 4)
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-decoration-none fw-bold small" style="color: #4338ca;">See all</a>
                    <div class="d-flex gap-2">
                        <button id="btnGcLeft"
                            class="btn btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" disabled>
                            <i class="bi bi-chevron-left text-muted small"></i>
                        </button>
                        <button id="btnGcRight"
                            class="btn btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;">
                            <i class="bi bi-chevron-right small"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Cards Slider -->
        <div class="d-flex flex-nowrap overflow-x-auto gap-4 pb-3" id="gcSlider"
            style="scrollbar-width: none; -ms-overflow-style: none;">
            <style>
                #gcSlider::-webkit-scrollbar,
                #salonSlider::-webkit-scrollbar {
                    display: none;
                }

                .service-card-item {
                    flex: 0 0 calc((100% - 1.5rem) / 2);
                    width: calc((100% - 1.5rem) / 2);
                }

                @media (min-width: 768px) {
                    .service-card-item {
                        flex: 0 0 calc((100% - 3rem) / 3);
                        width: calc((100% - 3rem) / 3);
                    }
                }

                @media (min-width: 992px) {
                    .service-card-item {
                        flex: 0 0 calc((100% - 4.5rem) / 4);
                        width: calc((100% - 4.5rem) / 4);
                    }
                }

                @media (min-width: 1200px) {
                    .service-card-item {
                        flex: 0 0 calc((100% - 6rem) / 5);
                        width: calc((100% - 6rem) / 5);
                    }
                }
            </style>

            @foreach ($generalCleaningServices as $service)
                <div class="service-card-item">
                    <div class="service-card m-0">
                        <div class="img-wrapper">
                            <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}">
                            <div class="card-tag" {!! isset($service['tagColor']) ? 'style="background-color: ' . $service['tagColor'] . ';"' : '' !!}>{!! $service['tag'] !!}</div>
                        </div>
                        <h3>{{ $service['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @php
        // Simulated array of services for Salon & Spa
        $salonServices = [
            [
                'title' => 'Women\'s Salon',
                'img' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 40 mins',
            ],
            [
                'title' => 'Men\'s Salon',
                'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 40 mins',
            ],
            [
                'title' => 'Spa at Home',
                'img' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 40 mins',
            ],
            [
                'title' => 'IV Therapy',
                'img' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 40 mins',
            ],
            [
                'title' => 'Hair Styling',
                'img' => 'https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 30 mins',
            ],
            [
                'title' => 'Makeup Artist',
                'img' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=500&h=300&fit=crop',
                'tag' => '<i class="bi bi-lightning-fill"></i> 1 hr',
            ],
        ];
    @endphp

    <!-- Section: Salon & Spa at Home -->
    <div class="container mt-5 mb-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold fs-4 m-0">Salon & Spa at Home</h2>

            <!-- Blade Logic: Only show 'See all' and arrows if items are greater than 4 -->
            @if (count($salonServices) > 4)
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-decoration-none fw-bold small" style="color: #4338ca;">See all</a>
                    <div class="d-flex gap-2">
                        <button id="btnSalonLeft"
                            class="btn btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" disabled>
                            <i class="bi bi-chevron-left text-muted small"></i>
                        </button>
                        <button id="btnSalonRight"
                            class="btn btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;">
                            <i class="bi bi-chevron-right small"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Cards Slider -->
        <div class="d-flex flex-nowrap overflow-x-auto gap-4 pb-3" id="salonSlider"
            style="scrollbar-width: none; -ms-overflow-style: none;">


            @foreach ($salonServices as $service)
                <div class="service-card-item">
                    <div class="service-card m-0">
                        <div class="img-wrapper">
                            <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}">
                            <div class="card-tag" {!! isset($service['tagColor']) ? 'style="background-color: ' . $service['tagColor'] . ';"' : '' !!}>{!! $service['tag'] !!}</div>
                        </div>
                        <h3>{{ $service['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @php
        // Simulated array of services for Moving
        $movingServices = [
            [
                'title' => 'Local moving',
                'img' => 'https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=500&h=300&fit=crop',
            ],
            [
                'title' => 'International moving',
                'img' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=500&h=300&fit=crop',
            ],
            [
                'title' => 'Vehicle shipping',
                'img' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?w=500&h=300&fit=crop',
            ],
        ];

        // Simulated array of services for Storage
        $storageServices = [
            [
                'title' => 'Self storage',
                'img' => 'https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=500&h=300&fit=crop',
            ],
            [
                'title' => 'AC storage',
                'img' => 'https://images.unsplash.com/photo-1558227691-41ea78d1f631?w=500&h=300&fit=crop',
            ],
            [
                'title' => 'Non-AC storage',
                'img' => 'https://images.unsplash.com/photo-1505705694340-019e1e335916?w=500&h=300&fit=crop',
            ],
            [
                'title' => 'Vehicle storage',
                'img' => 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=500&h=300&fit=crop',
            ],
        ];
    @endphp

    <!-- Section: Moving -->
    <div class="container mt-5 mb-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold fs-4 m-0">Moving</h2>

            <!-- Blade Logic: Only show 'See all' and arrows if items are greater than 4 -->
            @if (count($movingServices) > 4)
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-decoration-none fw-bold small" style="color: #4338ca;">See all</a>
                    <div class="d-flex gap-2">
                        <button id="btnMovingLeft"
                            class="btn btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" disabled>
                            <i class="bi bi-chevron-left text-muted small"></i>
                        </button>
                        <button id="btnMovingRight"
                            class="btn btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;">
                            <i class="bi bi-chevron-right small"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Cards Slider -->
        <div class="d-flex flex-nowrap overflow-x-auto gap-4 pb-3" id="movingSlider"
            style="scrollbar-width: none; -ms-overflow-style: none;">
            @foreach ($movingServices as $service)
                <div class="service-card-item">
                    <div class="service-card m-0">
                        <div class="img-wrapper">
                            <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}">
                            @if (isset($service['tag']))
                                <div class="card-tag" {!! isset($service['tagColor']) ? 'style="background-color: ' . $service['tagColor'] . ';"' : '' !!}>{!! $service['tag'] !!}</div>
                            @endif
                        </div>
                        <h3>{{ $service['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section: Storage -->
    <div class="container mt-5 mb-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold fs-4 m-0">Storage</h2>

            <!-- Blade Logic: Only show 'See all' and arrows if items are greater than 4 -->
            @if (count($storageServices) > 4)
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-decoration-none fw-bold small" style="color: #4338ca;">See all</a>
                    <div class="d-flex gap-2">
                        <button id="btnStorageLeft"
                            class="btn btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" disabled>
                            <i class="bi bi-chevron-left text-muted small"></i>
                        </button>
                        <button id="btnStorageRight"
                            class="btn btn-light rounded-circle border shadow-sm d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;">
                            <i class="bi bi-chevron-right small"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Cards Slider -->
        <div class="d-flex flex-nowrap overflow-x-auto gap-4 pb-3" id="storageSlider"
            style="scrollbar-width: none; -ms-overflow-style: none;">
            @foreach ($storageServices as $service)
                <div class="service-card-item">
                    <div class="service-card m-0">
                        <div class="img-wrapper">
                            <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}">
                            @if (isset($service['tag']))
                                <div class="card-tag" {!! isset($service['tagColor']) ? 'style="background-color: ' . $service['tagColor'] . ';"' : '' !!}>{!! $service['tag'] !!}</div>
                            @endif
                        </div>
                        <h3>{{ $service['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section: Premium How It Works -->
    <div class="container my-5">
        <div class="bg-light rounded-4 shadow-sm overflow-hidden border border-light">
            <div class="row g-0 align-items-center">

                <!-- Left Image (Seamless) -->
                <div class="col-lg-5 d-none d-lg-block" style="height: 480px;">
                    <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=600&h=750&fit=crop"
                        alt="Cleaner at work" class="img-fluid h-100 w-100" style="object-fit: cover;">
                </div>

                <!-- Right Content -->
                <div class="col-lg-7 p-4 p-lg-5">
                    <span class="badge mb-3 px-3 py-2 rounded-pill shadow-sm"
                        style="background-color: #ffc107; color: #212529; font-weight: bold;">How it works</span>
                    <h2 class="fw-bold text-dark mb-3" style="font-size: 2rem; letter-spacing: -0.5px;">We Do The Work, So
                        That You Can Chill.</h2>
                    <p class="text-secondary mb-4" style="font-size: 1rem; line-height: 1.6; max-width: 550px;">
                        We cut out the unnecessary steps with our easy to order process that makes your to-do-lists for your
                        home easy, fast, and stress-free.
                    </p>

                    <div class="row g-3">
                        <!-- Card 1 -->
                        <div class="col-md-4">
                            <div class="bg-white rounded-3 p-3 shadow-sm h-100 border-0"
                                style="transition: all 0.3s ease; cursor: default;"
                                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 15px rgba(0,0,0,0.05)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                                <div class="mb-3">
                                    <img src="https://picsum.photos/seed/search/100/100" alt="Find your service"
                                        class="rounded-circle shadow-sm"
                                        style="width: 48px; height: 48px; object-fit: cover; border: 2px solid #fff;">
                                </div>
                                <h4 class="fw-bold mb-1 text-dark" style="font-size: 14px;">Find your service</h4>
                                <p class="text-secondary mb-0" style="font-size: 12px; line-height: 1.5;">Choose from 50+
                                    services, 100+ vendors, live support, easy booking.</p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="col-md-4">
                            <div class="bg-white rounded-3 p-3 shadow-sm h-100 border-0"
                                style="transition: all 0.3s ease; cursor: default;"
                                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 15px rgba(0,0,0,0.05)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                                <div class="mb-3">
                                    <img src="https://picsum.photos/seed/book/100/100" alt="Book in Minutes"
                                        class="rounded-circle shadow-sm"
                                        style="width: 48px; height: 48px; object-fit: cover; border: 2px solid #fff;">
                                </div>
                                <h4 class="fw-bold mb-1 text-dark" style="font-size: 14px;">Book in Minutes</h4>
                                <p class="text-secondary mb-0" style="font-size: 12px; line-height: 1.5;">Secure pay,
                                    flexible slots, free quotes, managed packages.</p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="col-md-4">
                            <div class="bg-white rounded-3 p-3 shadow-sm h-100 border-0"
                                style="transition: all 0.3s ease; cursor: default;"
                                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 15px rgba(0,0,0,0.05)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                                <div class="mb-3">
                                    <img src="https://picsum.photos/seed/relax/100/100" alt="Relax & Chill"
                                        class="rounded-circle shadow-sm"
                                        style="width: 48px; height: 48px; object-fit: cover; border: 2px solid #fff;">
                                </div>
                                <h4 class="fw-bold mb-1 text-dark" style="font-size: 14px;">Relax & Chill</h4>
                                <p class="text-secondary mb-0" style="font-size: 12px; line-height: 1.5;">100%
                                    satisfaction,
                                    referral rewards, no hidden fees.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Section: Verified Reviews -->
    @php
        $verifiedReviews = [
            ['name' => 'Ali Al Samarai', 'text' => 'Quick and professional service and reasonably priced. Thank you'],
            ['name' => 'Ben Sapin', 'text' => 'Fantastic job, fast, professional and friendly'],
            ['name' => 'Andy Jobst', 'text' => 'Very responsive and reliable!'],
            [
                'name' => 'Sophy Drobnitzky',
                'text' => 'This is the first time I\'ve booked through the VendorsCity portal, as I\'ve had s...',
            ],
            ['name' => 'Michael Doe', 'text' => 'Excellent service all around. Highly recommended and easy to use!'],
        ];
    @endphp
    <div class="container mt-5 mb-2">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h2 class="fw-bold fs-3 text-dark m-0">Read Our Verified Reviews</h2>
        </div>

        <div class="{{ count($verifiedReviews) > 4 ? 'd-flex flex-nowrap overflow-x-auto gap-4 pb-3' : 'row g-4' }}"
            style="{{ count($verifiedReviews) > 4 ? 'scrollbar-width: none; -ms-overflow-style: none;' : '' }}">
            @if (count($verifiedReviews) > 4)
                <style>
                    .review-card-wrapper {
                        flex: 0 0 calc((100% - 1.5rem) / 2);
                        width: calc((100% - 1.5rem) / 2);
                    }

                    @media (min-width: 768px) {
                        .review-card-wrapper {
                            flex: 0 0 calc((100% - 3rem) / 3);
                            width: calc((100% - 3rem) / 3);
                        }
                    }

                    @media (min-width: 992px) {
                        .review-card-wrapper {
                            flex: 0 0 calc((100% - 4.5rem) / 4);
                            width: calc((100% - 4.5rem) / 4);
                        }
                    }
                </style>
            @endif

            @foreach ($verifiedReviews as $review)
                <div class="{{ count($verifiedReviews) > 4 ? 'review-card-wrapper' : 'col-md-6 col-lg-3' }}">
                    <div class="bg-white rounded-4 p-4 shadow-sm h-100 border border-light position-relative overflow-hidden"
                        style="transition: all 0.3s ease; cursor: default;"
                        onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                        <!-- Decorative Quote Background -->
                        <i class="bi bi-quote position-absolute"
                            style="font-size: 6rem; top: -20px; right: 10px; color: #f8f9fa; z-index: 0; transform: rotate(10deg);"></i>

                        <div class="position-relative" style="z-index: 1;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3 fw-bold shadow-sm"
                                    style="width: 45px; height: 45px; font-size: 16px; background: linear-gradient(135deg, #4338ca, #6366f1);">
                                    {{ substr($review['name'], 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="fw-bold fs-6 mb-1 text-dark">{{ $review['name'] }}</h5>
                                    <div class="text-warning d-flex gap-1" style="font-size: 13px;">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-secondary small mb-0" style="line-height: 1.6; font-style: italic;">
                                "{{ $review['text'] }}"</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section: Our Locations -->
    @php
        $ourLocations = [
            [
                'name' => 'Dubai',
                'img' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Abu Dhabi',
                'img' => 'https://images.unsplash.com/photo-1512632578888-169bbbc64f33?w=400&h=600&fit=crop',
            ],
            ['name' => 'Sharjah', 'img' => 'https://picsum.photos/seed/sharjah/400/600'],
            ['name' => 'Ras Al Khaimah', 'img' => 'https://picsum.photos/seed/rak/400/600'],
            ['name' => 'Ajman', 'img' => 'https://picsum.photos/seed/ajman/400/600'],
            ['name' => 'Umm Al Quwain', 'img' => 'https://picsum.photos/seed/uaq/400/600'],
            ['name' => 'Fujairah', 'img' => 'https://picsum.photos/seed/fuj/400/600'],
        ];
    @endphp
    <div class="container mb-5">
        <div class="mb-4">
            <h2 class="fw-bold fs-3 text-dark m-0">Our Locations</h2>
            <p class="text-secondary mt-1 mb-0">VendorsCity currently offers services in</p>
        </div>

        <div class="d-flex {{ count($ourLocations) > 7 ? 'flex-nowrap overflow-x-auto pb-3' : 'flex-wrap' }} gap-3"
            style="{{ count($ourLocations) > 7 ? 'scrollbar-width: none; -ms-overflow-style: none;' : '' }}">
            <style>
                .location-item {
                    flex: 0 0 calc((100% - 6 * 1rem) / 7);
                    width: calc((100% - 6 * 1rem) / 7);
                }

                @media (max-width: 1200px) {
                    .location-item {
                        flex: 0 0 calc((100% - 4 * 1rem) / 5);
                        width: calc((100% - 4 * 1rem) / 5);
                    }
                }

                @media (max-width: 768px) {
                    .location-item {
                        flex: 0 0 calc((100% - 2 * 1rem) / 3);
                        width: calc((100% - 2 * 1rem) / 3);
                    }
                }

                @media (max-width: 576px) {
                    .location-item {
                        flex: 0 0 calc((100% - 1rem) / 2);
                        width: calc((100% - 1rem) / 2);
                    }
                }
            </style>

            @foreach ($ourLocations as $location)
                <div class="location-item">
                    <div class="position-relative rounded-4 overflow-hidden shadow-sm"
                        style="height: 220px; transition: all 0.3s ease; cursor: default;"
                        onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                        <img src="{{ $location['img'] }}" alt="{{ $location['name'] }}" class="w-100 h-100"
                            style="object-fit: cover;">
                        <!-- Dark gradient overlay for text readability -->
                        <div class="position-absolute bottom-0 start-0 w-100 p-3"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);">
                            <h5 class="text-white fw-bold m-0" style="font-size: 15px;">{{ $location['name'] }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollContainer = document.getElementById('categoryScroll');
            const leftArrow = document.getElementById('leftArrowContainer');
            const rightArrow = document.getElementById('rightArrowContainer');
            const btnLeft = document.getElementById('btnScrollLeft');
            const btnRight = document.getElementById('btnScrollRight');

            const updateArrows = () => {
                // Check if content overflows
                if (scrollContainer.scrollWidth > scrollContainer.clientWidth) {
                    scrollContainer.style.justifyContent = 'flex-start';

                    // Show right arrow if we haven't scrolled to the end
                    if (Math.ceil(scrollContainer.scrollLeft + scrollContainer.clientWidth) < scrollContainer
                        .scrollWidth) {
                        rightArrow.classList.remove('d-none');
                        rightArrow.classList.add('d-md-flex');
                    } else {
                        rightArrow.classList.add('d-none');
                        rightArrow.classList.remove('d-md-flex');
                    }
                } else {
                    // Content fits perfectly, center it and hide right arrow
                    scrollContainer.style.justifyContent = 'center';
                    rightArrow.classList.add('d-none');
                    rightArrow.classList.remove('d-md-flex');
                }

                // Show left arrow if we have scrolled right
                if (scrollContainer.scrollLeft > 0) {
                    leftArrow.classList.remove('d-none');
                    leftArrow.classList.add('d-md-flex');
                } else {
                    leftArrow.classList.add('d-none');
                    leftArrow.classList.remove('d-md-flex');
                }
            };

            if (scrollContainer) {
                // Initial check after images/fonts might have loaded
                setTimeout(updateArrows, 100);

                // Listen to scroll and resize events
                scrollContainer.addEventListener('scroll', updateArrows);
                window.addEventListener('resize', updateArrows);

                // Click handlers to scroll smoothly for main categories
                if (btnRight) {
                    btnRight.addEventListener('click', () => {
                        scrollContainer.scrollBy({
                            left: 300,
                            behavior: 'smooth'
                        });
                    });
                }
                if (btnLeft) {
                    btnLeft.addEventListener('click', () => {
                        scrollContainer.scrollBy({
                            left: -300,
                            behavior: 'smooth'
                        });
                    });
                }
            }

            // General Cleaning Slider logic
            const gcSlider = document.getElementById('gcSlider');
            const btnGcLeft = document.getElementById('btnGcLeft');
            const btnGcRight = document.getElementById('btnGcRight');

            if (gcSlider) {
                const updateGcArrows = () => {
                    if (btnGcLeft) {
                        if (gcSlider.scrollLeft > 0) {
                            btnGcLeft.removeAttribute('disabled');
                            btnGcLeft.querySelector('i').classList.remove('text-muted');
                        } else {
                            btnGcLeft.setAttribute('disabled', 'true');
                            btnGcLeft.querySelector('i').classList.add('text-muted');
                        }
                    }
                    if (btnGcRight) {
                        if (Math.ceil(gcSlider.scrollLeft + gcSlider.clientWidth) < gcSlider.scrollWidth) {
                            btnGcRight.removeAttribute('disabled');
                            btnGcRight.querySelector('i').classList.remove('text-muted');
                        } else {
                            btnGcRight.setAttribute('disabled', 'true');
                            btnGcRight.querySelector('i').classList.add('text-muted');
                        }
                    }
                };

                gcSlider.addEventListener('scroll', updateGcArrows);
                window.addEventListener('resize', updateGcArrows);
                setTimeout(updateGcArrows, 100);

                if (btnGcRight) {
                    btnGcRight.addEventListener('click', () => {
                        gcSlider.scrollBy({
                            left: 300,
                            behavior: 'smooth'
                        });
                    });
                }
                if (btnGcLeft) {
                    btnGcLeft.addEventListener('click', () => {
                        gcSlider.scrollBy({
                            left: -300,
                            behavior: 'smooth'
                        });
                    });
                }
            }

            // Salon & Spa Slider logic
            const salonSlider = document.getElementById('salonSlider');
            const btnSalonLeft = document.getElementById('btnSalonLeft');
            const btnSalonRight = document.getElementById('btnSalonRight');

            if (salonSlider) {
                const updateSalonArrows = () => {
                    if (btnSalonLeft) {
                        if (salonSlider.scrollLeft > 0) {
                            btnSalonLeft.removeAttribute('disabled');
                            btnSalonLeft.querySelector('i').classList.remove('text-muted');
                        } else {
                            btnSalonLeft.setAttribute('disabled', 'true');
                            btnSalonLeft.querySelector('i').classList.add('text-muted');
                        }
                    }
                    if (btnSalonRight) {
                        if (Math.ceil(salonSlider.scrollLeft + salonSlider.clientWidth) < salonSlider
                            .scrollWidth) {
                            btnSalonRight.removeAttribute('disabled');
                            btnSalonRight.querySelector('i').classList.remove('text-muted');
                        } else {
                            btnSalonRight.setAttribute('disabled', 'true');
                            btnSalonRight.querySelector('i').classList.add('text-muted');
                        }
                    }
                };

                salonSlider.addEventListener('scroll', updateSalonArrows);
                window.addEventListener('resize', updateSalonArrows);
                setTimeout(updateSalonArrows, 100);

                if (btnSalonRight) {
                    btnSalonRight.addEventListener('click', () => {
                        salonSlider.scrollBy({
                            left: 300,
                            behavior: 'smooth'
                        });
                    });
                }
                if (btnSalonLeft) {
                    btnSalonLeft.addEventListener('click', () => {
                        salonSlider.scrollBy({
                            left: -300,
                            behavior: 'smooth'
                        });
                    });
                }
            }
        });
    </script>
@endpush
