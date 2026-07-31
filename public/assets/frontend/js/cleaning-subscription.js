/* Cleaning Subscription - Step 1 JS Logic */

let selectedAddons = [];
let currentStep = 1;

let state = {
    step: 1,
    hours: 1,
    packageId: null,
    frequencyId: null,
    visits: 1,
    selectedDays: [],
    time: null,
    timeName: null,
    materials: 'No',
    instructions: '',
    materialPrice: 0
};

function saveState() {
    let toSave = { state, currentStep, selectedAddons };
    sessionStorage.setItem('cleaningSubState', JSON.stringify(toSave));
}

function restoreState() {
    let saved = sessionStorage.getItem('cleaningSubState');
    if (saved) {
        let parsed = JSON.parse(saved);
        state = parsed.state;
        selectedAddons = parsed.selectedAddons || [];
        
        let targetStep = parsed.currentStep;
        if (targetStep >= 2 && window.isUserLoggedIn) {
            targetStep = 3; 
        }
        currentStep = targetStep;
        state.step = currentStep;
        
        document.querySelectorAll('#hoursSelection .pill').forEach(p => {
            if (parseInt(p.getAttribute('data-val')) === state.hours) {
                p.classList.add('selected');
            } else {
                p.classList.remove('selected');
            }
        });
        
        document.querySelectorAll('#packagesSelection .subscription-option').forEach(p => {
            if (p.getAttribute('data-val') == state.packageId) {
                p.classList.add('selected');
            } else {
                p.classList.remove('selected');
            }
        });
        
        document.querySelectorAll('#frequenciesSelection .frequency-card').forEach(p => {
            if (p.getAttribute('data-val') == state.frequencyId) {
                p.classList.add('selected');
            } else {
                p.classList.remove('selected');
            }
        });
        
        document.querySelectorAll('.day-pill').forEach(p => {
            if (state.selectedDays.includes(p.getAttribute('data-val'))) {
                p.classList.add('selected');
            } else {
                p.classList.remove('selected');
            }
        });
        
        document.querySelectorAll('.material-pill').forEach(p => {
            if (p.getAttribute('data-val') == state.materials) {
                p.classList.add('selected');
            } else {
                p.classList.remove('selected');
            }
        });
        
        if (state.time) {
            let timeRadio = document.querySelector('input[name="time_slot"][value="' + state.time + '"]');
            if (timeRadio) {
                timeRadio.checked = true;
            }
        }
        
        let specialInstr = document.getElementById('special_instructions');
        if (specialInstr && state.instructions) {
            specialInstr.value = state.instructions;
            let charCount = document.getElementById('charCount');
            if (charCount) charCount.innerText = state.instructions.length + '/150';
        }

        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        let activeStep = document.getElementById('step' + currentStep);
        if (activeStep) {
            activeStep.classList.add('active');
        }
        return true;
    }
    return false;
}

function init() {
    if (!restoreState()) {
        const firstHour = document.querySelector('#hoursSelection .pill.selected');
        if (firstHour) {
            state.hours = parseInt(firstHour.getAttribute('data-val') || 1);
            state.materialPrice = parseFloat(firstHour.getAttribute('data-material-price')) || 0;
        }

        const firstPkg = document.querySelector('#packagesSelection .subscription-option');
        if (firstPkg) state.packageId = firstPkg.getAttribute('data-val');

        const firstFreq = document.querySelector('#frequenciesSelection .frequency-card');
        if (firstFreq) {
            state.frequencyId = firstFreq.getAttribute('data-val');
            state.visits = parseInt(firstFreq.getAttribute('data-visits') || 1);
        }
    }

    bindEvents();
    updateUI();
    updateHeader();
}

