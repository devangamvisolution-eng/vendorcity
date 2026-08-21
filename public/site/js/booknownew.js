$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});
document.addEventListener('DOMContentLoaded', function () {

    const currentSubserviceId = document.getElementById("subservice_id")?.value;
    if (currentSubserviceId) {
        const lastServiceId = localStorage.getItem('lastServiceId');
        if (lastServiceId && lastServiceId !== currentSubserviceId) {
            localStorage.removeItem('currentStep'); // Resets funnel to Step 1
        }
        localStorage.setItem('lastServiceId', currentSubserviceId);
    }
    let steps = Array.from(document.querySelectorAll(".step-content")).filter(
        (el) => el.id.match(/^step\d+$/),
    );
    const stepHeader = document.querySelector('.step-header');
    const footer = document.querySelector('.footer-style1');
    const header = document.getElementById('stickyHeader');
    const tabsContainer = document.getElementById('categoryTabsPackages');
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');
    const sections = document.querySelectorAll('.section-packages');
    const buttons = tabsContainer.querySelectorAll('button');

    let lastActiveState = false;
    let lastCarouselState = false;
    let lastScrollY = 0;
    let isHeaderHidden = false;

    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        const footerRect = footer.getBoundingClientRect();
        const scrollingDown = scrollY > lastScrollY;

        // ✅ Sticky header after 100px
        const shouldBeActive = scrollY > 100;
        if (shouldBeActive !== lastActiveState) {
            lastActiveState = shouldBeActive;
            header.classList.toggle('active', shouldBeActive);
        }

        // ✅ Switch tabs from show-all to slider cleanly using requestAnimationFrame
        const wrapper = tabsContainer.closest('.category-tabs-wrapper');

        // Activate slider when reaching the second category content section as requested
        let activateThreshold = 300;
        let deactivateThreshold = 80;
        
        if (sections.length > 1) {
            activateThreshold = sections[1].offsetTop - 150;
            // Deactivate when reaching the first category section on the way back up
            deactivateThreshold = Math.min(activateThreshold - 100, sections[0].offsetTop - 150);
        } else if (sections.length > 0) {
            activateThreshold = sections[0].offsetTop - 150;
            deactivateThreshold = Math.max(80, activateThreshold - 100);
        }

        let shouldBeSlider = lastCarouselState;
        if (!lastCarouselState && scrollY > activateThreshold) {
            shouldBeSlider = true;
        } else if (lastCarouselState && scrollY < deactivateThreshold) {
            shouldBeSlider = false;
        }

        if (shouldBeSlider !== lastCarouselState) {
            lastCarouselState = shouldBeSlider;

            // Use requestAnimationFrame to avoid blocking the scroll thread,
            // and avoid calculating .offsetHeight which forces synchronous reflows causing stutters.
            window.requestAnimationFrame(() => {
                if (shouldBeSlider) {
                    tabsContainer.style.flexWrap = 'nowrap';
                    tabsContainer.style.overflowX = 'auto';
                    if (wrapper) wrapper.classList.add('arrows-visible');
                } else {
                    tabsContainer.style.flexWrap = 'wrap';
                    tabsContainer.style.overflowX = 'hidden';
                    if (wrapper) wrapper.classList.remove('arrows-visible');
                }
            });
        }

        // ✅ Highlight active tab while scrolling
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 180;
            if (scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });
        buttons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.target === current);
        });

        // ✅ Auto-scroll active tab into view (only when in slider mode)
        if (lastCarouselState || window.innerWidth <= 768) {
            const activeBtn = tabsContainer.querySelector('.active');
            if (activeBtn) {
                const btnRect = activeBtn.getBoundingClientRect();
                const containerRect = tabsContainer.getBoundingClientRect();
                if (btnRect.left < containerRect.left + 40 || btnRect.right > containerRect.right - 40) {
                    const offsetLeft = activeBtn.offsetLeft;
                    const width = activeBtn.offsetWidth;
                    const containerWidth = tabsContainer.offsetWidth;
                    tabsContainer.scrollTo({
                        left: offsetLeft - (containerWidth / 2) + (width / 2),
                        behavior: 'smooth'
                    });
                }
            }
        }

        // ✅ Hide stepHeader only when footer fully visible (end reached)
        const footerBottomVisible = footerRect.bottom - 50 <= window.innerHeight;
        if (footerBottomVisible && scrollingDown && !isHeaderHidden) {
            isHeaderHidden = true;
            stepHeader.classList.add('hidden');
        } else if ((!footerBottomVisible || !scrollingDown) && isHeaderHidden) {
            isHeaderHidden = false;
            stepHeader.classList.remove('hidden');
        }

        lastScrollY = scrollY;
    });

    // --- Arrow scroll ---
    leftArrow.addEventListener('click', () => {
        tabsContainer.scrollBy({ left: -200, behavior: 'smooth' });
    });
    rightArrow.addEventListener('click', () => {
        tabsContainer.scrollBy({ left: 200, behavior: 'smooth' });
    });

    // --- Smooth scroll on tab click ---
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetSection = document.getElementById(btn.dataset.target);
            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop - 150,
                    behavior: 'smooth'
                });
            }
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
});

