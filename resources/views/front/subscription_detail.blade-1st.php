@include('front.includes.header')

<style>
    .mar-btn {
        margin-bottom: 60px;
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .sidebar-left {
            display: none !important;
        }
    }

    .detail-card {
        background: #fff;
        border: 1px solid #eaeaea;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .detail-header {
        padding: 25px;
        background-color: #fafbfc;
        border-bottom: 1px solid #f5f5f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-title {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 5px 0;
    }

    .detail-subtitle {
        font-size: 15px;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    .status-badge {
        font-size: 13px;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 30px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .status-active {
        background-color: #ecfdf5;
        color: #059669;
        border: 1px solid #d1fae5;
    }

    .status-pending {
        background-color: #fffbeb;
        color: #d97706;
        border: 1px solid #fef3c7;
    }

    .status-cancelled {
        background-color: #fef2f2;
        color: #dc2626;
        border: 1px solid #fee2e2;
    }

    .status-expired {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .highlight-blocks {
        display: flex;
        gap: 20px;
        padding: 25px;
        border-bottom: 1px solid #f5f5f5;
    }

    .highlight-block {
        flex: 1;
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 20px;
        border-left: 4px solid #0040E6;
    }

    .highlight-block.secondary {
        border-left-color: #10b981;
    }

    .highlight-label {
        font-size: 13px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .highlight-value {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }

    .detail-body {
        padding: 25px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 20px;
    }

    .summary-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eaeaea;
    }

    .summary-table th,
    .summary-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #eaeaea;
        text-align: left;
    }

    .summary-table tr:last-child th,
    .summary-table tr:last-child td {
        border-bottom: none;
    }

    .summary-table th {
        background-color: #fafbfc;
        font-weight: 600;
        color: #475569;
        width: 40%;
        border-right: 1px solid #eaeaea;
    }

    .summary-table td {
        font-weight: 500;
        color: #1e293b;
    }

    /* Tabs Styles */
    .visits-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 1px solid #eaeaea;
    }

    .visit-tab {
        padding: 10px 20px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
    }

    .visit-tab.active {
        color: #0040E6;
        border-bottom-color: #0040E6;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .visit-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .visit-item {
        border: 1px solid #eaeaea;
        border-radius: 8px;
        padding: 20px;
        background: #fff;
    }

    .visit-item-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #eaeaea;
    }

    .visit-number {
        font-weight: 700;
        color: #0040E6;
        font-size: 15px;
    }

    .visit-status {
        font-size: 13px;
        font-weight: 600;
        color: #10b981;
    }

    .visit-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .v-detail-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .v-detail-value {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
    }

    .visit-actions {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 15px;
    }

    .visit-btn {
        color: #0040E6;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
    }

    .visit-btn:hover {
        text-decoration: underline;
    }

    /* Modals */
    .vc-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .vc-modal-overlay.active {
        display: flex;
    }

    .vc-modal {
        background: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 500px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    .vc-modal h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .vc-modal-close {
        float: right;
        cursor: pointer;
        font-size: 20px;
        color: #999;
    }

    .vc-btn-primary {
        background: #0040E6;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        display: block;
        text-align: center;
    }

    .vc-btn-primary:hover {
        background: #0030b3;
        text-decoration: none;
        color: #fff;
    }

    .vc-btn-outline {
        background: transparent;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
    }

    /* Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #059669;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .rating-stars {
        color: #f59e0b;
        font-size: 18px;
    }

    /* Manage Dropdown */
    .vc-dropdown {
        position: relative;
        display: inline-block;
    }

    .vc-dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        min-width: 240px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        border: 1px solid #eaeaea;
        z-index: 1000;
        overflow: hidden;
    }

    .vc-dropdown-content a {
        color: #1e293b;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
        font-weight: 500;
        border-bottom: 1px solid #f8fafc;
        cursor: pointer;
    }

    .vc-dropdown-content a:hover {
        background-color: #f8fafc;
        color: #0040E6;
    }

    .vc-dropdown-content a:last-child {
        border-bottom: none;
        color: #dc2626;
    }

    .vc-dropdown.active .vc-dropdown-content {
        display: block;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 8px 12px;
        width: 100%;
        font-family: inherit;
    }
