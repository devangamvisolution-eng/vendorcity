/* Cleaning Subscription - Step 1 JS Logic */

let selectedAddons = [];
let currentStep = 1;

let state = {
    step: 1,
    hours: 1,
    packageId: null,
    frequencyId: null,
    visits: 1,
    days: [],
    time: null,
    materials: 'No'
};

function init() {
    const firstPkg = document.querySelector('#packagesSelection .subscription-option');
    if (firstPkg) state.packageId = firstPkg.getAttribute('data-val');

    const firstFreq = document.querySelector('#frequenciesSelection .subscription-option');
    if (firstFreq) {
        state.frequencyId = firstFreq.getAttribute('data-val');
        state.visits = parseInt(firstFreq.getAttribute('data-visits') || 1);
    }

    bindEvents();
    updateUI();
}

function bindEvents() {
    document.querySelectorAll('#hoursSelection .pill').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('#hoursSelection .pill').forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            state.hours = parseInt(this.getAttribute('data-val'));
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

    document.querySelectorAll('#frequenciesSelection .subscription-option').forEach(el => {
        el.addEventListener('click', function () {
            document.querySelectorAll('#frequenciesSelection .subscription-option').forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            state.frequencyId = this.getAttribute('data-val');
            state.visits = parseInt(this.getAttribute('data-visits') || 1);
            updateUI();
        });
    });

    document.querySelectorAll('.day-checkbox').forEach(el => {
        el.addEventListener('change', function () {
            const checkedDays = document.querySelectorAll('.day-checkbox:checked');
            if (checkedDays.length > state.visits) {
                this.checked = false; 
                alert('You can only select ' + state.visits + ' day(s) for this frequency.');
            }
            
            state.days = Array.from(checkedDays).map(cb => cb.value);
        });
    });

    document.querySelectorAll('.time-radio').forEach(el => {
        el.addEventListener('change', function () {
            state.time = this.value;
        });
    });

    document.querySelectorAll('.material-radio').forEach(el => {
        el.addEventListener('change', function () {
            state.materials = this.value;
            updateUI();
        });
    });

    let bottomNextBtn = document.getElementById('bottomNextBtn');
    if (bottomNextBtn) {
        bottomNextBtn.addEventListener('click', function() {
            if (state.step === 1) {
                nextStep(hasAddons ? 2 : 3);
            } else if (state.step === 2) {
                nextStep(3);
            } else if (state.step === 3) {
                nextStep(4);
            } else {
                submitForm();
            }
        });
    }

    let backBtn = document.getElementById('backBtn');
    if (backBtn) {
        backBtn.addEventListener('click', goBack);
    }
}

function nextStep(step) {
    currentStep = step;
    state.step = step;
    document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    let activeStep = document.getElementById('step' + step);
    if(activeStep) {
        activeStep.classList.add('active');
    }
    updateHeader();

    if (step === 3) {
        let helperText = document.getElementById('daysHelperText');
        if (helperText) {
            helperText.innerText = 'Choose ' + state.visits + ' day(s)';
        }
    }
}