// document.addEventListener('DOMContentLoaded', function () {
//         new Splide('#addons-slider', {
//             type: 'slide',
//             perPage: 3,
//             gap: '1rem',
//             autoplay: false,
//             interval: 3000,
//             pagination: false,
//             arrows: true,
//             breakpoints: {
//             768: {
//                fixedWidth: '65%',   // Each slide takes 80% of container
//                     focus: 0,            // Start slide aligned left
//                     gap: '1rem',
//                     arrows: false,
//             },
//             },
//         }).mount();
//         });

// document.addEventListener("DOMContentLoaded", function() {
//   const slider = document.getElementById("dateSlider");
//   const today = new Date();
//   const days = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];

//   for (let i = 0; i < 14; i++) {
//     const date = new Date(today);
//     date.setDate(today.getDate() + i);

//     const dayName = days[date.getDay()];
//     const dayNum = date.getDate();

//     // Check weekend
//     const isWeekend = dayName === "Sa" || dayName === "Su";

//     // Create date item
//     const div = document.createElement("div");
//     div.classList.add("date-item");
//     if (i === 0) div.classList.add("active"); // first date active

//     // Badge for weekend
//     if (isWeekend) {
//       const badge = document.createElement("span");
//       badge.classList.add("price-badge");
//       badge.textContent = "+ AED 5";
//       div.appendChild(badge);
//     }

//     // Add content
//     const content = document.createElement("div");
//     content.classList.add("date-content");
//     content.innerHTML = `<div class="day">${dayName}</div><div class="num">${dayNum}</div>`;
//     div.appendChild(content);

//     // Add click event to activate
//     div.addEventListener("click", () => {
//       document.querySelectorAll(".date-item").forEach(d => d.classList.remove("active"));
//       div.classList.add("active");

//     });

//     slider.appendChild(div);
//   }

//   // Arrow scroll
//   document.querySelector(".arrow.left").addEventListener("click", () => {
//     slider.scrollBy({ left: -150, behavior: "smooth" });
//   });
//   document.querySelector(".arrow.right").addEventListener("click", () => {
//     slider.scrollBy({ left: 150, behavior: "smooth" });
//   });
// });

document.addEventListener("DOMContentLoaded", function () {
    const slider = document.getElementById("dateSlider");
    const today = new Date();
    const days = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    for (let i = 0; i < 14; i++) {
        const date = new Date(today);
        date.setDate(today.getDate() + i);

        const dayName = days[date.getDay()];
        const dayNum = date.getDate();
        const monthName = months[date.getMonth()];

        // Check weekend
        const isWeekend = dayName === "Sa" || dayName === "Su";
        const price = isWeekend ? 5 : 0;
        // Create date item
        const div = document.createElement("div");
        div.classList.add("date-item");
        //if (i === 0) div.classList.add("active"); // first date active

        // Badge for weekend
        if (isWeekend) {
            const badge = document.createElement("span");
            badge.classList.add("price-badge");
            badge.innerHTML = `<span>+ </span><span class="currency_dhiramnew">AED</span> <span>5</span>`;
            div.appendChild(badge);
        }

        // Add content
        const content = document.createElement("div");
        content.classList.add("date-content");
        content.innerHTML = `<div class="day">${dayName}</div><div class="num">${dayNum}</div>`;
        div.appendChild(content);

        // Add click event to activate and alert
        div.addEventListener("click", () => {
            document.querySelectorAll(".date-item").forEach(d => d.classList.remove("active"));
            div.classList.add("active");

            dateclickfunction(dayName, monthName, dayNum, price);
        });

        slider.appendChild(div);
    }

    // Arrow scroll
    document.querySelector(".arrow.left").addEventListener("click", () => {
        slider.scrollBy({ left: -150, behavior: "smooth" });
    });
    document.querySelector(".arrow.right").addEventListener("click", () => {
        slider.scrollBy({ left: 150, behavior: "smooth" });
    });
});


