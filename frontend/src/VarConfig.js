import axios from 'axios';
const config = {
    headers: { 'Content-Type': 'application/json',
                   'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU3NTQ1Mjk3NSwiZXhwIjoxNTc1NTM5Mzc1LCJuYmYiOjE1NzU0NTI5NzUsImp0aSI6ImYzSFJiTWNEc3Q4bmVoWWwiLCJzdWIiOjMsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.SaQbmR1CpugSrgtt6p9nYRldUsGczDuYqYBQQZ14wG0' 
               },
     url: 'http://localhost:8000/api/'
   
}

export default config

/**
const requestAxio =(method,url,data,succesFunc,errorFunc) => {

   axios({
    method: method,
    headers: { 'Content-Type': 'application/json',
                   'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU3NTM2NTI4NCwiZXhwIjoxNTc1NDUxNjg0LCJuYmYiOjE1NzUzNjUyODQsImp0aSI6Ilo2bHdGTVpMaXFNcjBTN1MiLCJzdWIiOjMsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.fZIPoEY3e9B0KEnXRSkG9Ch5kBGdcCTArFPWZTuPHl8' 
               },
    url:  'http://localhost:8000/api/' + url,
    data :data
    })
    .then(function (response) {
      
    });

}
*/
    
 


    