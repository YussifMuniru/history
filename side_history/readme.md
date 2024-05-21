1. use proper routing for the api
2. create folders in the app folder for the games
   eg. app [-> 5d,3d,fast3...]
3. put your logic into the controller class
4. call the render for each game under perspective route.
   eg.  /api/v1/5d
5. use a chaching library 'redis' to quickly  cache  history data
6. open the index.php. there is an example
7. use **Guzzle HTTP Client** for fast calls for data
 