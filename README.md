# clinic_system
# Clinic Management System

A PHP-based web application for managing clinic operations such as patients, doctors, and appointments.

---

## Tech Stack

- PHP 8.2
- Apache
- MySQL
- Docker

---

## Build and Run with Docker
## Run with Docker

### Build
docker build -t clinic-system .

### Run
docker run -d -p 8080:80 --name clinic-system clinic-system

### Open
http://localhost:8080

### Stop
docker stop clinic-system
docker rm clinic-system
