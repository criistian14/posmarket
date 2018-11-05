document.addEventListener('DOMContentLoaded', () => {

    // |---------- Materialize ----------|

    // Inicializar Side Nav de materialize
    const sideNavMaterializeElements = document.querySelectorAll('.sidenav');
    if (sideNavMaterializeElements) {
        let intancesSideNavElement = M.Sidenav.init(sideNavMaterializeElements);

    }

    // Inicializar Drop Down de Materialize
    const dropdownMaterializeElements = document.querySelectorAll('.dropdown-trigger');
    if(dropdownMaterializeElements){

        let instancesDropDownElement = M.Dropdown.init(dropdownMaterializeElements);
    }


    // Inicializar selects de materialize
    const selectsMaterializeElements = document.querySelectorAll('select');
    if (selectsMaterializeElements) {
        let intancesSelectsElement = M.FormSelect.init(selectsMaterializeElements);
    }


    // Inicializar Tabs de materialize
    const tabsMaterializeElements = document.querySelectorAll('.tabs');
    if (tabsMaterializeElements) {
        let intancesSelectsElement = M.Tabs.init(tabsMaterializeElements, { swipeable: false });
    }


    // Inicializar textarea de Materialize
    const textareaDescripcionReporteElement = [...document.querySelectorAll('#textareaDescripcionReporte')];
    if (textareaDescripcionReporteElement) {
        textareaDescripcionReporteElement.map( (textarea) => {
            M.textareaAutoResize(textarea);
        });
    }


    // Inicializar Date Pickers de materialize
    const datepickerMaterializeElements = document.querySelectorAll('.datepicker');
    if (datepickerMaterializeElements) {
        let intancesSelectsElement = M.Datepicker.init(datepickerMaterializeElements, { format: 'yyyy-mm-dd' });
    }





    // Pintar el color en el menu jejej
    const slideOutElement = document.getElementById('slide-out');
    if (slideOutElement) {
        let liElements = [...slideOutElement.children];

        liElements.map( (li) => {
            let a = li.firstElementChild;
            let url = location.href.split('/')[4];

            if ( a.href.includes(url) ) {
                a.classList.add('menu-active');
                console.log(url, a.href);
            }

        });

    }

});