function bindEvents() {
    document.querySelectorAll('#hoursSelection .pill').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('#hoursSelection .pill').forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            state.hours = parseInt(this.getAttribute('data-val'));
            state.materialPrice = parseFloat(this.getAttribute('data-material-price')) || 0;
            updateUI();
        });
    });

    document.querySelectorAll('#packagesSelection .subscription-option').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('#packagesSelection .subscription-option').forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            state.packageId = this.getAttribute('data-val');
            updateUI();
        });
    });

    document.querySelectorAll('#frequenciesSelection .frequency-card').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('#frequenciesSelection .frequency-card').forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            state.frequencyId = this.getAttribute('data-val');
            state.visits = parseInt(this.getAttribute('data-visits') || 1);
            updateUI();
        });
    });

    document.querySelectorAll('.day-pill').forEach(el => {
        el.addEventListener('click', function () {
            let day = this.getAttribute('data-val');
            let index = state.selectedDays.indexOf(day);
            if (index > -1) {
                state.selectedDays.splice(index, 1);
                this.classList.remove('selected');
            } else {
                if (state.selectedDays.length < state.visits) {
                    state.selectedDays.push(day);
                    this.classList.add('selected');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limit Reached',
                        text: 'You can only select ' + state.visits + ' day(s).',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                    });
                }
            }
            let errEl = document.getElementById('days_error');
            if (errEl) errEl.innerText = '';
            updateUI();
        });
    });

    document.querySelectorAll('.material-pill').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('.material-pill').forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            state.materials = this.getAttribute('data-val');
            updateUI();
        });
    });

    let specialInstr = document.getElementById('special_instructions');
    let charCount = document.getElementById('charCount');
    if (specialInstr) {
        specialInstr.addEventListener('input', function () {
            state.instructions = this.value;
            if (charCount) charCount.innerText = this.value.length + '/150';
        });
    }



    let backBtn = document.getElementById('backBtn');
    if (backBtn) {
        backBtn.addEventListener('click', prevStepBtn);
    }
}

window.nextStep = function (step) {
    if (currentStep === 1 && step === 2) {
        if (state.selectedDays.length > state.visits) {
            state.selectedDays = [];
            document.querySelectorAll('.day-pill').forEach(p => p.classList.remove('selected'));
        }
        updateUI();
    }

    if (currentStep === 2 && step > 2) {
        if (state.selectedDays.length !== state.visits) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Selection',
                text: 'Please select exactly ' + state.visits + ' day(s).',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
            });
            return;
        }
        if (!state.time) {
            Swal.fire({
                icon: 'warning',
                title: 'No Time Slot Selected',
                text: 'Please select a time slot.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
            });
            return;
        }
    }

    if (currentStep === 2 && step === 3) {
        if (typeof window.isUserLoggedIn !== 'undefined' && window.isUserLoggedIn === false) {
            $('#otp_popup_Modal').modal('show');
            return;
        }
    }

    if (currentStep === 3 && step > 3) {
        let city = document.getElementById('city');
        if (city && city.value.trim() === '') {
            Swal.fire({ icon: 'warning', title: 'City Required', text: 'Please select a city.', confirmButtonText: 'OK', confirmButtonColor: '#3085d6' });
            return;
        }

        let area = document.getElementById('area');
        if (area && area.value.trim() === '') {
            Swal.fire({ icon: 'warning', title: 'Area Required', text: 'Please enter your area.', confirmButtonText: 'OK', confirmButtonColor: '#3085d6' });
            return;
        }

        let building = document.getElementById('building_street_no');
        if (building && building.value.trim() === '') {
            Swal.fire({ icon: 'warning', title: 'Building/Street Required', text: 'Please enter your building name and/or street.', confirmButtonText: 'OK', confirmButtonColor: '#3085d6' });
            return;
        }

        let apartment = document.getElementById('apartment_villa_no');
        if (apartment && apartment.value.trim() === '') {
            Swal.fire({ icon: 'warning', title: 'Apartment/Villa Required', text: 'Please enter your apartment/villa number.', confirmButtonText: 'OK', confirmButtonColor: '#3085d6' });
            return;
        }

        // Check emirates ID / passport if they exist
        let docEmirates = document.getElementById('doc_type_emirates');
        if (docEmirates) {
            if (docEmirates.checked) {
                let emiratesId = document.getElementById('emirates_id_number');
                if (emiratesId && emiratesId.value.trim() === '') {
                    Swal.fire({ icon: 'warning', title: 'Emirates ID Required', text: 'Please enter your Emirates ID.', confirmButtonText: 'OK', confirmButtonColor: '#3085d6' });
                    return;
                }
            } else {
                let passport = document.getElementById('passport_number');
                if (passport && passport.value.trim() === '') {
                    Swal.fire({ icon: 'warning', title: 'Passport Required', text: 'Please enter your Passport number.', confirmButtonText: 'OK', confirmButtonColor: '#3085d6' });
                    return;
                }
            }
        }
    }

    currentStep = step;
    state.step = step;
    document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    let activeStep = document.getElementById('step' + step);
    if (activeStep) {
        activeStep.classList.add('active');
    }
    updateHeader();
    saveState();
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

