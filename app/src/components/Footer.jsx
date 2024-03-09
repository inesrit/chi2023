import { Link } from 'react-router-dom';
/**
 * Footer component
 * 
 * This adds the footer information at the bottom of the page
 * 
 * @author Ines Rita
 */
function Footer() {
    return (
        <>
        <footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
    <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">Ines Rita - 2002261 - CourseWork Assignment for KF6012 Web Application Integration, Northumbria University
    </span>
    <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
            <li className="hover:underline me-4 md:me-6"><Link to="/">Home</Link></li>
            <li className="hover:underline me-4 md:me-6"><Link to="/countries">Countries</Link></li>
            <li className="hover:underline me-4 md:me-6"><Link to="/content">Content</Link></li>
 
      </ul>
    </div>
</footer>
        </>
    )
}
 
export default Footer
 