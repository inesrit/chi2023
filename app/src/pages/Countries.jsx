import { useEffect, useState } from 'react'
/**
 * Countries page
 * 
 * This page will show all countries and allows to search for one
 * 
 * @author Ines Rita
 */ 
 
function Country(props) {
    const [visible, setVisible] = useState(false)
 
   // country listing and results
    return (
        
        <section>
            <li class="w-full border-b-2 border-neutral-100 border-opacity-100 py-4 dark:border-opacity-50">
      <div class="flex items-center space-x-4 rtl:space-x-reverse">
         <div class="flex-shrink-0">
         </div>
         <div class="flex-1 min-w-0">
               <h2 class="text-sm font-medium text-gray-900 truncate dark:text-white" onClick={() => setVisible( visible => !visible )}>{props.country.country}</h2>

            {visible && <p class="text-sm text-gray-500 truncate dark:text-gray-400">{props.country.city}</p>}
         </div>
      </div>
   </li>
        </section>
    )
}
 
 
function Countries() {
 
 
    const [countries, setCountry] = useState([])
    const [search, setSearch] = useState('')
 
 
    useEffect( () => {
        fetchData()
    },[])
 
 
    const handleResponse = (response) => {
        if (response.status === 200) {
            return response.json()
        } else {
            throw new Error("invalid response: " + response.status)
        }
    }
     
    const handleJSON = (json) => {
        if (json.constructor === Array) {
            console.log(json)
            setCountry(json)
        } else {
            throw new Error("invalid JSON: " + json)
        }
    }
     
    const fetchData = () => { 
        fetch('https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/country')
        .then( response => handleResponse(response) )
        .then( json => handleJSON(json) )
        .catch( err => { console.log(err.message) })
    }
 
 
    // function used for filtering country    
    const searchCountry = (country) => {
        const foundInTitle = country.country.toLowerCase().includes(search.toLowerCase())
        const foundInDescription = country.country.toLowerCase().includes(search.toLowerCase())
        return foundInTitle || foundInDescription
    }
 
 
    // Add a filter to the map function
    // The key has been forced to be unique to each country to avoid the 
    // description remaining visible when the details change
    const countryJSX = countries.filter(searchCountry).map( 
        (country, i) => <Country key={i + country} count={i} country={country} /> 
    ) 
 
 
    // update state when the search input changes
    const handleSearch = (event) => {
        setSearch(event.target.value)
    }
 
    // country heading
    // country search bar styling
    return (
        <>
        <ul className="divide-y divide-slate-100">
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Countries</h1>         
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        </div>
        <input type="text" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required value={search} onChange={handleSearch} />
        {countryJSX}
     </div>
            </ul>
        </>
    )
}
 
export default Countries




