</style>

<div class="body_content">
    <section class="our-login mt120">
        <div class="container mar-btn">
            <div class="row">
                <div class="col-lg-4 sidebar-left">
                    @include('front.account_sidebar')
                </div>

                <div class="col-lg-8">
                    <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <a href="{{ route('front.subscriptions') }}" style="color: #64748b; font-weight: 600; text-decoration: none;"><i class="fas fa-arrow-left"></i> Back to Subscriptions</a>

                        <div class="vc-dropdown" id="manageDropdown">
                            <button class="vc-btn-outline" onclick="toggleDropdown()" style="width:auto; display:flex; align-items:center; gap:8px;">
                                Manage Subscription <i class="fas fa-chevron-down" style="font-size:10px;"></i>
                            </button>
                            <div class="vc-dropdown-content">
                                <a onclick="openModal('pauseModal'); toggleDropdown();">Pause Subscription</a>
                                <a onclick="openModal('cleanerModal'); toggleDropdown();">Cleaner Preferences</a>
                                <a onclick="openModal('planModal'); toggleDropdown();">Change Plan</a>
                                <a onclick="openModal('scheduleModal'); toggleDropdown();">Edit Regular Schedule</a>
                                <a onclick="openModal('cancelModal'); toggleDropdown();">Cancel Subscription</a>
                            </div>
                        </div>
                    </div>

                    @if($subscription->cleaner_unavailable && count($subscription->upcoming_visits) > 0)
                    <div style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; padding: 15px 20px; margin-bottom: 20px; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <strong style="color: #d97706; display:block; margin-bottom:4px;">Action Required</strong>
                            <span style="color: #b45309; font-size:14px;">{{ $subscription->preferred_cleaner }} isn't available for your cleaning on {{ $subscription->upcoming_visits[0]->date }}.</span>
                        </div>
                        <div style="display:flex; gap:10px;">
                            <button class="vc-btn-outline" style="background:#fff; border-color:#fcd34d; color:#b45309; padding:6px 12px; font-size:13px; width:auto;" onclick="alert('Time kept. Another cleaner will be assigned.')">Keep my time</button>
                            <button class="vc-btn-primary" style="background:#d97706; padding:6px 12px; font-size:13px; width:auto;" onclick="alert('Proceed to choose another time slot for Sarah.')">Keep {{ $subscription->preferred_cleaner }}</button>
                        </div>
                    </div>
                    @endif

                    <div class="detail-card">
                        <div class="detail-header">
                            <div>
                                <h2 class="detail-title">{{ $subscription->category }} Subscription</h2>
                                <p class="detail-subtitle">{{ $subscription->plan_name }}</p>
                            </div>
                            <div>
                                <span id="main-status-badge" class="status-badge status-active">Active</span>
                                <div id="main-status-subtitle" style="font-size:11px; color:#64748b; margin-top:4px; text-align:right; display:none;">Ends after current cycle</div>
                            </div>
                        </div>

                        <div class="highlight-blocks">
                            <div class="highlight-block">
                                <div class="highlight-label">Next Visit</div>
                                <div class="highlight-value" id="highlight-next-visit">{{ $subscription->next_visit_date }}, {{ $subscription->next_visit_time }}</div>
                            </div>
                            <div class="highlight-block secondary">
                                <div class="highlight-label">Visits Remaining</div>
                                <div class="highlight-value">{{ $subscription->visits_per_cycle - $subscription->visits_completed }} of {{ $subscription->visits_per_cycle }}</div>
                            </div>
                        </div>

                        <div class="detail-body">
                            <h3 class="section-title">Quick Summary</h3>
                            <table class="summary-table">
                                <tbody>
                                    <tr>
                                        <th>Service Address</th>
                                        <td>
                                            {{ $subscription->service_address }}
                                            <a href="#" onclick="alert('Checking vendor coverage and availability at new address...')" style="display:block; font-size:12px; font-weight:600; color:#0040E6; margin-top:4px; text-decoration:none;">Change Address</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Regular Schedule</th>
                                        <td>{{ $subscription->recurring_schedule }}</td>
                                    </tr>
                                    <tr>
                                        <th>Visits</th>
                                        <td>{{ $subscription->visits_per_cycle }} per cycle (Completed: {{ $subscription->visits_completed }})</td>
                                    </tr>
                                    <tr>
                                        <th>Next Renewal</th>
                                        <td id="summary-next-renewal">{{ $subscription->next_renewal }}</td>
                                    </tr>
                                    <tr>
                                        <th>Renewal Amount</th>
                                        <td>{{ $subscription->renewal_amount }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment</th>
                                        <td>{{ $subscription->payment_method }}</td>
                                    </tr>
                                    <tr>
                                        <th>Auto-Renew</th>
                                        <td>
                                            <span id="auto-renew-label" style="color: #059669; font-weight: 700;">ON</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabs Section -->
                    <div class="visits-section" id="upcoming">
                        <div class="visits-tabs">
                            <div class="visit-tab active" onclick="switchTab('upcoming')">Upcoming Visits</div>
                            <div class="visit-tab" onclick="switchTab('history')">Visit History</div>
                            <div class="visit-tab" onclick="switchTab('billing')">Billing & Renewal</div>
                        </div>

                        <!-- Upcoming Visits Tab -->
                        <div id="tab-upcoming" class="tab-content active">
                            @if(count($subscription->upcoming_visits) > 0)
                            <div class="visit-list">
                                @foreach($subscription->upcoming_visits as $visit)
                                <div class="visit-item" id="visit-row-{{ $visit->visit_number }}">
                                    <div class="visit-item-header">
                                        <div class="visit-number">Visit {{ $visit->visit_number }} of {{ $visit->total_visits }}</div>
                                    </div>
                                    <div class="visit-details">
                                        <div>
                                            <div class="v-detail-label">Date & Time</div>
                                            <div class="v-detail-value visit-datetime">{{ $visit->date }}<br>{{ $visit->time }}</div>
                                        </div>
                                        <div>
                                            <div class="v-detail-label">Service Details</div>
                                            <div class="v-detail-value">Cleaner: {{ $visit->cleaner }}<br>Duration: {{ $visit->duration }}</div>
                                        </div>
                                    </div>
                                    <div class="visit-actions">
                                        <button class="visit-btn" onclick="openRescheduleModal({{ $visit->visit_number }}, '{{ $visit->date }}')">Reschedule</button>
                                        <span style="color: #cbd5e1;">|</span>
                                        <button class="visit-btn" onclick="openSkipModal({{ $visit->visit_number }}, '{{ $visit->date }}')">Skip</button>
                                        <span style="color: #cbd5e1;">|</span>
                                        <button class="visit-btn">View Details</button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="alert alert-info" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #475569;">
                                No upcoming visits scheduled.
                            </div>
                            @endif
                        </div>

                        <!-- Past Visits Tab -->
                        <div id="tab-history" class="tab-content">
                            @if(count($subscription->past_visits) > 0)
                            <div class="visit-list">
                                @foreach($subscription->past_visits as $visit)
                                <div class="visit-item">
                                    <div class="visit-item-header">
                                        <div class="visit-number">{{ $visit->date }}</div>
                                        <div class="visit-status">{{ $visit->status }}</div>
                                    </div>
                                    <div class="visit-details">
                                        <div>
                                            <div class="v-detail-label">Time & Duration</div>
                                            <div class="v-detail-value">{{ $visit->time }} ({{ $visit->duration }})</div>
                                        </div>
                                        <div>
                                            <div class="v-detail-label">Cleaner</div>
                                            <div class="v-detail-value">{{ $visit->cleaner }}</div>
                                        </div>
                                        <div>
                                            <div class="v-detail-label">Booking ID</div>
                                            <div class="v-detail-value">{{ $visit->booking_id }}</div>
                                        </div>
                                        <div>
                                            <div class="v-detail-label">Rating</div>
                                            <div class="v-detail-value">
                                                @if(isset($visit->rating) && $visit->rating > 0)
                                                <span class="rating-stars">
                                                    @for($i = 0; $i < $visit->rating; $i++)★@endfor
                                                </span>
                                                @else
                                                <a href="#" style="color: #0040E6; text-decoration: underline;">Rate Your Cleaning</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="visit-actions">
                                        <a class="visit-btn">Invoice/Receipt</a>
                                        <span style="color: #cbd5e1;">|</span>
                                        <a class="visit-btn">Support/Report Issue</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="alert alert-info" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #475569;">
                                No past visits found.
                            </div>
                            @endif
                        </div>

                        <!-- Billing & Renewal Tab -->
                        <div id="tab-billing" class="tab-content">
                            <div class="visit-item">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <h4 style="margin:0 0 5px 0; font-weight:700;">Auto-Renewal</h4>
                                        <p id="renewal-text" style="color:#64748b; margin:0; font-size:14px;">Your subscription will automatically renew for {{ $subscription->renewal_amount }} on {{ $subscription->next_renewal }}.</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" id="autoRenewToggle" checked onchange="toggleAutoRenew(this)">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div id="renewal-warning" style="display:none; margin-top:15px; padding:15px; background:#fef2f2; border:1px solid #fee2e2; border-radius:8px; color:#dc2626; font-size:13px; font-weight:500;">
                                    Your remaining visits will not be affected. Your subscription will end after your current cycle and will not renew.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modals -->

<!-- 1. Pause Modal -->
<div class="vc-modal-overlay" id="pauseModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('pauseModal')">&times;</span>
        <h3>Pause Subscription</h3>
        <p style="font-size:14px; color:#64748b; margin-bottom:20px;">Temporarily suspend your visits without cancelling your subscription.</p>

        <div class="form-group">
            <label>Pause for:</label>
            <select class="form-control" id="pause-duration" onchange="updatePauseImpact()">
                <option value="1">1 week</option>
                <option value="2">2 weeks</option>
                <option value="3">3 weeks</option>
                <option value="custom">Custom dates</option>
            </select>
        </div>

        <div id="pause-impact" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:15px; font-size:13px; color:#475569; margin-bottom:20px;">
            Your subscription will be paused from <strong>15 September - 22 September</strong>.<br><br>
            Your unused visit will be carried forward and your next renewal date will move from <strong>29 September &rarr; 6 October</strong>.<br><br>
            You will not lose any included visits.
        </div>

        <button class="vc-btn-primary" onclick="confirmModalAction('pauseModal', 'Subscription Paused ✓', () => {
            document.getElementById('main-status-badge').innerText = 'Paused';
            document.getElementById('main-status-badge').className = 'status-badge status-pending';
        })">Confirm Pause</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 2. Cleaner Preferences Modal -->