document.addEventListener("DOMContentLoaded", function () {

    let summaryModal = new bootstrap.Modal(document.getElementById("mobilesummaryModal"));

    document.querySelectorAll(".mobile_price").forEach(function (priceContainer) {

        priceContainer.addEventListener("click", function () {

            let arrow = priceContainer.querySelector(".arrow-toggle-mobile");
            if (!arrow) return;

            // Close if already open
            if (arrow.classList.contains("rotate-up")) {
                arrow.classList.remove("rotate-up");
                arrow.classList.add("rotate-down");
                summaryModal.hide();
            }
            else {
                // Reset all arrows first
                document.querySelectorAll(".arrow-toggle-mobile").forEach(a => {
                    a.classList.remove("rotate-up");
                    a.classList.add("rotate-down");
                });

                // Rotate this one
                arrow.classList.add("rotate-up");
                arrow.classList.remove("rotate-down");

                summaryModal.show();
            }
        });

    });

    // Reset arrows when modal closes
    document.getElementById("mobilesummaryModal").addEventListener("hidden.bs.modal", function () {
        document.querySelectorAll(".arrow-toggle-mobile").forEach(a => {
            a.classList.remove("rotate-up");
            a.classList.add("rotate-down");
        });
    });

});

document.addEventListener("DOMContentLoaded", function () {

    // Detect existing steps dynamically
    let steps = Array.from(document.querySelectorAll('.step-content'))
        .filter(el => el.id.match(/^step\d+$/));

    // Extract step numbers
    let stepNumbers = steps.map(el => parseInt(el.id.replace("step", "")));

    // Sort step numbers (important!)
    stepNumbers.sort((a, b) => a - b);

    let totalSteps = stepNumbers.length;

    // Load saved step OR first available step
    let currentStep = localStorage.getItem('currentStep')
        ? parseInt(localStorage.getItem('currentStep'))
        : stepNumbers[0];

    function showStep(stepNumber) {

        if (stepNumber == 2) {
            initSplideSlider();
        }
        
        if (stepNumber == 5) {
            $('#service_fee').val('9');
            if (typeof updateSidebarCart === 'function') {
                updateSidebarCart();
            }
        } else if (stepNumber < 5) {
            $('#service_fee').val('0');
            if (typeof updateSidebarCart === 'function') {
                updateSidebarCart();
            }
        }

        currentStep = stepNumber;

        // Save to storage
        localStorage.setItem('currentStep', currentStep);

        // Hide all
        document.querySelectorAll('.step-content').forEach(el =>
            el.classList.remove('active')
        );

        const target = document.getElementById('step' + stepNumber);
        if (!target) return;

        target.classList.add('active');

        updateStepHeader();

        const rightSidebar = document.getElementById("rightSidebar");

        if (stepNumber === 6) {
            rightSidebar.style.display = "none";  // hide on final step
        } else {
            rightSidebar.style.display = "block"; // show on all other steps
        }

        // Scroll to top of step
        const headerHeight = document.querySelector(".step-header").offsetHeight;
        const scrollPos = target.getBoundingClientRect().top + window.scrollY - (headerHeight + 130);

        window.scrollTo({
            top: scrollPos,
            behavior: 'smooth'
        });
    }

    function nextStep() {
        let idx = stepNumbers.indexOf(currentStep);
        if (idx === -1) return;

        // 1. Run current step validation
        switch (currentStep) {
            case 1:
                if (!validateStep1()) return;
                break;
            case 2:
                if (typeof validateStep2 === 'function') {
                    if (!validateStep2()) return;
                }
                break;
            case 3:
                if (typeof validateStep3 === 'function') {
                    if (!validateStep3()) return;
                }
                break;
            case 4:
                if (typeof validateStep4 === 'function') {
                    if (!validateStep4()) return;
                }
                break;
            case 5:
                if (typeof validateStep5 === 'function') {
                    if (!validateStep5()) return;
                }
                break;
            // case 6:
            //     if (typeof validateStep6 === 'function') {
            //         if (!validateStep6()) return;
            //     }
            //     break;
        }

        // 2. Determine next step
        if (idx < totalSteps - 1) {
            let nextStepNumber = stepNumbers[idx + 1];

            // 3. AUTH GATEKEEPER: If moving away from Step 2 or Step 3, ensure user is logged in
            // This allows guests to select packages and view dates/addons before required auth
            if (currentStep >= 2 && !window.isUserLoggedIn) {
                if (typeof validateStep2 === 'function') {
                    if (!validateStep2()) return;
                } else {
                    // Fallback if validateStep2 is not defined for some reason
                    $('#exampleModalLong').modal('show');
                    return;
                }
            }

            showStep(nextStepNumber);
        }
    }

    function prevStep() {

        let idx = stepNumbers.indexOf(currentStep);
        if (idx == 4) {
            $('#service_fee').val('0');
            updateSidebarCart();
        }
        if (idx > 0) {
            showStep(stepNumbers[idx - 1]);
        }
    }

    window.nextStep = nextStep;
    window.prevStep = prevStep;

    // function updateStepHeader() {
    //     const header = document.getElementById("stepHeader");
    //     let currentIndex = stepNumbers.indexOf(currentStep) + 1;



    //     if (currentIndex === 1) {
    //         header.innerHTML = `Step ${currentIndex} of ${totalSteps}`;
    //     } else {
    //         header.innerHTML = `
    //             <span style="cursor:pointer" onclick="prevStep()"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
    //             Step ${currentIndex} of ${totalSteps}
    //         `;
    //     }
    // }
    function updateStepHeader() {
        const header = document.getElementById("stepHeader");
        let currentIndex = stepNumbers.indexOf(currentStep) + 1;

        const serviceTitle = document.getElementById('serviceTitle')?.value || '';

        const stepTitles = {
            1: serviceTitle,          // Dynamic
            2: "People also added",
            3: "Schedule Service",
            4: "Your Location",
            5: "Review & Confirm"
        };

        const title = stepTitles[currentStep] || "";

        if (currentIndex === 1) {
            header.innerHTML = `
            <div class="step-count">Step ${currentIndex} of ${totalSteps}</div>
            <div class="modern-step-title">${title}</div>
        `;
        } else {
            header.innerHTML = `
            <div class="step-header-inner">
                <span class="back-arrow" onclick="prevStep()">
                    <i class="fa fa-arrow-left"></i>
                </span>
                <div>
                    <div class="step-count">Step ${currentIndex} of ${totalSteps}</div>
                    <div class="modern-step-title">${title}</div>
                </div>
            </div>
        `;
        }
    }

    // Show the saved step OR the first available one
    if (!stepNumbers.includes(currentStep)) {
        currentStep = stepNumbers[0];
    }

    showStep(currentStep);
});