window.prevStep = function (step) {
    nextStep(step);
};

function prevStepBtn() {
    if (currentStep > 1) {
        nextStep(currentStep - 1);
    } else {
        window.history.back();
    }
}
window.goBack = prevStepBtn;

function updateHeader() {
    let totalSteps = 4;

    let titles = {
        1: 'Cleaning Subscription',
        2: 'Schedule Service',
        3: 'Address Details',
        4: 'Payment Information'
    };

    let title = titles[currentStep] || '';

    let elCurrentStep = document.getElementById('currentStepNum');
    if (elCurrentStep) elCurrentStep.innerText = currentStep;

    let elTotalStep = document.getElementById('totalStepNum');
    if (elTotalStep) elTotalStep.innerText = totalSteps;

    let elHeaderTitle = document.getElementById('stepHeaderTitle');
    if (elHeaderTitle) elHeaderTitle.innerText = title;

    let elBackArrow = document.getElementById('backArrow');
    let elStepCounter = document.getElementById('stepCounter');

    if (currentStep === 1) {
        if (elBackArrow) elBackArrow.style.display = 'none';
        if (elStepCounter) elStepCounter.style.cursor = 'default';
    } else {
        if (elBackArrow) elBackArrow.style.display = 'inline-block';
        if (elStepCounter) elStepCounter.style.cursor = 'pointer';
    }
}

