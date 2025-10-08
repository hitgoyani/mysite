document.addEventListener('DOMContentLoaded', function() {
  // Load trainers.json if trainers container exists (or append a container)
  function renderTrainers(data) {
    var container = document.getElementById('trainers-json');
    if (!container) {
      container = document.createElement('div');
      container.id = 'trainers-json';
      var ref = document.querySelector('.container') || document.body;
      ref.appendChild(container);
    }
    var html = '<h2>Our Trainers (from JSON)</h2><div class="trainers-grid">';
    data.forEach(function(t){
      html += '<div class="trainer-card"><h3>'+t.name+'</h3><p><strong>'+t.specialty+'</strong></p><p>'+t.bio+'</p></div>';
    });
    html += '</div>';
    container.innerHTML = html;
  }

  function renderEvents(data) {
    var container = document.getElementById('events-json');
    if (!container) {
      container = document.createElement('div');
      container.id = 'events-json';
      var ref = document.querySelector('.container') || document.body;
      ref.appendChild(container);
    }
    var html = '<h2>Upcoming Events (from JSON)</h2><ul class="events-list">';
    data.forEach(function(e){
      html += '<li><strong>'+e.title+'</strong> — '+e.date+' '+e.time+'<br>'+e.desc+'</li>';
    });
    html += '</ul>';
    container.innerHTML = html;
  }

  // Fetch trainers.json
  fetch('data/trainers.json').then(function(r){ if(r.ok) return r.json(); throw new Error('No trainers'); })
    .then(function(json){ renderTrainers(json); })
    .catch(function(err){ /* no trainers */ });

  // Fetch events.json
  fetch('data/events.json').then(function(r){ if(r.ok) return r.json(); throw new Error('No events'); })
    .then(function(json){ renderEvents(json); })
    .catch(function(err){ /* no events */ });
});
