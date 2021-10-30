window.onload = () =>
{

   let admin = document.getElementById("user_roles_0");
   let user = document.getElementById("user_roles_1");
   let check = document.querySelectorAll(".form-check-input");

   console.log("test");
   for (let c of check) 
   {
       console.log("test2");
       c.addEventListener("change", function()
       {
           console.log("test3");
           console.log(c.checked);
           console.log(c.querySelector("#user_roles_0"));

           if (c.checked )
           {
                console.log(c.checked);
                if(admin.checked) 
                {
                    user.checked = false;
                }
           }
       })
   }
}