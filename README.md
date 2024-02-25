<h1 align="center">Residential Complex Management System<h1>

An api management system using Laravel for residential places, where the residency can create admins and and control the payment of the system which also made in the system by the residents.

## Setting up the project on your PC

It is required to download Apache, Docker, Composer, Python.

- We use the python to be able to run the setup of the project like database and running the docker files for those who don't have knowledge about docker.
- The composer and apache is for Laravel.
- The docker is for the database and admin configuration and view, the database is MySQL and the container is Adminer.

## First

Start by running the "python setup.py" command to setup the docker and check composer and docker.

## Second

Run "python start.py" to be able to run the docker and laravel.

## Third

Run "python database_and_records.py" to be able to configure the database and set the fake records into it.

## stopping the docker container

To stop the container you can use "python stop.py" command which stops the container.

## Notes

The database name is "residentialcomplexmanagementsystem" which is already configured in the Laravel .env file.

The path to open Laravel is: localhost:8000
The path to open the adminer is: localhost:8080
