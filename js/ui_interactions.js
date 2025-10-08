document.addEventListener('DOMContentLoaded', function(){

  // Create hamburger menu icon
  const toggle = document.querySelector('.menu-toggle');
  if (!toggle) {
    const newToggle = document.createElement('button');
    newToggle.className = 'menu-toggle';
    newToggle.innerHTML = '<span></span><span></span><span></span>';
    document.querySelector('.nav-right').insertBefore(newToggle, document.querySelector('.nav-right').firstChild);
  }

  // Mobile nav toggle
  const menuToggle = document.querySelector('.menu-toggle');
  if(menuToggle){
    menuToggle.addEventListener('click', function(e){
      e.stopPropagation();
      const nav = document.querySelector('.nav-center');
      menuToggle.classList.toggle('active');
      nav.classList.toggle('show');
    });
  }

  // Handle dropdowns in mobile view
  const dropdowns = document.querySelectorAll('.dropdown');
  dropdowns.forEach(dropdown => {
    dropdown.addEventListener('click', function(e) {
      if (window.innerWidth <= 900) {
        e.preventDefault();
        dropdown.classList.toggle('active');
      }
    });
  });

  // Close mobile nav when clicking outside
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.navbar')) {
      const nav = document.querySelector('.nav-center');
      const menuToggle = document.querySelector('.menu-toggle');
      if (nav.classList.contains('show')) {
        nav.classList.remove('show');
        menuToggle.classList.remove('active');
      }
      // Close any open dropdowns
      document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('active'));
    }
  });

  // Modal openers (data-modal target)
  document.querySelectorAll('[data-modal]').forEach(function(btn){
    btn.addEventListener('click', function(e){
      var id = btn.getAttribute('data-modal');
      var modal = document.getElementById(id);
      if(modal){
        var backdrop = document.querySelector('.modal-backdrop');
        if(!backdrop){
          backdrop = document.createElement('div');
          backdrop.className = 'modal-backdrop';
          document.body.appendChild(backdrop);
        }
        backdrop.innerHTML = '<div class="modal" role="dialog">' + modal.innerHTML + '<div style="text-align:right;margin-top:12px"><button class="btn close-modal">Close</button></div></div>';
        backdrop.style.display = 'flex';
        backdrop.querySelector('.close-modal').addEventListener('click', function(){ backdrop.style.display='none'; backdrop.innerHTML=''; });
      }
    });
  });

  // Close modal on backdrop click
  document.addEventListener('click', function(e){
    if(e.target.classList && e.target.classList.contains('modal-backdrop')){
      e.target.style.display = 'none';
      e.target.innerHTML = '';
    }
  });

  // Accordion
  document.querySelectorAll('.accordion .question').forEach(function(q){
    q.addEventListener('click', function(){
      var a = q.nextElementSibling;
      if(!a) return;
      if(a.style.display === 'block'){ a.style.display = 'none'; }
      else { a.style.display = 'block'; }
    });
  });

  // Trainer card detail popup (delegate)
  document.addEventListener('click', function(e){
    var t = e.target.closest('.trainer-card');
    if(t && t.dataset && t.dataset.detail){
      var detail = t.dataset.detail;
      var backdrop = document.querySelector('.modal-backdrop') || document.createElement('div');
      backdrop.className = 'modal-backdrop';
      document.body.appendChild(backdrop);
      backdrop.innerHTML = '<div class="modal">' + detail + '<div style="text-align:right;margin-top:12px"><button class="btn close-modal">Close</button></div></div>';
      backdrop.style.display = 'flex';
      backdrop.querySelector('.close-modal').addEventListener('click', function(){ backdrop.style.display='none'; backdrop.innerHTML=''; });
    }
  });

});
