# Website Traffic Tracker

This project is a simple website traffic tracker that monitors unique visits to a web page. It consists of three main components:

- Javascript tracker that clients will add to their websites
- Database storing the visits data
- Simple user interface that displays the number of unique visits per page, for a given time period

## Requirements

For this project, you will need to install:

- Docker
- Docker Compose

## How to set up and run the project

### 1. Clone the repository

First, navigate to the directory where you want to clone this repository. Use the following commands to clone the repository and navigate into it:

```bash
git clone git@github.com:dev-domagojsamardzic/visit-tracker.git
cd visit-tracker
```
### 2. Build and run docker containers

Run the following command to build and start the Docker containers:
```bash
docker compose up -d --build
```
After the containers are running, generate the autoload file using this command:
```bash
docker exec -it tracker-php composer install
```
Alternatively, since there are no dependency packages, you can use:
```bash
docker exec -it tracker-php composer dump-autoload
```

Once the containers are up, you can access the user interface by navigating to:
[http://localhost](http://localhost).


## Project Components

### 1. JS Tracker script

Tracker script is located in the ```cmd``` directory. \
The script is designed to be imported via a CDN into the website you wish to track. This project includes an example implementation. Two example websites, ```website1.html``` and ```website2.html```, are located in the ```public``` directory,
and the script is included in the ```<head>``` tag using the following syntax: \
```<script src="http://localhost/cdn/tracker.js"></script>```

When you visit one of these links:
- [http://localhost/website1.html](http://localhost/website1.html)
- [http://localhost/website2.html](http://localhost/website2.html)

The tracker sends an AJAX request with visitor_id and page_url as parameters to the track.php script. This script processes the request, validates the input parameters, and records a unique visit if necessary.

### 2. MySQL Database

This simple application requires simple database structure. Database contains a single table, named **visits**, which has following columns:

- **page VARCHAR(512)** - URL of the visited page.
- **visitor_id CHAR(10)** - A unique identifier for each visitor. Random 10 char string assigned.
- **date DATE** - date of the recorded visit in format (Y-m-d)

You don’t need to create the database manually. The Docker container handles database creation, user setup, and privilege assignment. \
Additionally, the ```database/migration.sql``` file is responsible for creating the visits table. This file is located in the docker-entrypoint-initdb.d directory, so it is automatically executed when the container is created.

### 3. User Interface (PHP, HTML, CSS)
The user interface is built using PHP. It allows users to:
- See a table of websites with the number of unique visits.
- Filter visits by a date range.
- Reset the date filter to show all visits.

You can access the user interface by visiting the project’s homepage at [http://localhost](http://localhost). \
Initially, all records are displayed regardless of the date range. You can filter the records by selecting a specific date range or reset the filter to return to the initial state.
If invalid inputs are provided, appropriate error messages will be displayed. You can always return to the initial state by clicking the reset button.