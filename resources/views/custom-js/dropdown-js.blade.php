<script>
    // get all dropdowns from the doc
    const dropdowns = document.querySelectorAll('.dropdown-button');

    // loop through all the dropdown elements
    dropdowns.forEach(dropdown => {
        // get inner elements
        const select = dropdown.querySelector('.select');
        const caret = dropdown.querySelector('.caret');
        const menu = dropdown.querySelector('.menu');
        const options = dropdown.querySelectorAll('.menu li');
        const selected = dropdown.querySelector('.selected');

        /*
            The method is being used to make sure that multiple
            dropdown buttons can work on the same page
        */

        // Add click event listener to select element
        select.addEventListener('click', () => {
            // Add the class select-clicked to the clicked select element
            select.classList.toggle('select-clicked');
            // Add the caret-rotate class to the caret element
            caret.classList.toggle('caret-rotate');
            // Add the open styles to the menu element
            menu.classList.toggle('menu-open');
        })

        // loop through all options
        options.forEach(option => {
            // Add a click event listenr
            option.addEventListener('click', () => {
                // change the select element inner text to the option innertext
                // selected.innerText = option.innerText;
                // remove the select click sytle
                select.classList.remove('select-clicked');
                // remove the caret-rotate class from the caret element
                caret.classList.remove('caret-rotate');
                // remove active classes from all option elements
                options.forEach(option => {
                    option.classList.remove('active');
                });
                // add active class to the option that is clicked
                // option.classList.add('active');
                // close the dropdown
                menu.classList.remove('menu-open');
            })
        })
    })

    // Determine whether the click inside the website is coming from 
    // the dropdown button wire or from outside

    document.addEventListener('click', (event) => {
        dropdowns.forEach(dropdown => {
            let targetElement = event.target;
            do {
                if (targetElement === dropdown) {
                    // this is a click from dropdown
                    return;
                }
                targetElement = targetElement.parentNode;
            } while (targetElement);
            // click from outside
            const menu = dropdown.querySelector('.menu');
            const caret = dropdown.querySelector('.caret');
            // close the menu
            menu.classList.remove('menu-open');
            // rotate the caret
            caret.classList.toggle('caret-rotate');
        });
    })
</script>
