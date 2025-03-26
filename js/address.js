// Function to update address fields based on selected country
function updateAddressFields() {
    const country = document.getElementById("country").value;
    const bangladeshFields = document.getElementById("bangladeshFields");
    const bangladeshdivision = document.getElementById("user_divison");
    const usaFields = document.getElementById("usaFields");

    if (country === "Bangladesh") {
        bangladeshFields.style.display = "block";
        usaFields.style.display = "none";

        // Populate divisions
        const divisionSelect = document.getElementById("division");
        divisionSelect.innerHTML = `<option value="">Select Division</option>`;
        Object.keys(bangladeshData.divisions).forEach(division => {
            divisionSelect.innerHTML += `<option value="${division}">${division}</option>`;
        });
        divisionSelect.disabled = false;
    } else if (country === "USA") {
        bangladeshFields.style.display = "none";
        // bangladeshdivision.style.display = "none";
        usaFields.style.display = "block";

        // Populate states
        const stateSelect = document.getElementById("state");
        stateSelect.innerHTML = `<option value="">Select State</option>`;
        Object.keys(usaData.states).forEach(state => {
            stateSelect.innerHTML += `<option value="${state}">${state}</option>`;
        });
        stateSelect.disabled = false;
    }
}

// Function to update districts based on selected division
function updateDistricts() {
    const division = document.getElementById("division").value;
    const districtSelect = document.getElementById("district");

    districtSelect.innerHTML = `<option value="">Select District</option>`;
    if (division && bangladeshData.divisions[division]) {
        bangladeshData.divisions[division].forEach(district => {
            districtSelect.innerHTML += `<option value="${district}">${district}</option>`;
        });
        districtSelect.disabled = false;
    } else {
        districtSelect.disabled = true;
    }
}

// Function to update upazilas based on selected district
function updateUpazila() {
    const district = document.getElementById("district").value;
    const upazilaSelect = document.getElementById("upazila");

    upazilaSelect.innerHTML = `<option value="">Select Upazila/City</option>`;
    if (district && bangladeshData.districts[district]) {
        bangladeshData.districts[district].forEach(upazila => {
            upazilaSelect.innerHTML += `<option value="${upazila}">${upazila}</option>`;
        });
        upazilaSelect.disabled = false;
    } else {
        upazilaSelect.disabled = true;
    }
}

// Function to update villages based on selected upazila
function updateVillage() {
    const upazila = document.getElementById("upazila").value;
    const villageSelect = document.getElementById("village");

    villageSelect.innerHTML = `<option value="">Select Village/Area</option>`;
    if (upazila && bangladeshData.thanas[upazila]) {
        bangladeshData.thanas[upazila].forEach(village => {
            villageSelect.innerHTML += `<option value="${village}">${village}</option>`;
        });
        villageSelect.disabled = false;
    } else {
        villageSelect.disabled = true;
    }
}

// Function to update cities based on selected state (USA)
function updateCities() {
    const state = document.getElementById("state").value;
    const citySelect = document.getElementById("city");

    citySelect.innerHTML = `<option value="">Select City</option>`;
    if (state && usaData.states[state]) {
        usaData.states[state].forEach(city => {
            citySelect.innerHTML += `<option value="${city}">${city}</option>`;
        });
        citySelect.disabled = false;
    } else {
        citySelect.disabled = true;
    }
}

// Attach event listeners
document.getElementById("country").addEventListener("change", updateAddressFields);
document.getElementById("division").addEventListener("change", updateDistricts);
document.getElementById("district").addEventListener("change", updateUpazila);
document.getElementById("upazila").addEventListener("change", updateVillage);
document.getElementById("state").addEventListener("change", updateCities);

// Initial call to populate fields if a country is already selected
updateAddressFields();

