# Website Traffic Tracker

This project is a simple website traffic tracker that tracks unique visits to a web page. It consists of three main components:

## Project Components

### 1. **JavaScript Tracker**
The JavaScript tracker is included in the HTML files (`website1.html` and `website2.html`), which are test sites. This script records a visit whenever a user accesses the page. It sends a request to the server, which logs the visit in the database.

### 2. **MySQL Database**
Basic table structure includes fields for `page`, `visitor_id`, and `date`:

- `page` - URL of the visited page.
- `visitor_id` - A unique identifier for each visitor.
- `date` - Date of the visit.



### 3. **User Interface (PHP)**
The user interface is built using PHP. It allows users to:
- See a table of websites with the number of unique visits.
- Filter visits by a date range.
- Reset the date filter to show all visits.

### 4. **Docker Setup**
The project uses Docker for easy containerization and setup. Docker Compose is used to run the containers for the web server (Nginx with PHP) and MySQL database.

## Requirements
- Docker
- Docker Compose

## How to Set Up and Run the Project

### 1. Clone the Repository

First, clone the repository to your local machine:

```bash
git clone ....
cd tracker
```

Build and run docker container:
```bash
docker compose up -d --build
```

Once the containers are running, you can access the user interface by navigating to:
[http://localhost](http://localhost).

There are two test websites included in this project:
- [http://localhost/website1.html](http://localhost/website1.html)
- [http://localhost/website2.html](http://localhost/website2.html)

When you visit these pages, the tracker will register the visit and store it in the database. Each unique visit is recorded.