<div class="vc-modal-overlay" id="cleanerModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('cleanerModal')">&times;</span>
        <h3>Request Different Cleaner</h3>
        <div style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #eaeaea;">
            <div>
                <div style="font-size:12px; color:#64748b; text-transform:uppercase; font-weight:600;">Your Preferred Cleaner</div>
                <div style="font-size:18px; font-weight:700; color:#1e293b;">{{ $subscription->preferred_cleaner }}</div>
            </div>
            @if($subscription->cleaner_rating)
            <div style="font-weight:600; color:#1e293b;"><span style="color:#f59e0b;">★</span> {{ $subscription->cleaner_rating }}</div>
            @endif
        </div>

        <div class="form-group">
            <label>Why would you like to change?</label>
            <select class="form-control">
                <option>Cleaner unavailable</option>
                <option>Quality of service</option>
                <option>Communication</option>
                <option>Timing/reliability</option>
                <option>Prefer another cleaner</option>
                <option>Other</option>
            </select>
        </div>

        <div class="form-group" style="margin-bottom:25px;">
            <label style="margin-bottom:10px;">Would you like the new cleaner for:</label>
            <label style="display:block; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cleaner_scope" checked> Next visit only</label>
            <label style="display:block; cursor:pointer;"><input type="radio" name="cleaner_scope"> All future visits</label>
        </div>

        <button class="vc-btn-primary" onclick="confirmModalAction('cleanerModal', 'Cleaner Request Sent ✓')">Confirm Request</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 3. Change Plan Modal -->
