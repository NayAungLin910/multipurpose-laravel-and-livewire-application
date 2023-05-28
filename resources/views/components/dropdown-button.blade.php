@section('style-component')
    <style>
        .normal-button {
            background-color: transparent;
            border: 0;
            margin: 0;
            padding: 0;
        }

        /* custom dropwon-button style */
        .dropdown-button {
            min-width: 15rem;
            position: relative;
            margin: 2rem;
        }

        .dropdown-button * {
            box-sizing: border-box;
        }

        .select {
            background-color: lightgrey;
            color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px grey solid;
            border-radius: 0.75rem;
            padding: 0.75rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        /* Clicked styles which will be added late in js*/
        .select-clicked {
            border: 2px lightseagreen solid;
            box-shadow: 0 0 2rem lightseagreen;
        }

        .select:hover {
            background: lightblue;
        }

        .caret {
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid white;
            transition: 0.3s;
        }

        /* Rotated .caret style */
        .caret-rotate {
            transform: rotate(180deg);
        }

        .menu {
            list-style: none;
            padding: 0.2rem 0.5rem;
            background: lightgrey;
            border: 1px grey solid;
            box-shadow: 0 0.5rem 1rem lightseagreen;
            border-radius: 0.75rem;
            color: black;
            position: absolute;
            top: 3rem;
            left: 50%;
            width: 100%;
            transform: translateX(-50%);
            opacity: 0;
            display: none;
            transition: 0.2s;
            z-index: 1;
        }

        .menu li {
            padding: 0.7rem 0.5rem;
            margin: 0.3rem 0;
            border-radius: 0.5rem;
            cursor: pointer;
        }

        .menu li:hover {
            background: lightblue;
        }

        /* Active style of active element will beadded on js*/
        .active {
            background: grey;
            color: white;
        }

        /*Opened menu style*/
        .menu-open {
            display: block;
            opacity: 1;
        }
    </style>
@endsection

<div class="dropdown-button" {{ $attributes }}>
    <div class="select">
        <span class="selected">Actions</span>
        <div class="caret"></div>
    </div>
    <ul class="menu">
        <li wire:click.prevent="deleteSelectedRows">Delete Selected</li>
        <li wire:click.prevent="markAllAsSchedule">Mark as a Schedule</li>
        <li wire:click.prevent="markAllAsClosed">Mark as Closed</li>
    </ul>
</div>

@section('js-component')
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
@endsection
