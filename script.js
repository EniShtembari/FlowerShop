const signUpButton=document.getElementById('signUpButton');
const logInButton = document.getElementById('logInButton');
const logInForm = document.getElementById('login');
const signUpForm = document.getElementById('signup');

signUpButton.addEventListener('click',function(){
    logInForm.style.display="none";
    signUpForm.style.display="block";
})
logInButton.addEventListener('click', function(){
    logInForm.style.display="block";
    signUpForm.style.display="none";
})


