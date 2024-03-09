import { Link } from 'react-router-dom';
import { useState, useEffect } from 'react'
import { useRef } from 'react'
/**
 * Note component
 * 
 * This will show all notes underneath each content and allow manipulation
 * 
 * @author Ines Rita
 */
function Note(props) {

    const [notes, setNotes] = useState([])

    useEffect( () => {
        getNote()
    },[])


    const handleNote = (data) =>{
        if (data.constructor === Array) {
            setNotes(data)
        } else {
            throw new Error("invalid JSON: " + data)
        }
    }
    
    var note = "";
    const obj =JSON.stringify(notes);
            var stringify = JSON.parse(obj);
            for (var i = 0; i < stringify.length; i++) {
                note=stringify[i]['note'];
            }
    
    //method that will fetch all the notes for the signed in user
    const getNote = () => {
        fetch('https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/note'+ '?content_id='+ props.content,
          {
            method: 'GET',
            headers: new Headers({ "Authorization": "Bearer "+localStorage.getItem('token') })
          })
         .then(response => response.json())
         .then(data => {handleNote(data) })
         .catch(error => console.log(error))
       }

        //method to update or add a new note to a content
       const updateNote = (note) => {

        let formData = new FormData(); 
        formData.append('content_id', props.content);   //append the values with key, value pair
        formData.append('note', note);

        fetch('https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/note',
          {
            method: 'POST',
            headers: new Headers({ "Authorization": "Bearer "+localStorage.getItem('token') }),
            body: formData,
          })
          .then(response => {
            if ((response.status === 200) || (response.status === 204)) {
                getNote();
            }
      })
       }


       //method to delete a note
       const deleteNote = () => {
        fetch('https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/note' + '?content_id=' + props.content,
          {
            method: 'DELETE',
            headers: new Headers({ "Authorization": "Bearer "+localStorage.getItem('token') })
          })
          .then(res => {
            if ((res.status === 200) || (res.status === 204)) {
                getNote();
            }
         })
       }


       const handleChange = (event) => {
        (note=(event.target.value))
       }

    return (
        <div className="flex flex-col p-5">
            <form class="max-w-sm mx-auto">
        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Note</label>
        <textarea 
                placeholder="Leave a note" 
                rows="4" 
                cols="50" 
                maxLength="250" 
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                defaultValue={note}
                onChange={handleChange}          
           />
        </form>
         <input 
                type="submit" 
                value='Save Note' 
                className="max-w-sm mx-auto block mb-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                onClick={() => updateNote(note)}
              />
              <input 
                type="submit" 
                value='Delete Note' 
                className="max-w-sm mx-auto block mb-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                onClick={deleteNote}
              />
        </div>
    )
}
 
export default Note