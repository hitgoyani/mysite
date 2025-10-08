document.addEventListener('DOMContentLoaded', function() {

  const form = document.getElementById('trainerContactForm');
  if (form) {
    form.addEventListener('submit', function(event) {
      let valid = true;
      const name = document.getElementById('contactName').value.trim();
      const email = document.getElementById('contactEmail').value.trim();
      const message = document.getElementById('contactMessage').value.trim();


      if (name.length < 2) {
        document.getElementById('contactNameError').textContent = 'Please enter at least 2 characters.';
        valid = false;
      } else {
        document.getElementById('contactNameError').textContent = '';
      }


      if (!/^\S+@\S+\.\S+$/.test(email)) {
        document.getElementById('contactEmailError').textContent = 'Please enter a valid email address.';
        valid = false;
      } else {
        document.getElementById('contactEmailError').textContent = '';
      }


      if (message.length < 5) {
        document.getElementById('contactMessageError').textContent = 'Message must be at least 5 characters.';
        valid = false;
      } else {
        document.getElementById('contactMessageError').textContent = '';
      }

      if (!valid) {
        event.preventDefault();
      }
    });
  }


  const faqQuestions = document.querySelectorAll('.faq-question');
  faqQuestions.forEach(function(btn) {
    btn.addEventListener('click', function() {
      const answer = this.nextElementSibling;
      if (answer.style.display === 'block') {
        answer.style.display = 'none';
      } else {

        document.querySelectorAll('.faq-answer').forEach(function(a) {
          a.style.display = 'none';
        });

        answer.style.display = 'block';
      }
    });
  });
});


