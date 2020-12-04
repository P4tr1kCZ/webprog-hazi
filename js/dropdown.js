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
                                    $('<li>', {'class': 'dropdown-toggle dropdown-item'}).attr('id', 'multiple').append(
                                        $('<a>').html(element.name)
                                    )
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

$(document).ready(function() {
    $(document).on('click', '.dropdown-menu', function (e) {
      e.stopPropagation();
    });

    if ($(window).width() < 992) {
	  	$('.dropdown-menu a').click(function(e){
	  		e.preventDefault();
	        if($(this).next('.submenu').length){
	        	$(this).next('.submenu').toggle();
	        }
	        $('.dropdown').on('hide.bs.dropdown', function () {
			   $(this).find('.submenu').hide();
			})
	  	});
	}	
});

