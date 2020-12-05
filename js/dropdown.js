$(document).ready(function() {
    $.ajax({
        method: "GET",
        url:"/rest/index.php/menus/parents",
        success: (res) => {
            $('#dropdownlist').empty();
            res.forEach(element => {
                $.ajax({
                    method: "GET",
                    url: `/rest/index.php/menus/${element.id}/children`,
                    success: (childElements) => {
                        if(childElements.length == 0) {
                            $('#dropdownlist').append(`
                            <li>
                                <form method="POST" action="index.php?controller=${element.controller}&amp;action=${element.action}">
                                    <button type="submit" class="dropdown-item">${element.name}</button>
                                </form>
                            </li>`);
                        } else {
                            $('#dropdownlist').append(
                                    $('<li>', {'class': 'start dropdown-toggle dropdown-item'}).attr('id', 'multiple').append(
                                        $('<a>').html(element.name)
                                    ).on('click', function(e){ 
                                        e.stopPropagation();
                                        if ($(window).width() < 992) {
                                            $(this).children().toggle();
                                            
                                        $('.dropdown').on('hide.bs.dropdown', function () {
                                            $(this).find('.submenu').hide();
                                        })
                                     }
                                })
                            )

                            $("#multiple").append($('<ul>', {'class': 'submenu submenu-left dropdown-menu'}).attr('id', 'apilist'));

                            childElements.forEach(child => {
                                $("#apilist").append(
                                    `<li>
                                    <form method="POST" action="index.php?controller=${child.controller}&amp;action=${child.action}">
                                        <button type="submit" class="dropdown-item">${child.name}</button>
                                    </form>
                                </li>`)
                            })
                        }
                    },
                });
            })
        },
    })
});

