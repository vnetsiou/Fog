const MyBaseUrl = "localhost:8080";
const MyKCUrl = "localhost:8182";


function decodeJwt(jwtToken) {
  const base64Url = jwtToken.split('.')[1]; // Get the payload part of the JWT
  const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/'); // Replace Base64 URL encoding characters
  const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join('')); // Decode Base64 and handle URI component encoding

  return JSON.parse(jsonPayload);
}

//Login User
/*
async function Login(e){
  //prevent reload page onsubmit
  e.preventDefault()
  //get user username
  const getUsernameLogin = document.getElementById("username").value;
  //get user password
  const getPasswordLogin = document.getElementById("password").value;

  try {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

    var urlencoded = new URLSearchParams();
    urlencoded.append("username", getUsernameLogin);
    urlencoded.append("password", getPasswordLogin);
    urlencoded.append("client_id", "frontend-app");
    urlencoded.append("client_secret", "YjQNvYXpWoPwEGQH84twDegZupqKXp1l");
    urlencoded.append("grant_type", "password");

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: urlencoded,
      redirect: 'follow'
    };

    const response = await fetch("http://"+MyKCUrl+"/auth/realms/e-shop/protocol/openid-connect/token", requestOptions)
    if(response.ok){
      const login = await response.json()
      const token = login.access_token
      
      //store in localstorage username, email, role (customer, seller) and refresh_token
      const decodeToken = await decodeJwt(token)

      const username = decodeToken.preferred_username;
      const email = decodeToken.email;
      const email_verified = decodeToken.email_verified;
      const user_id = decodeToken.sub;
      const refresh_token = login.refresh_token;
      var role = decodeToken.realm_access.roles;



      if(role.indexOf("customer"))role = "customer";
      else if(role.indexOf("seller"))role = "seller";
      else role = "";

      if(email_verified == true){

        localStorage.setItem("username", username)
        localStorage.setItem("email", email)
        localStorage.setItem("role", role)
        localStorage.setItem("user_id", user_id)
        localStorage.setItem("refresh_token", refresh_token)
        

        $("#loginerror").html("Login Success");
        $("#exampleModal").show();
        $("#exampleModal").addClass("show");
        setTimeout(()=>{
          window.location.href = "http://"+MyBaseUrl+"/index.php"
        },2000)
    
      }
      else{

        
        localStorage.setItem("username", username)
        localStorage.setItem("email", email)
        localStorage.setItem("role", role)
        localStorage.setItem("user_id", user_id)
        localStorage.setItem("refresh_token", refresh_token)

        $("#loginerror").html("This email is not verified yet");
        $("#exampleModal").show();
        $("#exampleModal").addClass("show");

        
      }
      


      //clear localStorage
      // localStorage.clear()
    }else{
      const err = await response.json()
      const resp = err.access_token
      const ERROR = resp.error_description;
        $("#loginerror").html(ERROR);
        $("#exampleModal").show();
        $("#exampleModal").addClass("show");
        setTimeout(()=>{
          $("#exampleModal").hide();
        },2000)
      console.log(err) 
    }

  } catch (error) {
    console.log(error)
  }
  return false
}
*/
async function Register(e) {
  
  
  //prevent reload page onsubmit
  e.preventDefault()

  
  //from register form get all data for register a user
  const getUsername = document.getElementById("register-username").value;
  const getEmail = document.getElementById("register-email").value;
  const getPassword = document.getElementById("register-password").value;
  const getRole = document.getElementById("select-role").value;

  try {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

    var urlencoded = new URLSearchParams();
    urlencoded.append("grant_type", "client_credentials");
    urlencoded.append("client_id", "admin-cli");
    urlencoded.append("client_secret", "we0EbOv5s0EzxGo0ZyLwy2UX4gyvxpun");

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: urlencoded,
      redirect: 'follow'
    };

    //get admin access token
    const first_response = await fetch("http://"+MyKCUrl+"/auth/realms/master/protocol/openid-connect/token", requestOptions)
      
    if(first_response.ok){
      const adminAccessToken = await first_response.json();
      const token = adminAccessToken.access_token

      var myHeaders = new Headers();
      myHeaders.append("Content-Type", "application/json");
      myHeaders.append("Authorization", "Bearer "+token);

      var raw = JSON.stringify({
        "email": getEmail,
        "enabled": "true",
        "username": getUsername,
        "attributes": {
          "client_id": "client-front"
          //"client_id": "frontend-app"
        },
        "groups": [
          getRole
        ],
        "credentials": [
          {
            "type": "password",
            "value": getPassword,
            "temporary": false
          }
        ]
      });

    var registerOptions = {
      method: 'POST',
      headers: myHeaders,
      body: raw,
      redirect: 'follow'
    };

    const registerUser =  await fetch("http://"+MyKCUrl+"/auth/admin/realms/e-shop/users", registerOptions)
    
    if(registerUser.ok){
      alert('register user is ok')

      setTimeout(()=>{
        window.location.href = "http://"+MyBaseUrl+"/login.html"
      },2000)
      
    }else{
      const err = await registerUser.json()
      console.log(err)
    }

    }else{
      const err = await first_response.json();
      console.log(err);
    }
    
  } catch (error) {
    console.log(error)
  }

  return false
}



