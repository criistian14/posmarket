document.addEventListener('DOMContentLoaded', () => {

    // |---------- Materialize ----------|

    // Inicializar Side Nav de materialize
    const sideNavMaterializeElements = document.querySelectorAll('.sidenav');
    if (sideNavMaterializeElements) {
        let intancesSideNavElement = M.Sidenav.init(sideNavMaterializeElements);

        // Abrir SideNav Categorias con el boton
        let botonAbrirSideNavCategoriasElement = document.getElementById('abrirSidenavCategorias');

        if (botonAbrirSideNavCategoriasElement) {
            botonAbrirSideNavCategoriasElement.addEventListener('click', () => {
                intancesSideNavElement[0].open();
            });
        }

        // Abrir SideNav Usuario con el boton
        let botonAbrirSideNavUsuarioElement = document.getElementById('abrirSidenavUsuario');

        if (botonAbrirSideNavUsuarioElement) {
            botonAbrirSideNavUsuarioElement.addEventListener('click', () => {
                intancesSideNavElement[0].open();
            });
        }
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





    // Pintar el color en el sidenav admin
    const slideOutElement = document.getElementById('slide-out');
    if (slideOutElement) {
        let liElements = [...slideOutElement.children];


        liElements.map( (li) => {
            let a = li.firstElementChild;
            let url = location.href.split('/')[4];

            if ( a.href.includes(url) ) {
                a.classList.add('menu-active');
            }

        });

    }

    // Pintar el color en el sidenav categorias
    const sidenavCategoriasElement = document.getElementById('sidenavCategorias');
    if (sidenavCategoriasElement) {
        let liElements = [...sidenavCategoriasElement.children];

        liElements.map( (li) => {

            if (li.tagName == 'LI') {

                let a = li.firstElementChild;
                let url = location.href.split('/')[5];

                if ( a.href.includes(url) ) {
                    a.classList.add('menu-active');
                }
            }
        });

    }



    abrirSidenavUsuario




    // Buscardor del index
    const buscarProductoNavElement = document.getElementById('buscarProductoNav');
    if (buscarProductoNavElement) {
        buscarProductoNavElement.addEventListener('keyup', (event) => {
            if (event.key == 'Enter') {
                let busqueda = buscarProductoNavElement.value.split(' ').join('-').toLowerCase();

                location.href = `${rutaApp}/buscar/${busqueda}`;
            }
        });
    }



});