let splideInitialized = false;

function initSplideSlider() {
    if (splideInitialized) return;   // Prevent re-loading

    const slider = document.querySelector('#addons-slider');

    if (slider) {
        new Splide('#addons-slider', {
            type: 'slide',
            perPage: 3,
            gap: '1rem',
            autoplay: false,
            interval: 3000,
            pagination: false,
            arrows: true,
            breakpoints: {
                768: {        // tablet & below
                    perPage: 3,   // show 3 slides
                    gap: '1rem',
                    arrows: true, // or false if you want
                    fixedWidth: '', // remove your previous 65%
                },
                480: {       // mobile
                    perPage: 2,
                    arrows: false,
                }
            },
        }).mount();

        splideInitialized = true;   // Set initialized flag
    }
}


// document.addEventListener("DOMContentLoaded", function () {

//   let steps = document.querySelectorAll('.step-content');
//   let totalSteps = steps.length;

//   // Load saved step or default to 1
//   let currentStep = localStorage.getItem('currentStep') 
//                       ? parseInt(localStorage.getItem('currentStep')) 
//                       : 1;

//   function showStep(step) {
//     currentStep = step;

//     // Save step
//     localStorage.setItem('currentStep', currentStep);

//     // Show correct step
//     steps.forEach(el => el.classList.remove('active'));
//     const target = document.getElementById('step' + step);
//     target.classList.add('active');

//     // Update header
//     updateStepHeader();

//     // ⭐ Scroll to the step (avoid header overlap)
//     const headerHeight = document.querySelector(".step-header").offsetHeight;
//     const topPos = target.getBoundingClientRect().top + window.scrollY - (headerHeight + 130);

//     window.scrollTo({
//         top: topPos,
//         behavior: 'smooth'
//     });
// }

//   function nextStep() {
//       if (currentStep < totalSteps) {
//           showStep(currentStep + 1);
//       }
//   }

//   function prevStep() {
//       if (currentStep > 1) {
//           showStep(currentStep - 1);
//       }
//   }

//   window.nextStep = nextStep;  // important → make them global
//   window.prevStep = prevStep;

//   function updateStepHeader() {
//       const header = document.getElementById("stepHeader");

//       if (currentStep === 1) {
//           header.innerHTML = `Step ${currentStep} of ${totalSteps}`;
//       } else {
//           header.innerHTML = `
//               <span style="cursor:pointer" onclick="prevStep()">←</span>
//               Step ${currentStep} of ${totalSteps}
//           `;
//       }
//   }

//   // Show saved step when page loads
//   showStep(currentStep);

// });



$(document).ready(function () {
    $('.booknow-otp-input').on('input', function () {
        let input = $(this);
        let value = input.val();
        if (/^\d$/.test(value)) {
            input.next('.booknow-otp-input').focus();
        } else {
            input.val('');
        }
    });

    $('.booknow-otp-input').on('keydown', function (e) {
        let input = $(this);
        if (e.key === "Backspace" && input.val() === '') {
            input.prev('.booknow-otp-input').focus();
        }
    });

    $('.booknow-otp-input').on('paste', function (e) {
        let data = e.originalEvent.clipboardData.getData('text');
        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
        $('.booknow-otp-input').each(function (index, element) {
            $(element).val(digits[index] || '');
        });
        if (digits.length > 0) {
            $('.booknow-otp-input').eq(digits.length - 1).focus();
        }
        e.preventDefault();
    });
});

