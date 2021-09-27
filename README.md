# JSON to Database Challenge

## Technologies
1. Laravel v8.x.x
2. MySQL

## Configuration
1. In the `.env` file configure the credentials for db connection
2. Run `php artisan migrate` in the root folder of this repo in your local environtment

## Usage
1. In your browser, please navigate to the route where the project is being hosted (e.g.: `localhost:8080/`).
2. You will find a `type file` input where you can upload the .json file
3. Click the `save` button
The process will start to replicate your json data into the database in the table `client`. It will take a moment to complete. Once completed, you will be prompted with `Data base updated!'` in your browser. 

To upload a new file, just do step 1 once again.