function updateUI() {
    let summaryHours = document.getElementById('summaryHours');
    if (summaryHours) summaryHours.innerText = state.hours + ' Hours';

    let summaryMaterial = document.getElementById('summaryMaterial');
    if (summaryMaterial) summaryMaterial.innerText = state.materials;

    let summaryFreq = document.getElementById('summaryFrequency');
    if (summaryFreq) summaryFreq.innerText = document.querySelector('#frequenciesSelection .frequency-card.selected strong')?.innerText || '-';

    let daysLabel = document.getElementById('daysLabel');
    if (daysLabel) daysLabel.innerText = 'Choose ' + state.visits + (state.visits > 1 ? ' days' : ' day');

    let summaryDT = document.getElementById('summaryDateTime');
    let dtStr = '-';
    if (state.selectedDays.length > 0) {
        dtStr = state.selectedDays.join(', ');
    }
    if (state.timeName) {
        dtStr += (dtStr !== '-' ? ' at ' : '') + state.timeName;
    }
    if (summaryDT) summaryDT.innerText = dtStr;

    let subtotal = 0;
    let discount = 0;

    // Move the frequency slider under the selected package
    let freqTarget = document.getElementById('freq-target-' + state.packageId);
    let freqSliderWrapper = document.getElementById('frequenciesWrapper');
    if (freqTarget && freqSliderWrapper) {
        document.querySelectorAll('.frequency-container-target').forEach(el => el.style.display = 'none');
        freqTarget.style.display = 'block';
        if (!freqTarget.contains(freqSliderWrapper)) {
            freqTarget.appendChild(freqSliderWrapper);
            let slider = document.getElementById('frequenciesSelection');
            if (slider) slider.scrollLeft = 0;
        }
        if (typeof checkArrowsVisibility === 'function') {
            setTimeout(checkArrowsVisibility, 50);
        }
    }

    // Dynamically update Frequency cards
    let currentDuration = parseInt(state.hours);
    document.querySelectorAll('#frequenciesSelection .frequency-card').forEach(el => {
        let fVisits = parseInt(el.getAttribute('data-visits') || 1);
        let fId = el.getAttribute('data-val');
        let fBadge = el.querySelector('.freq-discount-badge');
        let fDiscountVal = el.querySelector('.freq-discount-val');
        let fPriceHr = el.querySelector('.freq-price-hr');
        let fHoursVal = el.querySelector('.freq-hours-val');

        if (fHoursVal) fHoursVal.innerText = currentDuration;

        let freqPkgObj = null;
        if (typeof pricingRules !== 'undefined') {
            pricingRules.forEach(r => {
                if (r.package_id == state.packageId && r.duration_id == currentDuration && r.frequency_id == fId) {
                    freqPkgObj = r;
                }
            });
        }

        if (freqPkgObj) {
            let hourlyRate = parseFloat(freqPkgObj.price_per_hour);
            let formattedRate = hourlyRate % 1 === 0 ? hourlyRate.toString() : hourlyRate.toFixed(2);

            if (fPriceHr) fPriceHr.innerHTML = '<span class="currency_dhiramnew" style="font-size: 16px;">AED</span> <span class="price-val">' + formattedRate + '</span>';

            if (freqPkgObj.discount_percentage && freqPkgObj.discount_percentage > 0) {
                if (fBadge) fBadge.style.display = 'inline-block';
                if (fDiscountVal) fDiscountVal.innerText = freqPkgObj.discount_percentage;
            } else {
                if (fBadge) fBadge.style.display = 'none';
            }
        } else {
            if (fPriceHr) fPriceHr.innerHTML = '<span class="currency_dhiramnew" style="font-size: 16px;">AED</span> <span class="price-val">0</span>';
            if (fBadge) fBadge.style.display = 'none';
        }
    });

    let pkgObj = null;
    if (typeof pricingRules !== 'undefined') {
        pricingRules.forEach(r => {
            if (r.package_id == state.packageId && r.duration_id == currentDuration && r.frequency_id == state.frequencyId) {
                pkgObj = r;
            }
        });
    }

    let validityMonths = 1;
    if (typeof packagesData !== 'undefined' && state.packageId) {
        let selectedPackage = packagesData.find(p => p.id == state.packageId);
        if (selectedPackage) {
            validityMonths = selectedPackage.validity_months;
        }
    }
    let totalSessions = validityMonths * 4 * state.visits;

    if (pkgObj) {
        subtotal = parseFloat(pkgObj.price_per_hour) * currentDuration * totalSessions;
        if (pkgObj.discount_percentage) {
            discount = (pkgObj.discount_percentage / 100) * subtotal;
        }
    }

    let materialHtml = '';
    if (state.materials === 'Yes' && state.materialPrice > 0) {
        let materialCost = state.materialPrice; // Do not multiply by totalSessions
        subtotal += materialCost;

        materialHtml = `
        <div class="d-flex justify-content-between subheadingdev py-1">
            <div style="color: #6c757d; font-size:0.85rem;">Cleaning Materials</div>
            <div class="font-weight-bold sm-summary price-wrapper" style="color: #6c757d; font-size:0.85rem;">
                <span class="currency_dhiramnew" style="background-color: transparent; color:inherit;">AED</span>
                <span>${materialCost.toFixed(2)}</span>
            </div>
        </div>`;
    }

    let addonsHtml = '';
    if (typeof hasAddons !== 'undefined' && hasAddons && selectedAddons.length > 0) {
        selectedAddons.forEach(a => {
            subtotal += a.price * a.qty;
            addonsHtml += `
            <div class="d-flex justify-content-between subheadingdev py-1">
                <div style="color: #6c757d; font-size:0.85rem;">${a.name} x ${a.qty}</div>
                <div class="font-weight-bold sm-summary price-wrapper" style="color: #6c757d; font-size:0.85rem;">
                    <span class="currency_dhiramnew" style="background-color: transparent; color:inherit;">AED</span>
                    <span>${(a.price * a.qty).toFixed(2)}</span>
                </div>
            </div>`;
        });
    }

    let packageDetailsHtml = '';
    if (pkgObj) {
        let monthLabel = validityMonths == 1 ? "1 month" : validityMonths + " months";
        let visitsLabel = state.visits == 1 ? "1 visit per week" : state.visits + " visits per week";

        packageDetailsHtml = `
        <ul style="list-style:none; padding:0; margin:0; font-size:13px; color:#333; line-height:1.6;">
            <li style="display:flex; margin-bottom:2px;">
                <span style="width:140px; color:#555;">&bull; Package Type</span>
                <span style="font-weight:600;">: ${monthLabel}</span>
            </li>
            <li style="display:flex; margin-bottom:2px;">
                <span style="width:140px; color:#555;">&bull; Frequency</span>
                <span style="font-weight:600;">: ${visitsLabel}</span>
            </li>
            <li style="display:flex; margin-bottom:2px;">
                <span style="width:140px; color:#555;">&bull; Total Sessions</span>
                <span style="font-weight:600;">: ${totalSessions} sessions</span>
            </li>
            <li style="display:flex; margin-bottom:2px;">
                <span style="width:140px; color:#555;">&bull; Duration per visit</span>
                <span style="font-weight:600;">: ${currentDuration} hours</span>
            </li>
            <li style="display:flex; margin-bottom:2px;">
                <span style="width:140px; color:#555;">&bull; Professional</span>
                <span style="font-weight:600;">: 1</span>
            </li>
            <li style="display:flex; margin-bottom:2px;">
                <span style="width:140px; color:#555;">&bull; Material</span>
                <span style="font-weight:600;">: ${state.materials}</span>
            </li>
        </ul>`;
    }

    let combinedHtml = packageDetailsHtml + materialHtml + addonsHtml;

    let cartItemList = document.getElementById('cart_item_list');
    if (cartItemList) cartItemList.innerHTML = materialHtml + addonsHtml;

    let mobilePackageDetails = document.getElementById('mobile_package_details');
    if (mobilePackageDetails) mobilePackageDetails.innerHTML = combinedHtml;

    let paymentType = document.querySelector('input[name="payment_type"]:checked');
    let codFee = 0;

    if (paymentType && paymentType.value === 'COD' && typeof window.codFeeAmount !== 'undefined') {
        codFee = parseFloat(window.codFeeAmount);
    }

    let summaryCodRow = document.getElementById('summaryCodRow');
    let summaryCodFee = document.getElementById('summaryCodFee');
    if (summaryCodRow && summaryCodFee) {
        if (codFee > 0) {
            summaryCodRow.style.setProperty('display', 'flex', 'important');
            summaryCodFee.innerText = codFee.toFixed(2);
        } else {
            summaryCodRow.style.setProperty('display', 'none', 'important');
        }
    }

    let summaryDiscountRow = document.getElementById('summaryDiscountRow');
    if (summaryDiscountRow) {
        if (discount > 0) {
            summaryDiscountRow.style.setProperty('display', 'flex', 'important');
            let sd = document.getElementById('summaryDiscount');
            if (sd) sd.innerText = discount.toFixed(2);
        } else {
            summaryDiscountRow.style.setProperty('display', 'none', 'important');
        }
    }

    let baseTotal = subtotal - discount + codFee;
    if (typeof state !== 'undefined') {
        state.total = subtotal - discount; // Subtotal before COD for promo validation
    }

    let promoDiscount = parseFloat(document.getElementById('promo_discount') ? document.getElementById('promo_discount').value : 0) || 0;
    let walletUsed = parseFloat(document.getElementById('wallet_used') ? document.getElementById('wallet_used').value : 0) || 0;

    let promoSummaryRow = document.querySelector('.promo_dicount_summary_div');
    if (promoSummaryRow) {
        if (promoDiscount > 0) {
            promoSummaryRow.style.setProperty('display', 'flex', 'important');
            let pVal = document.querySelector('.promo_code_summary');
            if (pVal) pVal.innerText = promoDiscount.toFixed(2);
        } else {
            promoSummaryRow.style.setProperty('display', 'none', 'important');
        }
    }

    let walletSummaryRow = document.querySelector('.wallet_dicount_summary_div');
    if (walletSummaryRow) {
        if (walletUsed > 0) {
            walletSummaryRow.style.setProperty('display', 'flex', 'important');
            let wVal = document.querySelector('.wallet_used_summary');
            if (wVal) wVal.innerText = walletUsed.toFixed(2);
        } else {
            walletSummaryRow.style.setProperty('display', 'none', 'important');
        }
    }

    let total = baseTotal - promoDiscount - walletUsed;
    if (total < 0) total = 0;
    
    let sumSubtotal = document.getElementById('summarySubtotal');
    if (sumSubtotal) sumSubtotal.innerText = subtotal.toFixed(2);
    let totalPriceDisplay = document.querySelectorAll('.total_to_pay');
    let subTotalDisplay = document.querySelectorAll('.sub_total_display');
    let vatChargeDisplay = document.querySelectorAll('.vat_charge_display');

    totalPriceDisplay.forEach(el => {
        el.innerText = total.toFixed(2);
    });
    subTotalDisplay.forEach(el => {
        el.innerText = subtotal.toFixed(2);
    });
    vatChargeDisplay.forEach(el => {
        el.innerText = "0.00";
    });

    let summaryTotalBtnVal = document.getElementById('summaryTotalBtnVal');
    if (summaryTotalBtnVal) summaryTotalBtnVal.innerText = total.toFixed(2);
    
    saveState();
}