function updateHeader() {
    let totalSteps = hasAddons ? 3 : 2;
    let displayStep = currentStep;
    if (!hasAddons && currentStep === 3) displayStep = 2; // Date & Time is step 2 if no addons

    let titles = {
        1: 'Cleaning Subscription',
        2: 'People also added',
        3: 'Date & Time'
    };
    
    let title = titles[currentStep] || '';
    
    let elCurrentStep = document.getElementById('currentStepNum');
    if (elCurrentStep) elCurrentStep.innerText = displayStep;
    
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

function goBack() {
    if (currentStep > 1) {
        if (currentStep === 3 && !hasAddons) {
            nextStep(1);
        } else {
            nextStep(currentStep - 1);
        }
    } else {
        window.history.back();
    }
}

function updateUI() {
    let summaryHours = document.getElementById('summaryHours');
    if (summaryHours) summaryHours.innerText = state.hours + ' Hours';

    let summaryMaterial = document.getElementById('summaryMaterial');
    if (summaryMaterial) summaryMaterial.innerText = state.materials;

    let summaryFreq = document.getElementById('summaryFrequency');
    if (summaryFreq) summaryFreq.innerText = document.querySelector('#frequenciesSelection .subscription-option.selected strong')?.innerText || '-';

    let dtStr = '-';
    if (state.days.length > 0) {
        dtStr = state.days.join(', ');
    }
    if (state.time) {
        dtStr += (dtStr !== '-' ? ' at ' : '') + state.time;
    }
    
    let summaryDT = document.getElementById('summaryDateTime');
    if (summaryDT) summaryDT.innerText = dtStr;

    let subtotal = 0;
    let discount = 0;

    // Dynamically update Frequency cards
    let currentDuration = parseInt(state.hours);
    document.querySelectorAll('#frequenciesSelection .subscription-option').forEach(el => {
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
                if(r.package_id == state.packageId && r.duration_id == currentDuration && r.frequency_id == fId) {
                    freqPkgObj = r;
                }
            });
        }
        
        if (freqPkgObj) {
            let hourlyRate = parseFloat(freqPkgObj.price_per_hour);
            
            if (fPriceHr) fPriceHr.innerText = 'AED ' + hourlyRate.toFixed(2);
            
            if (freqPkgObj.discount_percentage && freqPkgObj.discount_percentage > 0) {
                if (fBadge) fBadge.style.display = 'inline-block';
                if (fDiscountVal) fDiscountVal.innerText = freqPkgObj.discount_percentage;
            } else {
                if (fBadge) fBadge.style.display = 'none';
            }
        } else {
             if (fPriceHr) fPriceHr.innerText = 'AED 0.00';
             if (fBadge) fBadge.style.display = 'none';
        }
    });

    let pkgObj = null;
    if (typeof pricingRules !== 'undefined') {
        pricingRules.forEach(r => {
            if(r.package_id == state.packageId && r.duration_id == currentDuration && r.frequency_id == state.frequencyId) {
                pkgObj = r;
            }
        });
    }

    if (pkgObj) {
        subtotal = parseFloat(pkgObj.price_per_hour) * currentDuration * state.visits * 4;
        if (pkgObj.discount_percentage) {
            discount = (pkgObj.discount_percentage / 100) * subtotal;
        }
    }

    let addonsHtml = '';
    if (typeof hasAddons !== 'undefined' && hasAddons && selectedAddons.length > 0) {
        selectedAddons.forEach(a => {
            subtotal += a.price * a.qty;
            addonsHtml += `
            <div class="d-flex justify-content-between subheadingdev">
                <div style="color: #6c757d;">${a.name} x ${a.qty}</div>
                <div class="font-weight-bold sm-summary price-wrapper" style="color: #6c757d;">
                    <span class="currency_dhiramnew" style="background-color: #6c757d;">AED</span>
                    <span>${(a.price * a.qty).toFixed(2)}</span>
                </div>
            </div>`;
        });
    }
    
    let cartItemList = document.getElementById('cart_item_list');
    if (cartItemList) cartItemList.innerHTML = addonsHtml;

    let total = subtotal - discount;
    let sumSubtotal = document.getElementById('summarySubtotal');
    if (sumSubtotal) sumSubtotal.innerText = subtotal.toFixed(2);
    
    let sumDiscount = document.getElementById('summaryDiscount');
    if (sumDiscount) sumDiscount.innerText = discount > 0 ? discount.toFixed(2) : '0.00';
    
    let sumTotal = document.getElementById('summaryTotalBtnVal');
    if (sumTotal) sumTotal.innerText = total.toFixed(2);
}

function submitForm() {
    alert("Booking Completed!");
}

document.addEventListener('DOMContentLoaded', init);
