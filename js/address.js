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
    "Rajshahi Division": [
      "Bogra District",
      "Joypurhat District",
      "Naogaon District",
      "Natore District",
      "Nawabganj District",
      "Pabna District",
      "Rajshahi District",
      "Sirajganj District"
    ],
    "Rangpur Division": [
      "Dinajpur District",
      "Gaibandha District",
      "Kurigram District",
      "Lalmonirhat District",
      "Nilphamari District",
      "Panchagarh District",
      "Rangpur District",
      "Thakurgaon District"
    ],
    "Barisal Division": [
      "Barguna District",
      "Barisal District",
      "Bhola District",
      "Jhalokati District",
      "Patuakhali District",
      "Pirojpur District"
    ],
    "Chittagong Division": [
      "Bandarban District",
      "Brahmanbaria District",
      "Chandpur District",
      "Chittagong District",
      "Comilla District",
      "Cox's Bazar District",
      "Feni District",
      "Khagrachhari District",
      "Lakshmipur District",
      "Noakhali District",
      "Rangamati District"
    ],
    "Dhaka Division": [
      "Dhaka District",
      "Faridpur District",
      "Gazipur District",
      "Gopalganj District",
      "Jamalpur District",
      "Kishoreganj District",
      "Madaripur District",
      "Manikganj District",
      "Munshiganj District",
      "Mymensingh District",
      "Narayanganj District",
      "Narsingdi District",
      "Netrokona District",
      "Rajbari District",
      "Shariatpur District",
      "Sherpur District",
      "Tangail District"
    ],
    "Khulna Division": [
      "Bagerhat District",
      "Chuadanga District",
      "Jessore District",
      "Jhenaida District",
      "Khulna District",
      "Kushtia District",
      "Magura District",
      "Meherpur District",
      "Narail District",
      "Satkhira District"
    ],
    "Sylhet Division": [
      "Habiganj District",
      "Moulvibazar District",
      "Sunamganj District",
      "Sylhet District"
    ]
  },
    districts: {
    "Joypurhat District": [
      "Akkelpur Upazila",
      "Joypurhat Sadar Upazila",
      "Kalai Upazila",
      "Khetlal Upazila",
      "Panchbibi Upazila"
    ],
    "Bogra District": [
      "Adamdighi Upazila",
      "Bogra Sadar Upazila",
      "Dhunat Upazila",
      "Dhupchanchia Upazila",
      "Gabtali Upazila",
      "Kahaloo Upazila",
      "Nandigram Upazila",
      "Sariakandi Upazila",
      "Shajahanpur Upazila",
      "Sherpur Upazila",
      "Shibganj Upazila",
      "Sonatola Upazila"
    ],
    "Naogaon District": [
      "Atrai Upazila",
      "Badalgachhi Upazila",
      "Dhamoirhat Upazila",
      "Manda Upazila",
      "Mohadevpur Upazila",
      "Naogaon Sadar Upazila",
      "Niamatpur Upazila",
      "Patnitala Upazila",
      "Porsha Upazila",
      "Raninagar Upazila",
      "Sapahar Upazila"
    ],
    "Natore District": [
      "Bagatipara Upazila",
      "Baraigram Upazila",
      "Gurudaspur Upazila",
      "Lalpur Upazila",
      "Naldanga Upazila",
      "Natore Sadar Upazila",
      "Singra Upazila"
    ],
    "Nawabganj District": [
      "Bholahat Upazila",
      "Gomastapur Upazila",
      "Nachole Upazila",
      "Nawabganj Sadar Upazila",
      "Shibganj Upazila"
    ],
    "Pabna District": [
      "Ataikula Upazila",
      "Atgharia Upazila",
      "Bera Upazila",
      "Bhangura Upazila",
      "Chatmohar Upazila",
      "Faridpur Upazila",
      "Ishwardi Upazila",
      "Pabna Sadar Upazila",
      "Santhia Upazila",
      "Sujanagar Upazila"
    ],
    "Sirajganj District": [
      "Belkuchi Upazila",
      "Chauhali Upazila",
      "Kamarkhanda Upazila",
      "Kazipur Upazila",
      "Raiganj Upazila",
      "Shahjadpur Upazila",
      "Sirajganj Sadar Upazila",
      "Tarash Upazila",
      "Ullahpara Upazila"
    ],
    "Rajshahi District": [
      "Bagha Upazila",
      "Bagmara Upazila",
      "Boalia Thana",
      "Charghat Upazila",
      "Durgapur Upazila",
      "Godagari Upazila",
      "Matihar Thana",
      "Mohanpur Upazila",
      "Paba Upazila",
      "Puthia Upazila",
      "Rajpara Thana",
      "Shah Mokdum Thana",
      "Tanore Upazila"
    ],
    "Dinajpur District": [
      "Biral Upazila",
      "Birampur Upazila",
      "Birganj Upazila",
      "Bochaganj Upazila",
      "Chirirbandar Upazila",
      "Dinajpur Sadar Upazila",
      "Ghoraghat Upazila",
      "Hakimpur Upazila",
      "Kaharole Upazila",
      "Khansama Upazila",
      "Nawabganj Upazila",
      "Parbatipur Upazila",
      "Phulbari Upazila"
    ],
    "Gaibandha District": [
      "Gaibandha Sadar Upazila",
      "Gobindaganj Upazila",
      "Palashbari Upazila",
      "Phulchhari Upazila",
      "Sadullapur Upazila",
      "Sughatta Upazila",
      "Sundarganj Upazila"
    ],
    "Kurigram District": [
      "Bhurungamari Upazila",
      "Char Rajibpur Upazila",
      "Chilmari Upazila",
      "Kurigram Sadar Upazila",
      "Nageshwari Upazila",
      "Phulbari Upazila",
      "Rajarhat Upazila",
      "Raomari Upazila",
      "Ulipur Upazila"
    ],
    "Lalmonirhat District": [
      "Aditmari Upazila",
      "Hatibandha Upazila",
      "Kaliganj Upazila",
      "Lalmonirhat Sadar Upazila",
      "Patgram Upazila"
    ],
    "Nilphamari District": [
      "Dimla Upazila",
      "Domar Upazila",
      "Jaldhaka Upazila",
      "Kishoreganj Upazila",
      "Nilphamari Sadar Upazila",
      "Saidpur Upazila"
    ],
    "Panchagarh District": [
      "Atwari Upazila",
      "Boda Upazila",
      "Debiganj Upazila",
      "Panchagarh Sadar Upazila",
      "Tetulia Upazila"
    ],
    "Rangpur District": [
      "Badarganj Upazila",
      "Gangachhara Upazila",
      "Kaunia Upazila",
      "Mithapukur Upazila",
      "Pirgachha Upazila",
      "Pirganj Upazila",
      "Rangpur Sadar Upazila",
      "Taraganj Upazila"
    ],
    "Thakurgaon District": [
      "Baliadangi Upazila",
      "Haripur Upazila",
      "Pirganj Upazila",
      "Ranisankail Upazila",
      "Thakurgaon Sadar Upazila"
    ],
    "Barguna District": [
      "Amtali Upazila",
      "Bamna Upazila",
      "Barguna Sadar Upazila",
      "Betagi Upazila",
      "Patharghata Upazila",
      "Taltoli Upazila"
    ],
    "Barisal District": [
      "Agailjhara Upazila",
      "Babuganj Upazila",
      "Bakerganj Upazila",
      "Banaripara Upazila",
      "Barisal Sadar Upazila",
      "Gaurnadi Upazila",
      "Hizla Upazila",
      "Mehendiganj Upazila",
      "Muladi Upazila",
      "Wazirpur Upazila"
    ],
    "Bhola District": [
      "Bhola Sadar Upazila",
      "Burhanuddin Upazila",
      "Char Fasson Upazila",
      "Daulatkhan Upazila",
      "Lalmohan Upazila",
      "Manpura Upazila",
      "Tazumuddin Upazila"
    ],
    "Jhalokati District": [
      "Jhalokati Sadar Upazila",
      "Kathalia Upazila",
      "Nalchity Upazila",
      "Rajapur Upazila"
    ],
    "Patuakhali District": [
      "Bauphal Upazila",
      "Dashmina Upazila",
      "Dumki Upazila",
      "Galachipa Upazila",
      "Kalapara Upazila",
      "Mirzaganj Upazila",
      "Patuakhali Sadar Upazila",
      "Rangabali Upazila"
    ],
    "Pirojpur District": [
      "Bhandaria Upazila",
      "Kawkhali Upazila",
      "Mathbaria Upazila",
      "Nazirpur Upazila",
      "Nesarabad (Swarupkati) Upazila",
      "Pirojpur Sadar Upazila",
      "Zianagor Upazila"
    ],
    "Bandarban District": [
      "Ali Kadam Upazila",
      "Bandarban Sadar Upazila",
      "Lama Upazila",
      "Naikhongchhari Upazila",
      "Rowangchhari Upazila",
      "Ruma Upazila",
      "Thanchi Upazila"
    ],
    "Brahmanbaria District": [
      "Akhaura Upazila",
      "Ashuganj Upazila",
      "Bancharampur Upazila",
      "Bijoynagar Upazila",
      "Brahmanbaria Sadar Upazila",
      "Kasba Upazila",
      "Nabinagar Upazila",
      "Nasirnagar Upazila",
      "Sarail Upazila"
    ],
    "Chandpur District": [
      "Chandpur Sadar Upazila",
      "Faridganj Upazila",
      "Haimchar Upazila",
      "Haziganj Upazila",
      "Kachua Upazila",
      "Matlab Dakshin Upazila",
      "Matlab Uttar Upazila",
      "Shahrasti Upazila"
    ],
    "Chittagong District": [
      "Anwara Upazila",
      "Bandor (Chittagong Port) Thana",
      "Banshkhali Upazila",
      "Boalkhali Upazila",
      "Chandanaish Upazila",
      "Chandgaon Thana",
      "Double Mooring Thana",
      "Fatikchhari Upazila",
      "Hathazari Upazila",
      "Kotwali Thana",
      "Lohagara Upazila",
      "Mirsharai Upazila",
      "Pahartali Thana",
      "Panchlaish Thana",
      "Patiya Upazila",
      "Rangunia Upazila",
      "Raozan Upazila",
      "Sandwip Upazila",
      "Satkania Upazila",
      "Sitakunda Upazila"
    ],
    "Comilla District": [
      "Barura Upazila",
      "Brahmanpara Upazila",
      "Burichang Upazila",
      "Chandina Upazila",
      "Chauddagram Upazila",
      "Comilla Adarsha Sadar Upazila",
      "Comilla Sadar Dakshin Upazila",
      "Daudkandi Upazila",
      "Debidwar Upazila",
      "Homna Upazila",
      "Laksam Upazila",
      "Meghna Upazila",
      "Monohargonj Upazila",
      "Muradnagar Upazila",
      "Nangalkot Upazila",
      "Titas Upazila"
    ],
    "Cox's Bazar District": [
      "Chakaria Upazila",
      "Cox's Bazar Sadar Upazila",
      "Kutubdia Upazila",
      "Maheshkhali Upazila",
      "Pekua Upazila",
      "Ramu Upazila",
      "Teknaf Upazila",
      "Ukhia Upazila"
    ],
    "Feni District": [
      "Chhagalnaiya Upazila",
      "Daganbhuiyan Upazila",
      "Feni Sadar Upazila",
      "Fulgazi Upazila",
      "Parshuram Upazila",
      "Sonagazi Upazila"
    ],
    "Khagrachhari District": [
      "Dighinala Upazila",
      "Khagrachhari Upazila",
      "Lakshmichhari Upazila",
      "Mahalchhari Upazila",
      "Manikchhari Upazila",
      "Matiranga Upazila",
      "Panchhari Upazila",
      "Ramgarh Upazila"
    ],
    "Lakshmipur District": [
      "Kamalnagar Upazila",
      "Lakshmipur Sadar Upazila",
      "Raipur Upazila",
      "Ramganj Upazila",
      "Ramgati Upazila"
    ],
    "Noakhali District": [
      "Begumganj Upazila",
      "Chatkhil Upazila",
      "Companiganj Upazila",
      "Hatiya Upazila",
      "Kabirhat Upazila",
      "Noakhali Sadar Upazila",
      "Senbagh Upazila",
      "Sonaimuri Upazila",
      "Subarnachar Upazila"
    ],
    "Rangamati District": [
      "Bagaichhari Upazila",
      "Barkal Upazila",
      "Belaichhari Upazila",
      "Juraichhari Upazila",
      "Kaptai Upazila",
      "Kawkhali (Betbunia) Upazila",
      "Langadu Upazila",
      "Naniyachar Upazila",
      "Rajasthali Upazila",
      "Rangamati Sadar Upazila"
    ],
    "Dhaka District": [
      "Dhamrai Upazila",
      "Dohar Upazila",
      "Keraniganj Upazila",
      "Nawabganj Upazila",
      "Savar Upazila"
    ],
    "Faridpur District": [
      "Alfadanga Upazila",
      "Bhanga Upazila",
      "Boalmari Upazila",
      "Charbhadrasan Upazila",
      "Faridpur Sadar Upazila",
      "Madhukhali Upazila",
      "Nagarkanda Upazila",
      "Sadarpur Upazila",
      "Saltha Upazila"
    ],
    "Gazipur District": [
      "Gazipur Sadar Upazila",
      "Kaliakair Upazila",
      "Kaliganj Upazila",
      "Kapasia Upazila",
      "Sreepur Upazila"
    ],
    "Gopalganj District": [
      "Gopalganj Sadar Upazila",
      "Kashiani Upazila",
      "Kotalipara Upazila",
      "Muksudpur Upazila",
      "Tungipara Upazila"
    ],
    "Jamalpur District": [
      "Baksiganj Upazila",
      "Dewanganj Upazila",
      "Islampur Upazila",
      "Jamalpur Sadar Upazila",
      "Madarganj Upazila",
      "Melandaha Upazila",
      "Sarishabari Upazila"
    ],
    "Kishoreganj District": [
      "Astagram Upazila",
      "Bajitpur Upazila",
      "Bhairab Upazila",
      "Hossainpur Upazila",
      "Itna Upazila",
      "Karimganj Upazila",
      "Katiadi Upazila",
      "Kishoreganj Sadar Upazila",
      "Kuliarchar Upazila",
      "Mithamain Upazila",
      "Nikli Upazila",
      "Pakundia Upazila",
      "Tarail Upazila"
    ],
    "Madaripur District": [
      "Kalkini Upazila",
      "Madaripur Sadar Upazila",
      "Rajoir Upazila",
      "Shibchar Upazila"
    ],
    "Manikganj District": [
      "Daulatpur Upazila",
      "Ghior Upazila",
      "Harirampur Upazila",
      "Manikgonj Sadar Upazila",
      "Saturia Upazila",
      "Shivalaya Upazila",
      "Singair Upazila"
    ],
    "Munshiganj District": [
      "Gazaria Upazila",
      "Lohajang Upazila",
      "Munshiganj Sadar Upazila",
      "Sirajdikhan Upazila",
      "Sreenagar Upazila",
      "Tongibari Upazila"
    ],
    "Mymensingh District": [
      "Bhaluka Upazila",
      "Dhobaura Upazila",
      "Fulbaria Upazila",
      "Gaffargaon Upazila",
      "Gauripur Upazila",
      "Haluaghat Upazila",
      "Ishwarganj Upazila",
      "Muktagachha Upazila",
      "Mymensingh Sadar Upazila",
      "Nandail Upazila",
      "Phulpur Upazila",
      "Tara Khanda Upazila",
      "Trishal Upazila"
    ],
    "Narayanganj District": [
      "Araihazar Upazila",
      "Bandar Upazila",
      "Narayanganj Sadar Upazila",
      "Rupganj Upazila",
      "Sonargaon Upazila"
    ],
    "Netrokona District": [
      "Atpara Upazila",
      "Barhatta Upazila",
      "Durgapur Upazila",
      "Kalmakanda Upazila",
      "Kendua Upazila",
      "Khaliajuri Upazila",
      "Madan Upazila",
      "Mohanganj Upazila",
      "Netrokona Sadar Upazila",
      "Purbadhala Upazila"
    ],
    "Rajbari District": [
      "Baliakandi Upazila",
      "Goalandaghat Upazila",
      "Kalukhali Upazila",
      "Pangsha Upazila",
      "Rajbari Sadar Upazila"
    ],
    "Shariatpur District": [
      "Bhedarganj Upazila",
      "Damudya Upazila",
      "Gosairhat Upazila",
      "Naria Upazila",
      "Shakhipur Upazila",
      "Shariatpur Sadar Upazila",
      "Zanjira Upazila"
    ],
    "Sherpur District": [
      "Jhenaigati Upazila",
      "Nakla Upazila",
      "Nalitabari Upazila",
      "Sherpur Sadar Upazila",
      "Sreebardi Upazila"
    ],
    "Tangail District": [
      "Basail Upazila",
      "Bhuapur Upazila",
      "Delduar Upazila",
      "Dhanbari Upazila",
      "Ghatail Upazila",
      "Gopalpur Upazila",
      "Kalihati Upazila",
      "Madhupur Upazila",
      "Mirzapur Upazila",
      "Nagarpur Upazila",
      "Sakhipur Upazila",
      "Tangail Sadar Upazila"
    ],
    "Narsingdi District": [
      "Belabo Upazila",
      "Monohardi Upazila",
      "Narsingdi Sadar Upazila",
      "Palash Upazila",
      "Raipura Upazila",
      "Shibpur Upazila"
    ],
    "Bagerhat District": [
      "Bagerhat Sadar Upazila",
      "Chitalmari Upazila",
      "Fakirhat Upazila",
      "Kachua Upazila",
      "Mollahat Upazila",
      "Mongla Upazila",
      "Morrelganj Upazila",
      "Rampal Upazila",
      "Sarankhola Upazila"
    ],
    "Chuadanga District": [
      "Alamdanga Upazila",
      "Chuadanga Sadar Upazila",
      "Damurhuda Upazila",
      "Jibannagar Upazila"
    ],
    "Jessore District": [
      "Abhaynagar Upazila",
      "Bagherpara Upazila",
      "Chaugachha Upazila",
      "Jessore Sadar Upazila",
      "Jhikargachha Upazila",
      "Keshabpur Upazila",
      "Manirampur Upazila",
      "Sharsha Upazila"
    ],
    "Jhenaida District": [
      "Harinakunda Upazila",
      "Jhenaidah Sadar Upazila",
      "Kaliganj Upazila",
      "Kotchandpur Upazila",
      "Maheshpur Upazila",
      "Shailkupa Upazila"
    ],
    "Khulna District": [
      "Batiaghata Upazila",
      "Dacope Upazila",
      "Daulatpur Thana",
      "Dighalia Upazila",
      "Dumuria Upazila",
      "Harintana Thana",
      "Khalishpur Thana",
      "Khan Jahan Ali Thana",
      "Kotwali Thana",
      "Koyra Upazila",
      "Paikgachha Upazila",
      "Phultala Upazila",
      "Rupsha Upazila",
      "Sonadanga Thana",
      "Terokhada Upazila"
    ],
    "Kushtia District": [
      "Bheramara Upazila",
      "Daulatpur Upazila",
      "Khoksa Upazila",
      "Kumarkhali Upazila",
      "Kushtia Sadar Upazila",
      "Mirpur Upazila",
      "Shekhpara Upazila"
    ],
    "Magura District": [
      "Magura Sadar Upazila",
      "Mohammadpur Upazila",
      "Shalikha Upazila",
      "Sreepur Upazila"
    ],
    "Meherpur District": [
      "Gangni Upazila",
      "Meherpur Sadar Upazila",
      "Mujibnagar Upazila"
    ],
    "Narail District": [
      "Kalia Upazila",
      "Lohagara Upazila",
      "Naragati Thana",
      "Narail Sadar Upazila"
    ],
    "Satkhira District": [
      "Assasuni Upazila",
      "Debhata Upazila",
      "Kalaroa Upazila",
      "Kaliganj Upazila",
      "Satkhira Sadar Upazila",
      "Shyamnagar Upazila",
      "Tala Upazila"
    ],
    "Habiganj District": [
      "Ajmiriganj Upazila",
      "Bahubal Upazila",
      "Baniyachong Upazila",
      "Chunarughat Upazila",
      "Habiganj Sadar Upazila",
      "Lakhai Upazila",
      "Madhabpur Upazila",
      "Nabiganj Upazila"
    ],
    "Moulvibazar District": [
      "Barlekha Upazila",
      "Juri Upazila",
      "Kamalganj Upazila",
      "Kulaura Upazila",
      "Moulvibazar Sadar Upazila",
      "Rajnagar Upazila",
      "Sreemangal Upazila"
    ],
    "Sunamganj District": [
      "Bishwamvarpur Upazila",
      "Chhatak Upazila",
      "Derai Upazila",
      "Dharampasha Upazila",
      "Dowarabazar Upazila",
      "Jagannathpur Upazila",
      "Jamalganj Upazila",
      "South Sunamganj Upazila",
      "Sullah Upazila",
      "Sunamganj Sadar Upazila",
      "Tahirpur Upazila"
    ],
    "Sylhet District": [
      "Balaganj Upazila",
      "Beanibazar Upazila",
      "Bishwanath Upazila",
      "Companigonj Upazila",
      "Fenchuganj Upazila",
      "Golapganj Upazila",
      "Gowainghat Upazila",
      "Jaintiapur Upazila",
      "Kanaighat Upazila",
      "South Shurma Upazila",
      "Sylhet Sadar Upazila",
      "Zakiganj Upazila"
    ]
  }
  };
// Data for USA
const usaData = {
    states: {
        "California": ["Los Angeles", "San Francisco", "San Diego"],
        "New York": ["New York City", "Buffalo", "Rochester"],
        "Texas": ["Houston", "Dallas", "Austin"],
    },
};