// Mobile Summary Modal Logic
document.addEventListener("DOMContentLoaded", function () {
    let modalElement = document.getElementById("mobilesummaryModal");
    if (!modalElement) return;

    let summaryModal = new bootstrap.Modal(modalElement);

    document.querySelectorAll(".mobile_price").forEach(function (priceContainer) {
        priceContainer.addEventListener("click", function () {
            let arrow = priceContainer.querySelector(".arrow-toggle-mobile");
            if (!arrow) return;

            if (arrow.classList.contains("rotate-up")) {
                arrow.classList.remove("rotate-up");
                arrow.classList.add("rotate-down");
                summaryModal.hide();
            } else {
                document.querySelectorAll(".arrow-toggle-mobile").forEach(a => {
                    a.classList.remove("rotate-up");
                    a.classList.add("rotate-down");
                });
                arrow.classList.remove("rotate-down");
                arrow.classList.add("rotate-up");
                summaryModal.show();
            }
        });
    });

    modalElement.addEventListener("hidden.bs.modal", function () {
        document.querySelectorAll(".arrow-toggle-mobile").forEach(a => {
            a.classList.remove("rotate-up");
            a.classList.add("rotate-down");
        });
    });
});

function submitForm() {
    // 1. Gather dynamic JS state
    let freqString = state.visits === 1 ? 'Weekly' : 'Multiple times a week';
    let daysString = state.selectedDays.join(', ');

    let pkgObj = null;
    if (typeof window.subscriptionData !== 'undefined' && window.subscriptionData.packages) {
        pkgObj = window.subscriptionData.packages.find(p => p.id == state.packageId);
    }
    let durationMonths = pkgObj ? parseInt(pkgObj.validity) : 1;
    let packageName = pkgObj ? pkgObj.name : '';

    // Calculate dynamic totals to send
    let sumSubtotal = parseFloat(document.getElementById('summarySubtotal') ? document.getElementById('summarySubtotal').innerText : 0) || 0;
    let sumDiscount = parseFloat(document.getElementById('summaryDiscount') ? document.getElementById('summaryDiscount').innerText : 0) || 0;
    let promoDiscount = parseFloat(document.getElementById('promo_discount') ? document.getElementById('promo_discount').value : 0) || 0;
    let walletUsed = parseFloat(document.getElementById('wallet_used') ? document.getElementById('wallet_used').value : 0) || 0;
    let totalToPay = parseFloat(document.getElementById('summaryTotalBtnVal') ? document.getElementById('summaryTotalBtnVal').innerText : 0) || 0;

    let codFee = 0;
    let paymentType = document.querySelector('input[name="payment_type"]:checked');
    if (paymentType && paymentType.value === 'COD' && typeof window.codFeeAmount !== 'undefined') {
        codFee = parseFloat(window.codFeeAmount);
    }

    // 2. Prepare form
    let form = document.getElementById('subscriptionForm');

    // Helper to append hidden input if it doesn't exist
    function addHidden(name, value) {
        let el = form.querySelector('input[name="' + name + '"]');
        if (!el) {
            el = document.createElement('input');
            el.type = 'hidden';
            el.name = name;
            form.appendChild(el);
        }
        el.value = value;
    }

    addHidden('how_often_do_you_need_cleaning', freqString);
    addHidden('selectedDays', daysString);
    addHidden('package_duration_months', durationMonths);
    addHidden('package', packageName);
    addHidden('hours', state.hours);
    addHidden('time', state.time); // Sending the integer ID for the time slot
    addHidden('materials', state.materials);
    addHidden('instructions', state.instructions);

    addHidden('sub_total', sumSubtotal);
    addHidden('package_discount', sumDiscount);
    addHidden('cod_charge', codFee);
    addHidden('total_to_pay', totalToPay);

    let formData = new FormData(form);

    // 3. Show loading
    let submitBtn = document.getElementById('confirmBookingBtn');
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
    }

    // 4. AJAX POST
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    alert("Booking Completed Successfully!");
                    window.location.reload();
                }
            } else {
                alert(data.message || 'An error occurred during booking.');
                if (submitBtn) {
                    submitBtn.innerHTML = 'Confirm Booking';
                    submitBtn.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred. Please try again.');
            if (submitBtn) {
                submitBtn.innerHTML = 'Confirm Booking';
                submitBtn.disabled = false;
            }
        });
}