$(document).ready(function () {
    $('.book-email-otp-input').on('input', function () {
        let input = $(this);
        let value = input.val();
        if (/^\d$/.test(value)) {
            input.next('.book-email-otp-input').focus();
        } else {
            input.val('');
        }
    });

    $('.book-email-otp-input').on('keydown', function (e) {
        let input = $(this);
        if (e.key === "Backspace" && input.val() === '') {
            input.prev('.book-email-otp-input').focus();
        }
    });

    $('.book-email-otp-input').on('paste', function (e) {
        let data = e.originalEvent.clipboardData.getData('text');
        let digits = data.replace(/\D/g, '').substring(0, 6).split('');
        $('.book-email-otp-input').each(function (index, element) {
            $(element).val(digits[index] || '');
        });
        if (digits.length > 0) {
            $('.book-email-otp-input').eq(digits.length - 1).focus();
        }
        e.preventDefault();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const Otpphoneinput = document.querySelector("#user-phone-number");

    if (Otpphoneinput && typeof window.intlTelInput === 'function') {
        const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
            initialCountry: "ae",  // UAE
            separateDialCode: true,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Assign globally
        window.Otpphoneinputnew = Otpphoneinputnew;

        // Update hidden country code when user selects a country
        const countryCodeInput = document.querySelector("#country_code_otp_popup_Modal_book");

        function setCountryCode() {
            const countryData = Otpphoneinputnew.getSelectedCountryData();
            if (countryCodeInput) countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
            // If you want full ISO code (like 'AE') → use countryData.iso2
        }

        // Set default initially
        setCountryCode();

        // Listen to country change
        Otpphoneinput.addEventListener("countrychange", function () {
            setCountryCode();
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const Otpphoneinput = document.querySelector("#book_email_mobile");

    if (Otpphoneinput && typeof window.intlTelInput === 'function') {
        const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
            initialCountry: "ae",  // UAE
            separateDialCode: true,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Assign globally
        window.Otpphoneinputnew = Otpphoneinputnew;

        // Update hidden country code when user selects a country
        const countryCodeInput = document.querySelector("#country_code_book_popup_Modal_book");

        function setCountryCode() {
            const countryData = Otpphoneinputnew.getSelectedCountryData();
            if (countryCodeInput) countryCodeInput.value = countryData.dialCode; // store only dial code (e.g. 971)
            // If you want full ISO code (like 'AE') → use countryData.iso2
        }

        // Set default initially
        setCountryCode();

        // Listen to country change
        Otpphoneinput.addEventListener("countrychange", function () {
            setCountryCode();
        });
    }
});



function booknow_otp_verification(id) {
    // STEP 1: Mobile Input
    // alert('here');
    if (id == '1') {
        var mobile = jQuery("#user-phone-number").val().trim();
        // alert(mobile);

        const selectedCountryCode = getCountryCode();
        $("#country_code").val(selectedCountryCode);
        if (mobile == '') {

            jQuery('#booknow_otp_phone_error').html("Please Enter Mobile No");
            jQuery('#booknow_otp_phone_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_otp_phone_error').show().delay(2000).fadeOut('show');
            return false;

        }
        if (mobile != '') {
            // var filter = /^\d{7}$/;
            if (mobile.length < 7 || mobile.length > 15) {
                jQuery('#booknow_otp_phone_error').html("Please Enter Valid Mobile Number");
                jQuery('#booknow_otp_phone_error').show().delay(0).fadeIn('show');
                jQuery('#booknow_otp_phone_error').show().delay(2000).fadeOut('show');
                return false;
            }
        }

        var url = booknowOtpUrl;
        var mobile = $('#user-phone-number').val();
        var country_code = $('#country_code_otp_popup_Modal_book').val();
        $.ajax({
            url: url,
            type: 'POST',
            data: {

                'mobile': mobile,
                'country_code': country_code
            },
            beforeSend: function () {

                $('#spinner_button_phone_book1').show();
                $('#submit_button_phone_book1').hide();
                //$('.detail-continue-btn').prop('disabled', true);
            },
            success: function (response) {

                if (response.success === true) {

                    $("#booknow_refresh_otp_div").load(location.href + " #booknow_refresh_otp_div");

                    document.getElementById('booknow-step-phone').style.display = 'none';
                    document.getElementById('booknow-step-otp').style.display = 'block';
                    document.getElementById('modalStepTitle').innerText = "Verify your phone number";

                    $('#booknow-whatsapp-number').text('+' + country_code + mobile);

                    if (response.user_data) {
                        $('#booknow_user_name').val(response.user_data.name);
                        $('#booknow_user_email').val(response.user_data.email);
                        //$('#booknow_user_area').val(response.user_data.area);
                    }

                }

                $('#spinner_button_phone_book1').hide();
                $('#submit_button_phone_book1').show();


            },
            error: function (xhr) {

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                    $('#exampleModalLong form')[0].reset();
                    $('#exampleModalLong #spinner_button_phone_book1').hide();
                    $('#exampleModalLong #submit_button_phone_book1').show();
                    $('#exampleModalLong').modal('show');
                } else {
                    alert("Failed to send OTP. Please try again.");
                    $('#exampleModalLong form')[0].reset();
                    $('#exampleModalLong #spinner_button_phone_book1').hide();
                    $('#exampleModalLong #submit_button_phone_book1').show();
                    $('#exampleModalLong').modal('show');
                }

            },
            complete: function () {
                $('.detail-continue-btn').prop('disabled', false);
            }
        });

        return false;


    }

    // STEP 2: OTP Verification
    if (id == '2') {
        var allFilled = true;
        jQuery('.booknow-otp-input').each(function () {
            if (jQuery(this).val().trim() === '') {
                allFilled = false;
            }
        });

        if (!allFilled) {
            jQuery('#booknow_otp_error').html("Please Enter OTP");
            jQuery('#booknow_otp_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }

        let otp = $('#book_session_otp').val();
        // alert(otp);
        let enteredOtp = '';
        document.querySelectorAll('.booknow-otp-input').forEach(input => {
            enteredOtp += input.value;
        });
        // alert(enteredOtp);

        if (otp != enteredOtp) {
            jQuery('#booknow_otp_error').html("OTP doesn't match");
            jQuery('#booknow_otp_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }



        let name = jQuery("input[name='book_name']").val().trim();
        let email = jQuery("input[name='book_email']").val().trim();

        $('#spinner_button_phone_book2').show();
        $('#submit_button_phone_book2').hide();

        if (name !== '' && email !== '') {
            submitLoginFormAjax('BookOtpForm', proceedAfterLogin);
            return false;

            document.getElementById('booknow-step-otp').style.display = 'none';
            document.getElementById('booknow_user_name').style.display = 'none';
            document.getElementById('booknow_user_email').style.display = 'none';
            document.getElementById('booknow-step-details').style.display = 'block';
            document.getElementById('modalStepTitle').innerText = "Personal Details";
        } else {
            document.getElementById('booknow-step-otp').style.display = 'none';
            document.getElementById('booknow-step-details').style.display = 'block';
            document.getElementById('modalStepTitle').innerText = "Personal Details";
        }
    }

    // STEP 3: Personal Details
    if (id == '3') {
        var name = jQuery("input[name='book_name']").val().trim();
        var email = jQuery("input[name='book_email']").val().trim();
        //var area = jQuery("input[name='book_area']").val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (name === '') {

            jQuery('#booknow_name_error').html("Please Enter Full  Name");
            jQuery('#booknow_name_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_name_error').show().delay(2000).fadeOut('show');
            return false;
        }
        if (email === '') {
            jQuery('#booknow_email_error').html("Please Enter email");
            jQuery('#booknow_email_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_email_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (!emailRegex.test(email)) {
            jQuery('#booknow_email_error').html("Please Enter Valid email");
            jQuery('#booknow_email_error').show().delay(0).fadeIn('show');
            jQuery('#booknow_email_error').show().delay(2000).fadeOut('show');
            return false;
        }

        //  if (area === '') {
        //     jQuery('#booknow_area_error').html("Please Enter area");
        //     jQuery('#booknow_area_error').show().delay(0).fadeIn('show');
        //     jQuery('#booknow_area_error').show().delay(2000).fadeOut('show');
        //     return false;
        // }

        $('#spinner_button_phone_book3').show();
        $('#submit_button_phone_book3').hide();

        // All validation passed, submit the form via AJAX
        submitLoginFormAjax('BookOtpForm', proceedAfterLogin);
    }
}

function book_email_goToOtpVerification(id) {

    if (id == '1') {


        var email_email = jQuery("input[name='book_email_email']").val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email_email === '') {
            jQuery('#book_email_email_error').html("Please Enter email");
            jQuery('#book_email_email_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_email_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (!emailRegex.test(email_email)) {
            jQuery('#book_email_email_error').html("Please Enter Valid email");
            jQuery('#book_email_email_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_email_error').show().delay(2000).fadeOut('show');
            return false;
        }

        // alert(email_email);

        var url = booknowOtpUrlEmail;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'email_email': email_email
            },
            beforeSend: function () {

                $('#spinner_button_email_book1').show();
                $('#submit_button_email_book1').hide();

                //$('.email-detail-continue-btn').prop('disabled', true);
            },
            success: function (response) {

                if (response.success === true) {

                    $("#book_email_refresh_otp_div").load(location.href + " #book_email_refresh_otp_div");

                    document.getElementById('book-email-step-phone').style.display = 'none';
                    document.getElementById('booknow-email-step-otp').style.display = 'block';
                    document.getElementById('booknow_email_modalStepTitle').innerText = "Verify your Email";

                    $('#book_email_address_model').text(email_email);

                    if (response.user_data) {
                        $('#book_email_name').val(response.user_data.name);
                        $('#book_email_mobile').val(response.user_data.mobile);
                        $('#country_code_book_popup_Modal_book').val(response.user_data.country_code);
                        //$('#book_email_area').val(response.user_data.area);
                    }

                }


            },
            error: function (xhr) {

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                    $('#book_email_otp_popup_Modal form')[0].reset();
                    $('#book_email_otp_popup_Modal #spinner_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal #submit_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal').modal('show');
                } else {
                    alert("Failed to send OTP. Please try again.");
                    $('#book_email_otp_popup_Modal form')[0].reset();
                    $('#book_email_otp_popup_Modal #spinner_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal #submit_button_email_book1').hide();
                    $('#book_email_otp_popup_Modal').modal('show');
                }

                $('#spinner_button_email_book1').hide();
                $('#submit_button_email_book1').show();

            },
            complete: function () {

                $('#spinner_button_email_book1').hide();
                $('#submit_button_email_book1').show();
                // Re-enable button
                //$('.email-detail-continue-btn').prop('disabled', false);
            }
        });

    }

    // STEP 2: OTP Verification
    if (id == '2') {
        var allFilled = true;
        jQuery('.book-email-otp-input').each(function () {
            if (jQuery(this).val().trim() === '') {
                allFilled = false;
            }
        });

        if (!allFilled) {
            jQuery('#book_email_otp_error').html("Please Enter OTP");
            jQuery('#book_email_otp_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }

        let otp = $('#book_email_session_otp').val();
        let enteredOtp = '';
        document.querySelectorAll('.book-email-otp-input').forEach(input => {
            enteredOtp += input.value;
        });
        // alert(otp);

        if (otp != enteredOtp) {
            jQuery('#book_email_otp_error').html("OTP doesn't match");
            jQuery('#book_email_otp_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_otp_error').show().delay(2000).fadeOut('show');
            return false;
        }


        let email_name = jQuery("input[name='book_email_name']").val().trim();
        let email_mobile = jQuery("input[name='book_email_mobile']").val().trim();

        $('#spinner_button_email_book2').show();
        $('#submit_button_email_book2').hide();

        if (email_name !== '' && email_mobile !== '') {
            submitLoginFormAjax('bookemailOtpForm', proceedAfterLogin);
            return false;

            document.getElementById('book_email_name').style.display = 'none';
            document.getElementById('book_email_mobile').style.display = 'none';
            document.getElementById('booknow-email-step-otp').style.display = 'none';
            document.getElementById('booknow-email-step-details').style.display = 'block';
            document.getElementById('booknow_email_modalStepTitle').innerText = "Personal Details";



        } else {
            // One or both fields are empty, show Step 3
            document.getElementById('booknow-email-step-otp').style.display = 'none';
            document.getElementById('booknow-email-step-details').style.display = 'block';
            document.getElementById('booknow_email_modalStepTitle').innerText = "Personal Details";

            $('#spinner_button_email_book2').hide();
            $('#submit_button_email_book2').show();
        }
    }

    // STEP 3: Personal Details
    if (id == '3') {
        var email_name = jQuery("input[name='book_email_name']").val().trim();
        var email_mobile = jQuery("input[name='book_email_mobile']").val().trim();
        //var email_area = jQuery("input[name='book_email_area']").val().trim();

        if (email_name === '') {

            jQuery('#book_email_name_error').html("Please Enter Full  Name");
            jQuery('#book_email_name_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_name_error').show().delay(2000).fadeOut('show');
            return false;
        }
        if (email_mobile === '') {
            jQuery('#book_email_mobile_error').html("Please Enter Mobile Number");
            jQuery('#book_email_mobile_error').show().delay(0).fadeIn('show');
            jQuery('#book_email_mobile_error').show().delay(2000).fadeOut('show');
            return false;
        }

        if (email_mobile != '') {
            // var filter = /^\d{7}$/;
            if (email_mobile.length < 7 || email_mobile.length > 15) {
                jQuery('#book_email_mobile_error').html("Please Enter Valid Mobile Number");
                jQuery('#book_email_mobile_error').show().delay(0).fadeIn('show');
                jQuery('#book_email_mobile_error').show().delay(2000).fadeOut('show');
                return false;
            }
        }
        //   if (email_area === '') {

        //     jQuery('#book_email_area_error').html("Please Enter Area");
        //     jQuery('#book_email_area_error').show().delay(0).fadeIn('show');
        //     jQuery('#book_email_area_error').show().delay(2000).fadeOut('show');
        //     return false;
        // }

        $('#spinner_button_email_book3').show();
        $('#submit_button_email_book3').hide();

        // All validation passed, submit the form via AJAX
        submitLoginFormAjax('bookemailOtpForm', proceedAfterLogin);
    }
}

function apply_promo(from) {
    // alert('Promo applied');

    let promo_code = $('#promo_code' + from).val();
    if (!promo_code) {
        Swal.fire({
            icon: 'warning',
            title: 'Please Enter Promo Code',
            // text: '',
            confirmButtonColor: '#3085d6',
        });

        return false;
    }

    $.ajax({
        url: package_promo_check,
        type: 'POST',
        data: {
            'promo_code': promo_code
        },
        success: function (response) {

            if (response === 'invalid') {

                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Promo Code',
                    // text: '',
                    confirmButtonColor: '#3085d6',
                });

                $('#promo_code' + from).val('');

                return false;

            } else if (response === 'Already') {
                Swal.fire({
                    icon: 'info',
                    title: 'Promo Code Already Used',
                    // text: '',
                    confirmButtonColor: '#3085d6',
                });

                $('#promo_code' + from).val('');
                return false;
            } else if (response === 'Already Used') {
                Swal.fire({
                    icon: 'info',
                    title: 'Promo Code Already Used',
                    // text: '',
                    confirmButtonColor: '#3085d6',
                });

                $('#promo_code' + from).val('');
                return false;
            } else if (response === 'invalid_user_count') {
                Swal.fire({
                    icon: 'info',
                    title: 'Coupon Code Expired.',
                    // text: '',
                    confirmButtonColor: '#3085d6',
                });

                $('#promo_code' + from).val('');
                return false;
            } else if (response === 'grater') {
                Swal.fire({
                    icon: 'info',
                    title: 'Promo Discount is greater than total amount',
                    // text: '',
                    confirmButtonColor: '#3085d6',
                });

                $('#promo_code' + from).val('');
                return false;
            } else if (response === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Promo Code Applied Successfully',
                    // text: '',
                    confirmButtonColor: '#3085d6',
                });
                $(".wallet_apply_new").show();
                $(".wallet_cancel_new").hide();

                $('#wallet_used').val('0');
                updateSidebarCart();
                return true;
            } else if (!isNaN(parseFloat(response)) && isFinite(response)) {
                Swal.fire({
                    icon: 'info',
                    title: 'To apply this promo you need a minimum order of ' + response + ' AED',
                    // text: '',
                    confirmButtonColor: '#3085d6',
                });

                $('#promo_code' + from).val('');
                return false;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong',
                    // text: '',
                    confirmButtonColor: '#3085d6',
                });

                $('#promo_code' + from).val('');
                return false;
            }

        },

    });
}

