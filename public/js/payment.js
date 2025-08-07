function submitForm(formId) {
  const form = document.getElementById(formId);
  const submitButton = form.querySelector('button[type="submit"]');

  // Disable the submit button to prevent double submission
  submitButton.disabled = true;
  submitButton.innerHTML = "Memproses...";

  // Submit the form
  form.submit();
}
