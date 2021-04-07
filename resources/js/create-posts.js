
  let openmodal = document.querySelectorAll('.modal-open');
  for (const modal of openmodal) {
    modal.addEventListener('click', function(event){
      event.preventDefault();
      toggleModal();
    });
  }
  
  const overlay = document.querySelector('.modal-overlay');
  if(overlay) {
    overlay.addEventListener('click', toggleModal);

    let closemodal = document.querySelectorAll('.modal-close');
    for (const modal of closemodal) {
      modal.addEventListener('click', toggleModal);
    }
  }
  
  document.onkeydown = function(evt) {
    evt = evt || window.event;
    let isEscape = false;
    if ("key" in evt) {
      isEscape = (evt.key === "Escape" || evt.key === "Esc")
    } else {
      isEscape = (evt.keyCode === 27);
    }
    if (isEscape && document.body.classList.contains('modal-active')) {
      toggleModal();
    }
  };
  
  
  function toggleModal () {
    const body = document.querySelector('body');
    const modal = document.querySelector('.modal');
    modal.classList.toggle('opacity-0');
    modal.classList.toggle('pointer-events-none');
    body.classList.toggle('modal-active');
  }