<div class="vc-modal-overlay" id="planModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('planModal')">&times;</span>
        <h3>Change Plan</h3>
        <p style="font-size:14px; color:#64748b; margin-bottom:20px;">Your new plan will begin on your next renewal date.</p>

        <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:20px;">
            <label style="border:1px solid #0040E6; background:#f8fafc; border-radius:8px; padding:15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:700; color:#1e293b; font-size:16px;">1× Weekly <span style="font-size:12px; font-weight:normal; background:#0040E6; color:#fff; padding:2px 6px; border-radius:4px; margin-left:5px;">Current</span></div>
                    <div style="font-size:13px; color:#64748b;">4 visits/cycle</div>
                </div>
                <input type="radio" name="plan" checked>
            </label>
            <label style="border:1px solid #eaeaea; border-radius:8px; padding:15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:700; color:#1e293b; font-size:16px;">2× Weekly</div>
                    <div style="font-size:13px; color:#64748b;">8 visits/cycle</div>
                </div>
                <input type="radio" name="plan">
            </label>
            <label style="border:1px solid #eaeaea; border-radius:8px; padding:15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:700; color:#1e293b; font-size:16px;">3× Weekly</div>
                    <div style="font-size:13px; color:#64748b;">12 visits/cycle</div>
                </div>
                <input type="radio" name="plan">
            </label>
        </div>

        <button class="vc-btn-primary" onclick="confirmModalAction('planModal', 'Plan Change Scheduled ✓')">Confirm Change</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 4. Edit Schedule Modal -->
