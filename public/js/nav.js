document.addEventListener('DOMContentLoaded', () => {

  document.addEventListener('scroll', () => {
    const sidenavIndexElement = document.getElementById('sidenav-index');

      if(window.scrollY >= 48){
          // Atrapando el id jiji
          sidenavIndexElement.classList.add('sidenav-append');
          
      }else{

        sidenavIndexElement.classList.remove('sidenav-append');

      }
  });


});