// Data for Bangladesh
const bangladeshData = {
    divisions: {
        "Dhaka": ["Dhaka District", "Gazipur District", "Narayanganj District"],
        "Chittagong": ["Chittagong District", "Cox's Bazar District", "Comilla District"],
        "Rajshahi": ["Rajshahi District", "Bogra District", "Pabna District"],
        "Khulna": ["Khulna District", "Jessore District", "Satkhira District"],
        "Barishal": ["Barishal District", "Patuakhali District", "Bhola District"],
        "Sylhet": ["Sylhet District", "Moulvibazar District", "Habiganj District"],
        "Rangpur": ["Rangpur District", "Dinajpur District", "Nilphamari District"],
        "Mymensingh": ["Mymensingh District", "Netrokona District", "Jamalpur District"],
    },
    districts: {
        // Dhaka Division
        "Dhaka District": ["Dhanmondi Thana", "Mirpur Thana", "Gulshan Thana"],
        "Gazipur District": ["Gazipur Sadar Thana", "Kaliakair Thana", "Sreepur Thana"],
        "Narayanganj District": ["Narayanganj Sadar Thana", "Sonargaon Thana", "Bandar Thana"],

        // Chittagong Division
        "Chittagong District": ["Chittagong Sadar Thana", "Patiya Thana", "Sitakunda Thana"],
        "Cox's Bazar District": ["Cox's Bazar Sadar Thana", "Teknaf Thana", "Ukhia Thana"],
        "Comilla District": ["Comilla Sadar Thana", "Chauddagram Thana", "Laksam Thana"],

        // Rajshahi Division
        "Rajshahi District": ["Rajshahi Sadar Thana", "Paba Thana", "Bagmara Thana"],
        "Bogra District": ["Bogra Sadar Thana", "Sherpur Thana", "Dhunat Thana"],
        "Pabna District": ["Pabna Sadar Thana", "Ishwardi Thana", "Sujanagar Thana"],

        // Khulna Division
        "Khulna District": ["Khulna Sadar Thana", "Dumuria Thana", "Batiaghata Thana"],
        "Jessore District": ["Jessore Sadar Thana", "Chaugachha Thana", "Monirampur Thana"],
        "Satkhira District": ["Satkhira Sadar Thana", "Kaliganj Thana", "Debhata Thana"],

        // Barishal Division
        "Barishal District": ["Barishal Sadar Thana", "Bakerganj Thana", "Babuganj Thana"],
        "Patuakhali District": ["Patuakhali Sadar Thana", "Mirzaganj Thana", "Galachipa Thana"],
        "Bhola District": ["Bhola Sadar Thana", "Daulatkhan Thana", "Tazumuddin Thana"],

        // Sylhet Division
        "Sylhet District": ["Sylhet Sadar Thana", "Beanibazar Thana", "Golapganj Thana"],
        "Moulvibazar District": ["Moulvibazar Sadar Thana", "Kulaura Thana", "Sreemangal Thana"],
        "Habiganj District": ["Habiganj Sadar Thana", "Madhabpur Thana", "Nabiganj Thana"],

        // Rangpur Division
        "Rangpur District": ["Rangpur Sadar Thana", "Badarganj Thana", "Gangachara Thana"],
        "Dinajpur District": ["Dinajpur Sadar Thana", "Birampur Thana", "Parbatipur Thana"],
        "Nilphamari District": ["Nilphamari Sadar Thana", "Saidpur Thana", "Jaldhaka Thana"],

        // Mymensingh Division
        "Mymensingh District": ["Mymensingh Sadar Thana", "Trishal Thana", "Fulbaria Thana"],
        "Netrokona District": ["Netrokona Sadar Thana", "Kendua Thana", "Atpara Thana"],
        "Jamalpur District": ["Jamalpur Sadar Thana", "Melandaha Thana", "Islampur Thana"],
    },
    thanas: {
        // Dhaka Division
        "Dhanmondi Thana": ["Dhanmondi", "Shantinagar", "Rayerbazar"],
        "Mirpur Thana": ["Mirpur Union", "Pallabi", "Kafrul"],
        "Gulshan Thana": ["Gulshan 1", "Gulshan 2", "Banani"],

        "Gazipur Sadar Thana": ["Gazipur Union", "Baria", "Tongi"],
        "Kaliakair Thana": ["Kaliakair Union", "Mouchak", "Barmi"],
        "Sreepur Thana": ["Sreepur Union", "Maijbagh", "Rajabari"],

        "Narayanganj Sadar Thana": ["Narayanganj Union", "Bandar", "Fatullah"],
        "Sonargaon Thana": ["Sonargaon Union", "Panam", "Goaldi"],
        "Bandar Thana": ["Bandar Union", "Madanpur", "Kutubpur"],

        // Chittagong Division
        "Chittagong Sadar Thana": ["Chittagong Union", "Agrabad", "Halishahar"],
        "Patiya Thana": ["Patiya Union", "Char Patharghata", "Jiri"],
        "Sitakunda Thana": ["Sitakunda Union", "Banshbaria", "Kumira"],

        "Cox's Bazar Sadar Thana": ["Cox's Bazar Union", "Kolatoli", "Himchari"],
        "Teknaf Thana": ["Teknaf Union", "Shahporir Dwip", "St. Martin's Island"],
        "Ukhia Thana": ["Ukhia Union", "Raja Palong", "Haldia Palong"],

        "Comilla Sadar Thana": ["Comilla Union", "Kotbari", "Shashidal"],
        "Chauddagram Thana": ["Chauddagram Union", "Batisa", "Gouripur"],
        "Laksam Thana": ["Laksam Union", "Ajgara", "Mudaffarganj"],

        // Rajshahi Division
        "Rajshahi Sadar Thana": ["Rajshahi Union", "Shaheb Bazar", "Katakhali"],
        "Paba Thana": ["Paba Union", "Haripur", "Bhabaniganj"],
        "Bagmara Thana": ["Bagmara Union", "Durgapur", "Bhuban Mohan"],

        "Bogra Sadar Thana": ["Bogra Union", "Sherpur", "Dupchachia"],
        "Sherpur Thana": ["Sherpur Union", "Nandigram", "Kahalu"],
        "Dhunat Thana": ["Dhunat Union", "Gosaibari", "Elangi"],

        "Pabna Sadar Thana": ["Pabna Union", "Ishwardi", "Sujanagar"],
        "Ishwardi Thana": ["Ishwardi Union", "Pakshi", "Dashuria"],
        "Sujanagar Thana": ["Sujanagar Union", "Chatmohar", "Bhangura"],

        // Khulna Division
        "Khulna Sadar Thana": ["Khulna Union", "Khan Jahan Ali", "Sonadanga"],
        "Dumuria Thana": ["Dumuria Union", "Magura", "Batiaghata"],
        "Batiaghata Thana": ["Batiaghata Union", "Surkhali", "Amirpur"],

        "Jessore Sadar Thana": ["Jessore Union", "Chaugachha", "Monirampur"],
        "Chaugachha Thana": ["Chaugachha Union", "Bagherpara", "Keshabpur"],
        "Monirampur Thana": ["Monirampur Union", "Abhaynagar", "Keshabpur"],

        "Satkhira Sadar Thana": ["Satkhira Union", "Kaliganj", "Debhata"],
        "Kaliganj Thana": ["Kaliganj Union", "Tala", "Assasuni"],
        "Debhata Thana": ["Debhata Union", "Kalaroa", "Shyamnagar"],

        // Barishal Division
        "Barishal Sadar Thana": ["Barishal Union", "Bakerganj", "Babuganj"],
        "Bakerganj Thana": ["Bakerganj Union", "Gournadi", "Agailjhara"],
        "Babuganj Thana": ["Babuganj Union", "Uzirpur", "Barajalia"],

        "Patuakhali Sadar Thana": ["Patuakhali Union", "Mirzaganj", "Galachipa"],
        "Mirzaganj Thana": ["Mirzaganj Union", "Dashmina", "Bauphal"],
        "Galachipa Thana": ["Galachipa Union", "Rangabali", "Kalapara"],

        "Bhola Sadar Thana": ["Bhola Union", "Daulatkhan", "Tazumuddin"],
        "Daulatkhan Thana": ["Daulatkhan Union", "Borhanuddin", "Lalmohan"],
        "Tazumuddin Thana": ["Tazumuddin Union", "Char Fasson", "Manpura"],

        // Sylhet Division
        "Sylhet Sadar Thana": ["Sylhet Union", "Beanibazar", "Golapganj"],
        "Beanibazar Thana": ["Beanibazar Union", "Kanaighat", "Companiganj"],
        "Golapganj Thana": ["Golapganj Union", "Jaintiapur", "Balaganj"],

        "Moulvibazar Sadar Thana": ["Moulvibazar Union", "Kulaura", "Sreemangal"],
        "Kulaura Thana": ["Kulaura Union", "Rajnagar", "Kamalganj"],
        "Sreemangal Thana": ["Sreemangal Union", "Barlekha", "Juri"],

        "Habiganj Sadar Thana": ["Habiganj Union", "Madhabpur", "Nabiganj"],
        "Madhabpur Thana": ["Madhabpur Union", "Chunarughat", "Bahubal"],
        "Nabiganj Thana": ["Nabiganj Union", "Baniachong", "Ajmiriganj"],

        // Rangpur Division
        "Rangpur Sadar Thana": ["Rangpur Union", "Badarganj", "Gangachara"],
        "Badarganj Thana": ["Badarganj Union", "Pirgachha", "Kaunia"],
        "Gangachara Thana": ["Gangachara Union", "Taraganj", "Pirganj"],

        "Dinajpur Sadar Thana": ["Dinajpur Union", "Birampur", "Parbatipur"],
        "Birampur Thana": ["Birampur Union", "Birganj", "Khansama"],
        "Parbatipur Thana": ["Parbatipur Union", "Chirirbandar", "Bochaganj"],

        "Nilphamari Sadar Thana": ["Nilphamari Union", "Saidpur", "Jaldhaka"],
        "Saidpur Thana": ["Saidpur Union", "Kishoreganj", "Domar"],
        "Jaldhaka Thana": ["Jaldhaka Union", "Dimla", "Kishoreganj"],

        // Mymensingh Division
        "Mymensingh Sadar Thana": ["Mymensingh Union", "Trishal", "Fulbaria"],
        "Trishal Thana": ["Trishal Union", "Bhaluka", "Muktagachha"],
        "Fulbaria Thana": ["Fulbaria Union", "Gaffargaon", "Ishwarganj"],

        "Netrokona Sadar Thana": ["Netrokona Union", "Kendua", "Atpara"],
        "Kendua Thana": ["Kendua Union", "Barhatta", "Durgapur"],
        "Atpara Thana": ["Atpara Union", "Khaliajuri", "Madan"],

        "Jamalpur Sadar Thana": ["Jamalpur Union", "Melandaha", "Islampur"],
        "Melandaha Thana": ["Melandaha Union", "Dewanganj", "Bakshiganj"],
        "Islampur Thana": ["Islampur Union", "Sarishabari", "Madarganj"],
    },
};

// Data for USA
const usaData = {
    states: {
        "California": ["Los Angeles", "San Francisco", "San Diego"],
        "New York": ["New York City", "Buffalo", "Rochester"],
        "Texas": ["Houston", "Dallas", "Austin"],
    },
};