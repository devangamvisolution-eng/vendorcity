<div class="form-group mb-3">
    <label class="form-label fw500 dark-color " for="country">Where would you like your service?</label>
    <p style="margin-top: -10px;font-size:14px;">Save your address details.</p>
    <div class="radio-group">
        <input type="radio" id="address_type_home" name="address_type" value="home" checked>
        <label for="address_type_home" style="border-radius: 50px;">Home</label>

        <input type="radio" id="address_type_office" name="address_type" value="office">
        <label for="address_type_office" style="border-radius: 50px;">Office</label>

        <input type="radio" id="address_type_other" name="address_type" value="other">
        <label for="address_type_other" style="border-radius: 50px;">Other</label>
    </div>
    <p class="form-error-text" id="address_type_error" style="color: red; margin-top: 10px;"></p>
</div>
<div class="form-group mb-3">
    <select class="form-control" name="city" id="city">
        <option value="">Select City</option>
        <option value="Dubai" data-id="17" selected>Dubai</option>
        <option value="Abu Dhabi" data-id="20">Abu Dhabi</option>
        <option value="Sharjah" data-id="22">Sharjah</option>
        <option value="Ajman" data-id="23">Ajman</option>
        <option value="Umm Al Quwain" data-id="24">Umm Al Quwain</option>
        <option value="Ras Al Khaimah" data-id="25">Ras Al Khaimah</option>
        <option value="Fujairah" data-id="26">Fujairah</option>
    </select>
    <p class="form-error-text" id="city_error" style="color: red; margin-top: 10px;"></p>
</div>
<div class="form-group mb-3">
    <input type="text" name="area" id="area" class="form-control" placeholder="Enter Your Area">
    <p class="form-error-text" id="area_error" style="color: red; margin-top: 10px;"></p>
</div>
<div class="form-group mb-3">
    <input type="text" name="building_street_no" id="building_street_no" class="form-control" placeholder="Enter your building name and/or street">
    <p class="form-error-text" id="building_street_no_error" style="color: red; margin-top: 10px;"></p>
</div>
<div class="form-group mb-3">
    <input type="text" name="apartment_villa_no" id="apartment_villa_no" class="form-control" placeholder="Enter your apartment number & floor or villa number">
    <p class="form-error-text" id="apartment_villa_no_error" style="color: red; margin-top: 10px;"></p>
</div>

@if (isset($emiratesShow) && $emiratesShow == true)
    <div class="form-group mb-3">
        <label class="form-label fw500 dark-color">Document Type</label>
        <div class="radio-group">
            <input type="radio" id="doc_type_emirates" name="doc_type" value="emirates" checked>
            <label for="doc_type_emirates" style="border-radius: 50px;">Emirates ID</label>

            <input type="radio" id="doc_type_passport" name="doc_type" value="passport">
            <label for="doc_type_passport" style="border-radius: 50px;">Passport Number</label>
        </div>
    </div>

    <div class="form-group mb-3" id="emirates_id_container">
        <input type="text" name="emirates_id_number" id="emirates_id_number" class="form-control" placeholder="Enter Your Emirates ID Number">
        <p class="form-error-text" id="emirates_id_number_error" style="color: red; margin-top: 10px;"></p>
    </div>

    <div class="form-group mb-3" id="passport_container" style="display: none;">
        <input type="text" name="passport_number" id="passport_number" class="form-control" placeholder="Enter Your Passport Number">
        <p class="form-error-text" id="passport_number_error" style="color: red; margin-top: 10px;"></p>
    </div>
@endif