<div class="vc-modal-overlay" id="scheduleModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('scheduleModal')">&times;</span>
        <h3>Edit Regular Schedule</h3>
        <div style="font-size:14px; color:#475569; margin-bottom:20px;">Current Schedule: <strong>{{ $subscription->recurring_schedule }}</strong></div>

        <div class="form-group">
            <label>New Day of Week</label>
            <select class="form-control">
                <option>Monday</option>
                <option>Tuesday</option>
                <option>Wednesday</option>
                <option selected>Thursday</option>
                <option>Friday</option>
                <option>Saturday</option>
                <option>Sunday</option>
            </select>
        </div>
        <div class="form-group">
            <label>New Time</label>
            <select class="form-control">
                <option>08:00 AM</option>
                <option>10:00 AM</option>
                <option selected>02:00 PM</option>
                <option>04:00 PM</option>
            </select>
        </div>

        <div class="form-group" style="margin-bottom:25px; margin-top:20px;">
            <label style="margin-bottom:10px;">Apply to:</label>
            <label style="display:block; margin-bottom:8px; cursor:pointer;"><input type="radio" name="sched_scope"> Next visit only</label>
            <label style="display:block; cursor:pointer;"><input type="radio" name="sched_scope" checked> All future visits</label>
        </div>

        <button class="vc-btn-primary" onclick="confirmModalAction('scheduleModal', 'Schedule Updated ✓')">Update Schedule</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<!-- 5. Smart Cancellation Modal -->
