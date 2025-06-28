//login popup
document.addEventListener('DOMContentLoaded', () => {
    const loginButton = document.querySelector('.login_btn');
    const overlay = document.querySelector('#overlay');
    const loginPopup = document.querySelector('#login-popup');
    const closePopupButton = document.querySelector('.close_btn');
  
    loginButton.addEventListener('click', () => {
        overlay.style.display = 'block';
        loginPopup.style.display = 'block';
    });
  
    overlay.addEventListener('click', () => {
        overlay.style.display = 'none';
        loginPopup.style.display = 'none';
    });
  
    closePopupButton.addEventListener('click', () => {
        overlay.style.display = 'none';
        loginPopup.style.display = 'none';
    });
  
    // Loading animation for links
    const links = document.querySelectorAll('a');
    const loadingAnimation = document.getElementById('loading-animation');
  
    links.forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            loadingAnimation.style.display = 'flex';
            setTimeout(() => {
                window.location.href = link.href;
            }, 500);
        });
    });
  });
  
  // Navigation menu functionality
  var navLinks = document.getElementById("navLinks");
  
  function showMenu() {
    navLinks.style.right = "0";
  }
  
  function hideMenu() {
    navLinks.style.right = "-200px";
  }
  