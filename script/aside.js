
    window.onload = () => {
        document.querySelector('.expenses-adder').classList.add('active');
        document.querySelector('.name').style.display = 'none';
    }
    const toggler = document.querySelector('#toggler i');
    const aside = document.querySelector('.aside');
    toggler.addEventListener('click', () => {
        aside.classList.toggle('close');
        if (aside.classList.contains('close')) {
            document.querySelector('.name').style.display = 'none';
            document.querySelector('.expenses-adder').classList.add('active');
        } else {
            document.querySelector('.name').style.display = 'block';
            document.querySelector('.expenses-adder').classList.remove('active');
            
        }
    });
