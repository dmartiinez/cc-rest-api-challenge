# SETUP

The API is setup with Docker. In order to run it you must install [docker](https://www.docker.com/products/docker-desktop)

Once Docker is installed (and is running) on your machine and you have cloned the repository, run `docker-compose up -d` from within the project directory to set up the containers.
While that is being setup, download [Postman](https://www.getpostman.com/downloads/), this is an API Development Environment where you will be able to perform the requests to my API. (There is no need to create an account, there is a very light gray skip link at the bottom of the application window)

# Interacting with API

Once you have Postman up and running you can select what kind of requests you want to perform on the API. The request URL will be `http://localhost:8080/hospitals.php`.

## GET

You can perform this request by simply going to `http://localhost:8080/hospitals.php` and you can add the id and city parameters to the URL to test those results. (the Json Viewer chrome extension prettyfies the output :))

You can also do this in Postman, the GET request should be preselected so just enter the url and hit the blue `Send` button. To enter the query parameters, just enter the key and value in the `Params` tab or add to the URL field.

## POST

Change the Postman dropdown to POST and go to the `Body` tab, choose `raw` and change the dropdown from Test to `JSON`. Now in the test editor enter the entry in JSON format and then hit send.
ex:
```
{
	"name": "Oswego Hospital",
	"city": "Oswego",
	"state": "IL",
	"address": "1234 Hospital Ln"
}
```

## PUT

Follow same steps as Post, change request to PUT and enter the hospital entry you want to update - including the id this time.
ex:
```
{
	"id": 6,
    "name": "Oswego Hospital",
    "city": "Naperville",
    "state": "IL",
    "address": "555 Hospital Ln"
}
```

## DELETE

Change request to DELETE and provide the id of the entry you want removed in JSON format.
ex:
```
{
    "id": 6
}
```
* Note: You can also select the format you want to view the response in. HTML is preselected but you can change this to JSON if you want it to look nicer!. *

# Viewing DB

If you want to check the database as you are making requests, you can do it from the command line! Go to the api's directory and run the command `docker exec -ti mysql_cc mysql -u root -p`. It will prompt you for a password which is `root_pwd`. Then from there you can do
1. `use my_db;`
2. `Select * FROM hospitals;`

after the requests to verify that the correct actions are being taken!


