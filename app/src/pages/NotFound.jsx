import Pic from './kostiantyn-li-Fi_nhg5itCw-unsplash.jpg'
/**
 * Not found page
 * 
 * This page will apear when trying to access an unrecognized or non existent page 
 * 
 * @author Ines Rita
 */
function NotFound() {
    return (
        <>      
        <img class="h-auto max-w-xl" src={Pic} alt="image description"/>

            <p>Not Found</p>
        </>
    )
}
 
export default NotFound
 