
    window.onload = () => {
        document.querySelector('.name').style.display = 'none';
    }
    const toggler = document.querySelector('#toggler i');
    const aside = document.querySelector('.aside');
    function asideToggle(className) {
        console.log(className)
        aside.classList.toggle('close');
        if (aside.classList.contains('close')) {
            document.querySelector('.name').style.display = 'none';
           
            document.querySelector(className).classList.add('active');
        } else {
            document.querySelector('.name').style.display = 'block';
            document.querySelector(className).classList.remove('active'); 
        }
    };
