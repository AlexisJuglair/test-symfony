window.onload = () =>
{
    let active = document.querySelectorAll(".active-switch");

    for (let a of active) 
    {
        a.addEventListener("click", function()
        {
            let ajax = new XMLHttpRequest();
            let id = a.getAttribute("data-id");
           
            ajax.open("GET", "/admin/user/active/"+id);

            ajax.onreadystatechange = function () 
            {
                if(ajax.readyState === 4) 
                {
                    if (ajax.status === 200)
                    {
                        console.log(ajax.responseText);
                    }
                }
            };

           ajax.send();
        })
    }
}