<div class="vc-modal-overlay" id="cancelModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('cancelModal')">&times;</span>

        <!-- Step 1 -->
        <div id="cancel-step-1">
            <h3>Cancel Subscription</h3>
            <p style="font-size:14px; color:#64748b; margin-bottom:20px;">We're sorry to see you go. Why are you cancelling?</p>

            <div class="form-group" style="margin-bottom:25px;">
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="expensive"> Too expensive</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="holiday"> Going away</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="noneed"> Don't need cleaning right now</label>
                <label style="display:block; padding:10px; border:1px solid #eaeaea; border-radius:6px; margin-bottom:8px; cursor:pointer;"><input type="radio" name="cancel_reason" value="other"> Other</label>
            </div>

            <button class="vc-btn-primary" onclick="processCancellationStep2()">Continue</button>
        </div>

        <!-- Step 2 Smart Retention -->
        <div id="cancel-step-2" style="display:none;">
            <h3>Wait! Before you cancel...</h3>
            <div id="retention-content" style="background:#f8fafc; padding:20px; border-radius:8px; margin-bottom:20px; text-align:center;">
                <!-- Filled via JS -->
            </div>
            <button class="vc-btn-primary" id="retention-btn" onclick="closeModal('cancelModal')" style="margin-bottom:10px;">Smart Action</button>
            <button class="vc-btn-outline" style="border:none; color:#94a3b8;" onclick="showCancellationFinal()">No thanks, continue to cancel</button>
        </div>

        <!-- Step 3 Final Confirmation -->
        <div id="cancel-step-3" style="display:none;">
            <h3>Confirm Cancellation</h3>
            <div style="font-size:14px; color:#1e293b; background:#fef2f2; border:1px solid #fee2e2; padding:15px; border-radius:8px; margin-bottom:20px;">
                <ul style="margin:0; padding-left:20px;">
                    <li style="margin-bottom:5px;">Your last usable date will be <strong>{{ $subscription->next_renewal }}</strong>.</li>
                    <li style="margin-bottom:5px;">You have <strong>{{ $subscription->visits_per_cycle - $subscription->visits_completed }} remaining visits</strong> in this cycle.</li>
                    <li style="margin-bottom:5px;">Your upcoming appointments will remain scheduled.</li>
                    <li>Auto-renewal will be turned off immediately. No refunds for unused visits.</li>
                </ul>
            </div>

            <button class="vc-btn-primary" style="background:#dc2626;" onclick="confirmModalAction('cancelModal', 'Subscription Cancelled', () => {
                document.getElementById('main-status-badge').innerText = 'Cancelled';
                document.getElementById('main-status-badge').className = 'status-badge status-cancelled';
                document.getElementById('autoRenewToggle').checked = false;
                toggleAutoRenew(document.getElementById('autoRenewToggle'));
            })">Confirm Cancellation</button>
            <div class="success-msg" style="display:none; color:#dc2626; font-weight:700; text-align:center; margin-top:15px;"></div>
        </div>

    </div>
</div>