function apply_wallet_discount() {
    //alert('Wallet discount applied');

    Swal.fire({
        title: 'Are you sure you want to apply wallet balance?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, apply it!'
    }).then((result) => {
        if (result.isConfirmed) {
            proceedApplyWallet();
        }
    });
}

function proceedApplyWallet() {

    let walletBalance = parseFloat($("#wallet_balance").val()) || 0;
    let totalToPay = parseFloat($("#total_to_pay").val()) || 0;

    let walletUsed = 0;

    if (walletBalance >= totalToPay) {
        // wallet fully covers order
        walletUsed = totalToPay;
        totalToPay = 0;
    } else {
        // wallet partially covers order
        walletUsed = walletBalance;
        totalToPay = totalToPay - walletBalance;
    }

    $('#wallet_used').val(walletUsed.toFixed(2));

    $(".wallet_apply_new").hide();
    $(".wallet_cancel_new").show();
    //updateSidebarCart();
    removeCoupan();

    Swal.fire({
        icon: "success",
        title: "Wallet balance applied successfully",
        showConfirmButton: false,
        timer: 1200
    });

}

function cancelWalletDiscount() {


    Swal.fire({
        title: 'Are you sure you want to remove wallet balance?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            proceedCancelWallet();
        }
    });
}

function proceedCancelWallet() {

    Swal.fire({
        icon: "success",
        title: "Wallet balance removed successfully",
        showConfirmButton: false,
        timer: 1200
    });

    $(".wallet_apply_new").show();
    $(".wallet_cancel_new").hide();

    $('#wallet_used').val('0');

    updateSidebarCart();

}