<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('project/css/map.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('project/css/bootstrap.min.css')}}">

</head>
<body>
  
  <div class="count">
    <strong>STORE LOCATOR</strong>
    <label for=""></label>
<select id="country" name="country">
  <option value="">Nigeria</option>
  <option value="AF">Afghanistan</option>
  <option value="AL">Albania</option>
  <option value="DZ">Algeria</option>
  <option value="AD">Andorra</option>
  <option value="AO">Angola</option>
  <option value="AG">Antigua and Barbuda</option>
  <option value="AR">Argentina</option>
  <option value="AM">Armenia</option>
  <option value="AU">Australia</option>
  <option value="AT">Austria</option>
  <option value="AZ">Azerbaijan</option>
  <option value="BS">Bahamas</option>
  <option value="BH">Bahrain</option>
  <option value="BD">Bangladesh</option>
  <option value="BB">Barbados</option>
  <option value="BY">Belarus</option>
  <option value="BE">Belgium</option>
  <option value="BZ">Belize</option>
  <option value="BJ">Benin</option>
  <option value="BT">Bhutan</option>
  <option value="BO">Bolivia</option>
  <option value="BA">Bosnia and Herzegovina</option>
  <option value="BW">Botswana</option>
  <option value="BR">Brazil</option>
  <option value="BN">Brunei</option>
  <option value="BG">Bulgaria</option>
  <option value="BF">Burkina Faso</option>
  <option value="BI">Burundi</option>
  <option value="CV">Cabo Verde</option>
  <option value="KH">Cambodia</option>
  <option value="CM">Cameroon</option>
  <option value="CA">Canada</option>
  <option value="CF">Central African Republic</option>
  <option value="TD">Chad</option>
  <option value="CL">Chile</option>
  <option value="CN">China</option>
  <option value="CO">Colombia</option>
  <option value="KM">Comoros</option>
  <option value="CD">Congo (Democratic Republic)</option>
  <option value="CG">Congo (Republic)</option>
  <option value="CR">Costa Rica</option>
  <option value="CI">Côte d’Ivoire</option>
  <option value="HR">Croatia</option>
  <option value="CU">Cuba</option>
  <option value="CY">Cyprus</option>
  <option value="CZ">Czech Republic</option>
  <option value="DK">Denmark</option>
  <option value="DJ">Djibouti</option>
  <option value="DM">Dominica</option>
  <option value="DO">Dominican Republic</option>
  <option value="EC">Ecuador</option>
  <option value="EG">Egypt</option>
  <option value="SV">El Salvador</option>
  <option value="GQ">Equatorial Guinea</option>
  <option value="ER">Eritrea</option>
  <option value="EE">Estonia</option>
  <option value="SZ">Eswatini</option>
  <option value="ET">Ethiopia</option>
  <option value="FJ">Fiji</option>
  <option value="FI">Finland</option>
  <option value="FR">France</option>
  <option value="GA">Gabon</option>
  <option value="GM">Gambia</option>
  <option value="GE">Georgia</option>
  <option value="DE">Germany</option>
  <option value="GH">Ghana</option>
  <option value="GR">Greece</option>
  <option value="GD">Grenada</option>
  <option value="GT">Guatemala</option>
  <option value="GN">Guinea</option>
  <option value="GW">Guinea-Bissau</option>
  <option value="GY">Guyana</option>
  <option value="HT">Haiti</option>
  <option value="HN">Honduras</option>
  <option value="HU">Hungary</option>
  <option value="IS">Iceland</option>
  <option value="IN">India</option>
  <option value="ID">Indonesia</option>
  <option value="IR">Iran</option>
  <option value="IQ">Iraq</option>
  <option value="IE">Ireland</option>
  <option value="IL">Israel</option>
  <option value="IT">Italy</option>
  <option value="JM">Jamaica</option>
  <option value="JP">Japan</option>
  <option value="JO">Jordan</option>
  <option value="KZ">Kazakhstan</option>
  <option value="KE">Kenya</option>
  <option value="KI">Kiribati</option>
  <option value="KW">Kuwait</option>
  <option value="KG">Kyrgyzstan</option>
  <option value="LA">Laos</option>
  <option value="LV">Latvia</option>
  <option value="LB">Lebanon</option>
  <option value="LS">Lesotho</option>
  <option value="LR">Liberia</option>
  <option value="LY">Libya</option>
  <option value="LI">Liechtenstein</option>
  <option value="LT">Lithuania</option>
  <option value="LU">Luxembourg</option>
  <option value="MG">Madagascar</option>
  <option value="MW">Malawi</option>
  <option value="MY">Malaysia</option>
  <option value="MV">Maldives</option>
  <option value="ML">Mali</option>
  <option value="MT">Malta</option>
  <option value="MH">Marshall Islands</option>
  <option value="MR">Mauritania</option>
  <option value="MU">Mauritius</option>
  <option value="MX">Mexico</option>
  <option value="FM">Micronesia</option>
  <option value="MD">Moldova</option>
  <option value="MC">Monaco</option>
  <option value="MN">Mongolia</option>
  <option value="ME">Montenegro</option>
  <option value="MA">Morocco</option>
  <option value="MZ">Mozambique</option>
  <option value="MM">Myanmar</option>
  <option value="NA">Namibia</option>
  <option value="NR">Nauru</option>
  <option value="NP">Nepal</option>
  <option value="NL">Netherlands</option>
  <option value="NZ">New Zealand</option>
  <option value="NI">Nicaragua</option>
  <option value="NE">Niger</option>
  <option value="NG">Nigeria</option>
  <option value="KP">North Korea</option>
  <option value="MK">North Macedonia</option>
  <option value="NO">Norway</option>
  <option value="OM">Oman</option>
  <option value="PK">Pakistan</option>
  <option value="PW">Palau</option>
  <option value="PS">Palestine</option>
  <option value="PA">Panama</option>
  <option value="PG">Papua New Guinea</option>
  <option value="PY">Paraguay</option>
  <option value="PE">Peru</option>
  <option value="PH">Philippines</option>
  <option value="PL">Poland</option>
  <option value="PT">Portugal</option>
  <option value="QA">Qatar</option>
  <option value="RO">Romania</option>
  <option value="RU">Russia</option>
  <option value="RW">Rwanda</option>
  <option value="KN">Saint Kitts and Nevis</option>
  <option value="LC">Saint Lucia</option>
  <option value="VC">Saint Vincent and the Grenadines</option>
  <option value="WS">Samoa</option>
  <option value="SM">San Marino</option>
  <option value="ST">Sao Tome and Principe</option>
  <option value="SA">Saudi Arabia</option>
  <option value="SN">Senegal</option>
  <option value="RS">Serbia</option>
  <option value="SC">Seychelles</option>
  <option value="SL">Sierra Leone</option>
  <option value="SG">Singapore</option>
  <option value="SK">Slovakia</option>
  <option value="SI">Slovenia</option>
  <option value="SB">Solomon Islands</option>
  <option value="SO">Somalia</option>
  <option value="ZA">South Africa</option>
  <option value="KR">South Korea</option>
  <option value="SS">South Sudan</option>
  <option value="ES">Spain</option>
  <option value="LK">Sri Lanka</option>
  <option value="SD">Sudan</option>
  <option value="SR">Suriname</option>
  <option value="SE">Sweden</option>
  <option value="CH">Switzerland</option>
  <option value="SY">Syria</option>
  <option value="TJ">Tajikistan</option>
  <option value="TZ">Tanzania</option>
  <option value="TH">Thailand</option>
  <option value="TL">Timor-Leste</option>
  <option value="TG">Togo</option>
  <option value="TO">Tonga</option>
  <option value="TT">Trinidad and Tobago</option>
  <option value="TN">Tunisia</option>
  <option value="TR">Turkey</option>
  <option value="TM">Turkmenistan</option>
  <option value="TV">Tuvalu</option>
  <option value="UG">Uganda</option>
  <option value="UA">Ukraine</option>
  <option value="AE">United Arab Emirates</option>
  <option value="GB">United Kingdom</option>
  <option value="US">United States</option>
  <option value="UY">Uruguay</option>
  <option value="UZ">Uzbekistan</option>
  <option value="VU">Vanuatu</option>
  <option value="VA">Vatican City</option>
  <option value="VE">Venezuela</option>
  <option value="VN">Vietnam</option>
  <option value="YE">Yemen</option>
  <option value="ZM">Zambia</option>
  <option value="ZW">Zimbabwe</option>

</select>
<div class="enter">
<form id="searchForm" action="javascript:void(0);">
  
<input type="text" id="locationInput" placeholder="Enter a Town, Postcode or City ">
<button type="submit"><i class="ri-search-line"></i></button>
</form>
</div>
<div class="line-text" id="line">
 OR
</div>
<div class="menter">
<button id="useLocation"><i class="ri-map-pin-range-line"></i>USE MY LOCATION</button>
</div>


  <div class="accordion" id="accordionExample">
  <form id="filterForm">
    @csrf

    <div class="accordion-item" id="acc">
      <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
          STORE SERVICES
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show">
        <div class="accordion-body" id="bb">

          <label class="per">
            <input type="checkbox" name="services[]" value="personal_styling" hidden>
            <div class="box"></div>
            <p>Personal Styling</p>
          </label>

          <label class="per">
            <input type="checkbox" name="services[]" value="click_collect" hidden>
            <div class="box"></div>
            <p>Click & Collect Pickup</p>
          </label>

          <label class="per">
            <input type="checkbox" name="services[]" value="online_return" hidden>
            <div class="box"></div>
            <p>Online Return Accepted</p>
          </label>
        </div>
      </div>
    </div>

    <div class="accordion-item" id="acc">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
          RANGE
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse">
        <div class="accordion-body">
          <label class="li">
            <input type="checkbox" name="range[]" value="limited_edition" hidden>
            <div class="box"></div>
            <p>Limited Edition</p>
          </label>

          <label class="li">
            <input type="checkbox" name="range[]" value="new_in" hidden>
            <div class="box"></div>
            <p>New In</p>
          </label>
        </div>
      </div>
    </div>
  </form>

  
</div>
<style>
  .box {
  width: 20px;
  height: 20px;
  border: 2px solid #000;
  margin-right: 10px;
  transition: 0.3s;
  cursor: pointer;
  border-radius: 4px;
}

input[type="checkbox"]:checked + .box {
  background-color: #000;
}

</style>


  
 <iframe class="floating-map" id="map"
    src="https://www.google.com/maps?q={{ urlencode('Housing Estate 33, Onitsha, Nigeria') }}&hl=en&z=15&output=embed"
    allowfullscreen
    loading="lazy">
  </iframe>  
 
   
<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('searchForm');
  const input = document.getElementById('locationInput');
  const map = document.getElementById('map');
  const useLocation = document.getElementById('useLocation');
  const country = document.getElementById('country');

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    const location = input.value.trim();
    if (location !== "") {
      map.src = `https://www.google.com/maps?q=${encodeURIComponent(location)}&output=embed`;
    }
  });

  useLocation.addEventListener('click', function () {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        map.src = `https://www.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
      }, () => alert("Unable to retrieve your location."));
    } else {
      alert("Geolocation not supported.");
    }
  });

  country.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex].text;
    if (selected) {
      map.src = `https://www.google.com/maps?q=${encodeURIComponent(selected)}&output=embed`;
    }
  });
});
</script>  


  <style>
.floating-map {
      position: fixed;
      top: 30px;
      right: 40px;
      width: 700px;
      height: 550px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
      z-index: 9999;
      transition: all 0.3s ease;
    }

    .floating-map:hover {
      transform: scale(1.05);
    }

    iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
  </style>


</body>
<script src="{{asset('project/js/bootstrap.bundle.js')}}"></script>
</html>