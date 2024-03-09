import { Link } from 'react-router-dom';
import { useState, useEffect } from 'react'
import { useRef } from 'react'
/**
 * Sign In component
 * 
 * This is allows for the section on top of every page to input sign in details, username and password and sign user in
 * 
 * @author Ines Rita
 */
function SignIn(props) {
    const [username, setUsername] = useState("")
    const [password, setPassword] = useState("")
    const [signInError, setSignInError] = useState(false)

    useEffect(
       () => {
        if (localStorage.getItem('token')) {
          props.setSignedIn(true);
        }
      }, []
    )
 
    const signIn = () => {
        const encodedString = btoa(username + ':' + password)

        fetch('https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/token',
        {
            method: 'GET',
            headers: new Headers( { "Authorization": "Basic " + encodedString })
          }
        )
        .then(response => {
            if(response.status === 200) {
                props.setSignedIn(true);
                setSignInError(false);
            }else{
                setSignInError(true);
            }
            return response.json()
        })
        .then(data => {
            if (data.token) {
              localStorage.setItem('token', data.token)
            }
        })
        .then(response => {
          if ((!response.status === 200) || (!response.status === 204)) {
              props.setSignedIn(false)
              return [] 
          }
          return response.json()
      })
        .catch(error => console.log(error))
    }

    const signOut = () => {
        props.setSignedIn(false);
        localStorage.removeItem('token');
    }
 
    const handleUsername = (event) => (setUsername(event.target.value))

    const handlePassword = (event) => (setPassword(event.target.value))

    const bgColour = (signInError) ? " bg-red-200" : " bg-slate-100"
    

    return (
      <div className='bg-slate-800 p-2 text-md text-right'>
          { !props.signedIn && <div>
              <input 
                type="text" 
                placeholder='username' 
                className={'p-1 mx-2 rounded-md' + bgColour}
                value={username}
                onChange={handleUsername}
              />
              <input 
                type="password" 
                placeholder='password' 
                className={'p-1 mx-2 rounded-md' + bgColour}
                value={password}
                onChange={handlePassword}
              />
              <input 
                type="submit" 
                value='Sign In' 
                className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                onClick={signIn}
              />
          </div>
          }
          { props.signedIn && <div>
              <input 
                type="submit" 
                value='Sign Out' 
                className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                onClick={signOut}
              />
          </div>
          }
      </div>
  )
}
 
export default SignIn

 