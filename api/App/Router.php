<?php
  /**
 * ROuter Class
 *
 * This class specifies all the routes for each api endpoint
 *
 * @author Ines Rita
 * @package App
 */
namespace App;
 
abstract class Router
{
    public static function routeRequest()
    {
        try
        {
            switch (Request::endpointName()) {
                case '/':
                case '/home':
                case '/home/':
                    $endpoint = new EndpointController\Home();
                     break;
                case '/country':
                case '/country/':
                    $endpoint = new EndpointController\Country();
                    break;
                case '/preview':
                case '/preview/':
                    $endpoint = new EndpointController\Preview();
                    break;
                case '/developer':
                case '/developer/':
                    $endpoint = new EndpointController\Developer();
                    break;
                case '/author-and-affiliation':
                case '/author-and-affiliation/':
                    $endpoint = new EndpointController\AuthorAndAffiliation();
                    break;
                case '/content':
                case '/content/':
                    $endpoint = new EndpointController\Content();
                    break;
                case '/token':
                case '/token/':
                    $endpoint = new EndpointController\Token();
                    break;
                case '/note':
                case '/note/':
                    $endpoint = new EndpointController\Note();
                    break;
                default:
                throw new ClientError(404);
                break; 
            }
        } catch (ClientError $e) {
            $data = ['message' => $e->getMessage()];
            $endpoint = new EndpointController\Endpoint($data);
        }
 
        return $endpoint;
    }
}