async function Login(e){
  //prevent reload page onsubmit
  e.preventDefault()
  //get user username
  const getUsernameLogin = document.getElementById("username").value;
  //get user password
  const getPasswordLogin = document.getElementById("password").value;

  try {
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

    var urlencoded = new URLSearchParams();
    urlencoded.append("username", getUsernameLogin);
    urlencoded.append("password", getPasswordLogin);
    urlencoded.append("client_id", "frontend-app");
    urlencoded.append("client_secret", "YjQNvYXpWoPwEGQH84twDegZupqKXp1l");
    urlencoded.append("grant_type", "password");

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: urlencoded,
      redirect: 'follow'
    };

    const response = await fetch("http://"+MyKCUrl+"/auth/realms/e-shop/protocol/openid-connect/token", requestOptions)
    if(response.ok){
      const login = await response.json()
      const token = login.access_token
      
      //store in localstorage username, email, role (customer, seller) and refresh_token
      const decodeToken = await decodeJwt(token)

      const username = decodeToken.preferred_username;
      const email = decodeToken.email;
      const email_verified = decodeToken.email_verified;
      const user_id = decodeToken.sub;
      const refresh_token = login.refresh_token;
      var my_role = decodeToken.realm_access.roles;


      if(my_role.indexOf("customer")>=0)my_role = "customer";
      else if(my_role.indexOf("seller")>=0)my_role = "seller";
      else my_role = "";

      if(email_verified == true){

        localStorage.setItem("username", username)
        localStorage.setItem("email", email)
        localStorage.setItem("role", my_role)
        localStorage.setItem("user_id", user_id)
        localStorage.setItem("refresh_token", refresh_token)

        SetUserSessionId(user_id, 1, my_role);
        
        $("#loginerror").html("Login Success");
        $("#exampleModal").show();
        $("#exampleModal").addClass("show");
        
        setTimeout(()=>{
          window.location.href = "http://"+MyBaseUrl+"/index.php"
        },2000)
      }
      else{
        
        localStorage.setItem("username", username)
        localStorage.setItem("email", email)
        localStorage.setItem("role", my_role)
        localStorage.setItem("user_id", user_id)
        localStorage.setItem("refresh_token", refresh_token)
        SetUserSessionId(user_id, 1, my_role);

        

        $("#loginerror").html("Το email αυτό δεν έχει γίνει verified ακόμα");
        $("#exampleModal").show();
        $("#exampleModal").addClass("show");
        
      }
    }else{
      const err = await response.json()
      const ERROR = err.error_description;
        $("#loginerror").html(ERROR);
        $("#exampleModal").show();
        $("#exampleModal").addClass("show");
        setTimeout(()=>{
          $("#exampleModal").hide();
        },2000)
      console.log(err) 
    }

  } catch (error) {
    console.log(error)
  }
  return false
}

function SetUserSessionId(user_id, set, role){
    $.ajax({
        type: 'GET',
        url: 'Ajax_SetSessionId.php?sid=' + user_id + "&set=" + set + "&role=" + role, 
        dataType: 'html',
        contentType: 'application/json',
        success: function(response) {
        },
        error: function(error) {
        }
    });

}

$(function(){
  var user_id = localStorage.getItem("user_id");
  if(user_id != "" && user_id != undefined){
    window.location.href = "http://"+MyBaseUrl+"/index.php"
  }

})