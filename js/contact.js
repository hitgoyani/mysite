document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contactForm');

  if (form) {
    const nameField = document.getElementById('name');
    const emailField = document.getElementById('email');
    const messageField = document.getElementById('message');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const messageError = document.getElementById('messageError');

    function validateName(name) {
      if (name.length < 2) return 'Name must be at least 2 characters long.';
      if (!/^[a-zA-Z\s]+$/.test(name)) return 'Name can only contain letters and spaces.';
      return '';
    }

    function validateEmail(email) {
      if (!/^\S+@\S+\.\S+$/.test(email)) return 'Please enter a valid email address.';
      return '';
    }

    function validateMessage(message) {
      if (message.length < 10) return 'Message must be at least 10 characters long.';
      if (message.length > 500) return 'Message cannot exceed 500 characters.';
      return '';
    }

    nameField.addEventListener('input', function() {
      nameError.textContent = validateName(this.value.trim());
    });

    emailField.addEventListener('input', function() {
      emailError.textContent = validateEmail(this.value.trim());
    });

    messageField.addEventListener('input', function() {
      messageError.textContent = validateMessage(this.value.trim());
    });

    form.addEventListener('submit', function(event) {
      let valid = true;
      nameError.textContent = validateName(nameField.value.trim());
      emailError.textContent = validateEmail(emailField.value.trim());
      messageError.textContent = validateMessage(messageField.value.trim());

      if (nameError.textContent) {
        nameField.focus();
        valid = false;
      } else if (emailError.textContent) {
        emailField.focus();
        valid = false;
      } else if (messageError.textContent) {
        messageField.focus();
        valid = false;
      }

      if (!valid) {
        event.preventDefault();
        return;
      }
      event.preventDefault();


      fetch('php/contact_save.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name: nameField.value.trim(), email: emailField.value.trim(), message: messageField.value.trim() })
      }).then(r => r.json())
        .then(data => {
          if (data.success) {
            alert('Thank you for your message! We will get back to you soon.');
            form.reset();
            nameError.textContent = '';
            emailError.textContent = '';
            messageError.textContent = '';
          } else {
            alert('Failed to send message: ' + (data.error || 'Unknown error'));
          }
        }).catch(err => {
          console.error(err);
          alert('Server error, please try again later.');
        });
    });
  }
});