window.scrollFreqSlider = function (direction) {
    let slider = document.getElementById('frequenciesSelection');
    if (slider) {
        let scrollAmount = 280; // approximate width of a card + gap
        slider.scrollLeft += (scrollAmount * direction);
        setTimeout(window.checkArrowsVisibility, 50);
    }
};

window.checkArrowsVisibility = function () {
    let slider = document.getElementById('frequenciesSelection');
    let leftArrow = document.querySelector('.freq-nav-btn.left-arrow');
    let rightArrow = document.querySelector('.freq-nav-btn.right-arrow');

    if (slider && leftArrow && rightArrow) {
        if (slider.scrollLeft <= 0) {
            leftArrow.style.display = 'none';
        } else {
            leftArrow.style.display = 'flex';
        }

        if (Math.ceil(slider.scrollLeft + slider.clientWidth) >= slider.scrollWidth) {
            rightArrow.style.display = 'none';
        } else {
            rightArrow.style.display = 'flex';
        }
    }
};

document.addEventListener('DOMContentLoaded', function () {
    init();

    let freqSlider = document.getElementById('frequenciesSelection');
    if (freqSlider) {
        freqSlider.addEventListener('scroll', checkArrowsVisibility);
        setTimeout(checkArrowsVisibility, 100);
    }

    let paymentRadios = document.querySelectorAll('input[name="payment_type"]');
    paymentRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            updateUI();
        });
    });
});

function timeSlotClick(price, name) {
    let selectedRadio = document.querySelector('input[name="time_slot"]:checked');
    if (selectedRadio) {
        state.time = selectedRadio.value;
        state.timeName = name;
        document.getElementById('time_slot_error').innerText = '';
        updateUI();
    }
}


