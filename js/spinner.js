document.getElementById('socialaccountsForm').addEventListener('submit', function (e) {
    // Prevent the default form submission
    e.preventDefault();

    // Get the Save Changes button and spinner
    const saveButton = document.getElementById('saveSocialChangesBtn');
    const saveText = document.getElementById('saveText');
    const spinner = document.getElementById('spinner');

    // Disable the button and show the spinner
    saveButton.disabled = true;
    saveText.textContent = 'Saving...';
    spinner.classList.remove('d-none');

    // Simulate form submission (replace this with your actual form submission logic)
    setTimeout(() => {
        // Re-enable the button and hide the spinner after submission
        saveButton.disabled = false;
        saveText.textContent = 'Save Changes';
        spinner.classList.add('d-none');

        // Optionally, close the modal after saving
        const modal = bootstrap.Modal.getInstance(document.getElementById('socialaccounts'));
        modal.hide();

        // Optionally, refresh the page or update the UI
        window.location.href = window.location.href;
    }, 2000); // Simulate a 2-second delay for submission
});