Work by:
Ines Rita
Student ID: 20022261

Endpoints 

Part 1:
Endpoint 1
GET /Developer
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/developer

Endpoint 2
GET /Country
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/country
Parameters:
- country:  to search for a country by name, case insensitive - e.g: (country?country=canada)
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/country?country=canada


Endpoint 3
GET /Preview
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/preview
Parameters:
- limit:  limit number of results returned- (e.g: preview?limit=2)
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/preview?limit=2



Endpoint 4
GET /AuthorAndAffiliation
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/author-and-affiliation
Parameters:
- content:  return only results of that content id- (e.g: author-and-affiliation?content=95692)
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/author-and-affiliation?content=95692
- country:  return only results of that country - (e.g: author-and-affiliation?country=australia)
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/author-and-affiliation?country=australia



Endpoint 5
GET /Content
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/content
Parameters:
- page:  return only 20 results per page- (e.g: content?page=2)
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/author-and-affiliation?content=95692
- type:  return only results of that content type - (e.g: content?type=course)
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/content?type=course
- type and page:  return only results of that content type and results are limited to the page number - (e.g: content?type=course&page=2)
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/content?type=course&page=2



Endpoint 6
GET /Token
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/token
Parameters:
Authorization headers - Basic Auth:
- Username (e.g: john@example.com)
- Password: (e.g: examplePassword1234)
Returns JWT token:
{
  "id": 1,
  "iat": 1703799177,
  "exp": 1703800977,
  "iss": "w20022261"
}


Endpoint 7
GET /Note
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/note
Parameters:
Authorization headers - Bearer Token:
- token: (e.g: eyJ0eXAiOiJK...)
Returns all notes by the user signed in
POST /Note
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/note
Parameters:
Authorization headers - Bearer Token:
- token: (e.g: eyJ0eXAiOiJK...)
Body - FormData:
- content_id : (eg: content_id = 95696)
- note: (e.g: note = this is the note for 95696)
Adds new note or updates the note of the content_id specified in form data with the note also specified in form data.
DELETE /Note
https://w20022261.nuwebspace.co.uk/kf6012/assessment/api/note
Parameters :
- content_id:  (e.g: note?content_id=95696)
Deletes note associated with content_id specified in params


Part 2:

Page 1
Home/ Landing Page:
https://w20022261.nuwebspace.co.uk/kf6012/assessment/app/



Page 2 and 3 are accessible through the home page/ landing page.
Below is how the url would look but accessing these urls directly will not work. Needs to be accessed by clicking through the option on the navbar at homepage: https://w20022261.nuwebspace.co.uk/kf6012/assessment/app/

Page 2
Countries:
https://w20022261.nuwebspace.co.uk/kf6012/assessment/app/countries


Page 3
Content:
https://w20022261.nuwebspace.co.uk/kf6012/assessment/app/content

Feature 1
Sign in/ Sign Out
Found in all pages at the top for inputting username and password
Button to sign in, and after that sign out

Feature 2
Notes
/content
Found inside content page when clicking on a content
Buttons to save note and delete note

Obs:
After signing in, to see the note for the user, refresh the page and go back to the landing home page: https://w20022261.nuwebspace.co.uk/kf6012/assessment/app/




