document.addEventListener('DOMContentLoaded', function () {
    console.log("Script loaded successfully!"); // Debugging

    // ---- Counting Animation ----
    function startCounting() {
        const counters = document.querySelectorAll('.count');
        const speed = 200; // Adjust speed (lower = faster)

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const increment = target / speed;

            const updateCount = () => {
                const currentCount = +counter.innerText;
                if (currentCount < target) {
                    counter.innerText = Math.ceil(currentCount + increment);
                    setTimeout(updateCount, 10); // Adjust timing (lower = faster)
                } else {
                    counter.innerText = target + '+'; // Add "+" sign at the end
                }
            };
            updateCount();
        });
    }

    // Check if '.about_pg3_left' exists before creating an observer
    const targetElement = document.querySelector('.about_pg3_left');

    if (targetElement) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startCounting();
                    observer.disconnect(); // Stop observing after animation starts
                }
            });
        });

        observer.observe(targetElement);
    } else {
        console.warn("Skipping observer: '.about_pg3_left' not found on this page.");
    }

    // ---- Update Current Year ----
    const currentYearElement = document.getElementById('currentYear');
    if (currentYearElement) {
        currentYearElement.textContent = new Date().getFullYear();
    } else {
        console.warn("Element with ID 'currentYear' not found!");
    }

    // ---- Country Code Selection ----
    const phoneInput = document.querySelector("#user_g_phone");
    if (phoneInput) {
        const iti = window.intlTelInput(phoneInput, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"
        });

        // Set initial country based on user's location
        iti.promise.then(() => {
            const countryCode = iti.getSelectedCountryData().iso2;
            iti.setCountry(countryCode);
        });

        // Listen for country change event
        phoneInput.addEventListener("countrychange", function () {
            const countryCode = iti.getSelectedCountryData().iso2;
            console.log("Selected country code:", countryCode);
        });
    } else {
        console.warn("Phone input field (#user_g_phone) not found!");
    }

    // ---- My Account View/Edit Mode ----
    const editButtons = document.querySelectorAll('.edit-btn');
    if (editButtons.length === 0) {
        console.warn("No .edit-btn elements found in the document!");
    }

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            console.log("Edit button clicked!"); // Debugging
            const section = button.closest('.list_dt2');

            if (section) {
                const viewMode = section.querySelector('.view-mode');
                const editMode = section.querySelector('.edit-mode');

                if (viewMode && editMode) {
                    viewMode.style.display = 'none';
                    editMode.style.display = 'block';
                } else {
                    console.error("view-mode or edit-mode not found inside section!");
                }
            } else {
                console.error("Parent section (.list_dt2) not found!");
            }
        });
    });

    // Select all cancel buttons
    const cancelButtons = document.querySelectorAll('.cancel-btn');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function () {
            console.log("Cancel button clicked!"); // Debugging
            const section = button.closest('.list_dt2');

            if (section) {
                const viewMode = section.querySelector('.view-mode');
                const editMode = section.querySelector('.edit-mode');

                if (viewMode && editMode) {
                    editMode.style.display = 'none';
                    viewMode.style.display = 'block';
                } else {
                    console.error("view-mode or edit-mode not found inside section!");
                }
            } else {
                console.error("Parent section (.list_dt2) not found!");
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {
    const heightSelect = document.getElementById('user_height');

    // Clear existing options (except the first one)
    heightSelect.innerHTML = '<option selected disabled>Select One</option>';

    // Generate height options
    for (let cm = 140; cm <= 190; cm++) {
        // Convert cm to feet and inches
        const feet = Math.floor(cm / 30.48); // 1 foot = 30.48 cm
        const inches = Math.round((cm / 30.48 - feet) * 12); // Remaining inches

        // Format the height string (e.g., "169 cm / 5'6"")
        const heightString = `${cm} cm / ${feet}'${inches}"`;

        // Create a new option element
        const option = document.createElement('option');
        option.value = cm; // Use cm as the value
        option.textContent = heightString; // Display the formatted height

        // Add the option to the select element
        heightSelect.appendChild(option);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const weightSelect = document.getElementById('user_weight');

    // Clear existing options (except the first one)
    weightSelect.innerHTML = '<option selected disabled>Select One</option>';

    // Generate weight options
    for (let kg = 30; kg <= 150; kg++) {
        // Convert kg to lbs (1 kg = 2.20462 lbs)
        const lbs = (kg * 2.20462).toFixed(0); // Round to the nearest whole number

        // Format the weight string (e.g., "45 Kgs / 99 lbs")
        const weightString = `${kg} Kgs / ${lbs} lbs`;

        // Create a new option element
        const option = document.createElement('option');
        option.value = kg; // Use kg as the value
        option.textContent = weightString; // Display the formatted weight

        // Add the option to the select element
        weightSelect.appendChild(option);
    }
});


document.addEventListener("DOMContentLoaded", function () {
    // User Annual Income
    const currencySelect = document.getElementById("currency");
    const incomeSelect = document.getElementById("annual-income");

    // Partner Annual Income
    const partnercurrencySelect = document.getElementById("partner_currency");
    const partnerincomeSelect = document.getElementById("partner_annual_income");

    if (!currencySelect || !incomeSelect) {
        console.error("User dropdown elements not found! Check your HTML IDs.");
        return;
    }

    if (!partnercurrencySelect || !partnerincomeSelect) {
        console.error("Partner dropdown elements not found! Check your HTML IDs.");
        return;
    }

    const incomeOptions = {
        taka: [
            { value: "below_10000", text: "Below ৳10,000" },
            { value: "10000_20000", text: "৳10,000 - ৳20,000" },
            { value: "20000_30000", text: "৳20,000 - ৳30,000" },
            { value: "30000_40000", text: "৳30,000 - ৳40,000" },
            { value: "40000_50000", text: "৳40,000 - ৳50,000" },
            { value: "50000_75000", text: "৳50,000 - ৳75,000" },
            { value: "75000_100000", text: "৳75,000 - ৳100,000" },
            { value: "above_100000", text: "Above ৳100,000" }
        ],
        dollar: [
            { value: "below_1000", text: "Below $1,000" },
            { value: "1000_2000", text: "$1,000 - $2,000" },
            { value: "2000_3000", text: "$2,000 - $3,000" },
            { value: "3000_4000", text: "$3,000 - $4,000" },
            { value: "4000_5000", text: "$4,000 - $5,000" },
            { value: "5000_7000", text: "$5,000 - $7,500" },
            { value: "7500_10000", text: "$7,500 - $10,000" },
            { value: "above_10000", text: "Above $10,000" }
        ]
    };

    function updateIncomeOptions(selectElement, currency) {
        selectElement.innerHTML = ""; // Clear existing options
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "Select Annual Income";
        selectElement.appendChild(defaultOption);

        incomeOptions[currency].forEach(option => {
            const opt = document.createElement("option");
            opt.value = option.value;
            opt.textContent = option.text;
            selectElement.appendChild(opt);
        });
    }

    // Initialize with Taka options
    updateIncomeOptions(incomeSelect, "taka");
    updateIncomeOptions(partnerincomeSelect, "taka");

    // Change options when currency changes
    currencySelect.addEventListener("change", function () {
        updateIncomeOptions(incomeSelect, this.value);
    });

    partnercurrencySelect.addEventListener("change", function () {
        updateIncomeOptions(partnerincomeSelect, this.value);
    });
});







document.getElementById('saveProfilePicture').addEventListener('click', function () {
    const fileInput = document.getElementById('profilePictureUpload');
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            // Update the profile picture source
            document.querySelector('.profile-picture').src = e.target.result;
            // Close the modal
            $('#profilePictureModal').modal('hide');
            alert('Profile picture updated successfully!');
        };

        reader.readAsDataURL(file); // Read the file as a data URL
    } else {
        alert('Please select a file to upload.');
    }
});



document.addEventListener('DOMContentLoaded', function () {
    console.log("JavaScript is running!");

    const editButtons = document.querySelectorAll('.edit-btn');
    console.log("Edit buttons found:", editButtons.length);

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            console.log("Edit button clicked!");
            const section = button.closest('.list_dt2');
            const viewMode = section.querySelector('.view-mode');
            const editMode = section.querySelector('.edit-mode');

            if (viewMode && editMode) {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
            }
        });
    });
});


document.getElementById('uploadButton').addEventListener('click', function () {
    const fileInput = document.getElementById('imageUpload');
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        // Handle the file upload here (e.g., send it to a server)
        console.log('File to upload:', file);
        alert('Upload functionality to be implemented.');
    } else {
        alert('Please select a file to upload.');
    }
});

