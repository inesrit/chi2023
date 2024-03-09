import { useEffect, useState } from 'react'
import Note from './../components/Note'
 
 /**
 * Content page
 * 
 * This page will show all the content and allows to expand information about them, search for a specifict content title or abstract information, and type, and navigation between pages
 * 
 * @author Ines Rita
 */
function Search(props) {
    return (
        <input type="text" value={props.search} onChange={props.handleSearch} />
    )
}
 
 
function Contents(props) {
    const [visible, setVisible] = useState(false)
 
    return (
        <section>
        <li class="w-full border-b-2 border-neutral-100 border-opacity-100 py-4 dark:border-opacity-50">
  <div class="flex items-center space-x-4 rtl:space-x-reverse">
     <div class="flex-shrink-0">
     </div>
     <div class="flex-1 min-w-0">
           <h2 class="text-sm font-medium text-gray-900 truncate dark:text-white" onClick={() => setVisible( visible => !visible )}>{props.content.title}</h2>

        {visible && <p class="text-sm text-gray-500 truncate dark:text-gray-400">{props.content.abstract}</p>}
        <p class="text-sm font-medium text-gray-900 truncate dark:text-white"> ID: {props.content.id}</p>
        <p class="text-sm font-medium text-gray-900 truncate dark:text-white"> Type: {props.content.content_type}</p>
        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Author: {props.content.author_name}</p>
        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Country: {props.content.author_affiliation_country}</p>
        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Instituition: {props.content.author_affiliation_institution}</p>
        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">Award: {props.content.has_award}</p>
       
        {visible && <Note content={props.content.id} setSignedIn = {props.setSignedIn}/>}
     </div>
  </div>
</li>
    </section>
    )

}
 
 
function Content(props) {
 

    const [contents, setContents] = useState([])
    const [page, setPage] = useState(1)
    const [search, setSearch] = useState('')
    const [selectType, setSelectType] = useState('')
 
 
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
            setContents(json)
        } else {
            throw new Error("invalid JSON: " + json)
        }
    }
     
    const fetchData = () => { 
        fetch('https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/content')
        .then( response => handleResponse(response) )
        .then( json => handleJSON(json) )
        .catch( err => { console.log(err.message) })
    }
 

    // function used for filtering content    
    const searchContents = (content) => {
        const foundInTitle = content.title.toLowerCase().includes(search.toLowerCase())
             return foundInTitle
    }
 
 
    const selectContentType = (content) => {
        if (selectType === '') {
            return true
        } else {
            return content.content_type === selectType
        }
    }
 
  
            // Work out where to slice the array
            const startOfPage = (page - 1) * 20
            const endOfPage = startOfPage + 20

    // We have three filters, so we need to chain them together
    const contentJSX = contents
        .filter(selectContentType)
        .filter(searchContents)
        .slice(startOfPage,endOfPage)
        .map( 
            (content, i) => <Contents key={i + content.title} count={i} content={content} /> 
        ) 
 
 
    // update state when the search input changes
    const handleSearch = (event) => {
        setSearch(event.target.value)
    }
 
 
    const handleSelectType = (event) => {
        setSelectType(event.target.value)
    }
 

 // Work out if we're on the first or last page
 const lastPage = (contentJSX.length === 0)
 const firstPage = (page <= 1)


 // Functions to change the page
 const nextPage = () => {
     if (lastPage === false) {
         setPage( page => page + 1 )
     }
 }


 // Functions to change the page
 const previousPage = () => {
     if (firstPage === false) {
         setPage( page => page - 1 )
     }
 }


 // Disable the buttons if we're on the first or last page
 const prevDisabled = (firstPage) ? 'disabled' : ''
 const nextDisabled = (lastPage) ? 'disabled' : ''



    return (
        <>
            <ul className="divide-y divide-slate-100">
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Content</h1>          
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        </div>
        <input type="text" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required value={search} onChange={handleSearch} />
     </div>
            </ul>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Type
                    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value={selectType} onChange={handleSelectType}>
                        <option value="">Any</option>
                        <option value="Course">Course</option>
                        <option value="Demo">Demo</option>
                        <option value="Doctoral Consortium">Doctoral Consortium</option>
                        <option value="Event">Event</option>
                        <option value="Late-Breaking Work">Late-Breaking Work</option>
                        <option value="Paper">Paper</option>
                        <option value="Poster">Poster</option>
                        <option value="Work-in-Progress">Work-in-Progress</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Case Study">Case Study</option>
                        <option value="Panel">Panel</option>
                        <option value="AltCHI">AltCHI</option>
                        <option value="SIG">SIG</option>
                        <option value="Keynote">Keynote</option>
                        <option value="Interactivity">Interactivity</option>
                        <option value="Journal">Journal</option>
                        <option value="Symposia">Symposia</option>
                        <option value="Competitions">Competitions</option>
                    </select>
                </label>
            </div>
            {contentJSX}
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onClick={previousPage} disabled={prevDisabled}>Previous</button>
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onClick={nextPage} disabled={nextDisabled}>Next</button>
        </>
    )
}




 
export default Content












