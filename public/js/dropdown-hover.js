document.addEventListener("DOMContentLoaded", function(){
    var dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(function(dropdown){
      dropdown.addEventListener('mouseover', function(event){
        this.querySelector('.dropdown-menu').classList.add('show');
      });
      dropdown.addEventListener('mouseout', function(event){
        this.querySelector('.dropdown-menu').classList.remove('show');
      });
    });
  });

  document.addEventListener("DOMContentLoaded", function() { 
    const myCarouselElement = document.querySelector('#carouselExampleSlidesOnly');
    const carousel = new bootstrap.Carousel(myCarouselElement, {
      interval: 2000,
      touch: true
    });
  });