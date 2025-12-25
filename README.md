# Clinic Management System

# Clinic Management System

A full-featured web-based **Clinic Management System** built to manage patients, appointments, doctors, and clinic operations efficiently. This system provides a responsive web interface and secure backend powered by PHP and MySQL.

---

## Tech Stack

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  
- **Containerization:** Docker  

---

## Getting Started with Docker

Follow these steps to run the Clinic Management System locally using Docker:

### 1. Clone the repository

```bash
git clone https://github.com/yazannazzal321/Clinic-Management-System
cd Clinic-Management-System

2. Build the Docker image
docker build -t clinic_system .

3. Run the Docker container
docker run -d -p 8080:80 --name clinic_app clinic_system
The app will be accessible at http://localhost:8080