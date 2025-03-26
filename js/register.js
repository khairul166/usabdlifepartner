
function updateAddressFields() {
    const country = document.getElementById('country').value;
    const bangladeshFields = document.getElementById('bangladeshFields');
    const usaFields = document.getElementById('usaFields');

    if (country === 'Bangladesh') {
        bangladeshFields.style.display = 'block';
        usaFields.style.display = 'none';
    } else if (country === 'USA') {
        bangladeshFields.style.display = 'none';
        usaFields.style.display = 'block';
    } else {
        bangladeshFields.style.display = 'none';
        usaFields.style.display = 'none';
    }
}

function updateDistricts() {
    const division = document.getElementById('division').value;
    const districtSelect = document.getElementById('district');
    districtSelect.innerHTML = '<option value="">Select District</option>';

    if (division === 'Dhaka') {
        districtSelect.innerHTML += '<option value="Dhaka">Dhaka</option>';
        districtSelect.innerHTML += '<option value="Gazipur">Gazipur</option>';
    } else if (division === 'Chittagong') {
        districtSelect.innerHTML += '<option value="Chittagong">Chittagong</option>';
        districtSelect.innerHTML += '<option value="Cox\'s Bazar">Cox\'s Bazar</option>';
    }
}

function updateUpazila() {
    const district = document.getElementById('district').value;
    const upazilaSelect = document.getElementById('upazila');
    upazilaSelect.innerHTML = '<option value="">Select Upazila/City</option>';

    if (district === 'Dhaka') {
        upazilaSelect.innerHTML += '<option value="Gulshan">Gulshan</option>';
        upazilaSelect.innerHTML += '<option value="Banani">Banani</option>';
    } else if (district === 'Chittagong') {
        upazilaSelect.innerHTML += '<option value="Chandgaon">Chandgaon</option>';
        upazilaSelect.innerHTML += '<option value="Pahartali">Pahartali</option>';
    }
}

function updateVillage() {
    const upazila = document.getElementById('upazila').value;
    const villageSelect = document.getElementById('village');
    villageSelect.innerHTML = '<option value="">Select Village/Area</option>';

    if (upazila === 'Gulshan') {
        villageSelect.innerHTML += '<option value="Gulshan 1">Gulshan 1</option>';
        villageSelect.innerHTML += '<option value="Gulshan 2">Gulshan 2</option>';
    } else if (upazila === 'Banani') {
        villageSelect.innerHTML += '<option value="Banani 1">Banani 1</option>';
        villageSelect.innerHTML += '<option value="Banani 2">Banani 2</option>';
    }
}

function updateCities() {
    const state = document.getElementById('state').value;
    const citySelect = document.getElementById('city');
    citySelect.innerHTML = '<option value="">Select City</option>';

    if (state === 'California') {
        citySelect.innerHTML += '<option value="Los Angeles">Los Angeles</option>';
        citySelect.innerHTML += '<option value="San Francisco">San Francisco</option>';
    } else if (state === 'New York') {
        citySelect.innerHTML += '<option value="New York City">New York City</option>';
        citySelect.innerHTML += '<option value="Buffalo">Buffalo</option>';
    }
}
