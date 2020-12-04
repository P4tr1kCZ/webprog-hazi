$(document).ready(function() {

    $.ajax({
        method: "GET",
        url: "/rest/index.php/users",
        success: (res) => {
            $("#userstable").empty();
            res.forEach(user => {
                console.log(user);
                $("#userstable").append(
                    `<tr>
                        <th scope="row">${user.id}</th>
                        <td>${user.username}</td>
                        <td>${user.role}</td>
                    </tr>`
                );
            });

            var pretty = JSON.stringify(res, undefined, 4);
            $("#jsonresult").val(pretty);
        }
    })
});