import Home from './pages/Home'
import NotFound from './pages/NotFound'
import Countries from './pages/Countries'
import Content from './pages/Content'
import Menu from './components/Menu'
import Footer from './components/Footer'
import SignIn from './components/SignIn'
import { Routes, Route } from 'react-router-dom'
import { useState, useEffect } from 'react'
import {
  BrowserRouter as Router,
  Routes,
  Route,
  useRoutes,
} from 'react-router-dom';
 
 
/**
 * App
 *
 * This will show a menu above each page 
 *  
 * @author Ines Rita
 */
function App() {

  const [signedIn, setSignedIn] = useState(false)
 
  return (
    <>
   <SignIn 
      signedIn={signedIn} 
      setSignedIn={setSignedIn}
    />
      <Menu />
      <div class="border-8 border-white	 ...">
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/countries" element={<Countries signedIn={signedIn} setSignedIn={setSignedIn} />} />
        <Route path="/content" element={<Content signedIn={signedIn} setSignedIn={setSignedIn} />} />
        <Route path="/*" element={<NotFound />} />
      </Routes>
      </div>
      <Footer />
    </>
   
  )
}
 
export default App