<!-- Reschedule & Skip Modals -->
<div class="vc-modal-overlay" id="rescheduleModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('rescheduleModal')">&times;</span>
        <h3>Reschedule Visit</h3>
        <p style="font-size:14px; color:#64748b;">You are rescheduling your visit on <strong id="rs-date"></strong>.</p>
        <div style="background:#f8fafc; border-left:3px solid #0040E6; padding:10px 15px; font-size:12px; color:#475569; margin-bottom:20px;">
            <strong>Rescheduling Policy:</strong> Free rescheduling is available until 24 hours before your appointment. Late rescheduling may result in the visit being counted or a fee being charged.
        </div>
        <div class="form-group"><label>New Date</label><input type="date" class="form-control"></div>
        <button class="vc-btn-primary" onclick="confirmModalAction('rescheduleModal', 'Visit Rescheduled ✓')">Confirm</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<div class="vc-modal-overlay" id="skipModal">
    <div class="vc-modal">
        <span class="vc-modal-close" onclick="closeModal('skipModal')">&times;</span>
        <h3>Skip Visit</h3>
        <div style="margin-bottom:20px;">
            <label style="display:flex; align-items:flex-start; gap:10px; margin-bottom:15px; cursor:pointer;">
                <input type="radio" name="skipOption" checked style="margin-top:4px;">
                <div>
                    <div style="font-weight:600; color:#1e293b;">Move to end of subscription</div>
                    <div style="font-size:12px; color:#64748b;">Your renewal date will move forward.</div>
                </div>
            </label>
        </div>
        <button class="vc-btn-primary" onclick="confirmModalAction('skipModal', 'Visit Skipped ✓')">Confirm Skip</button>
        <div class="success-msg" style="display:none; color:#059669; font-weight:700; text-align:center; margin-top:15px;"></div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.visit-tab').forEach(tab => tab.classList.remove('active'));
        event.target.classList.add('active');
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        document.getElementById('tab-' + tabId).classList.add('active');
    }

    function toggleAutoRenew(el) {
        if (el.checked) {
            document.getElementById('renewal-warning').style.display = 'none';
            document.getElementById('renewal-text').innerHTML = 'Your subscription will automatically renew for {{ $subscription->renewal_amount }} on {{ $subscription->next_renewal }}.';
            document.getElementById('auto-renew-label').innerHTML = 'ON';
            document.getElementById('auto-renew-label').style.color = '#059669';
            document.getElementById('main-status-subtitle').style.display = 'none';
        } else {
            document.getElementById('renewal-warning').style.display = 'block';
            document.getElementById('renewal-text').innerHTML = 'Auto-renewal is currently disabled.';
            document.getElementById('auto-renew-label').innerHTML = 'OFF';
            document.getElementById('auto-renew-label').style.color = '#64748b';
            document.getElementById('main-status-subtitle').style.display = 'block';
        }
    }

    function toggleDropdown() {
        document.getElementById("manageDropdown").classList.toggle("active");
    }

    // Close dropdown if clicked outside
    window.onclick = function(event) {
        if (!event.target.matches('.vc-btn-outline') && !event.target.matches('.fa-chevron-down')) {
            var dropdowns = document.getElementsByClassName("vc-dropdown");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('active')) {
                    openDropdown.classList.remove('active');
                }
            }
        }
    }

    function openModal(id) {
        document.getElementById(id).classList.add('active');
        // Reset cancel flow
        if (id === 'cancelModal') {
            document.getElementById('cancel-step-1').style.display = 'block';
            document.getElementById('cancel-step-2').style.display = 'none';
            document.getElementById('cancel-step-3').style.display = 'none';
        }
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        let msg = document.getElementById(id).querySelector('.success-msg');
        if (msg) msg.style.display = 'none';
    }

    function confirmModalAction(id, msgText, callback) {
        let msg = document.getElementById(id).querySelector('.success-msg');
        if (msg) {
            msg.innerText = msgText;
            msg.style.display = 'block';
        }
        if (callback) callback();
        setTimeout(() => closeModal(id), 1200);
    }

    // Cancellation Flow
    function processCancellationStep2() {
        let reason = document.querySelector('input[name="cancel_reason"]:checked');
        if (!reason) {
            alert("Please select a reason.");
            return;
        }

        document.getElementById('cancel-step-1').style.display = 'none';

        let retention = document.getElementById('retention-content');
        let btn = document.getElementById('retention-btn');

        if (reason.value === 'holiday') {
            retention.innerHTML = "<h4>Going on holiday?</h4><p>You can pause your subscription instead and keep your remaining visits.</p>";
            btn.innerText = "Pause Instead";
            btn.onclick = () => {
                closeModal('cancelModal');
                openModal('pauseModal');
            };
            document.getElementById('cancel-step-2').style.display = 'block';
        } else if (reason.value === 'expensive') {
            retention.innerHTML = "<h4>Looking to save money?</h4><p>Switch to a lower-frequency plan instead of cancelling.</p>";
            btn.innerText = "Change Plan";
            btn.onclick = () => {
                closeModal('cancelModal');
                openModal('planModal');
            };
            document.getElementById('cancel-step-2').style.display = 'block';
        } else {
            // Bypass retention
            showCancellationFinal();
        }
    }

    function showCancellationFinal() {
        document.getElementById('cancel-step-2').style.display = 'none';
        document.getElementById('cancel-step-3').style.display = 'block';
    }

    function openRescheduleModal(id, date) {
        document.getElementById('rs-date').innerText = date;
        openModal('rescheduleModal');
    }

    function openSkipModal(id, date) {
        openModal('skipModal');
    }

    function updatePauseImpact() {
        /* Logic retained */
    }
</script>

@include('front.includes.footer')